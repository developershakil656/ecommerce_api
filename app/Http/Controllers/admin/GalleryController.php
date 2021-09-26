<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Expectation;
use Image;

class GalleryController extends Controller
{
    public function store($gallery_data,$product_id)
    {
        foreach ($gallery_data as $key => $item) {
            $gallery = new Gallery;

            #image url and file-type generate
            $image = image_link_genterator($item['file_type'],$product_id,$key);

            $gallery->file_type = $image['file'];
            $gallery->product_id = $product_id;
            $gallery->url = $image['url'];

            if ($gallery->save()) {
                Image::make($item['data'])->resize(330, 330)->save($image['url']);
            }
        }
    }

    #update gallery
    public function update($gallery_data,$product_id)
    {
        #deleting gallery files
            foreach ($gallery_data['delete'] as $item) {
                $gallery = Gallery::find($item);
                if($gallery){
                    if(file_exists($gallery->url)){
                        unlink($gallery->url);
                    }
                    $gallery->delete();
                }
            }
        #inserting all images
        $this->store($gallery_data['insert'],$product_id);
    }
}
