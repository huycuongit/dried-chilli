<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:release-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release stock for orders pending payment longer than 30 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Find orders pending payment older than 30 minutes
        $expiredOrders = Order::where('status', 'pending')
            ->where('payment_status', 'unpaid')
            ->where('created_at', '<=', now()->subMinutes(30))
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('No expired orders found.');
            return 0;
        }

        $count = 0;
        foreach ($expiredOrders as $order) {
            DB::transaction(function () use ($order, &$count) {
                // Return stock to inventory
                foreach ($order->items as $item) {
                    $inventory = Inventory::where('product_id', $item->product_id)
                        ->when($item->variant_id, function($q) use ($item) {
                            return $q->where('variant_id', $item->variant_id);
                        })
                        ->first();

                    if ($inventory) {
                        $inventory->increment('quantity', $item->quantity);
                    }
                }

                // Mark order as cancelled
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'expired'
                ]);

                Log::info("Order {$order->id} cancelled due to payment timeout. Stock restored.");
                $count++;
            });
        }

        $this->info("Released {$count} expired orders and restored their stock.");
        return 0;
    }
}
