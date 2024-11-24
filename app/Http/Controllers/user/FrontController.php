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
        $products = Product::where('is_featured','Yes')->where('status',1)->take(8)->get();
        
        $data['featuredProducts'] = $products;

        $latestProducts = Product::orderBy('id', 'DESC')->where('status',1)->take(8)->get();
        
        $data['latestProducts'] =  $latestProducts;

        return view('user.home', $data);
    }

    public function addToWishlist(Request $request){

        if(Auth::check() == false){

            session(['url.intended'=>url()->previous()]); //: Nếu người dùng chưa đăng nhập, lưu URL của trang trước đó vào session với key là 'url.intended'

            return response()->json([
                'status' => false,
            ]);
        }

        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id
            ]
        );

        // $wishlist = new Wishlist();
        // $wishlist->user_id = Auth::user()->id;
        // $wishlist->product_id = $request->id;
        // $wishlist->save();

        $product = Product::where('id', $request->id)->first();

        if($product == null){
            return response()->json([
                'status' => true,
                'message' => '<div class="text-center text-danger">Sản phẩm không tồn tại!</div>'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '<div class="text-center text-success"><strong>'.$product->name.'</strong> Đã thêm sản phẩm vào danh sách yêu thích!</div>'
        ]);
    }
}
