<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductsController extends Controller
{
    public function getAll(Request $request){

        $products = Product::latest('id')->with('product_images')->get(); // Lấy dữ liệu sản phẩm

        return response()->json(['products' => $products], 200); // Trả về JSON response

    }

    public function getOne($id){

        $product = Product::with('product_images')->findOrFail($id);
    
        return response()->json(['product' => $product], 200);
    }

 
}
