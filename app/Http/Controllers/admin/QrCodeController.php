<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;


class QrCodeController extends Controller
{
    public function showHello(){
      return view('staff.productsList');
    }
}
