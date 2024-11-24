<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;

class DiscountCodeController extends Controller
{
    public function index(Request $request){

        $discount = DiscountCoupon::latest('id');

        if(!empty($request->get('keyword'))){
            $discount =    $discount->where('name', 'like', '%'.$request->get('keyword').'%' );
        }


        $discount =   $discount->paginate(10);

        $data['discount'] =   $discount;

        return view('admin.discount.list', $data);
    }

    public function create(){
        return view('admin.discount.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',

        ],[
            'code.required' => 'Mã giảm giá không được để trống',
            'type.required' => 'Chọn kiểu mã giảm giá',
            'discount_amount.required' => 'Số tiền giảm không được để trống',
            'status.required' => 'Chọn trạng thái',
        ]);

        if($validator->passes()){

           if(!empty($request->start_day)){
                $now = Carbon::now();
                
                $start = Carbon::create($request->start_day);

                if($start <= $now){
                    return response()->json([
                        'status' => false,
                        'errors' => ['start_day' => 'Ngày bắt đầu không được nhỏ hơn ngày hiện tại']
                    ]);
                }
           }

           if(!empty($request->start_day) && !empty($request->end_day)){

                $end = Carbon::create($request->end_day, 'Asia/Ho_Chi_Minh');
                $start = Carbon::create($request->start_day, 'Asia/Ho_Chi_Minh');

                if ($end->gt($start) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['end_day' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu']
                    ]);
                }
             }

            $discountCoupon = new DiscountCoupon();
            $discountCoupon->code = $request->code;
            $discountCoupon->name = $request->name;
            $discountCoupon->des = $request->des;
            $discountCoupon->type = $request->type;
            $discountCoupon->max_uses_user = $request->max_uses_user;
            $discountCoupon->max_usage = $request->max_usage;
            $discountCoupon->discount_amount = $request->discount_amount;
            $discountCoupon->min_amount = $request->min_amount;
            $discountCoupon->status = $request->status;
            $discountCoupon->start_day = $request->start_day;
            $discountCoupon->end_day = $request->end_day;
            $discountCoupon->save();

            session()->flash('success', 'Tạo mã giảm giá thành công!!');

            return response()->json([
                'status' => true,
                'message' => 'Tạo mã giảm giá thành công!!'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request, $id){
        $discount = DiscountCoupon::find($id);

        if( $discount == null){
            session()->flash('error', 'Mã giảm giá không tồn tại');
            return redirect()->route('discount.index');
        }
        $data['discount'] = $discount;

        return view('admin.discount.edit', $data);
    }

    public function update(Request $request, $id){
        $discountCoupon = DiscountCoupon::find($id);

        if($discountCoupon == null){
            session()->flash('error', 'Mã giảm giá không tồn tại');
            return response()->json([
                'status' => false,
                'errors' => 'Mã giảm giá không tồn tại'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',

        ],[
            'code.required' => 'Mã giảm giá không được để trống',
            'type.required' => 'Chọn kiểu mã giảm giá',
            'discount_amount.required' => 'Số tiền giảm không được để trống',
            'status.required' => 'Chọn trạng thái',
        ]);

        if($validator->passes()){

           if(!empty($request->start_day)){
                $now = Carbon::now('Asia/Ho_Chi_Minh');
                
                $start = Carbon::create($request->start_day, 'Asia/Ho_Chi_Minh');

                if($start->lte($now) == true){
                    return response()->json([
                        'status' => false,
                        'errors' => ['start_day' => 'Ngày bắt đầu không được nhỏ hơn ngày hiện tại']
                    ]);
                }
           }

           if(!empty($request->start_day) && !empty($request->end_day)){

                $end = Carbon::create($request->end_day, 'Asia/Ho_Chi_Minh');
                $start = Carbon::create($request->start_day, 'Asia/Ho_Chi_Minh');

                if ($end->gt($start) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['end_day' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu']
                    ]);
                }
             }

            $discountCoupon->code = $request->code;
            $discountCoupon->name = $request->name;
            $discountCoupon->des = $request->des;
            $discountCoupon->type = $request->type;
            $discountCoupon->max_usage = $request->max_usage;
            $discountCoupon->max_uses_user = $request->max_uses_user;
            $discountCoupon->discount_amount = $request->discount_amount;
            $discountCoupon->min_amount = $request->min_amount;
            $discountCoupon->status = $request->status;
            $discountCoupon->start_day = $request->start_day;
            $discountCoupon->end_day = $request->end_day;
            $discountCoupon->save();

            session()->flash('success', 'Cập nhật giảm giá thành công!!');

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật giảm giá thành công!!'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    } 

    public function destroy(Request $request, $id){
    
        $discount = DiscountCoupon::find($id);
  
        if(empty($discount)){
  
          session()->flash('error', 'Mã giảm giá không tồn tại');
  
          return response([
            'status' => false,
            'notFound' => true,
          ]);
      }
  
        $discount->delete();
  
        session()->flash('success', 'Xóa mã giảm giá thành công!!');
  
        return response([
          'status' => true,
          'message' => 'Xóa mã giảm giá thành công!!'
        ]);
    }
}
