<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function list()
    {
        try {

            $products = Product::all();

            foreach ($products as $key => $product) {
                $products[$key]['image_filename'] = Storage::disk("public")->url($product['image_filename']);
            }

            return response()->json([
                'status' => true,
                'products' => $products
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
