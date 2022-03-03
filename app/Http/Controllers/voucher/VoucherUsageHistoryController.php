<?php

namespace App\Http\Controllers\voucher;

use App\Http\Controllers\Controller;
use App\Models\VoucherUsageHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherUsageHistoryController extends Controller
{
    public function store($voucher){
        $voucher_usage = new VoucherUsageHistory;
        $voucher_usage->user_id = Auth::user()->id;
        $voucher_usage->voucher_id = $voucher->id;

        $voucher_usage->save();
    }
}
