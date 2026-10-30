<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('web')->user();
        
        // Retrieve recent orders for the dashboard preview
        $recentOrders = \App\Models\Order::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('frontend.account.dashboard', compact('user', 'recentOrders'));
    }

    public function addresses()
    {
        $user = Auth::guard('web')->user();
        $addresses = \App\Models\UserAddress::where('user_id', $user->id)->get();

        return view('frontend.account.addresses', compact('user', 'addresses'));
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = \App\Models\Order::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('frontend.account.orders', compact('user', 'orders'));
    }

    public function orderDetail($id)
    {
        $user = Auth::guard('web')->user();
        $order = \App\Models\Order::with('items.product', 'items.variant')
                    ->where('user_id', $user->id)
                    ->findOrFail($id);

        return view('frontend.account.order_detail', compact('user', 'order'));
    }
}
