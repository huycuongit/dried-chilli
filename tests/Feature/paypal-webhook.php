<?php
// Run with: php -d extension=pdo_sqlite tests/Feature/paypal-webhook.php
putenv('APP_ENV=testing');
require __DIR__.'/../../vendor/autoload.php';
$app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default'=>'sqlite','database.connections.sqlite.database'=>':memory:','session.driver'=>'array','services.paypal'=>['enabled'=>true,'environment'=>'sandbox','client_id'=>'id','client_secret'=>'secret','webhook_id'=>'WH-1','ca_bundle'=>null]]);
use App\Models\Order;
use App\Models\PaymentAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
DB::purge();
Schema::create('inventories',function($t){$t->id();$t->unsignedBigInteger('product_id');$t->unsignedBigInteger('variant_id')->nullable();$t->integer('quantity');$t->timestamps();});
Schema::create('carts',function($t){$t->id();$t->string('session_id')->nullable();$t->timestamps();});
Schema::create('cart_items',function($t){$t->id();$t->unsignedBigInteger('cart_id');$t->unsignedBigInteger('product_id')->nullable();$t->unsignedBigInteger('variant_id')->nullable();$t->integer('quantity');$t->decimal('price',15,2);$t->timestamps();});
Schema::create('coupons',function($t){$t->id();$t->string('code');$t->integer('usage_limit')->nullable();$t->integer('used_count')->default(0);$t->timestamps();});
Schema::create('orders',function($t){$t->id();$t->unsignedBigInteger('user_id')->nullable();$t->string('status');$t->decimal('total_amount',15,2);$t->text('shipping_address')->nullable();$t->string('payment_method')->nullable();$t->string('payment_status');$t->string('coupon_code')->nullable();$t->decimal('discount_amount',15,2)->default(0);$t->timestamps();});
Schema::create('order_items',function($t){$t->id();$t->unsignedBigInteger('order_id');$t->unsignedBigInteger('product_id')->nullable();$t->unsignedBigInteger('bundle_id')->nullable();$t->unsignedBigInteger('variant_id')->nullable();$t->integer('quantity');$t->decimal('price',15,2);$t->timestamps();});
foreach (['2026_10_28_000000_create_payment_attempts_tables'=>'CreatePaymentAttemptsTables','2026_11_02_000000_create_paypal_webhook_events_table'=>'CreatePaypalWebhookEventsTable'] as $file=>$class) { require_once database_path("migrations/{$file}.php"); (new $class())->up(); }
Schema::table('payment_attempts',function($t){$t->timestamp('expires_at')->nullable();$t->string('provider_capture_id')->nullable();$t->string('provider_refund_id')->nullable();$t->string('refund_status')->nullable();$t->timestamp('refund_requested_at')->nullable();$t->text('refund_last_error')->nullable();$t->timestamp('paypal_checked_at')->nullable();});

$check=function($ok,$message){if(!$ok)throw new RuntimeException($message);};
$verified='SUCCESS'; $verifyBodies=[];
Http::fake(function($request)use(&$verified,&$verifyBodies){
    if (str_contains($request->url(),'/oauth2/token')) return Http::response(['access_token'=>'token']);
    if (str_contains($request->url(),'verify-webhook-signature')) { $verifyBodies[]=$request->body(); return Http::response(['verification_status'=>$verified]); }
    throw new RuntimeException('unexpected PayPal call: '.$request->url());
});
$send=function(array $event,array $headers=[]){
    $body=json_encode($event,JSON_UNESCAPED_SLASHES).' ';
    $server=['CONTENT_TYPE'=>'application/json','HTTP_ACCEPT'=>'application/json'];
    foreach (($headers+['Auth-Algo'=>'SHA256withRSA','Cert-Url'=>'https://api.paypal.com/cert','Transmission-Id'=>'tx','Transmission-Sig'=>'sig','Transmission-Time'=>'2026-11-02T00:00:00Z']) as $name=>$value) if ($value!==null) $server['HTTP_PAYPAL_'.strtoupper(str_replace('-','_',$name))]=$value;
    return app(Illuminate\Contracts\Http\Kernel::class)->handle(Request::create('/paypal/webhook','POST',[],[],[],$server,$body))->getStatusCode();
};
$attempt=function(string $orderId,string $status=PaymentAttempt::PENDING){
    $cart=App\Models\Cart::create(['session_id'=>$orderId]);
    $item=App\Models\CartItem::create(['cart_id'=>$cart->id,'product_id'=>7,'quantity'=>2,'price'=>10]);
    return PaymentAttempt::create(['cart_id'=>$cart->id,'idempotency_key'=>'key_'.$orderId,'provider'=>'paypal','provider_payment_id'=>$orderId,'status'=>$status,'currency'=>'AUD','total_amount'=>20,'amount_minor'=>2000,'shipping_address'=>'Jane','expires_at'=>now()->addMinutes(15),
        'cart_snapshot'=>['cart_id'=>$cart->id,'items'=>[['cart_item_id'=>$item->id,'product_id'=>7,'bundle_id'=>null,'variant_id'=>null,'quantity'=>2,'price'=>10]],'subtotal'=>20,'discount_amount'=>0,'coupon_code'=>null,'total'=>20]]);
};
$capture=function(string $id,string $orderId,string $status='COMPLETED',string $value='20.00'){
    return ['id'=>$id,'status'=>$status,'create_time'=>now()->toIso8601String(),'amount'=>['currency_code'=>'AUD','value'=>$value],'supplementary_data'=>['related_ids'=>['order_id'=>$orderId]]];
};
DB::table('inventories')->insert(['product_id'=>7,'quantity'=>10]);

// Forged and malformed deliveries change nothing.
$a=$attempt('ORDER1');
$verified='FAILURE';
$check($send(['id'=>'WH-bad','event_type'=>'PAYMENT.CAPTURE.COMPLETED','resource'=>$capture('CAP1','ORDER1')])===400,'forged event accepted');
$verified='SUCCESS';
$check($send(['id'=>'WH-bad'],['Transmission-Sig'=>null])===400,'unsigned event accepted');
$check(Order::count()===0 && DB::table('paypal_webhook_events')->count()===0,'rejected event had an effect');
$check(str_contains($verifyBodies[0],'"webhook_id":"WH-1","webhook_event":{') && str_ends_with($verifyBodies[0],' }'),'event not verified as raw bytes');
config(['services.paypal.webhook_id'=>'']);
$check($send(['id'=>'WH-x','event_type'=>'y'])===503,'missing webhook id did not fail closed');
config(['services.paypal.webhook_id'=>'WH-1']);

// A pending capture settles through the webhook without the browser, exactly once.
$pending=['id'=>'WH-1','event_type'=>'PAYMENT.CAPTURE.PENDING','resource'=>$capture('CAP1','ORDER1','PENDING')];
$check($send($pending)===200,'pending rejected');
$check($a->fresh()->status===PaymentAttempt::PROCESSING && Order::count()===0,'pending not recorded');
$done=['id'=>'WH-2','event_type'=>'PAYMENT.CAPTURE.COMPLETED','resource'=>$capture('CAP1','ORDER1')];
$check($send($done)===200 && $send($done)===200,'completed rejected');
$check($send(['id'=>'WH-3']+$done)===200,'second delivery rejected');
$a=$a->fresh();
$check($a->status===PaymentAttempt::PAID && $a->provider_capture_id==='CAP1' && Order::count()===1,'completed did not create exactly one order');
$check(Order::first()->payment_status==='paid' && (int)DB::table('inventories')->value('quantity')===8,'order not fulfilled');
$check($send(['id'=>'WH-9']+$pending)===200 && $a->fresh()->status===PaymentAttempt::PAID,'late pending overwrote a paid attempt');

// Denied payments fail and create no order.
$b=$attempt('ORDER2');
$check($send(['id'=>'WH-4','event_type'=>'PAYMENT.CAPTURE.DENIED','resource'=>$capture('CAP2','ORDER2','DECLINED')])===200,'denied rejected');
$check($b->fresh()->status===PaymentAttempt::FAILED && Order::count()===1,'denied not recorded');

// Partial refunds wait for staff; full refunds and reversals update attempt and order.
$refund=function($id,$value){return ['id'=>$id,'status'=>'COMPLETED','amount'=>['currency_code'=>'AUD','value'=>$value],'links'=>[['rel'=>'self','href'=>'https://api.paypal.com/v2/payments/refunds/'.$id],['rel'=>'up','href'=>'https://api.paypal.com/v2/payments/captures/CAP1']]];};
$check($send(['id'=>'WH-5','event_type'=>'PAYMENT.CAPTURE.REFUNDED','resource'=>$refund('REF1','5.00')])===200,'partial refund rejected');
$check($a->fresh()->status===PaymentAttempt::PAID,'partial refund marked the order refunded');
$check($send(['id'=>'WH-6','event_type'=>'PAYMENT.CAPTURE.REFUNDED','resource'=>$refund('REF2','20.00')])===200,'refund rejected');
$a=$a->fresh();
$check($a->status===PaymentAttempt::REFUNDED && $a->provider_refund_id==='REF2' && Order::first()->payment_status==='refunded','refund not recorded');

// Events for other PayPal payments and unrelated types are acknowledged.
$check($send(['id'=>'WH-7','event_type'=>'PAYMENT.CAPTURE.COMPLETED','resource'=>$capture('CAP9','OTHER')])===200,'unknown order rejected');
$check($send(['id'=>'WH-8','event_type'=>'CUSTOMER.DISPUTE.CREATED','resource'=>[]])===200,'unrelated event rejected');
$check(strpos(file_get_contents(app_path('Http/Middleware/VerifyCsrfToken.php')),"'paypal/webhook'")!==false,'webhook not exempt from CSRF');
echo "PASS: PayPal webhook verifies events and keeps payment status in step\n";
