<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Models\DiscountCoupon;

class DeliveryController extends Controller
{
    // Giao  hàng 
    public function ordersPending(){
        $orders = Order::latest('orders.created_at')
            ->select('orders.*', 'users.email', 'users.name', 'users.phone_number')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->where('orders.status', '=', 'Đang vận chuyển')
            ->get();

        $data['orders'] = $orders;

        return view('staff.listOrdersPending', $data);
    }

    public function ordersComplete(){

            $ordersComplete = Order::latest('orders.updated_at')
            ->select('orders.*', 'users.email', 'users.name', 'users.phone_number')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->where('orders.status', '=', 'Đã giao hàng')
            ->get();

        $data['ordersComplete'] =  $ordersComplete;

        return view('staff.listOrdersComplete', $data);

    }


    public function detailOrder($orderId){

        $order = Order::where('id', $orderId)->first();
        $orderDetail = OrderDetail::where('order_id', $orderId)->get();

        // dd($orderDetail);

        $data['order'] = $order;
        $data['orderDetail'] = $orderDetail;

        return view('admin.orders.orderDetail', $data);
    }

    public function updateOrderStatusQR(Request $request, $orderId){

        $order = Order::find($orderId);
        $order->status = 'Đã giao hàng';
        $order->payment_status = 'Đã thanh toán';
        
        $order->save();
    }

    public function successful($id){
        return view('staff.successful',[
            'id' => $id
        ]);
    }
    
    public function viewBill($orderId){

       // Lấy thông tin về đơn hàng
       $order = Order::find($orderId);
        
       if (!$order) {
           // Xử lý trường hợp không tìm thấy đơn hàng
           return redirect()->route('admin.orders.list')->with('error', 'Đơn hàng không tồn tại.');
       }

       // Lấy thông tin chi tiết của đơn hàng kèm theo thông tin sản phẩm
       $orderDetails = OrderDetail::where('order_id', $orderId)
                                   ->join('products', 'order_details.product_id', '=', 'products.id')
                                   ->select('order_details.*', 'products.name AS product_name')
                                   ->get();

       // Lấy thông tin về mã giảm giá
       $discountAmount = null;
       $discountCode = $order->discount_code;

       if ($discountCode) {
           $discount = DiscountCoupon::where('code', $discountCode)->first();
           $discountAmount = $discount ? $discount->discount_amount : null;
       }

        return view('staff.bill.viewbill', [
            'order' => $order,
            'orderDetails' =>$orderDetails,
            'discountAmount' =>  $discountAmount
        ]);

    }

    public function viewProfile(){

        $staff = Auth()->user();
        // dd($staffs);

        return view('staff.account.profile', [
            'staff' => $staff
        ]);
    }
}
