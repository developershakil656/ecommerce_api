<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Expectation;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('subCategories')->get();
        return send_response(true,'',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50|unique:categories',
            ]);

            if ($validator->fails()) 
                return send_response(false,'validation error!',$validator->errors());

                
            $category = new Category;
            $category->name = $request->name;
            $category->slug = slugify($request->name);
            if($category->save())
                return send_response(true,'category successfully created',$category);

        } catch (Expectation $e) {
            report($e);
    
            return $e;
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
        $category = Category::find($id);
        if($category)
            return send_response(true,'',$category);
        else
            return send_response(false,'No Data Found!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:50',
                    Rule::unique('categories')->ignore($id),
                ],
                'status' => 'required',
            ]);

            if ($validator->fails()) 
                return send_response(false,'validation error!',$validator->errors());

            $category= Category::find($id);
            $category->name = $request->name;
            $category->slug = slugify($request->name);
            $category->status = $request->status;
            if($category->update())
                return send_response(true,'category successfully updated',$category);

        } catch (Expectation $e) {
            report($e);
    
            return $e;
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

}