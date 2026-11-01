<?php
putenv('APP_ENV=testing');
require __DIR__.'/../../vendor/autoload.php';
$app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$bundle='C:/Program Files/Git/mingw64/etc/ssl/cert.pem';
if (!is_file($bundle)) $bundle=__FILE__;
config(['services.paypal.ca_bundle'=>$bundle,'services.paypal.environment'=>'sandbox','services.paypal.client_id'=>'test','services.paypal.client_secret'=>'test']);
$seen=[];
Illuminate\Support\Facades\Http::fake(function($request,$options)use(&$seen,$bundle){
 if (($options['verify']??null)!==$bundle) throw new RuntimeException('CA verification not configured');
 $seen[]=$request->url();
 if (str_contains($request->url(),'/oauth2/token')) return Illuminate\Support\Facades\Http::response(['access_token'=>'test'],200);
 return Illuminate\Support\Facades\Http::response(['id'=>'test-order','status'=>'CREATED'],201);
});
$result=(new App\Support\Payments\PayPalGateway())->createOrder(['attempt_id'=>'test-attempt','currency'=>'USD','amount_minor'=>100]);
if($result['id']!=='test-order'||count($seen)!==2)throw new RuntimeException('PayPal request path');
config(['services.paypal.ca_bundle'=>'missing-ca.pem']);
try{(new App\Support\Payments\PayPalGateway())->createOrder(['attempt_id'=>'test-attempt','currency'=>'USD','amount_minor'=>100]);throw new RuntimeException('Missing CA accepted');}catch(RuntimeException $e){if(!str_contains($e->getMessage(),'missing or unreadable'))throw $e;}
echo "PASS: PayPal OAuth and create-order requests use CA verification; missing CA fails closed (mocked HTTP)\n";
