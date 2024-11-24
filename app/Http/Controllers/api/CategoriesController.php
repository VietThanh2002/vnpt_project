<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function getAll(){

        $categories = Category::latest('id')->get(); 

        return response()->json(['categories' => $categories], 200); 
    }

    public function getOne($id){
        // Tìm sản phẩm theo ID và cũng lấy thông tin hình ảnh sản phẩm
        $categories = Category::findOrFail($id);
    
        return response()->json(['categories' =>  $categories], 200);
    }
}
