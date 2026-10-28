<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutWebController extends Controller
{
    /**
     * Display the order confirmation / thank you page.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function success($id, Request $request)
    {
        $order = Order::with(['items.product', 'items.variant', 'items.bundle'])->find($id);

        if (!$order) {
            return redirect()->route('page.shop')->with('error', 'Order not found.');
        }

        // Validate access authorization:
        // 1. Authenticated user owns the order
        // 2. Or token signature in URL matches
        // 3. Or current session placed this order
        $expectedToken = hash('sha256', $order->id . $order->created_at . config('app.key'));
        $providedToken = $request->query('token');

        $isAuthorized = false;

        if (Auth::check() && Auth::id() === $order->user_id) {
            $isAuthorized = true;
        } elseif ($providedToken && hash_equals($expectedToken, $providedToken)) {
            $isAuthorized = true;
        } elseif (session('last_order_id') == $order->id) {
            $isAuthorized = true;
        }

        if (!$isAuthorized) {
            return redirect()->route('page.shop')->with('error', 'Unauthorized access to order details.');
        }

        return view('frontend.checkout.success', compact('order'));
    }
}
