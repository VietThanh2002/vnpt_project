<?php

namespace App\Http\Controllers\admin;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Carbon;
use App\Models\DiscountCoupon;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function index($orderId)
    {
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


        return view('admin.bill.viewbill', [
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

    
    
    public function exportPdf($orderId){

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


            $data = [
                'order' => $order,
                'orderDetails' => $orderDetails,
            ];
    
            // Tạo PDF từ view và dữ liệu
           $pdf = FacadePdf::loadView('admin.bill.expdf', $data);
    
            // Xuất hóa đơn dưới dạng PDF
            $today = Carbon::now()->format('d-m-Y');

            return $pdf->download('export-order-'. $order->id.'/'. $today .'.pdf');

    }
}
