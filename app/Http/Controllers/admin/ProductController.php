<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){

        $products = Product::latest('id')->with('product_images')->where('type', 'Dịch vụ Internet');

        if($request->get('keyword') != ""){
            $products = $products->where('name','like','%'.$request->keyword.'%');
        }

        $products = $products->paginate(10);

        $data['products'] = $products;
        
        // dd($products);

        return view('admin.products.list', $data);
    }
    

    public function create(){
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] =   $categories;
        return view('admin.products.create', $data);
    }

    public function store(Request $request){
        $rule = [
            'name' => 'required',
            'des' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|numeric',            
        ];

        $customMessages = [
            'name.required' => 'Tên không được để trống.',
            'des.required' => 'Mô tả không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',            
        ];      
    
        $validator = Validator::make($request->all(), $rule, $customMessages);
    
        if($validator->passes()){
            
            $product = new Product();

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->des = $request->des;
            $product->short_des = $request->short_des;
            $product->price = $request->price;
            $product->type = 'Dịch vụ Internet';
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->save();
            
            if(!empty($request->image_array)){
                foreach ($request->image_array as $temp_image_id){
                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.',  $tempImageInfo->name);
                    $ext = last($extArray);
    
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $ImageName = $product->id.'-'. $productImage->id.'-'.time().'.'.$ext;
                    $productImage->image = $ImageName;
                    $productImage->save();

                    $sPath = public_path().'/temp/'.$tempImageInfo->name;
                    $dPath = public_path().'/uploads/product/'. $ImageName;

                    File::copy($sPath, $dPath);

                    $productImage->save();
                }
            }

            session()->flash('success', 'Tạo sản phẩm thành công!');
    
            return response()->json([
                'status' => true,
                'message' => 'Tạo sản phẩm thành công!'
            ]);
    
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    

    public function edit($id, Request $request){

        $product = Product::find($id);

        
        if(empty($product)){
            session()->flash('error', 'Product not found');
            return redirect()->route('products.index')->with('error', 'Product not found');
        }


        $relatedProducts = [];
        if($product->related_products != ''){
            $productArray = explode(',', $product->related_products);

            $relatedProducts = Product::WhereIn('id', $productArray)->with('product_images')->get();
        }

        // in hinh 
        $productImages = ProductImage::where('product_id', $product->id)->get();

        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        // dd($subCategory);

        
        $data = [];
        $data['product'] = $product;
        $data['subCategories'] = $subCategories;
        $data['categories'] =   $categories;
        $data['productImages'] =  $productImages;

        $data['relatedProducts'] =  $relatedProducts;


        return view('admin.products.edit', $data);

    }


    public function update($id, Request $request){

        $product = Product::find($id);

        $rule = [
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' .$product->id.',id',
            'des' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|numeric',
            
        ];      

         $Validator =  Validator::make($request->all(), $rule);

         if($Validator->passes()){
            
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->des = $request->des;
            $product->short_des = $request->short_des;
            $product->price = $request->price;
            $product->type = 'Dịch vụ Internet';
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->save();
            
             session()->flash('success', 'Cập nhật sản phẩm thành công!');
 
             return response()->json([
                 'status' => true,
                 'message' => 'Cập nhật sản phẩm thành công!'
             ]);
 
 
         }else{
             return response()->json([
                 'status' => false,
                 'errors' => $Validator->errors()
             ]);
         }
    }

    public function destroy($id, Request $request){

        $product = Product::find($id);

        if(empty($product)){
            session()->flash('errors', 'Sản phẩm không tồn tại !');
            return response()->json([
                'status' => false,
                'errors' => true
            ]);
        }

       $productImages = ProductImage::where('product_id', $id)->get();

        if(!empty($productImages)){
           foreach ($productImages as $productImage) {
                File::delete(public_path('/uploads/product/' .$productImage->image));
           }

           ProductImage::where('product_id', $id)->delete();
        }

        $product->delete();

        session()->flash('success', 'Xóa sản phẩm thành công !');

        return response()->json([
            'status' => true,
            'message' => 'Xóa sản phẩm thành công !'
        ]);

    }

    public function getProducts(Request $request){
        $tempProduct = [];
        if($request->term != ""){
            $products = Product::where('name', 'like', '%'.$request->term.'%')->get();

            if($products != null){
                foreach($products as $product){
                    $tempProduct [] = array('id' => $product->id, 'text' => $product->name);
                }
            }
        }

        return response()->json([
            'tags' =>  $tempProduct,
            'status' => true
        ]);

        // print_r($tempProduct);
    }

    // public function productRating(Request $request){

    //     $ratings = ProductRating::select('product_ratings.*', 'products.name as productName')
    //                                 ->orderBy('product_ratings.created_at', 'DESC')
    //                                 ->leftJoin('products', 'products.id', '=', 'product_ratings.product_id');

    //     if($request->get('keyword') != ""){
    //         $ratings =  $ratings->orWhere('products.name','like','%'.$request->keyword.'%');
    //         $ratings =  $ratings->orWhere('product_ratings.user_name','like','%'.$request->keyword.'%');
    //     }

    //     $ratings = $ratings->paginate(10);

    //     // dd($ratings);
    //     return view('admin.products.ratings',  [
    //         'ratings' => $ratings
    //     ]);
    // }

    // public function changeRatingStatus(Request $request){

    //     $productRating = ProductRating::find($request->id);
    //     $productRating->status = $request->status;
    //     $productRating->save();

    //     session()->flash('success', 'Cập nhật trạng thái đánh giá thành công !');

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Cập nhật trạng thái đánh giá thành công !'
    //     ]);


    // }


}
