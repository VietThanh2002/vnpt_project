<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderDetail;

class WarehouseController extends Controller
{
    public function import(Request $request){
        $products = Product::orderBy('created_at', 'ASC');

        if($request->get('keyword') != ""){
            $products = $products->where('name','like','%'.$request->keyword.'%');
        }
        $products = $products->paginate(10);

        return view('admin.warehouse.importProducts', compact('products'));
    }
}
