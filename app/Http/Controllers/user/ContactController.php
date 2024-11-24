<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
class ContactController extends Controller
{
    public function index(){
        return view('user.contact');
    }

    public function sendContactEmail(Request $request){

        $validator = Validator::make($request->all(),[
            'user_name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:10',
            'content' => 'required'
        ],[
            'user_name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'subject.required' => 'Vui lòng nhập chủ đề liên hệ',
            'subject.min' => 'Chủ đề liên hệ không đươc nhỏ hơn 10 ký tự',
            'content.required' => 'Vui lòng nhập nội dung liên hệ'
        ]);

        if($validator->passes()){
            //send email
            $mailContent = [
                'user_name' => $request->user_name,
                'email' => $request->email,
                'subject' => $request->subject,
                'content' => $request->content,
                'mail_subject' => 'Bạn đã nhận được một email liên từ khách hàng'
            ];

            $admin = User::where('id', 1)->first();

            Mail::to($admin->email)->send(new ContactEmail($mailContent));

            session()->flash('success', 'Bạn đã gửi liên hệ thành công, chúng tôi gửi phản hồi bạn trong thời gian sớm nhất !');

            return response()->json([
                'status' => true,
                'message' => 'Bạn đã gửi liên hệ thành công, chúng tôi gửi phản hồi bạn trong thời gian sớm nhất !'
             ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
