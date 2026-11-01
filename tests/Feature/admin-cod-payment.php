<?php
putenv('APP_ENV=testing');
require __DIR__.'/../../vendor/autoload.php';
$app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default'=>'sqlite','database.connections.sqlite.database'=>':memory:']);
Illuminate\Support\Facades\DB::purge();
$schema=Illuminate\Support\Facades\Schema::getFacadeRoot();
$schema->create('orders',function($t){$t->id();$t->string('status');$t->string('payment_status');$t->string('payment_method');$t->decimal('total_amount',15,2);$t->timestamps();});
Illuminate\Support\Facades\DB::table('orders')->insert([
 ['id'=>1,'status'=>'completed','payment_status'=>'unpaid','payment_method'=>'cod','total_amount'=>35,'created_at'=>now(),'updated_at'=>now()],
 ['id'=>2,'status'=>'pending','payment_status'=>'unpaid','payment_method'=>'paypal','total_amount'=>99,'created_at'=>now(),'updated_at'=>now()],
 ['id'=>3,'status'=>'cancelled','payment_status'=>'unpaid','payment_method'=>'cod','total_amount'=>20,'created_at'=>now(),'updated_at'=>now()],
]);
$controller=new App\Http\Controllers\Admin\EcomOrderController();
$controller->confirmCodPayment(1);
$check=function($ok,$message){if(!$ok)throw new RuntimeException($message);};
$check(Illuminate\Support\Facades\DB::table('orders')->where('id',1)->value('payment_status')==='paid','COD not marked paid');
foreach([1,2,3] as $id){try{$controller->confirmCodPayment($id);throw new RuntimeException('invalid COD confirmation accepted');}catch(Symfony\Component\HttpKernel\Exception\HttpException $e){$check($e->getStatusCode()===422,'unexpected error');}}
echo "PASS: COD confirmation; rejects duplicate, non-COD and cancelled orders\n";
