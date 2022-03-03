<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\ShippingAddress;

class OrderDetailsController extends Controller
{
    public function store($shipping_address_id,$order_id,$payment_id)
    {
        $shipping_address = ShippingAddress::find($shipping_address_id);

        $order_details = new OrderDetails;
        $order_details->order_id = $order_id;
        $order_details->payment_id = $payment_id;
        $order_details->reciever_name = $shipping_address->reciever_name;
        $order_details->number = $shipping_address->number;
        $order_details->region = $shipping_address->region;
        $order_details->city = $shipping_address->city;
        $order_details->area = $shipping_address->area;
        $order_details->address = $shipping_address->address;
        $order_details->label = $shipping_address->label;

        $order_details->save();
    }
}
