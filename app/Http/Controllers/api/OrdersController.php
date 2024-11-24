<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrdersController extends Controller
{
    public function getAll(){
        
        $orders = Order::all();

        return response()->json(['orders' => $orders], 200); 
    }

    public function getOrdersId($id)
    {
        try {
            $order = Order::findOrFail($id);
    
            return response()->json(['order' => $order], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }
}
