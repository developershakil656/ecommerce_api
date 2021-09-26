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
