<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

class SimCardController extends Controller
{
    public function index()
    {   
        $simCards = Product::where('type', 'Dịch vụ di động');

        $simCards = $simCards->paginate(10);

        // dd($simCards);
        
        return view('admin.sim_cards.list', compact('simCards'));
    }

    public function create()
    {   
        $categories = Category::where('status', 1)->get();

        return view('admin.sim_cards.create', compact('categories'));
    }

    public function store(Request $request)
    {   

        
        $validator = Validator::make($request->all(), [
            'sim_number' => [
                'required',
                'regex:/^(091|094|088|081|082|083|084|085)\d{7}$/',
                'unique:sim_cards,sim_number', // Kiểm tra số SIM đã tồn tại
            ],
            'price' => 'required|numeric',
            'sim_type' => 'required',
            'category' => 'required',
        ], [
            'sim_number.required' => 'Số sim không được để trống',
            'sim_number.regex' => 'Số sim phải bắt đầu bằng các đầu số hợp lệ (091, 094, 088, 081, 082, 083, 084, 085) và có 10 chữ số',
            'sim_number.unique' => 'Số sim này đã tồn tại trong hệ thống',
            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá phải là số',
            'sim_type.required' => 'Loại sim không được để trống',
            'category.required' => 'Danh mục không được để trống',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]); 
        }

        $simCard = new Product();

        $simCard->sim_number = $request->sim_number;
        $simCard->slug = $request->sim_number;
        $simCard->price = $request->price;
        $simCard->status = 1;
        $simCard->sim_type = $request->sim_type;
        $simCard->type = 'Dịch vụ di động';
        $simCard->category_id = $request->category;
        $simCard->sub_category_id = $request->sub_category;
        $simCard->save();

        session()->flash('success', 'Thêm sim thành công');

        return response()->json([
            'status' => true,
            'message' => 'Thêm sim thành công'
        ]);
    }

    public function edit($id)
    {
        $simCard = Product::find($id)->where('type', 'Dịch vụ di động')->first();

        $categories = Category::where('status', 1)->get();

        $subCategories = SubCategory::where('category_id',  $simCard->category_id)->get();

        return view('admin.sim_cards.edit', compact('simCard', 'categories', 'subCategories'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sim_number' => [
                'required',
                'regex:/^(091|094|088|081|082|083|084|085)\d{7}$/',
                'unique:sim_cards,sim_number,'.$id.',id', // Kiểm tra số SIM đã tồn tại
            ],
            'price' => 'required|numeric',
            'sim_type' => 'required',
            'category' => 'required',
        ], [
            'sim_number.required' => 'Số sim không được để trống',
            'sim_number.regex' => 'Số sim phải bắt đầu bằng các đầu số hợp lệ (091, 094, 088, 081, 082, 083, 084, 085) và có 10 chữ số',
            'sim_number.unique' => 'Số sim này đã tồn tại trong hệ thống',
            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá phải là số',
            'sim_type.required' => 'Loại sim không được để trống',
            'category.required' => 'Danh mục không được để trống',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $simCard = Product::find($id);

        $simCard->sim_number = $request->sim_number;
        $simCard->slug = $request->sim_number;
        $simCard->price = $request->price;
        $simCard->status = 1;
        $simCard->sim_type = $request->sim_type;
        $simCard->type = 'Dịch vụ di động';
        $simCard->category_id = $request->category;
        $simCard->sub_category_id = $request->sub_category;
        $simCard->save();

        session()->flash('success', 'Cập nhật sim thành công');

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật sim thành công'
        ]);
    }

    public function destroy($id)
    {
        $simCard = Product::find($id);

        if(empty($simCard)){
            session()->flash('errors', 'Sản phẩm không tồn tại !');
            return response()->json([
                'status' => false,
                'errors' => true
            ]);
        }

        $simCard->delete();

        session()->flash('success', 'Xóa sim thành công');

        return response()->json([
            'status' => true,
            'message' => 'Xóa sim thành công'
        ]);
    }


}
