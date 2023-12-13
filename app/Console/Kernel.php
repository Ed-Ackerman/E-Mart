<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Models\Admin\InventoryManagement\Alert;
use App\Models\Admin\ProductManagement\Product;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('ProductController@checkProductThresholds')
            ->weekly()
            ->mondays()
            ->at('09:00');
    }

    private function checkProductThresholds()
    {
        $products = Product::all();
    
        foreach ($products as $product) {
            if ($product->quantity <= $product->alert_threshold) {
                Alert::create([
                    'product_id' => $product->id,
                    'message' => 'Product quantity is below the threshold.',
                ]);
            }
        }
    }
    
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
