<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Models\DiscountCoupon;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UserAddress;
use App\Models\ShippingCost;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Handler\Proxy;

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
            'productImage' => (!empty($product->product_images)) ? $product->product_images->first() : ''
        ]);
    
        // Chuyển hướng đến trang thanh toán
        return response()->json([
            'status' => true,
            'message' => 'Đã thêm dịch vụ'
        ]);
    }

    public function checkout(Request $request){

    



        $discount = 0;
        
        // if (Cart::count() == 0){ // giỏ hàng rỗng
        //     return redirect()->route('user.cart');
        // }

        // chưa đăng nhập
        // if(Auth::check() == false){

        //     if(!session()->has('url.intended')){
        //         session(['url.intended' => url()->current()]); // lưu đường dẫn của trang
        //     }
        //     return redirect()->route('user.login');
        // }

        // session()->forget('url.intended');
        
    
        $grandTotal = Cart::subtotal(2, '.', '');

        

        $ShippingCost = 0;
        
        return view('user.checkout', [
            'ShippingCost' => formatPriceVND($ShippingCost),
            'grandTotal' =>  formatPriceVND($grandTotal),
            'discount' =>  formatPriceVND($discount)
        ]);
    }
    
    // public function processCheckout(Request $request){

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'city' => 'required',
    //         'district' => 'required',
    //         'ward' => 'required',
    //         'address' => 'required',
    //         'mobile' => 'required',
    //     ],[
    //         'name.required' => 'Vui lòng nhập họ tên',
    //         'city.required' => 'Vui lòng chọn Tỉnh/Thành phố',
    //         'district.required' => 'Vui lòng chọn Quận/huyện',
    //         'ward.required' => 'Vui lòng chọn Phường/xã',
    //         'address.required' => 'Vui lòng điều số / tên đường',
    //         'mobile.required' => 'Vui lòng nhập số điện thoại',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'status' => false,
    //             'message' =>  'Đã xảy ra lỗi',
    //             'errors' => $validator->errors()
    //         ]);
    //     }

    //     // lwu địa chi khách hàng
    //     //$userAddress = UserAddress::find();
    //     $user = Auth::user();

    //     UserAddress::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'city' => $request->city,
    //             'district' => $request->district,
    //             'ward' => $request->ward,
    //             'address' => $request->address,
    //             'mobile' => $request->mobile,
    //         ]
    //     );

    //     // lưu dữ liệu vào bản đặt hàng

    //     if($request->payment_method == 'Thanh toán khi nhận hàng'){
    //         $discountCodeId = '';
    //         $promoCode = '';
    //         $discount = 0;
    //         // phí vận chuyển
    //         $shipping = 0;
    //         $subTotal = Cart::subtotal(2, '.', '');
    //         $totalQty = 0;
    //         $grandTotal = 0;
    //         //applyDiscount
    //         if(session()->has('code')){
    //             $code = session()->get('code');
    //             if($code->type == 'percent'){
    //                 $discount = ($code->discount_amount/100)* $subTotal;
    //             }else{
    //                 $discount = $code->discount_amount;
    //             }

    //             $discountCodeId = $code->id; //id mã giảm giá
    //             $promoCode = $code->code;
    //         }
    
    //         foreach(Cart::content() as $item){
    //             $totalQty += $item->qty;
    //         }
            
            
    //         $shippingInfo = ShippingCost::where('city_province', $request->city)->first();

    //         if($shippingInfo != null){

    //             if($subTotal > 5000000){

    //                 $shipping = 0;

    //             }else{

    //                 if($shippingInfo != null){ // = bẳng tỉnh thành có trên database

    //                     $shipping =  $shippingInfo->shipping_fee;
        
    //                     $grandTotal =  ($subTotal - $discount) +   $shipping;
                        
    //                 }else{ // khác tỉnh thành có trên database
    //                     $grandTotal =  ($subTotal - $discount) +   30000;
        
    //                     $shipping =  30000;
    //                 }

    //             }

    //         }
                
    //         if (!is_numeric($discountCodeId)) { //// Kiểm tra nếu discountCodeId không phải là số nguyên hợp lệ
    //             $discountCodeId = null; 
    //         }

    //         $order = new Order();
    //         $order->subtotal =  $subTotal;
    //         $order->shipping = $shipping;
    //         $order->grand_total = $grandTotal;
    //         $order->discount_code_id = $discountCodeId;
    //         $order->discount_code = $promoCode;
    //         $order->payment_status = 'Chưa thanh toán';
    //         $order->payment_method = $request->payment_method;
    //         $order->status = 'Chờ xử lý';
            
    //         $order->user_id  = $user->id;

    //         $order->name = $request->name;
    //         $order->email = $request->email;
    //         $order->city = $request->city;
    //         $order->district = $request->district;
    //         $order->ward = $request->ward;
    //         $order->address = $request->address;
    //         $order->mobile = $request->mobile;
    //         $order->notes = $request->notes;

    //         $order->save();
            
    //         // lưu sản item vào bản order detail

    //         foreach ( Cart::content() as $item){

    //             $orderItem = new OrderDetail();
    //             $orderItem->product_id = $item->id;
    //             $orderItem->order_id = $order->id;
    //             $orderItem->name = $item->name;
    //             $orderItem->qty = $item->qty;
    //             $orderItem->price = $item->price;
    //             $orderItem->total = $item->price * $item->qty;
    //             $orderItem->save();

    //             // Cập nhật lại số lượng sản phẩm
    //             $productData = Product::find($item->id);
    //             if($productData->track_qty == 'Yes'){
    //                 $currentQty =   $productData->qty; // số lượng hiện tại
    //                 $updateQty =  $currentQty - $item->qty;
    //                 $productData->qty = $updateQty;
    //                 $productData->save();
    //             }
        
    //         }
    //         sendEmail($order->id, 'user');

    //         session()->flash('success', 'Bạn đã đặt hàng thành công !');

    //         Cart::destroy();

    //         session()->forget('code');

    //         return response()->json([
    //             'status' => true,
    //             'orderId' => $order->id,
    //             'message' =>  'Bạn đã đặt hàng thành công',
    //         ]);

    
    //     }

    // }

    // Tính lại giá trị đơn hàng khi áp dụng mã giảm giá
    public function processCheckout(Request $request){

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

        // Lưu địa chỉ người dùng vào CSDL
        UserAddress::updateOrCreate(
            ['user_id' => $user->id],
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

        // Xác định phí vận chuyển
        $subTotal = Cart::subtotal(2, '.', '');
        $shipping = 0;
        $discount = 0;

        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount/100)* $subTotal;
            } else {
                $discount = $code->discount_amount;
            }
        }

        $shippingInfo = ShippingCost::where('city_province', $request->city)->first();
        
        if(($shippingInfo != null) && ($subTotal - $discount <= 5000000)){

            $shipping = $shippingInfo->shipping_fee;
        }
        else if(($shippingInfo != null) && ($subTotal >= 5000000)){
            $shipping = 0;
        } 
        else if(($shippingInfo == null) && ($subTotal >= 5000000)){
            $shipping = 0;
        }
        else{
            $shipping = 30000;
        }

        $grandTotal = ($subTotal - $discount) + $shipping;

        // Tạo đơn hàng mới
        $order = new Order();
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->grand_total = $grandTotal;
        $order->discount_code_id = session()->has('code') ? session()->get('code')->id : null;
        $order->discount_code = session()->has('code') ? session()->get('code')->code : null;
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

            // Cập nhật số lượng sản phẩm
            $productData = Product::find($item->id);
            if($productData->track_qty == 'Yes'){
                $currentQty = $productData->qty;
                $updateQty = $currentQty - $item->qty;
                $productData->qty = $updateQty;
                $productData->save();
            }
        }

        // Gửi email xác nhận đơn hàng
        sendEmail($order->id, 'user');

        // Xóa giỏ hàng và mã giảm giá
        Cart::destroy();
        session()->forget('code');

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

    // Tính lại giá trị đơn hàng khi áp dụng mã giảm giá
    public function getOrderSummary(Request $request){
        $subTotal = Cart::subtotal(2, '.', '');
        $discount = 0;
        $shipping = 0;
        $grandTotal = 0;

        // Áp dụng mã giảm giá
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount/100) * $subTotal;
            }else{
                $discount = $code->discount_amount;
            }
        }

        // Lấy thông tin vận chuyển từ database
        $shippingInfo = ShippingCost::where('city_province', $request->city)->first();

        if(($shippingInfo != null) && ($subTotal - $discount <= 5000000)){

            $shipping = $shippingInfo->shipping_fee;
        }
        else if(($shippingInfo != null) && ($subTotal - $discount >= 5000000)){
            $shipping = 0;
        } 
        else if(($shippingInfo == null) && ($subTotal - $discount >= 5000000)){
            $shipping = 0;
        }
        else{
            $shipping = 30000;
        }

        // Tính toán tổng giá trị đơn hàng
        $grandTotal = ($subTotal - $discount) + $shipping;

        return response()->json([
            'status' => true,
            'shippingInfoId' => isset($shippingInfo) ? $shippingInfo->id : null,
            'shippingInfo' => isset($shippingInfo) ? $shippingInfo->city_province : null,
            'grandTotal' => formatPriceVND($grandTotal),
            'shipping' => formatPriceVND($shipping),
            'discount' => formatPriceVND($discount)
        ]);
    }

    

    public function applyDiscount(Request $request){
        $code = DiscountCoupon::where('code', $request->code)->first();

        if($code == null){
            return response()->json([
                'status' => false,
                'message' => 'Phiếu giảm giá không hợp lệ'
              ]);
        }

        // kiểm tra ngày bắt đầu giảm giá có hợp lệ hay không

        $now = Carbon::now('Asia/Ho_Chi_Minh');
        // echo $now;
        // echo $code->start_day;  // In ra giá trị của $code->start_day
        // echo $code->end_day; 
        if($code->start_day != ""){
            $startDate = Carbon::create($code->start_day, 'Asia/Ho_Chi_Minh');

            if($now < ($startDate)){ // nhỏ hơn
                return response()->json([ // Phiếu giảm giá chưa có hiệu lực
                    'status' => false,
                    'message' => 'Chưa đến thời gian áp dụng mã giảm giá !'
                  ]);
            }
        }

        if($code->end_day != ""){ // phiếu giảm giá hết hiệu lực
            $endDate = Carbon::create($code->end_day, 'Asia/Ho_Chi_Minh');

            if($now->gt($endDate)){ // lớn hơn
                return response()->json([
                    'status' => false,
                    'message' => 'Mã giảm giá đã hết giá trị sử dụng !'
                  ]);
            }
        }

        // Kiểm tra số lần sử dụng của mã giảm giá
        if($code->max_usage > 0){

            $couponUsed = Order::where('discount_code_id', $code->id)->count(); 

            if($couponUsed >= $code->max_usage){
                return response()->json([
                    'status' => false,
                    'message' => 'Mã giảm giá hết giá trị sử dụng !'
                ]);
            }
        }


        // Đếm số lần sử dụng của mã giảm giá theo từng người dùng
        if($code->max_uses_user > 0){

            // dd(Auth::user());

            $couponUsedByUser = Order::where(['discount_code_id' => $code->id, 'user_id' => Auth::user()->id])->count();
            // dd($couponUsedByUser);

            if ($couponUsedByUser >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Số lần có thể áp dụng mã giảm giá của bạn đã hết !'
                ]);
            }
        }

        //kiểm tra tình trạng số tiền tối thiểu

        $subTotal = Cart::subtotal(2, '.', '');

        if($code->min_amount > 0){
            if($subTotal < $code->min_amount){

                return response()->json([
                    'status' => false,
                    'message' => 'Giá trị đơn hàng của bạn phải lớn hơn '.formatPriceVND($code->min_amount). ' mới có thể sử dụng mã giảm giá !'
                ]);
            }
        }

        
        session()->put('code', $code);

        return $this->getOrderSummary($request);
    }

    public function removeDiscount(Request $request){
        session()->forget('code');
        return $this->getOrderSummary($request);
    }

}