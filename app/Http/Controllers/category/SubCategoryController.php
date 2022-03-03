<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Expectation;

/**
 * @group Admin/SubCategory
 *
 * APIs for managing SubCategory,access by Admin
 */
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = SubCategory::with('category')->get();
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
                'name' => [
                        'required',
                        'max:50',
                        Rule::unique('sub_categories')->where('category_id',$request->category_id),
                    ],
                'category_id' => 'required',
            ]);

            if ($validator->fails()) 
                return send_response(false,'validation error!',$validator->errors(),400);

                
            $category = new SubCategory;
            $category->category_id = $request->category_id;
            $category->name = $request->name;
            $category->slug = slugify($request->name);
            if($category->save())
                return send_response(true,'sub-category successfully created',$category);

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
        $category = SubCategory::find($id);
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
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:50',
                    Rule::unique('sub_categories')->where('category_id',$request->category_id)->ignore($id),
                ],
                'category_id' => 'required',
                'status' => 'required|in:active,inactive',
            ]);

            if ($validator->fails()) 
                return send_response(false,'validation error!',$validator->errors(),400);

            $category= SubCategory::find($id);
            $category->name = $request->name;
            $category->category_id = $request->category_id;
            $category->slug = slugify($request->name);
            $category->status = $request->status;
            if($category->update())
                return send_response(true,'sub-category successfully updated',$category);

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