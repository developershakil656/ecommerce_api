<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    public function color()
    {
        return $this->belongsTo(ProductColor::class,'product_color_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class,'product_size_id');
    }
}
