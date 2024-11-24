<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImagesController extends Controller
{
    /**
     * Lấy tất cả các hình ảnh của một sản phẩm
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductImages($productId)
    {
        // Kiểm tra xem sản phẩm có tồn tại không
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }
        
        // Lấy tất cả các hình ảnh của sản phẩm
        $images = ProductImage::where('product_id', $productId)->get();
        
        // Trả về danh sách các hình ảnh dưới dạng JSON
        return response()->json(['images' => $images], 200);
    }
}
