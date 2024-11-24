<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ListProductSellingController extends Controller
{
    public function listProductSellingWeek(){
        

        $startOfWeek =  Carbon::now()->startOfWeek(); // Ngày đầu tiên của tuần hiện tại
            // echo $startOfWeek;        
        $today = Carbon::now();   // Ngày hiện tại

        // Lấy danh sách sản phẩm bán được theo tuần
        $SellingProductsWeek = OrderDetail::select('order_details.product_id', 'products.name', 'products.price', DB::raw('SUM(order_details.qty) as total_qty'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'Hủy đơn')
            ->whereBetween('orders.created_at', [$startOfWeek, $today])
            ->groupBy('order_details.product_id', 'products.name', 'products.price')
            ->paginate(15);

        // Mảng chứa thông tin sản phẩm bán chạy

        $data['SellingProductsWeek'] = $SellingProductsWeek;




        return view('admin.products_selling_list.products_selling_week_list', $data);
    }

    public function listProductSellingMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth(); // Ngày đầu tiên của tháng hiện tại
        $today = Carbon::now();   // Ngày hiện tại

        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsMonth = OrderDetail::select('order_details.product_id', 'products.name', 'products.price', DB::raw('SUM(order_details.qty) as total_qty'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'Hủy đơn')
            ->whereBetween('orders.created_at', [$startOfMonth, $today])
            ->groupBy('order_details.product_id', 'products.name', 'products.price')
            ->paginate(15);

        // Mảng chứa thông tin sản phẩm bán chạy
        $data['SellingProductsMonth'] = $SellingProductsMonth;

        return view('admin.products_selling_list.products_selling_month_list', $data);
    }


    public function listProductSellingLastMonth()
    {
        $lastMonthStartDate = Carbon::now()->subMonthNoOverflow()->startOfMonth(); // Lấy ngày đầu của tháng trước

        $lastMonthEndDate = Carbon::now()->subMonthNoOverflow()->endOfMonth(); // ngày cuối cùng của tháng trước

        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsLastMonth = OrderDetail::select('order_details.product_id', 'products.name', 'products.price', DB::raw('SUM(order_details.qty) as total_qty'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'Hủy đơn')
            ->whereBetween('orders.created_at', [$lastMonthStartDate,  $lastMonthEndDate])
            ->groupBy('order_details.product_id', 'products.name', 'products.price')
            ->paginate(15);

            // dd($SellingProductsLastMonth);

        // Mảng chứa thông tin sản phẩm bán chạy
        $data['SellingProductsLastMonth'] = $SellingProductsLastMonth;

        return view('admin.products_selling_list.products_selling_last_month_list', $data);
    }

    
    public function listProductSellingYear(){


        $startOfYear =  Carbon::now()->startOfYear(); //Ngày đầu tiên của năm hiện tại
        $today = Carbon::now();  // Ngày hiện tại

        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsYear = OrderDetail::select('order_details.product_id', 'products.name', 'products.price', DB::raw('SUM(order_details.qty) as total_qty'))
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'Hủy đơn')
            ->whereBetween('orders.created_at', [$startOfYear, $today])
            ->groupBy('order_details.product_id', 'products.name', 'products.price')
            ->paginate(15);

            // dd($SellingProductsLastMonth);


        // Mảng chứa thông tin sản phẩm bán chạy
        $data['SellingProductsYear'] =  $SellingProductsYear;

        return view('admin.products_selling_list.products_selling_year_list', $data);
    }

    public function quarter1(){
        // Quý 1
        $startOfQuarter1 = Carbon::now()->startOfYear();  // Ngày đầu tiên của năm
        $endOfQuarter1 = $startOfQuarter1->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 1
    
        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsQuarter1 = $this->getSellingProducts($startOfQuarter1, $endOfQuarter1);
    
        $data['SellingProductsQuarter1'] = $SellingProductsQuarter1;
        
        return view('admin.products_selling_list.products_selling_quarter1_list', $data);
    }
    
    public function quarter2(){
        // Quý 2
        $startOfQuarter2 = Carbon::now()->startOfYear()->addMonths(3); // Ngày đầu tiên của quý 2
        
        $endOfQuarter2 = $startOfQuarter2->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 2
    
        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsQuarter2 = $this->getSellingProducts($startOfQuarter2, $endOfQuarter2);
    
        $data['SellingProductsQuarter2'] = $SellingProductsQuarter2;
        
        return view('admin.products_selling_list.products_selling_quarter2_list', $data);
    }
    
    public function quarter3(){
        // Quý 3
        $startOfQuarter3 = Carbon::now()->startOfYear()->addMonths(6); // Ngày đầu tiên của quý 3
        $endOfQuarter3 = $startOfQuarter3->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 3
    
        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsQuarter3 = $this->getSellingProducts($startOfQuarter3, $endOfQuarter3);
    
        $data['SellingProductsQuarter3'] = $SellingProductsQuarter3;
        
        return view('admin.products_selling_list.products_selling_quarter3_list', $data);
    }
    
    public function quarter4(){
        // Quý 4
        $startOfQuarter4 = Carbon::now()->startOfYear()->addMonths(9); // Ngày đầu tiên của quý 4
        $endOfQuarter4 = $startOfQuarter4->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 4
    
        // Lấy danh sách sản phẩm bán được theo tháng
        $SellingProductsQuarter4 = $this->getSellingProducts($startOfQuarter4, $endOfQuarter4);
    
        $data['SellingProductsQuarter4'] = $SellingProductsQuarter4;
        
        return view('admin.products_selling_list.products_selling_quarter4_list', $data);
    }

    private function getSellingProducts($startDate, $endDate){
        return OrderDetail::select('order_details.product_id', 'products.name', 'products.price', DB::raw('SUM(order_details.qty) as total_qty'))
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->where('orders.status', '!=', 'Hủy đơn')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->groupBy('order_details.product_id', 'products.name', 'products.price')
                ->paginate(15);
    }

}
