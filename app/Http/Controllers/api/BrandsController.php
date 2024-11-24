<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function getAll(){

        $brands = Brand::latest('id')->get(); 

        return response()->json(['brands' => $brands], 200); 
    }
 
    public function getOne($id){
     
        $brands = Brand::findOrFail($id);
    
        return response()->json(['brands' =>  $brands], 200);
    }
}
