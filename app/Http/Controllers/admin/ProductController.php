<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ProductController extends Controller
{
    // public function __construct()
    // {
    //     changeStatus();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category', 'subCategory')->get();
        return send_response(true, '', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #product form validation
        $validator= $this->product_validation($request);
        if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors());

        $product = new Product;
        $this->set_data($product, $request, true);

        if ($request->thumbnail) {
            #image url and file-type generate
            $image = image_link_genterator($request->file_type, $product->slug);
            $product->thumbnail = $image['url'];

            if ($product->save()) {
                Image::make($request->thumbnail)->resize(330, 330)->save($image['url']);

                #setting the price
                if ($request->price) {
                    $price = new ProductPriceController;
                    $price->store($request->price, $product->id);
                }
                #store all files in gallery
                if ($request->gallery) {
                    $gallery = new GalleryController;
                    $gallery->store($request->gallery, $product->id);
                }
                #store all attributes and stock
                if ($request->stock) {
                    $stock = new ProductStockController;
                    $stock->store($request->stock, $product->id);
                }
                
                #setting product current stocks of product
                $on_stock = new ProductStockController;
                $on_stock= $on_stock->on_stock($product->id);
                $product->on_stock = $on_stock;
                $product->save();

                return send_response(true, 'product successfully created.');
            }
        } else {
            return send_response(true, 'something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category', 'subCategory')->find($id);

        $attr = $product->stocks($id, false);
        $res = array('product' => $product) + $attr;

        return send_response(true, '', $res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //product form validation
        $validator = $this->product_validation($request);
        if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors());

        $product = Product::find($id);
        if ($product) {
            #setting the price
            if ($request->price) {
                $price = new ProductPriceController;
                $price->store($request->price, $product->id);
            }
            #update all images in gallery
            if ($request->gallery) {
                $gallery = new GalleryController;
                // return send_response(true,'from gallery',$request->gallery);
                $gallery->update($request->gallery, $id);
            }
            #store all attributes and stock
            if ($request->stock) {
                $stock = new ProductStockController;
                $stock->store($request->stock, $product->id);
            }
            #setting product current stocks of product
            $on_stock = new ProductStockController;
            $on_stock= $on_stock->on_stock($product->id);
            $product->on_stock = $on_stock;

            #setting all data
            $this->set_data($product, $request);

            if ($request->thumbnail != $product->thumbnail) {
                #delete old thumbnail
                if (file_exists($product->thumbnail)) {
                    unlink($product->thumbnail);
                }

                #image url and file-type generate
                $image = image_link_genterator($request->file_type, $product->slug);
                $product->thumbnail = $image['url'];

                if ($product->update()) {
                    Image::make($request->thumbnail)->resize(330, 330)->save($image['url']);
                }

                return send_response(true, 'product successfully updated.');
            } else {
                $product->update();
                return send_response(true, 'product successfully updated.');
            }
        } else {
            return send_response(true, 'invalid request!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return send_response(false,'not found!');
    }



    // public function product(){
    //     $product= Product::with('category','subCategory')->where('status',1)->find(9);
    //     // $product= new Product;

    //     $attr = $product->stocks(9);
    //     $res = array('product'=>$product)+$attr;

    //     return send_response(true,'',$res);
    // }

    #custom method for use this controller
    private function set_data($product, $request, $create_new_slug = false)
    {
        $slug = $create_new_slug ? slugify($request->name . date('-dmysih')) : $product->slug;

        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->name = $request->name;
        $product->slug = $slug;
        $product->status = 0;
    }

    #make validataion
    private function product_validation($request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'category_id' => 'required',
            'sub_category_id' => 'required',

            'stock' => 'required|array',
            'stock.*.product_color_id' => 'required',
            'stock.*.product_size_id' => 'required',
            'stock.*.stock' => 'required',

            'price' => 'required',
            'price.cost_price' => 'required',
            'price.retail_price' => 'required',

            'thumbnail' => 'required',
            'gallery' => 'array',
        ]);
        return $validator;
    }
}
