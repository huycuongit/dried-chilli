<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // User: View their own orders
    public function index(Request $request)
    {
        $userId = Auth::guard('web')->id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Order::with('items.product')->where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

}
