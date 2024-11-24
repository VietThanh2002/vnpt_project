<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePassWordController extends Controller
{
    public function changePassWordForm(){
        return view('admin.changePassWord');
    }

    public function changePassWord(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ],[
            'old_password.required' => 'Mật khẩu cũ không được để trống!',
            'new_password.required' => 'Mật khẩu mới không được để trống!',
            'new_password.min' => 'Mật khẩu không được nhỏ hơn 8 ký tự !',
            'confirm_password.required' => 'Mật khẩu xác nhận không được để trống!',
            'confirm_password.same' => 'Mật khẩu xác nhận không chính xác !'
        ]);
        
        $id =  Auth::guard('admin')->user()->id;

        $admin = User::where('id', $id)->first();

        if($validator->passes()){
          
            if(!Hash::check($request->old_password, $admin->password)){
                session()->flash('error','Mật khẩu hiện tại không chính xác, vui lòng kiểm tra lại');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', $id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success','Cập nhật mật khẩu thành công !');
                return response()->json([
                    'status' => true,
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
