<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;

class OrderController extends Controller
{
    // User: View their own orders
    public function index(Request $request)
    {
        $userId = Auth::guard('api')->id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Order::with('items.product')->where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    // Admin/System: Update Order Status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,canceled'
        ]);

        $order = Order::findOrFail($id);

        try {
            DB::beginTransaction();
            
            // If order is canceled, we must restock the inventory
            if ($request->status === 'canceled' && $order->status !== 'canceled') {
                foreach ($order->items as $item) {
                    $inventory = Inventory::where('product_id', $item->product_id)
                                          ->where('variant_id', $item->variant_id)
                                          ->lockForUpdate()
                                          ->first();
                    if ($inventory) {
                        $inventory->quantity += $item->quantity;
                        $inventory->save();
                    }
                }
            }

            $order->status = $request->status;
            $order->save();

            DB::commit();
            return response()->json(['message' => 'Status updated successfully', 'order' => $order]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Could not update status'], 500);
        }
    }
}
