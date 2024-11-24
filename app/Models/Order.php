<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\Staff;

class Order extends Model
{
    use HasFactory;

    // mỗi bản ghi trong bảng Orders (đơn hàng) có thể có nhiều bản ghi trong bảng OrderDetails (chi tiết đơn hàng).
    public function items(){
        return $this->hasMany(OrderDetail::class); // định nghĩa mối quan hệ giữa bảng Order và OrderDeil
    }

    public function staff()
    {
        return $this->hasOne(Staff::class); //một đơn hàng sẽ thuộc về một nhân viên
    }

    protected $fillable = [
        // Các trường khác của model
        'status',
    ];

}
