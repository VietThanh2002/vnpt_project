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
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){
        
        
        $totalUser = User::where('role', 1)->count();
        $totalOrder = Order::where('status', '!=', 'Hủy đơn')->count();
        $totalCancelOrders = Order::where('status', '=', 'Hủy đơn')->count();
        $totalOrderComplete = Order::where('status', '=', 'Đã giao hàng')->count();
        $totalProduct = Product::count();

        $usersVipCount = DB::table('users')
                            ->join('orders', 'users.id', '=', 'orders.user_id')
                            ->select('users.id')
                            ->groupBy('users.id')
                            ->havingRaw('COUNT(orders.id) > ?', [10])
                            ->count();

        $totalRevenue =  Order::where('status', '!=', 'Hủy đơn')->sum('grand_total'); // tổng doanh thu


        $startOfWeek =  Carbon::now()->startOfWeek(); // Ngày đầu tiên của tuần hiện tại
        // echo $startOfWeek;

        $startOfMonth =  Carbon::now()->startOfMonth(); //Ngày đầu tiên của tháng hiện tại
        // echo   $startOfMonth;
        $startOfYear =  Carbon::now()->startOfYear(); //Ngày đầu tiên của năm hiện tại
        // Ngày hiện tại
        $today = Carbon::now();

        // Thống kê doanh thu theo tuần hiện tại
        $totalRevenueWeek =  Order::where('status', '!=', 'Hủy đơn')
                                ->whereDate('created_at', '>=',  $startOfWeek)
                                ->whereDate('created_at', '<=',  $today)
                                ->sum('grand_total');

        // dd($totalRevenueWeek);

        // Thống kê doanh thu theo tháng hiện tại
        $totalRevenueMonth =  Order::where('status', '!=', 'Hủy đơn')
                                ->whereDate('created_at', '>=', $startOfMonth)
                                ->whereDate('created_at', '<=',  $today)
                                ->sum('grand_total');
        // dd($totalRevenueMonth);

        $totalRevenueYear =  Order::where('status', '!=', 'Hủy đơn')
                                ->whereDate('created_at', '>=', $startOfYear)
                                ->whereDate('created_at', '<=',  $today)
                                ->sum('grand_total'); 
                                
        // Thống kê tháng trước đó
        $lastMonthStartDate = Carbon::now()->subMonthNoOverflow()->startOfMonth(); // Lấy ngày đầu của tháng trước

        $lastMonthEndDate = Carbon::now()->subMonthNoOverflow()->endOfMonth(); // ngày cuối cùng của tháng trước

        // Kiểm tra nếu là tháng 2 của năm không phải năm nhuận
        if ($lastMonthEndDate->month == 2 && !$lastMonthEndDate->isLeapYear()) {
            $lastMonthEndDate->subDays(1);
        }

        // echo $lastMonthStartDate;
        // echo $lastMonthEndDate;

        $totalRevenueLastMonth =  Order::where('status', '!=', 'Hủy đơn')
                                ->whereDate('created_at', '>=',  $lastMonthStartDate)
                                ->whereDate('created_at', '<=',  $lastMonthEndDate)
                                ->sum('grand_total');
    
        // Quý 1
        $startOfQuarter1 = Carbon::now()->startOfYear();  // Ngày đầu tiên của năm
        $endOfQuarter1 = $startOfQuarter1->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 1

        // Quý 2
        $startOfQuarter2 = $endOfQuarter1->copy()->addDay(); // Ngày đầu tiên của quý 2
        $endOfQuarter2 = $startOfQuarter2->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 2

        // Quý 3
        $startOfQuarter3 = $endOfQuarter2->copy()->addDay(); // Ngày đầu tiên của quý 3
        $endOfQuarter3 = $startOfQuarter3->copy()->endOfMonth()->startOfDay()->addMonths(2)->endOfMonth()->endOfDay(); // Ngày cuối cùng của quý 3

        // Quý 4
        $startOfQuarter4 = $endOfQuarter3->copy()->addDay(); // Ngày đầu tiên của quý 4
        $endOfQuarter4 = Carbon::now()->endOfYear(); // Ngày cuối cùng của năm

        $totalRevenueQuarter1 = Order::where('status', '!=', 'Hủy đơn')
                                    ->whereDate('created_at', '>=', $startOfQuarter1)
                                    ->whereDate('created_at', '<=', $endOfQuarter1)
                                    ->sum('grand_total');

        $totalRevenueQuarter2 = Order::where('status', '!=', 'Hủy đơn')
                                    ->whereDate('created_at', '>=', $startOfQuarter2)
                                    ->whereDate('created_at', '<=', $endOfQuarter2)
                                    ->sum('grand_total');

        $totalRevenueQuarter3 = Order::where('status', '!=', 'Hủy đơn')
                                    ->whereDate('created_at', '>=', $startOfQuarter3)
                                    ->whereDate('created_at', '<=', $endOfQuarter3)
                                    ->sum('grand_total');

        $totalRevenueQuarter4 = Order::where('status', '!=', 'Hủy đơn')
                                    ->whereDate('created_at', '>=', $startOfQuarter4)
                                    ->whereDate('created_at', '<=', $endOfQuarter4)
                                    ->sum('grand_total');


        return view('admin.dashboard', [
            'totalOrder' => $totalOrder,
            'totalProduct' => $totalProduct,
            'totalUser' =>   $totalUser,
            'usersVipCount' =>  $usersVipCount,
            'totalRevenue' => $totalRevenue,
            'totalCancelOrders' => $totalCancelOrders,
            'totalOrderComplete' =>  $totalOrderComplete,
            'totalRevenueWeek' => $totalRevenueWeek, 
            'totalRevenueMonth' => $totalRevenueMonth,
            'totalRevenueYear' =>  $totalRevenueYear,
            'totalRevenueLastMonth' =>   $totalRevenueLastMonth,
            // Doanh thu theo quý
            'totalRevenueQuarter1' =>  $totalRevenueQuarter1,
            'totalRevenueQuarter2' =>  $totalRevenueQuarter2,
            'totalRevenueQuarter3' =>  $totalRevenueQuarter3,
            'totalRevenueQuarter4' =>  $totalRevenueQuarter4,

        ]); 
        // $admin = Auth::guard('admin')->user();

        // echo 'Wellcom admin!!' .$admin->name. '<a href="'.route('admin.logout').'">Logout</a>';

        
    }

    public function getCancelOrder (){

        $cancelOrders = Order::where('status', '=', 'Hủy đơn')->paginate(20);

        $data['cancelOrders'] = $cancelOrders;

        return view('admin.orders.cancelOrderList', $data);
    }

    public function getCompleteOrder (){

        $completeOrders = Order::where('status', '=', 'Đã giao hàng')->paginate(20);

        $data['completeOrders'] =   $completeOrders;

        return view('admin.orders.completeOrderList', $data);
    }

    public function getUserVip(){

        $usersVip = DB::table('users')
                    ->join('orders', 'users.id', '=', 'orders.user_id')
                    ->select('users.id', 'users.name', 'users.email', 'users.phone_number', DB::raw('COUNT(orders.id) as order_count'))
                    ->groupBy('users.id', 'users.name',  'users.email', 'users.phone_number')
                    ->having('order_count', '>', 10)
                    ->paginate(10);
                    

        $data['usersVip'] = $usersVip;

        return view('admin.orders.topOrderList', $data);

    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
