<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Product;

class StaffLoginController extends Controller
{
    public function login(){
        return view('staff.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'login_name' => 'required',
            'password' => 'required',
        ], [
            'login_name.required' => 'Email không được để trống !',
            'password.required' => 'Mật khẩu không được để trống !',
        ]);
    
        if ($validator->passes()) {
            // Attempt to authenticate user
            if (Auth::guard('staff')->attempt(['login_name' => $request->login_name, 'password' => $request->password], $request->get('remember'))) {
                // User authenticated successfully, redirect to staff home
                return redirect()->route('staff.home');
            } else {
                // Authentication failed, redirect back to login with error message
                return redirect()->route('staff.login')->with('error', 'Tên đăng nhập hoặc mật khẩu không chính xác');
            }
        } else {
            // Validation failed, redirect back to login with validation errors
            return redirect()->route('staff.login')
                ->withErrors($validator)
                ->withInput($request->only('login_name'));
        }
    }
    public function home(){

        $totalOrders = Order::count();
        $beingTransported = Order::where('status', '=', 'Đang vận chuyển')->count(); // Trạng thái đơn hàng là đang vận chuyển
        $ordersComplete = Order::where('status', '=', 'Đã giao hàng')->count(); 
        // dd($ordersComplete);
        // dd($beingTransported);
        // dd($totalOrders);

        return view('staff.home', [
            'totalOrders' =>   $totalOrders,
            'beingTransported' =>   $beingTransported,
            'ordersComplete' =>   $ordersComplete
        ]);
    }

    public function getProducts(){

        $products = Product::latest('id')->with('product_images');

        $products = $products->get();

        $data['products'] = $products;

        return view('staff.productsList',   $data);
    }

    public function logout(){
        Auth::guard('staff')->logout();
        return redirect()->route('staff.login');
    }

      
}
