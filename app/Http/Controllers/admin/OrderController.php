<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\OrderDetail;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::orderBy('orders.created_at', 'DESC')
            ->select('orders.*', 'users.email', 'users.name', 'users.phone_number')
            ->leftJoin('users', 'users.id', 'orders.user_id');

        if(!empty($request->get('keyword'))){
            $orders =   $orders->where('users.name', 'like', '%'.$request->get('keyword').'%' );
            $orders =   $orders->orWhere('users.email', 'like', '%'.$request->get('keyword').'%' );
            $orders =   $orders->orWhere('users.phone_number', 'like', '%'.$request->get('keyword').'%' );
        }

        $orders = $orders->paginate(20);

        $data['orders'] =  $orders;

        return view('admin.orders.list', $data);
    }

    
    
    public function detailOrder($orderId){

        $order = Order::where('id', $orderId)->first();

            // nạp thêm thông tin bảng sản phẩm để lấy thêm hình ảnh sản phẩm
        $orderDetail = OrderDetail::where('order_id', $orderId)
                                    ->with('product.product_images') // Kèm theo thông tin về hình ảnh sản phẩm
                                    ->get();                            // đã được định nghĩa eloquent 

        // dd($orderDetail);
 
        $data['order'] = $order;
        $data['orderDetail'] = $orderDetail;

        return view('admin.orders.orderDetail', $data, [
        ]);
    }

    public function changeOrderStatus(Request  $request, $orderId){
        $order = Order::find($orderId);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;

        $order->save();

        session()->flash('success', 'Cập nhật trạng thái đơn hàng thành công!');

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công!'
        ]);
    }

    public function destroy($orderId, Request $request){

        $order = Order::find($orderId);

        if(empty($order)){
            return redirect()->route('admin.dashboard');
        }
        
        $order->delete();

        session()->flash('success', 'Xóa thành công!');
      
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công !'
        ]);
    }

    public function sendEmailOrder(Request $request, $orderId){

        sendEmail($orderId, $request->userType);

        session()->flash('success', 'Gửi đơn hàng qua email thành công!');

        return response()->json([
            'status' => true,
            'message' => 'Gửi đơn hàng qua email thành công!'
        ]);

    }
}
