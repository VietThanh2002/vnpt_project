<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;

class StaffsManagerController extends Controller
{
    public function index(Request $request){

        $staffs = Staff::orderBy('name', 'DESC');

        if($request->get('keyword') != ""){
            $staffs = $staffs->where('name','like','%'.$request->keyword.'%');
            $staffs = $staffs->orWhere('mobile','like','%'.$request->keyword.'%');
            $staffs = $staffs->orWhere('email','like','%'.$request->keyword.'%');
            $staffs = $staffs->orWhere('position','like','%'.$request->keyword.'%');
        }
        $staffs = $staffs->paginate(10);
        // dd($user);

        $data['staffs'] =   $staffs;

        return view('admin.staffs.list', $data);
    }

    public function create(){
        return view('admin.staffs.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|min:10|max:10',
            'login_name' => 'required|unique:staff|min:8',
            'password' => 'required|min:8',
            'position' => 'required',
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
        ],[
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'login_name.required' => 'Tên đăng nhập không được để trống',
            'login_name.min' => 'Tên đăng nhập ít nhất 8 ký tự',
            'login_name.unique' => 'Tên đăng nhập đã tồn tại',
            'mobile.required' => 'Số điện thoại không được để trống',
            'mobile.min' => 'Số điện thoại phải có ít nhất :min ký tự',
            'mobile.max' => 'Số điện thoại không được quá :max ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự',
            'city.required' => 'Vui lòng chọn Tỉnh/Thành phố',
            'district.required' => 'Vui lòng chọn Quận/huyện',
            'ward.required' => 'Vui lòng chọn Phường/xã',
            'address.required' => 'Vui lòng điều số / tên đường',
        ]);

        if($validator->passes()){

            $staff = new Staff();
            $staff->name = $request->name;
            $staff->email = $request->email;
            $staff->mobile = $request->mobile;
            $staff->login_name  = $request->login_name;
            $staff->password = Hash::make($request->password);
            $staff->city = $request->city;
            $staff->district = $request->district;
            $staff->ward = $request->ward;
            $staff->address = $request->address;
            $staff->position = $request->position;
            $staff->save();

            session()->flash('success', 'Thêm nhân viên thành công !');

            return response()->json([
               'status' => true,
               'message' => 'Thêm nhân viên thành công !'
           ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request, $staffId){
        $staff = Staff::find($staffId);
        // dd($staff);
        $data['staff'] =  $staff;

        return view('admin.staffs.edit', $data);
    }
    public function update(Request $request, $staffId){

        $staff = Staff::find($staffId);

        if($staff == null){
            return response()->json([
                'status' => false,
                'errors' => 'Nhân viên không tồn tại'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|min:10|max:10',
            'login_name' => 'required|min:8',
            'password' => 'required|min:8',
            'position' => 'required',
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
        ],[
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'login_name.required' => 'Tên đăng nhập không được để trống',
            'login_name.min' => 'Tên đăng nhập ít nhất 8 ký tự',
            'mobile.required' => 'Số điện thoại không được để trống',
            'mobile.min' => 'Số điện thoại phải có ít nhất :min ký tự',
            'mobile.max' => 'Số điện thoại không được quá :max ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự',
            'city.required' => 'Vui lòng chọn Tỉnh/Thành phố',
            'district.required' => 'Vui lòng chọn Quận/huyện',
            'ward.required' => 'Vui lòng chọn Phường/xã',
            'address.required' => 'Vui lòng điều số / tên đường',
        ]);

        if($validator->passes()){

            $staff->name = $request->name;
            $staff->email = $request->email;
            $staff->mobile = $request->mobile;
            $staff->login_name  = $request->login_name;
            $staff->password = Hash::make($request->password);
            $staff->city = $request->city;
            $staff->district = $request->district;
            $staff->ward = $request->ward;
            $staff->address = $request->address;
            $staff->position = $request->position;
            $staff->save();

            session()->flash('success', 'Cập nhật thông tin thành công !');

            return response()->json([
               'status' => true,
               'message' => 'Cập nhật thông tin thành công !'
           ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        
    }
    public function destroy($staffId){

        $staff = Staff::find($staffId);

        if(empty($staff)){
            session()->flash('errors', 'Không tồn tại nhân viên này');
            return response()->json([
                'status' => false,
                'errors' => true
            ]);
        }


        $staff->delete();

        session()->flash('success', 'Đã xóa nhân viên !');

        return response()->json([
            'status' => true,
            'message' => 'Đã xóa nhân viên !'
        ]);
    }

}
