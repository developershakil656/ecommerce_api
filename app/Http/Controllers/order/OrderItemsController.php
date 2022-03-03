<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ProductStock;
use Carbon\Carbon;

class OrderItemsController extends Controller
{
    public function store($order_items,$order_id)
    {
        foreach ($order_items as $item) {
            // get this product
            $product = Product::with('prices')->find($item['product_id']);
            
            $hasStock= ProductStock::where([
                ['product_id',$item['product_id']],
                ['product_size_id',$item['product_size_id']],
                ['product_color_id',$item['product_color_id']],
            ])->first();
            if($hasStock && ($hasStock->stock >= $item['quantity'])){
                $hasStock->stock = $hasStock->stock - $item['quantity'];
                $product->on_stock = $product->on_stock - $item['quantity'];
                
                $hasStock->update();

                if($product->update()){
                    $price= $product->prices->retail_price;
                    if($product->prices->discount_price){
                        $today = Carbon::now()->toDateTimeString();
                        $start = $product->prices->discount_start;
                        $end = $product->prices->discount_end;
                        if(($start <= $today) && ($today <= $end)){
                            $price = $product->prices->discount_price;
                        }
                    }
                    $order = new OrderItems;
                    $order->order_id = $order_id;
                    $order->product_id = $item['product_id'];
                    $order->product_size_id = $item['product_size_id'];
                    $order->product_color_id = $item['product_color_id'];
                    $order->price = $price;
                    $order->quantity = $item['quantity'];
                    $order->product_name = $product->name;

                    $order->save();
                }
            }else{
                return 'error';
            }
            
        }
    }

    public function total($order_id){
        $orders= OrderItems::where('order_id',$order_id)->get();
        $total=0;
        foreach($orders as $item){
            $total += $item->price * $item->quantity;
        }
        $res=[
            'price'=>$total,
            'items'=>$orders->sum('quantity')
        ];
        return $res;
    }
}
