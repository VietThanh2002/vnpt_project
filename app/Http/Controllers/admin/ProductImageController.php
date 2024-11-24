<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    public function update(Request $request){

        $tempImageInfo = $request->image;
        $ext =  $tempImageInfo->getClientOriginalExtension(); // kiểm tra đuôi tập tin có phải là ảnh hay không 

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();


        $ImageName = $request->product_id.'-'. $productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $ImageName;
        $productImage->save();

        $sourcePath = $tempImageInfo->getPathName();
        $dPath = public_path().'/uploads/product/'. $ImageName;


        File::copy($sourcePath, $dPath);

        $productImage->save();

        session()->flash('success', 'Cập nhật thành công!!');

   
        return response()->json([
            'status' => true,
            'image_id' =>   $productImage->id,
            'ImagePath' => asset('/uploads/product/' .$productImage->image),
            'message' => 'Cập nhật thành công!!'
        ]);

    }

    public function destroy(Request $request){
        
        $productImage = ProductImage::find($request->id);
        // dd($productImage);

        if(empty($productImage)){
            return response()->json([
                'status' => false,
                'message' => 'Hình ảnh không tồn tại!'
            ]);
        }

        File::delete(public_path('/uploads/product/' .$productImage->image));

        $productImage->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Xóa hình ảnh thành công !'
        ]);
    }
}
