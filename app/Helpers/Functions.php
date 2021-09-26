<?php
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @param $text
 * @return bool|false|string|string[]|null
 */
function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

// api response
function send_response($status, $message = '', $data = null)
{
    $res = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];

    return response()->json($res);
}

#multiple delete,update,trash,restore url
// function multipleResourceUrl($url,$controller){
//     $res= Route::prefix($url)->group(function() use($controller){
//             Route::post('/move/to/trash',[$controller,'trash']);
//             Route::post('/change/status',[$controller,'changeStatus']);
//             Route::get('/trashed/items',[$controller,'trashed']);
//             Route::post('/force/delete',[$controller,'forceDelete']);
//             Route::post('/restore',[$controller,'restore']);
//         });
//     return $res;
// }
#------------------------------------------- multiple resource url and contorler start------------------------------------
#multiple delete,update,trash,restore url
function multipleResourceUrl($url,$model)
{
    $res = Route::prefix($url)->group(function() use($model){
        Route::post('/move/to/trash', function (Request $request) use($model){
            return trash($request,$model);
        });
        Route::post('/change/status', function(Request $request) use($model){
            return changeStatus($request,$model);
        });
        Route::get('/trashed/items', function() use($model){
            return trashed($model);
        });
        Route::post('/force/delete', function (Request $request) use($model){
            return forceDelete($request,$model);
        });
        Route::post('/restore', function (Request $request) use($model){
            return restore($request,$model);
        });
    });
    return $res;
}

#multiple delete,update,trash,restore controller
#change status
function changeStatus(Request $request,$model)
{
    $validator = resource_validation($request,true);
    if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors());

    foreach ($request->data as $id) {
        $item = $model::find($id);

        if ($item) {
            $item->status = $request->status;
            $item->update();
        }
    }
    return send_response(true, 'status successfully changed');
}

#trash and trushed item
function trash(Request $request,$model)
{
    $validator = resource_validation($request);
    if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors());

    foreach ($request->data as $id) {
        $item = $model::find($id);
        if ($item)
            $item->delete();
    }

    return send_response(true, 'successfully moved to trashed');
}

function trashed($model)
{
    $items = $model::onlyTrashed()->get();
    return send_response(true, 'success', $items);
}

#force delete and restore
function forceDelete(Request $request,$model)
{
    $validator = resource_validation($request);
    if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors());

    foreach ($request->data as $id) {
        $item = $model::onlyTrashed()->find($id);
        if ($item)
            $item->forceDelete();
    }

    return send_response(true, 'successfully deleted');
}

function restore(Request $request,$model)
{
    $validator = resource_validation($request);
    if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors());

    foreach ($request->data as $id) {
        $item = $model::onlyTrashed()->find($id);
        if ($item)
            $item->restore();
    }

    return send_response(true, 'successfully restored');
}

# multiple resource url controller validation
function resource_validation($request,$status=false){
    $status=$status ? 'required':'';
    $validator = Validator::make($request->all(), [
        'data' => 'required',
        'status' => $status
    ]);
    return $validator;
}

# -------------------------------------------------multiple resource url and contorler end------------------------------

//image url generator
function image_link_genterator($file_type, $any_unique_info, $add_to_end = 0)
{

    $name = $any_unique_info . date('-sihdmy-') . $add_to_end;

    $fileType = explode('/', $file_type);
    $ext = end($fileType);
    $full_name = $name . '.' . $ext;
    $thumbnail_path = 'gallery/products/';

    $url = $thumbnail_path . $full_name;
    $file_type = array_shift($fileType);

    #setting resposne
    $res = [];
    $res['url'] = $url;
    $res['file'] = $file_type;

    return $res;
}

//product size for seeding
function product_size($val)
{
    $res = ['m', 'l', 'xl', 'xxl', 'xxxl'];

    return $res[$val];
}
