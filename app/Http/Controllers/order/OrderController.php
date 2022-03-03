<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\order\OrderItemsController;
use App\Http\Controllers\payment\PaymentController;
use App\Http\Controllers\voucher\VoucherController;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group User/Order
 *
 * APIs for managing Users Order
 */
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return send_response(true, '', $orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #order form validation
        $validator = $this->order_validation($request);
        if ($validator->fails()) {
            return send_response(false, 'validation error!', $validator->errors(), 500);
        }

        $order = new Order;
        $order->user_id = Auth::user()->id;

        //transaction
        DB::beginTransaction();
        if ($order->save()) {

            #store all items
            if ($request->order_items) {
                $order_items = new OrderItemsController;
                // $order_items->store($request->order_items, $order->id);
                if ($order_items->store($request->order_items, $order->id))
                    return send_response(false, 'some items out of stock!', null, 500);
            }

            #setting status,total price and totl items of order
            $total = new OrderItemsController;
            $total = $total->total($order->id);

            $voucher_value=0;
            $voucher_code= null;
            if($request->voucher){
                // check again this voucher
                $voucherController = new VoucherController;
                $voucher= $voucherController->checkAgain($request->voucher['code'],$total['price']);
                if(is_array($voucher)){
                    $voucher_value= $voucher['value'];
                    $voucher_code= $voucher['code'];
                    $voucherController->usingUpdate($voucher_code);
                }else{
                    return $voucher;
                }
            }

            $order->shipping_charge = $request->shipping_charge;
            $order->voucher_discount = $voucher_value;
            $order->total_price = $total['price'] - $voucher_value + $request->shipping_charge;
            $order->total_items = $total['items'];
            $order->voucher = $voucher_code;
            if($request->payment_option == 'cash_on_delivery')
                $order->status = 'prossesing';

            #setting order payment
            if ($request->payment_option) {
                $payment = new PaymentController;
                $payment_id = $payment->store($order->total_price, $request->payment_option);
            }

            #setting order details
            if ($request->shipping_address_id) {
                $order_details = new OrderDetailsController;
                $order_details->store($request->shipping_address_id, $order->id, $payment_id);
            }

            $order->update();

            DB::commit();
            return send_response(true, 'order successfully created.');
        }
    }

    #custom method for use this controller

    #make validataion
    private function order_validation($request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address_id' => 'required',

            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required',
            'order_items.*.product_size_id' => 'required',
            'order_items.*.product_color_id' => 'required',
            'order_items.*.quantity' => 'required',

            'payment_option' => 'required',

        ]);
        return $validator;
    }
}
