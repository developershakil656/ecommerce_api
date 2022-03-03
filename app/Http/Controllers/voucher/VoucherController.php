<?php

namespace App\Http\Controllers\voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherUsageHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = Voucher::get();
        return send_response(true, '', $vouchers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:50|unique:vouchers',
            'value' => 'required'
        ]);

        if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors(), 422);
        $voucher = new Voucher;

        $this->set_data($voucher, $request);

        if ($voucher->save())
            return send_response(true, 'voucher successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = Voucher::find($id);
        if ($voucher)
            return send_response(true, '', $voucher);
        else
            return send_response(false, 'No Data Found!');
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
        $validator = Validator::make($request->all(), [
            'code' => [
                'required',
                'max:50',
                Rule::unique('vouchers')->ignore($id),
            ],
            'value' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails())
            return send_response(false, 'validation error!', $validator->errors(), 422);
        $voucher = Voucher::findOrFail($id);

        $this->set_data($voucher, $request);

        if ($voucher->update())
            return send_response(true, 'voucher successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return send_response(false, 'not found!');
    }

    // custom function

    private function set_data($voucher, $request)
    {
        $voucher->code = $request->code;
        $voucher->value = $request->value;
        $voucher->type = $request->type ? $request->type : 'flat';
        $voucher->minimum_order_value = $request->minimum_order_value;
        $voucher->maximum_discount_value = $request->maximum_discount_value;
        $voucher->start = $request->start;
        $voucher->end = $request->end;
        $voucher->limit = $request->limit || 1000;
        $voucher->details = $request->details;
        $voucher->status = $request->status;
        $voucher->only_for_users = $request->only_for_users;
    }
    /**
     * Check the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        return $this->checkVoucher($request->code, $request->order_value, true);
    }
    public function checkAgain($voucher_code, $order_value)
    {
        return $this->checkVoucher($voucher_code, $order_value);
    }

    private function checkVoucher($code, $order_value, $default_json_response = false)
    {
        $voucher = Voucher::where('code', $code)->first();

        if ($voucher) {
            if ($voucher->status == 'active') {
                if (($voucher->limit) !== null && ($voucher->limit) == 0) {
                    return send_response(false, 'sorry! this voucher reached its limit', null, 500);
                } else {
                    if ($voucher->start) {
                        $today = Carbon::now()->toDateTimeString();
                        $start = $voucher->start;
                        if ($start <= $today) {
                            if ($voucher->end) {
                                $end = $voucher->end;
                                if ($today > $end) {
                                    return send_response(false, 'sorry! this voucher has expired', null, 500);
                                }
                            }
                        } else {
                            return send_response(false, 'sorry! this voucher no found', null, 500);
                        }
                    }
                    if ($minimun = $voucher->minimum_order_value) {
                        if (($minimun) > ($order_value))
                            return send_response(false, 'add another ' . $minimun - $order_value . ' tk', null, 500);
                    }

                    // checking user
                    if ($voucher->user_type) {
                        $voucher_usage = VoucherUsageHistory::where("user_id", Auth::user()->id)->get();
                        //  user type
                        if ($voucher->user_type == 'new') {
                            if ($voucher_usage->count()) {
                                return send_response(false, 'sorry! this voucher is only for new user', null, 500);
                            }
                        } elseif ($voucher->user_type == 'existing') {
                            if ($voucher_usage->count() < 1) {
                                return send_response(false, 'sorry! this voucher is only for existing user', null, 500);
                            }
                        }
                    }


                    if($voucher->only_for_users){
                        if(!in_array(Auth::user()->id,$voucher->only_for_users))
                        return send_response(false, 'sorry! this voucher is only for special user', null, 500);
                    }

                    // checking for specific date
                    $form = Carbon::today()->addDay()->subDays($voucher->for)->toDateString();
                    $form = $voucher->for ? $form:0;
                    $today = Carbon::today()->toDateString();
                    $voucher_usage = VoucherUsageHistory::where([
                        ["voucher_id", $voucher->id],
                        ["user_id", Auth::user()->id]
                    ])->whereDate('created_at', '>=', $form)->get();
                    if ($voucher->user_limit) {
                        if ($voucher_usage->count() >= $voucher->user_limit)
                            return send_response(false, 'sorry! this voucher is already used', null, 500);
                    }

                    // send response
                    $data = [];
                    $data['code'] = $voucher->code;

                    if ($voucher->type == 'flat') {
                        $data['value'] = $voucher->value;
                    } elseif ($voucher->type == 'percent') {
                        $value = ($order_value * $voucher->value) / 100;

                        if ($voucher->maximum_discount_value && $value > $voucher->maximum_discount_value) {
                            $data['value'] = $voucher->maximum_discount_value;
                        } else {
                            $data['value'] = $value;
                        }
                    }
                    if ($default_json_response) {
                        return send_response(true, '', $data, 200);
                    } else {
                        return $data;
                    }
                }
            }
        }
        return send_response(false, 'invalid code!', null, 500);
    }

    public function usingUpdate($voucher_code)
    {
        $voucher = Voucher::where('code', $voucher_code)->first();

        if ($voucher->limit)
            $voucher->limit = $voucher->limit - 1;
        $voucher->total_used = $voucher->total_used + 1;

        if ($voucher->update())
            $voucher_usage = new VoucherUsageHistoryController;
        $voucher_usage->store($voucher);
    }
}
