<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\PaymentAttempt;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        $canOrders = $admin->hasPermission('admin.ecom_orders.index');
        $canProducts = $admin->hasPermission('admin.ecom_products.index');
        $canInventory = $admin->hasPermission('admin.ecom_inventory.index');
        $canCustomers = $admin->hasPermission('admin.ecom_customers.index');
        $metrics = [];
        $recentOrders = collect();
        $salesDays = collect();
        $lowStock = collect();
        $topProducts = collect();

        if ($canOrders) {
            $paid = Order::where('payment_status', 'paid');
            $metrics['collected'] = (clone $paid)->sum('total_amount');
            $metrics['month_collected'] = (clone $paid)->where('created_at', '>=', now()->startOfMonth())->where('created_at', '<', now()->startOfMonth()->addMonth())->sum('total_amount');
            $metrics['order_count'] = Order::count();
            $metrics['active_orders'] = Order::whereIn('status', ['pending', 'paid', 'processing', 'shipped'])->count();
            $metrics['unpaid_orders'] = Order::whereIn('status', ['pending', 'paid', 'processing', 'shipped'])->where('payment_status', 'unpaid')->count();
            $metrics['refunds_pending'] = PaymentAttempt::where('status', PaymentAttempt::REFUND_PENDING)->count();
            $metrics['statuses'] = Order::select('status', DB::raw('COUNT(*) as total'))->groupBy('status')->pluck('total', 'status');
            $recentOrders = Order::orderByDesc('id')->limit(6)->get();
            for ($day = 6; $day >= 0; $day--) {
                $date = now()->startOfDay()->subDays($day);
                $salesDays->push(['date' => $date, 'amount' => (float) (clone $paid)->where('created_at', '>=', $date)->where('created_at', '<', $date->copy()->addDay())->sum('total_amount')]);
            }
            if ($canProducts) {
                $topProducts = DB::table('order_items')->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->where('orders.payment_status', 'paid')
                    ->select('products.id', 'products.name', DB::raw('SUM(order_items.quantity) as units'))
                    ->groupBy('products.id', 'products.name')->orderByDesc('units')->limit(5)->get();
            }
        }
        if ($canProducts) $metrics['products'] = Product::where('is_active', true)->count();
        if ($canCustomers) $metrics['customers'] = Customer::count();
        if ($canInventory) {
            $stockQuery = Inventory::whereColumn('quantity', '<=', 'low_stock_threshold')->whereHas('product', fn ($query) => $query->where('is_active', true));
            $metrics['low_stock'] = (clone $stockQuery)->count();
            $lowStock = (clone $stockQuery)->with(['product', 'variant'])->orderBy('quantity')->limit(5)->get();
        }

        return view('admin.dashboard.index', compact('canOrders', 'canProducts', 'canInventory', 'canCustomers', 'metrics', 'recentOrders', 'salesDays', 'lowStock', 'topProducts'));
    }
}
