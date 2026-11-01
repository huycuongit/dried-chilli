<?php
putenv('APP_ENV=testing');
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default'=>'sqlite','database.connections.sqlite.database'=>':memory:']);
Illuminate\Support\Facades\DB::purge();
$schema = Illuminate\Support\Facades\Schema::getFacadeRoot();
$schema->create('orders', function ($t) { $t->id(); $t->string('status'); $t->string('payment_status'); $t->decimal('total_amount', 15, 2); $t->timestamps(); });
$schema->create('products', function ($t) { $t->id(); $t->string('name'); $t->boolean('is_active'); });
$schema->create('product_variants', function ($t) { $t->id(); });
$schema->create('order_items', function ($t) { $t->id(); $t->integer('order_id'); $t->integer('product_id'); $t->integer('quantity'); });
$schema->create('inventories', function ($t) { $t->id(); $t->integer('product_id'); $t->integer('variant_id')->nullable(); $t->integer('quantity'); $t->integer('low_stock_threshold'); });
$schema->create('customers', function ($t) { $t->id(); });
$schema->create('payment_attempts', function ($t) { $t->string('id'); $t->string('status'); });
$schema->create('systems', function ($t) { $t->id(); $t->string('key'); $t->text('content')->nullable(); });
$db = Illuminate\Support\Facades\DB::class;
$db::table('orders')->insert([
 ['id'=>1,'status'=>'processing','payment_status'=>'paid','total_amount'=>100,'created_at'=>now(),'updated_at'=>now()],
 ['id'=>2,'status'=>'pending','payment_status'=>'unpaid','total_amount'=>20,'created_at'=>now(),'updated_at'=>now()],
 ['id'=>3,'status'=>'cancelled','payment_status'=>'refunded','total_amount'=>50,'created_at'=>now(),'updated_at'=>now()],
]);
$db::table('products')->insert([['id'=>1,'name'=>'Chili crisp','is_active'=>1],['id'=>2,'name'=>'Hidden','is_active'=>0]]);
$db::table('order_items')->insert([['order_id'=>1,'product_id'=>1,'quantity'=>3],['order_id'=>2,'product_id'=>1,'quantity'=>20],['order_id'=>3,'product_id'=>1,'quantity'=>10]]);
$db::table('inventories')->insert([['product_id'=>1,'quantity'=>2,'low_stock_threshold'=>5],['product_id'=>2,'quantity'=>0,'low_stock_threshold'=>5]]);
$db::table('customers')->insert(['id'=>1]);
$db::table('payment_attempts')->insert(['id'=>'p1','status'=>'REFUND_PENDING']);
class DashboardTestAdmin extends App\Models\Admin {
 public $allowed = true;
 public function hasPermission($permission) { return $this->allowed; }
 public function hasAnyPermission($permission) { return $this->allowed; }
 public function getAllCheckPermissions() { return collect(); }
}
$admin = new DashboardTestAdmin(); $admin->setRawAttributes(['id'=>1,'name'=>'Test','user_name'=>'Admin','active'=>1]); $admin->setRelation('roles', collect());
auth()->guard('admin')->setUser($admin);
$controller = new App\Http\Controllers\Admin\DashboardController();
$d = $controller->index()->getData();
$check = function($ok,$message){ if (!$ok) throw new RuntimeException($message); };
$check((float)$d['metrics']['collected']===100.0 && (float)$d['metrics']['month_collected']===100.0, 'Paid revenue excludes unpaid and refunded');
$check($d['metrics']['active_orders']===2 && $d['metrics']['unpaid_orders']===1, 'Order status totals');
$check($d['metrics']['refunds_pending']===1 && $d['metrics']['low_stock']===1, 'Refunds and active low stock');
$check((int)$d['topProducts'][0]->units===3 && count($d['recentOrders'])===3 && count($d['salesDays'])===7, 'Top products and activity');
view()->share('errors', new Illuminate\Support\ViewErrorBag());
$html = $controller->index()->render();
$check(strpos($html, 'Total collected') !== false && strpos($html, '$100.00') !== false && strpos($html, 'Chili crisp') !== false, 'Dashboard rendering');
$admin->allowed = false;
$d = $controller->index()->getData();
$check(!$d['canOrders'] && !$d['canInventory'] && !$d['canCustomers'] && !$d['canProducts'] && !$d['metrics'] && $d['recentOrders']->isEmpty(), 'Dashboard permissions');
echo "PASS: paid totals, order states, pending refunds, inventory, product units, permissions\n";
