<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\ProductPrice;

class ProductPriceController extends Controller
{
    public function store($product_price_data,$product_id)
    {
        $product_price = ProductPrice::where('product_id',$product_id)->first();

        if($product_price){
            $product = $product_price;
        }else{
            $product = new ProductPrice;
        }
        
        $product->product_id = $product_id;
        $product->cost_price = $product_price_data['cost_price'];
        $product->retail_price = $product_price_data['retail_price'];
        $product->discount_price = $product_price_data['discount_price'];
        $product->discount_start = $product_price_data['discount_start'];
        $product->discount_end = $product_price_data['discount_end'];

        $product->save();
    }
}
