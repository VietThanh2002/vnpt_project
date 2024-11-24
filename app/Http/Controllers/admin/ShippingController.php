<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\ShippingCost;

class ShippingController extends Controller
{

  public function index(){

    $shippings = ShippingCost::orderBy('shipping_fee')->paginate(8);

    $data['shippings'] =  $shippings;

    return view('admin.shipping.list', $data);

    
  }

  public function create(){

   return view('admin.shipping.create');

  }

  public function store(Request $request){
    $validator = Validator::make($request->all(),[
       'city' => 'required',
       'fee' => 'required'
    ],[
        'city.required' => 'Vui lòng chọn Tỉnh/Thành phố',
        'fee.required' => 'Không được để trống !'
    ]);

    if($validator->passes()){

      // Kiểm tra tỉnh thành phố có tồn tại hay chưa 
      $cityExist = ShippingCost::where('city_province', $request->city)->count();

      if($cityExist > 0){

        session()->flash('error', 'Phí vận chuyển đã tồn tại');

        return response()->json([
          'status' => true,
          // 'message' => 'Tỉnh hoặc thành phố đã tồn tại !'
        ]);
      }

      $shipping = new ShippingCost();

      $shipping->city_province = $request->city;
      $shipping->shipping_fee = $request->fee;

      $shipping->save();

      session()->flash('success', 'Tạo phí vận chuyển thành công !');

      return response()->json([
        'status' => true,
        'message' => 'Tạo phí vận chuyển thành công !'
      ]);

    }else{
        return response()->json([
          'status' => false,
          'errors' => $validator->errors()
        ]);
    }
  }

  public function edit($id){

      $shippings = ShippingCost::find($id);

      $data['shippings'] = $shippings;

      return view('admin.shipping.edit', $data);
  }

  public function update($id, Request $request){

    $validator = Validator::make($request->all(),[
       'fee' => 'required'
    ],[
        'fee.required' => 'Không được để trống !'
    ]);

    if($validator->passes()){

      $shipping = ShippingCost::find($id);

      $shipping->shipping_fee = $request->fee;

      $shipping->save();

      session()->flash('success', 'Cập nhật phí vận chuyển thành công !');

      return response()->json([
        'status' => true,
        'message' => 'Cập nhật phí vận chuyển thành công !'
      ]);

    }else{
        return response()->json([
          'status' => false,
          'errors' => $validator->errors()
        ]);
    }
  }


  public function destroy($id, Request $request){
    
      $shipping = ShippingCost::find($id);

      if(empty($shipping)){

        session()->flash('error', 'Phí vận chuyển không tồn tại');

        return response([
          'status' => false,
          'notFound' => true,
        ]);
    }

      $shipping->delete();

      session()->flash('success', 'Xóa phí vận chuyển thành công!!');

      return response([
        'status' => true,
        'message' => 'Xóa phí vận chuyển thành công!!'
      ]);
  }

}
