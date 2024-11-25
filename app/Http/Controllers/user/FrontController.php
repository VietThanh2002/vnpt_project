<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Wishlist;

class FrontController extends Controller
{
    public function index(){
        $products = Product::where('status',1)->where('type', 'Dịch vụ Internet')->take(8)->get();
        
        $data['featuredProducts'] = $products;

        $latestProducts = Product::orderBy('id', 'DESC')->where('status',1)->take(8)->get();
        
        $data['latestProducts'] =  $latestProducts;

        return view('user.home', $data);
    }
}
