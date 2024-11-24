<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandsController extends Controller
{

    public function index(Request $request){

        $brand = Brand::latest('id');

        if(!empty($request->get('keyword'))){
            $brand =  $brand->where('name', 'like', '%'.$request->get('keyword').'%' );
        }

        $brand = $brand->paginate(10);

        return view('admin.brands.list', compact('brand'));
        
    }

    public function create(){
        return view('admin.brands.create');
    }

    public function store(Request $request){

       $validator =  Validator::make($request->all(),[
            'name' => 'required|unique:brands',
            'slug' => 'required',
        ],[
          'name.required' => 'Tên thương hiệu không được để trống',
          'name.unique' => 'Tên thương hiệu để tồn tại'
        ]);

        if($validator->passes()){

            $brand = new Brand();

            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;

            $brand->save();

            session()->flash('success', 'Tạo nhãn hiệu thành công!!');

            return response()->json([
                'status' => true,
                'message' => 'Tạo nhãn hiệu mới thành công'
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }


    }

    public function edit($id, Request $request ){
        // echo $categoryId;
        $brand = Brand::find($id);

        if(empty( $brand)){
            session()->flash('error', 'Nhãn hàng không tồn tại!!');
            return redirect()->route('brands.index');
        }

        $data['brand'] = $brand;

        return view('admin.brands.edit', $data);
        
    }
    public function update($id, Request $request){
        $brand = Brand::find($id);
    
        if(empty($brand)){
    
          session()->flash('error', 'Nhãn hiệu không tồn tại!');
    
          return response([
            'status' => false,
            'notFound' => true,
          ]);
    
          // return redirect()->route('sub-categories.index');
        }
    
        $validator = Validator::make($request->all(), [
    
          'name' => 'required',
          'slug' => 'required|unique:brands,slug,' .$brand->id,
          'status'=> 'required',
        ]);
    
        if($validator->passes()){
         
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
    
            $brand->save();
    
            session()->flash('success', 'Cập nhật nhãn hàng thành công!!');
        
            return response([
                'status' => true,
                'message' => 'Cập nhật nhãn hàng thành công!!'
            ]);
    
        }else{
          return response([
              'status' => false,
              'errors' => $validator->errors()
          ]);
        }
      }
      
      public function destroy($id, Request $request){
    
        $brand = Brand::find($id);
  
        if(empty($brand)){
  
          session()->flash('error', 'Nhãn hiệu không tồn tại');
  
          return response([
            'status' => false,
            'notFound' => true,
          ]);
      }
  
        $brand->delete();
  
        session()->flash('success', 'Xóa nhãn hàng thành công!!');
  
        return response([
          'status' => true,
          'message' => 'Xóa nhãn hàng thành công!!'
        ]);
    }
}
