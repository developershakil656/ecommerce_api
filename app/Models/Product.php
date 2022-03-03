<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function prices()
    {
        return $this->hasOne(ProductPrice::class);
    }


    public function order_status($order_status,$product_id)
    {
        // $this_status_orders=array();
        $allItems=array();
        $sizes=array();
        $colors=array();
        $colorWise=array();

        $all_order_items= OrderItems::where('product_id',$product_id)->with('order')->get();

        foreach($all_order_items as $item){
            if($item->order->status == $order_status){
                array_push($allItems,$item);
                array_push($colors,$item->product_color_id);
                array_push($sizes,$item->product_size_id);
                // array_push($color_size,[
                //     'product_color_id'=>$item->product_color_id,
                //     'product_size_id'=>$item->product_size_id,
                // ]);
            }
        }

        foreach(array_unique($colors) as $color){
            $sizeWise= array();
            foreach(array_unique($sizes) as $size){
                $quantity = 0;
                foreach($allItems as $item){
                    if($color == $item->product_color_id && $size == $item->product_size_id){
                        $quantity = $quantity + $item->quantity;
                    }
                }
                array_push($sizeWise,[
                    'product_size_id' => $size,
                    'quantity' => $quantity
                ]);
            }
            array_push($colorWise,[
                'product_color_id' => $color,
                'data' => $sizeWise
            ]);
        }

        return $colorWise;
    }

    public function products_order_status($order_status)
    {
        $this_status_orders=array();
        $products = Product::get();

        foreach($products as $product){
            $all_this_status_orders=array();
            $all_order_items= OrderItems::where('product_id',$product->id)->with('order')->get();

            foreach($all_order_items as $item){
                if($item->order->status == $order_status){
                    array_push($all_this_status_orders,$item->quantity);
                }
            }
            $this_status_orders[$product->id] = array_sum($all_this_status_orders);
        }

        return $this_status_orders;
    }

    #all stocks of product
    // public function stocks($id)
    // {
    //     $colorsId = array();
    //     $colors = array();
    //     $stocks = array();

    //     $allStocks = ProductStock::where([
    //         ['product_id',$id],
    //         ['stock','>',0]
    //     ])->get();

    //     #getting all colors id
    //     foreach ($allStocks as $item) {
    //         array_push($colorsId, $item->product_color_id);
    //     }
    //     $colorsId = array_unique($colorsId);

    //     #getting all color wise stocks
    //     foreach ($colorsId as $item) {
    //         $stock = ProductStock::where([
    //             ['product_id',$id],
    //             ['product_color_id', $item],
    //             ['stock','>',0],
    //             ])->with('color','size')->get();
                
    //         $stocks[$stock[0]->color->name] = $stock;

    //         #all colors name
    //         array_push($colors, $stock[0]->color->name);
    //     }

    //     #response all colors and stocks
    //     $res = [
    //         'colors' => $colors,
    //         'stocks' => $stocks,
    //     ];
    //     return $res;
    // }

    public function stocks($id,$only_in_stock=true)
    {
        $colorsId = array();
        $colors = array();
        $stocks = array();

        $only_in_stock= $only_in_stock ? ['stock','>',0] : ['stock','>=',0];


        $allStocks = ProductStock::where([
            ['product_id',$id],
            $only_in_stock

        ])->get();

        #getting all colors id
        foreach ($allStocks as $item) {
            array_push($colorsId, $item->product_color_id);
        }
        $colorsId = array_unique($colorsId);

        #getting all color wise stocks
        foreach ($colorsId as $item) {
            $stock = ProductStock::where([
                ['product_id',$id],
                ['product_color_id', $item],
                $only_in_stock,
                ])->with('color','size')->get();
                
            $stocks[$stock[0]->color->name] = $stock;

            #all colors name
            array_push($colors, $stock[0]->color->name);
        }

        #response all colors and stocks
        $res = [
            'colors' => $colors,
            'stocks' => $stocks,
        ];
        return $res;
    }
}
