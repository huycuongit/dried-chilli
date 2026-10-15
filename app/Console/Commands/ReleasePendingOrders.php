<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReleasePendingOrders extends Command
{
    protected $signature = 'orders:release-pending';
    protected $description = 'Release stock for pending orders that have not been paid after 30 minutes';

    public function handle()
    {
        $expirationTime = Carbon::now()->subMinutes(30);

        $pendingOrders = Order::with('items')->where('payment_status', 'unpaid')
                              ->where('status', 'pending')
                              ->where('created_at', '<', $expirationTime)
                              ->get();

        $count = 0;
        foreach ($pendingOrders as $order) {
            DB::transaction(function () use ($order) {
                // Restore inventory
                foreach ($order->items as $item) {
                    if ($item->bundle_id) {
                        $bundle = \App\Models\Bundle::with('items')->find($item->bundle_id);
                        if ($bundle) {
                            foreach ($bundle->items as $bItem) {
                                $inventory = Inventory::where('product_id', $bItem->product_id)->first();
                                if ($inventory) {
                                    $inventory->quantity += ($item->quantity * $bItem->required_quantity);
                                    $inventory->save();
                                }
                            }
                        }
                    } else {
                        $inventory = Inventory::where('product_id', $item->product_id)
                                              ->where('variant_id', $item->variant_id)
                                              ->first();
                        if ($inventory) {
                            $inventory->quantity += $item->quantity;
                            $inventory->save();
                        }
                    }
                }

                $order->status = 'cancelled';
                $order->save();
            });
            $count++;
        }

        $this->info("Released {$count} pending orders.");
    }
}
