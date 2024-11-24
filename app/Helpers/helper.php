<?php
    use App\Models\User;
    use App\Mail\OrderEmail;
    use App\Models\Product;
    use App\Models\Category;
    use App\Models\Order;
    use App\Models\OrderDetail;
    use App\Models\ProductImage;
    use Illuminate\Support\Facades\Mail;
    use App\Models\DiscountCoupon;

    function getCategories(){
       return Category::orderBy('name', 'ASC')
            ->with('sub_category')
            ->orderBy('id', 'DESC')
            ->where('status', 1)
            ->where('show_home', 'Yes')
            ->get();
    }

    function getProductsSale(){
        return Product::orderBy('id', 'DESC')
        ->where('compare_price', '>', 0)
        ->where('status', 1)
        ->take(8)
        ->get();
    }

    function getProductImage($productId){
        return ProductImage::where('product_id', $productId)->first();
    }

    // function getUsers(){
    //     return User::where('role', 1)->orderBy('name', 'ASC')->get();
    // }

    function sendEmail($orderId, $userType="user"){

        $order = Order::where('id', $orderId)->with('items')->first();

        if($userType == 'user'){
            $subject = 'Cảm ơn bạn đã đặt hàng !';
            $email = $order->email;
        }else{
            $subject = 'Bạn có 1 đơn hàng !';
            $email = env('ADMIN_EMAIL');
        }

          // Lấy thông tin về mã giảm giá
          $discountAmount = null;
          $discountCode = $order->discount_code;
  
          if ($discountCode) {
              $discount = DiscountCoupon::where('code', $discountCode)->first();
              $discountAmount = $discount ? $discount->discount_amount : null;
          }

        // dd($order);

        $mailContent = [
            'subject' => $subject,
            'order' => $order,
            'discountAmount' =>  $discountAmount,
            'userType' => $userType
        ];



        Mail::to($email)->send(new OrderEmail($mailContent));

      
    }    
    
    //format VND
    function formatPriceVND($number) {
        
        $floatNumber = floatval(str_replace(',', '', $number)); // Chuyển đổi chuỗi thành số thực và loại bỏ dấu phẩy
        return number_format($floatNumber, 0, ',', '.') . ' ₫';
    }
?>