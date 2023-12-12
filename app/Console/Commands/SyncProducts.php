<?php

namespace App\Console\Commands;

use App\Helpers\RestAPI;
use App\Jobs\DownloadProductImages;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'woocommerce:syncproducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //call api
        $response = (new RestAPI)->getRequest("/products");

        if (!empty($response)) {
            foreach ($response as $product) {
                $product_check = Product::where('name', $product['name'])->first();

                //check existance and save data
                if (empty($product_check)) {
                    $data = Product::create([
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'description' => $product['description']
                    ]);

                    DownloadProductImages::dispatch($data->id, $product['images'][0]['src']);

                }

            }

            return Command::SUCCESS;
        } else {
            echo "Something went wrong";
            return Command::FAILURE;
        }

    }
}
