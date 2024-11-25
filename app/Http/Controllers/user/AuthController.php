<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\DiscountCoupon;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // đung để xứ lý chuổi
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){

        return view('user.account.login');
    }

    public function register(){
        return view('user.account.register');
    }

    public function processRegister(Request $request){

        $validator = Validator::make($request->all(), [

            'name' => 'required|min:8',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|min:10|max:10',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',

        ],[
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email này đã tồn tại trong hệ thống',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password_confirmation.required' => 'Mật khẩu xác nhận không được để trống',
        ]);

        if($validator->passes()){

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->password = Hash::make($request->password);
            $user->save();
            
            session()->flash('success', 'Đăng ký tài khoản thành công !');

             return response()->json([
                'status' => true,
                'message' => 'Đăng ký tài khoản thành công !'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request) {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ]);
    
        // Kiểm tra validate
        if ($validator->fails()) {
            return redirect()->route('user.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    
        // Xác thực người dùng với vai trò role = 1 (người dùng thông thường)
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 1], $request->filled('remember'))) {
            
            // Kiểm tra xem có URL nào được lưu trong session không
            $intendedUrl = session('url.intended', route('user.profile')); // Mặc định chuyển đến trang profile
            session()->forget('url.intended'); // Xóa session sau khi sử dụng
            
            return redirect($intendedUrl);
        }
    
        // Đăng nhập thất bại
        session()->flash('error', 'Email hoặc mật khẩu không chính xác');
        return redirect()->route('user.login')
            ->withInput($request->only('email'))
            ->with('error', 'Email hoặc mật khẩu không chính xác');
    }
    

    public function logout(){

        Auth::logout();

        return redirect()->route('user.login')
                            ->with('success', 'Đăng xuất tài khoản thành công !');
    }

    public function profile(){

        $user = Auth::user(); // lấy người dùng hiện tại
        
        $data['user'] = $user;

        return view('user.account.profile', $data);
    }

    public function addressInfo(){
        $userAddress = UserAddress::where('user_id',  Auth::user()->id)->first();
        $data['userAddress'] = $userAddress;
        return view('user.account.addressInfo', $data);
    }

    public function updateProfile(Request $request, $userId){
        $user = Auth::user();
    
        if($user->id != $userId){
            return response()->json([
                'status' => false,
                'errors' => 'Bạn không có quyền cập nhật thông tin của người dùng khác'
            ]);
        }

         // Lấy thông tin người dùng cần cập nhật
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'errors' => 'Người dùng không tồn tại'
            ]);
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:8',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|min:10|max:10',
        ],[
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải ít nhất :min ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng bởi người dùng khác',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.min' => 'Số điện thoại phải có ít nhất :min ký tự',
            'phone_number.max' => 'Số điện thoại không được quá :max ký tự',
        ]);
    
        if($validator->passes()){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;

            $user->save();

            session()->flash('success', 'Cập nhật thông tin cá nhân thành công!');

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông tin thành công!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function updateUserAddress(Request $request){
        $userId = Auth::user()->id;
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
            'mobile' => 'required',
        ],[
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'city.required' => 'Vui lòng chọn Tỉnh/Thành phố',
            'district.required' => 'Vui lòng chọn Quận/huyện',
            'ward.required' => 'Vui lòng chọn Phường/xã',
            'address.required' => 'Vui lòng điều số / tên đường',
            'mobile.required' => 'Vui lòng nhập số điện thoại',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' =>  'Đã xảy ra lỗi',
                'errors' => $validator->errors()
            ]);
        }
    
        if($validator->passes()){
            $user = User::find($userId);
            UserAddress::updateOrCreate(
                ['user_id' =>  $user->id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'city' => $request->city,
                    'district' => $request->district,
                    'ward' => $request->ward,
                    'address' => $request->address,
                    'mobile' => $request->mobile,
                ]
            );

            session()->flash('success', 'Cập nhật địa chỉ nhận hàng thành công!');

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông tin thành công!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    

    public function getOrder(){

        $user = Auth::user()->id; // lấy id user hiện tại
        // dd($user);
        
        $orders = Order::where('user_id', $user)->where('status', '!=' , 'Hủy đơn')->paginate(5);
        $cancelOrders = Order::where('user_id', $user)->where('status', '=' , 'Hủy đơn')->paginate(5);

        // dd($cancelOrders);

        $data['orders'] = $orders;
        $data['cancelOrders'] = $cancelOrders;

        return view('user.account.order', $data);
    }

    public function getOrderDetail($id){

        $user = Auth::user();

        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        // nạp thêm thông tin bảng sản phẩm để lấy thêm hình ảnh sản phẩm
        $orderDetail = OrderDetail::where('order_id', $id)
                                    ->with('product.product_images') // Kèm theo thông tin về hình ảnh sản phẩm
                                    ->get();                            // đã được định nghĩa eloquent 

        // dd($orderDetail);
         // Lấy thông tin về mã giảm giá
        
        $data['order'] = $order;
        // dd(  $orderDetail);
        $data['orderDetail'] =  $orderDetail;

        return view('user.account.orderDetail', $data, [

        ]);
    }


    public function cancelOrder($id){

        $order = Order::find($id);
  
        if(empty($order)){
  
          session()->flash('error', 'Đơn hàng không tồn tại');
  
          return response([
            'status' => false,
            'notFound' => true,
          ]);
      }

      if($order->status == 'Chờ xử lý'){

        $order->update(['status' => 'Hủy đơn']);
  
        session()->flash('success', 'Đã hủy đơn hàng!!');
  
        return response()->json([
          'status' => true,
          'message' => 'Đã hủy đơn hàng!!'
        ]);

      }else{
        session()->flash('error', 'Đơn hàng đã được vận chuyển bạn không thể xóa đơn hàng này!!');
  
        return response()->json([
          'status' => false,
          'error' => 'Đơn hàng đã được vận chuyển bạn không thể xóa đơn hàng này!!'
        ]);
      }
  
    }


    public function changePassWordForm(){
        return view('user.account.changepassword');
    }

    public function changePassWord(Request $request){

        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password',
            'confirm_password' => 'required|same:new_password',

        ],[
            'old_password.required' => 'Mật khẩu cũ không đươc để trống!',
            'new_password.required' => 'Mật khẩu mới không được để trống!',
            'new_password.min' => 'Chiều dài mật khẩu ít nhất 8 ký tự!',
            'new_password.different' => 'Mật khẩu mới không được trùng với mật khẩu cũ!',
            'confirm_password.required' => 'Mật khẩu nhập xác nhận không được để trống!',
            'confirm_password.same' => 'Mật khẩu nhập xác không khớp, vui lòng kiểm tra lại!',
        ]);

        if($validator->passes()){
            $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();

            if(!Hash::check($request->old_password, $user->password)){

                session()->flash('error', 'Mật khẩu cũ không chính xác, vui lòng kiểm tra lại!');

                return response()->json([
                    'status' => true,
                  ]);
            }

            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success', 'Thay đổi mật khẩu thành công');

            return response()->json([
                'status' => true,
              ]);


            // dd($user);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
              ]);
        }
    }

    public function forgotPassword(){
        return view('user.account.forgotpassword');
    }

    public function executeResetPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users' //exists:table_name,coloumn_name kiểm tra email có tồn tại trên csdl không
        ],[
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
        ]);

        if($validator->fails()){ // fails trả về true khi dữ liệu không hợp lệ
            return redirect()->route('user.forgotPassword')->withInput()->withErrors($validator); //biến $message nhận thông điệp từ withErrors
        }

        $token = Str::random(50); //tạo một chuỗi ngẫu nhiên với độ dài 50
         // Trong bảng password_reset_tokens email là khóa chính trên email không thế bị trùng
        DB::table('password_reset_tokens')->where('email', $request->email)->delete(); // trước khi chèn sẽ xóa

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        //Gửi mail

        $user = User::where('email', $request->email)->first();

        $mailContent = [
            'token' => $token,
            'user' => $user,
            'mailSubject' => 'Yêu cầu để đặt lại mật khẩu'
        ];

        Mail::to($request->email)->send(new ResetPassword($mailContent));

        return redirect()->route('user.forgotPassword')->with('success', 'Vui lòng kiểm tra email để thiết lập lại mật khẩu của bạn');

    }

    public function resetPassword($token){

        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        if($tokenExist == null){
            return redirect()->route('user.forgotPassword')->with('error', 'yêu cầu không hợp lệ');
        }

        return view('user.account.resetPassword', [
            'token' => $token,
        ]);
    }

    public function processResetPassword(Request $request){

        $token = $request->token;

        $tokenObj = DB::table('password_reset_tokens')->where('token', $token)->first();

        if($tokenObj == null){
            return redirect()->route('user.forgotPassword')->with('error', 'Yêu cầu không hợp lệ');
        }

        $user = User::where('email',  $tokenObj->email)->first();

        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password' //exists:table_name,coloumn_name kiểm tra email có tồn tại trên csdl không
        ],[
            'new_password.required' => 'Mật khẩu không được để trống !',
            'new_password.min' => 'Mật khẩu phải lớn hơn 7 ký tự!',
            'confirm_password.required' => 'Mật khẩu xác nhận không được để trống!',
            'confirm_password.same' => 'Mật khẩu xác nhận không chính xác'
        ]);

        if($validator->fails()){ // fails trả về true khi dữ liệu không hợp lệ
            return redirect()->route('user.resetPassword', $token)->withErrors($validator);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete(); 

        return redirect()->route('user.login')->with('success', 'Đặt lại mật khẩu thành công');

    }
}
