<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null ){

        $categorySelected = '';
        $subCategorySelected = '';

        $categories = Category::orderBy('name','ASC')->with('sub_category')->where('status', 1)->where('name', 'INTERNET - TRUYỀN HÌNH')->take(8)->get();
        $products = Product::where('status', 1)->where('type', 'Dịch vụ Internet');

        // Lọc sản phẩm
        if(!empty($categorySlug)){
            $category = Category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }

        if(!empty($subCategorySlug)){
            $subCategory = SubCategory::where('slug',  $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
            $subCategorySelected =  $subCategory->id;
        }

        // checkbox brand

        $brandsArray = [];

        if(!empty($request->get('brand'))){
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }

        //sắp xếp giá
        if($request->get('price_max') != '' &&  $request->get('price_min') != ''){
           if($request->get('price_max') == 10000000){
            $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max')), 10000000]);
           }
           else{
            $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
           }
        }

        // sort giá góc trên
        if($request->get('sort') != ''){
            if($request->get('sort') == 'latest'){
                $products = $products->orderBy('id','DESC');;
            }else if($request->get('sort') == 'price_desc'){
                $products = $products->orderBy('price','DESC');;
            }else{
                $products = $products->orderBy('price','ASC');;
            }
        }else{
            $products = $products->orderBy('id','DESC');;
        }

        // tìm kiếm sản phẩm

        if(!empty($request->get('search'))){
            $products = Product::where('name', 'like', '%'.$request->get('search') .'%');
            // $brands = Brand::orWhere('name', 'like', '%'.$request->get('search') .'%');
        }


        $products = $products->paginate(6);

        $data['categories'] = $categories;
        $data['products'] = $products;

        $data['categorySelected'] =  $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;

        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 10000000 : intval($request->get('price_max'));
        $data['priceMin'] = intval($request->get('price_min'));

        $data['sort'] = $request->get('sort');

        return view('user.shop', $data);
    }

    public function product($slug){

        $product = Product::where('slug', $slug)
                                ->withCount('product_ratings') // trả về  "product_ratings_count" => 5 // số lượt đánh giá cho 1 sản phẩm 
                                ->withSum('product_ratings', 'rating') // "product_ratings_sum_rating" => 17.0 //tổng điểm đánh giá
                                ->with('product_images', 'product_ratings')->first();
        // dd($product);

        // dd($product);
        if($product == null){
            abort(404);
        }

        // Trung bình đánh giá
        $avgRating = '0.00'; // điểm đánh giá Trung bình đánh giá
        $avgRatingPercent = 0; // trung bình tổng % đánh giá để hiển thị sao vào 
        if($product->product_ratings_count > 0){
            $avgRating = number_format(($product->product_ratings_sum_rating/$product->product_ratings_count),2);
            $avgRatingPercent = ( $avgRating * 100)/5;
        }
        
        $data['avgRating'] =   $avgRating;
        $data['avgRatingPercent'] =   $avgRatingPercent;
        $data['product'] = $product;

        return view('user.product', $data);
    }

    public function saveRating(Request $request, $productId){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6',
            'email' => 'required|email',
            'rating' => 'required',
            'comment' => 'required|min:10'
        ], [
            'name.required' => 'Không được để trống họ và tên',
            'name.min' => 'Tên không được ít hơn 6 ký tự',
            'email.required' => 'Email không được để trống',
            'rating.required' => 'Khách hàng vui lòng đánh giá chất lượng sản phẩm',
            'comment.required' => 'Khách hàng vui lòng điền nội dung đánh giá sản phẩm',
            'comment.min' => 'Nội dung đánh giá phải ít nhất 10 ký tự'
        ]);

        if($validator->passes()){
            $product = Product::where('id', $productId)->first();
            // dd($product);
            $count = ProductRating::where('email', $request->email)->count(); // Kiểm tra khách hàng a đã đánh giá sản phẩm chưa
            if($count > 0){
                return response()->json([
                    'status' => true,
                    'message' =>'<div class="text-center text-danger">Bạn đã có đánh giá cho sản phẩm <strong>'.$product->name.'</strong>!<br>
                                        Bạn không thể đánh giá sản phẩm nhiều lần !
                                </div>'
                ]);
            }

            $productRating = new ProductRating();
            $productRating->product_id = $productId;
            $productRating->user_name = $request->name;
            $productRating->email = $request->email;
            $productRating->rating = $request->rating;
            $productRating->comment = $request->comment;
            $productRating->status = 1;

            $productRating->save();

            session()->flash('success', 'Cảm ơn đánh giá của bạn !');

            return response()->json([
               'status' => true,
               'message' => 'Cảm ơn đánh giá của bạn !'
           ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
