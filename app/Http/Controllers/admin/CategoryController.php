<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name', 'like', '%'.$request->get('keyword').'%' );
        }

        $categories = $categories->paginate(10);
        // dd($categories);
      
        return view('admin.category.list', compact('categories')); // compact () trong PHP được sử dụng để tạo một mảng từ các biến có tên được truyền vào. 
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
       $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories',
                // 'slug' => 'required | unique:categories',
       ],[

            'name.required' => 'Tên danh mục không được để trống!',
            'name.unique' => 'Danh mục này đã tồn tại!',
            // 'slug' => 'Không được để trống!',
        ]);

       if($validator->passes()){

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->show_home = $request->show_home;
            $category->save();

            //lưu hình

            if(!empty($request->image_id)){
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath, $dPath);

                $category->image = $newImageName;
                $category->save();
            }



            session()->flash('success', 'Thêm danh mục thành công!');
            


            return response()->json([
                'status' => true,
                'message' => 'Tạo danh mục mới thành công!'
            ]);

       } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
       }
    }

    public function edit($categoryId, Request $request ){
        // echo $categoryId;
        $category = Category::find($categoryId);

        if(empty($category)){
            return redirect()->route('categories.index');
        }

        return view('admin.category.edit', compact('category'));
        
    }

    public function update($categoryId, Request $request){

        $category = Category::find($categoryId);

        if(empty($category)){
           
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Categogy not found'
           ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $categoryId,
            ],[

                'name.required' => 'Tên không được để trống!',
                'slug' => 'Không được để trống!',
            ]);

            if($validator->passes()){

                  
                    $category->name = $request->name;
                    $category->slug = $request->slug;
                    $category->status = $request->status;
                    $category->show_home = $request->show_home;
                    $category->save();

                    $oldImage = $category->image;

                    //lưu hình

                    if(!empty($request->image_id)){
                        $tempImage = TempImage::find($request->image_id);
                        $extArray = explode('.', $tempImage->name);
                        $ext = last($extArray);

                        $newImageName = $category->id.'-'.time().'.'.$ext;
                        $sPath = public_path().'/temp/'.$tempImage->name;
                        $dPath = public_path().'/uploads/category/'.$newImageName;
                        File::copy($sPath, $dPath);

                        // Tạo hình thu nhỏ
                        $category->image = $newImageName;
                        $category->save();


                        // Xóa hình củ
                        File::delete(public_path().'/uploads/category/'. $oldImage);
                    }



                    session()->flash('success', 'Cập nhật thành công!!');
                    


                    return response()->json([
                        'status' => true,
                        'message' => 'Cập nhật thành công'
                    ]);

                    } else {
                            return response()->json([
                                'status' => false,
                                'errors' => $validator->errors()
                            ]);
                    }
    }

    public function destroy($categoryId, Request $request){
        $category = Category::find($categoryId);
        // session()->flash('error', 'Lỗi!');
        if(empty($category)){
            return redirect()->route('categories.index');
        }

        File::delete(public_path().'/uploads/category/'.$category->image);

        $category->delete();

        session()->flash('success', 'Xóa thành công!');
      
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công !'
        ]);
    }
}
