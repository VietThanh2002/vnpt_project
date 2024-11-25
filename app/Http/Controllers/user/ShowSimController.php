<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ShowSimController extends Controller
{
    public function index(Request $request)
    {   
        $simCards = Product::where('type', 'Dịch vụ di động');

        // Lọc theo đầu số
        if ($request->has('prefix') && $request->prefix != 'all') {
            $simCards = $simCards->where('sim_number', 'like', $request->prefix . '%');
        }

        // Lọc theo loại thuê bao
        if ($request->has('subscription_type')) {
            if ($request->subscription_type == 'prepaid') {
                $simCards = $simCards->where('sim_type', 'Trả trước');
            } elseif ($request->subscription_type == 'postpaid') {
                $simCards = $simCards->where('sim_type', 'Trả sau');
            }
        }

        $simCards = $simCards->paginate(10);
        
        return view('user.sim_card', compact('simCards'));
    }
}
