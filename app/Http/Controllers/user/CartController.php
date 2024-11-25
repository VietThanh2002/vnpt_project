<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function formatPriceVND($number) {
        
        $floatNumber = floatval(str_replace(',', '', $number)); // Chuyển đổi chuỗi thành số thực và loại bỏ dấu phẩy
        return number_format($floatNumber, 0, ',', '.') . ' ₫';
    }

    public function addService(Request $request) {
        // Tìm sản phẩm theo ID
        $product = Product::with('product_images')->find($request->id);
    
        // Kiểm tra sản phẩm tồn tại không
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm không tồn tại'
            ]);
        }
    
        // Xóa toàn bộ giỏ hàng trước khi thêm dịch vụ mới
        Cart::destroy();  // Xóa tất cả các mục trong giỏ hàng

        // Thêm sản phẩm vào giỏ hàng
        Cart::add($product->id, $product->name, 1, $product->price, [
            'type' => $product->type,
            'productImage' => (!empty($product->product_images)) ? $product->product_images->first() : ''
        ]);
    
        // Chuyển hướng đến trang thanh toán
        return response()->json([
            'status' => true,
            'message' => 'Đã thêm dịch vụ'
        ]);
    }

    public function buySim(Request $request){

        $product = Product::with('product_images')->find($request->id);

        if($product == null){
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm không tồn tại'
            ]);
        }

        Cart::destroy();

        Cart::add($product->id, $product->sim_number, 1, $product->price, [
            'type' => $product->type,
            'sim_type' => $product->sim_type,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đã thêm sim vào giỏ hàng'
        ]);
    }

    public function checkout(Request $request){
        // dd( Cart::content());

        // chưa đăng nhập
        if (!Auth::check()) {
            session(['url.intended' => url()->current()]);
            return redirect()->route('user.login');
        }

        session()->forget('url.intended');

        $grandTotal = Cart::subtotal(2, '.', '');

        return view('user.checkout', [
            'grandTotal' =>  formatPriceVND($grandTotal),
        ]);
    }

    // Tính lại giá trị đơn hàng khi áp dụng mã giảm giá
    public function processCheckout(Request $request){

        // dd( $request->all());

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

        // Lấy thông tin người dùng
        $user = Auth::user();

        $grandTotal = Cart::subtotal(2, '.', '');
        // Tạo đơn hàng mới
        $order = new Order();
        $order->grand_total = $grandTotal;
        $order->payment_status = 'Chưa thanh toán';
        $order->payment_method = $request->payment_method;
        $order->status = 'Chờ xử lý';
        $order->user_id = $user->id;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->city = $request->city;
        $order->district = $request->district;
        $order->ward = $request->ward;
        $order->address = $request->address;
        $order->mobile = $request->mobile;
        $order->notes = $request->notes;
        $order->save();
        
        // Lưu sản phẩm vào chi tiết đơn hàng
        foreach (Cart::content() as $item){
            $orderItem = new OrderDetail();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->name = $item->name;
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;
            $orderItem->save();
           
        }
        // Gửi email xác nhận đơn hàng
        sendEmail($order->id, 'user');

        // Xóa giỏ hàng 
        Cart::destroy();

        // Trả về thông tin đơn hàng mới
        return response()->json([
            'status' => true,
            'orderId' => $order->id,
            'message' => 'Bạn đã đặt hàng thành công',
        ]);
    }


    public function thank($id){
        return view('user.success_order',[
            'id' => $id
        ]);
    }
}