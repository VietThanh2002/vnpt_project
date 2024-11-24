<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email không được để trống !',
            'password.required' => 'Mật khẩu không được để trống !',
        ]);

        if ($validator->passes()) {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 2], $request->get('remember'))) {
                
                return redirect()->route('admin.dashboard');
            }
            else if ((Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 1], $request->get('remember')))){

                return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập trang quản trị viên !');
            }
            else {
                return redirect()->route('admin.login')->with('error', 'Email hoặc mật khẩu không chính xác');
            }

        } else {
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
        
    }

}
