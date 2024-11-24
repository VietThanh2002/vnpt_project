<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
  public function index(Request $request){
    $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')
                                  ->latest('sub_categories.id')
                                  ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

    if(!empty($request->get('keyword'))){
      $subCategories = $subCategories->where('sub_categories.name', 'like', '%'.$request->get('keyword').'%' );
      $subCategories = $subCategories->orWhere('sub_categories.name', 'like', '%'.$request->get('keyword').'%' );
    }

    $subCategories = $subCategories->paginate(10);
    // dd($categories);
  
    return view('admin.sub_category.list', compact('subCategories')); // compact () trong PHP được sử dụng để tạo một mảng từ các biến có tên được truyền vào. 
  }
  
  public function create(){
    $categories = Category::orderBy('name', 'ASC')->get();
    $data['categories'] = $categories;
    return view('admin.sub_category.create', $data);
  }

  public function store(Request $request){
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'slug' => 'required|unique:sub_categories',
        'category' => 'required',
        'status'=> 'required',
        'show_home'=> 'required',
      ]);

      if($validator->passes()){
        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->show_home = $request->show_home;
        $subCategory->category_id = $request->category;

        $subCategory->save();

        session()->flash('success', 'Thêm danh mục con thành công!!');

        return response([
          'status' => true,
          'message' => 'Thêm danh mục con thành công!!'
        ]);

      }else{
        return response([
            'status' => false,
            'errors' => $validator->errors()
        ]);
      }
  }
  

  public function edit($id, Request $request){
    // echo $id;
    $subCategories = SubCategory::find($id);

    if(empty($subCategories)){
      session()->flash('error', 'Không tìm thấy danh mục con này');
      return redirect()->route('sub-categories.index');
    }

    $categories = Category::orderBy('name', 'ASC')->get();
    $data['categories'] = $categories;
    $data['subCategory'] = $subCategories;
    return view('admin.sub_category.edit', $data);
  }

  public function update($id, Request $request){
    $subCategory = SubCategory::find($id);

    if(empty($subCategory)){

      session()->flash('error', 'Không tìm thấy danh mục con này');

      return response([
        'status' => false,
        'notFound' => true,
      ]);

      // return redirect()->route('sub-categories.index');
    }

    $validator = Validator::make($request->all(), [

      'name' => 'required',
      'slug' => 'required|unique:sub_categories,slug,' .$subCategory->id,
      'category' => 'required',
      'status'=> 'required',
    ]);

    if($validator->passes()){
     
      $subCategory->name = $request->name;
      $subCategory->slug = $request->slug;
      $subCategory->status = $request->status;
      $subCategory->show_home = $request->show_home;
      $subCategory->category_id = $request->category;

      $subCategory->save();

      session()->flash('success', 'Cập nhật danh mục con thành công!!');

      return response([
        'status' => true,
        'message' => 'Cập nhật danh mục con thành công!!'
      ]);

    }else{
      return response([
          'status' => false,
          'errors' => $validator->errors()
      ]);
    }
  }

  public function destroy($id, Request $request){
    
      $subCategory = SubCategory::find($id);

      if(empty($subCategory)){

        session()->flash('error', 'Không tìm thấy danh mục con này');

        return response([
          'status' => false,
          'notFound' => true,
        ]);
    }

      $subCategory->delete();

      session()->flash('success', 'Xóa danh mục con thành công!!');

      return response([
        'status' => true,
        'message' => 'Xóa danh mục con thành công!!'
      ]);
  }
}