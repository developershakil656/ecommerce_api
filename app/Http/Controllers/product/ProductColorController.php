<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\ProductColor;

class ProductColorController extends Controller
{
    public function getColorId($colorName)
    {
        $hasStock= ProductColor::where('name',$colorName)->first();
        if($hasStock){
            return $hasStock->id;
        }else{
            $color = new ProductColor;
            $color->name = $colorName;
            $color->save();

            return $color->id;
        }
    }
}
