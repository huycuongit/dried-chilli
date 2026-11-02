<?php
// Run with: php -d extension=pdo_sqlite tests/Feature/cart-deleted-product.php
putenv('APP_ENV=testing');
require __DIR__.'/../../vendor/autoload.php';
$app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default'=>'sqlite','database.connections.sqlite.database'=>':memory:','session.driver'=>'array']);
use App\Models\Cart;
use App\Support\Shop\CartCheckout;
use App\Support\Shop\CheckoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
DB::purge();
Schema::create('products',function($t){$t->id();$t->string('name');$t->boolean('is_active')->default(true);$t->decimal('price',15,2);$t->decimal('sale_price',15,2)->nullable();$t->string('sale_type')->nullable();$t->timestamp('sale_start_date')->nullable();$t->timestamp('sale_end_date')->nullable();$t->timestamps();});
Schema::create('product_variants',function($t){$t->id();$t->unsignedBigInteger('product_id');$t->decimal('additional_price',15,2)->default(0);$t->timestamps();});
Schema::create('bundles',function($t){$t->id();$t->timestamps();});
Schema::create('inventories',function($t){$t->id();$t->unsignedBigInteger('product_id');$t->unsignedBigInteger('variant_id')->nullable();$t->integer('quantity');$t->timestamps();});
Schema::create('carts',function($t){$t->id();$t->unsignedBigInteger('user_id')->nullable();$t->string('session_id')->nullable();$t->timestamps();});
Schema::create('cart_items',function($t){$t->id();$t->unsignedBigInteger('cart_id');$t->unsignedBigInteger('product_id')->nullable();$t->unsignedBigInteger('variant_id')->nullable();$t->unsignedBigInteger('bundle_id')->nullable();$t->integer('quantity');$t->decimal('price',15,2);$t->decimal('limited_sale_price',15,2)->nullable();$t->timestamp('limited_sale_expires_at')->nullable();$t->timestamps();});
$check=function($ok,$message){if(!$ok)throw new RuntimeException($message);};

DB::table('products')->insert(['id'=>7,'name'=>'Chili Crisp','price'=>10]);
DB::table('inventories')->insert(['product_id'=>7,'quantity'=>5]);
$cart=Cart::create(['session_id'=>'session_orphan']);
// Product 117 was deleted from the shop: its product and inventory rows are gone, the cart line is not.
DB::table('cart_items')->insert([['cart_id'=>$cart->id,'product_id'=>117,'quantity'=>1,'price'=>20],['cart_id'=>$cart->id,'product_id'=>7,'quantity'=>1,'price'=>10]]);

try {
    CartCheckout::price($cart->load(['items.product','items.variant','items.bundle']),null);
    throw new RuntimeException('deleted product was priced');
} catch (CheckoutException $e) {
    $check($e->getMessage()==='A product in your cart is no longer available.','misleading checkout error: '.$e->getMessage());
}

$request=Request::create('/api/cart','GET');
$request->headers->set('Session-Id','session_orphan');
$body=app(App\Http\Controllers\Api\CartController::class)->index($request)->getData(true);
$check(count($body['cart']['items'])===1 && $body['cart']['items'][0]['product_id']===7,'deleted product still listed in the cart');
$check((float)$body['subtotal']===10.0,'deleted product still counted in the subtotal');
$check(DB::table('cart_items')->where('product_id',117)->doesntExist(),'deleted product line was kept');

$priced=CartCheckout::price(Cart::with(['items.product','items.variant','items.bundle'])->find($cart->id),null);
$check($priced['total']===10.0,'cart cannot check out after the deleted product is removed');
echo "PASS: deleted product is reported as unavailable, pruned from the cart, and checkout continues\n";
