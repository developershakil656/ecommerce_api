<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    
    public function store($stock_data,$product_id)
    {
        foreach ($stock_data as $item) {
            $hasStock= ProductStock::where([
                ['product_id',$product_id],
                ['product_color_id',$item['product_color_id']],
                ['product_size_id',$item['product_size_id']],
            ])->first();

            if($hasStock){
                $hasStock->stock = $item['stock'];
                $hasStock->update();
            }else{
                $stock = new ProductStock;
                $stock->product_id = $product_id;
                $stock->product_color_id = $item['product_color_id'];
                $stock->product_size_id = $item['product_size_id'];
                $stock->stock = $item['stock'];

                $stock->save();
            }
            
        }
    }

    public function on_stock($product_id){
        $stocks= ProductStock::where('product_id',$product_id)->sum('stock');
        return $stocks;
    }



    public function product(){
        // $products= ProductStock::where('product_id',9)->with('color')->get();

        // $colors=[];
        // foreach ($products as $item){
        //     array_push($colors,$item->product_color_id);
        // }
        // $colors = array_unique($colors);

        // $sizes=[];
        // foreach($colors as $item){
        //     $product= ProductStock::where('product_id',9)->where('product_color_id',$item)->with('color')->get();
        //     $sizes[$item] = $product;
        // }

        // return send_response(true,'',$products);
    }
}
