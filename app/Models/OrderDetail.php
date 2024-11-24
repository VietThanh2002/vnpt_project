<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    
    // Trong mô hình này, mỗi chi tiết đơn hàng (OrderDetail) sẽ "thuộc về" một sản phẩm (Product) cụ thể.
    // với mối dòng trong bảng  chi tiết đơn hàng sẽ thuộc về một sản phẩm

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
