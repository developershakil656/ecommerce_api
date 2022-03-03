<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;

/**
 * @group payment
 *
 * APIs for managing payment
 */
class PaymentController extends Controller
{
    public function store($total_price,$provider){
        $payment = new Payment;
        $payment->amount = $total_price;
        $payment->provider = $provider;
        $payment->save();

        return $payment->id;
    }
}
