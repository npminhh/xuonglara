<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{

   

    //
    public function add(Request $request)
    {
//        dd($request->all());

        try {
            // Check tài khoản đăng nhập
            $order = Order::query()->create([
                'user_id' => $request->userId,
                'user_email' => $request->user_email,
                'user_name' => $request->user_name,
                'user_address'=>$request->user_address,
                'user_phone'=>$request->user_phone,
                'receiver_email'=>$request->receiver_email,
                'receiver_name'=>$request->receiver_name,
                'receiver_address'=>$request->receiver_address,
                'receiver_phone'=>$request->receiver_phone,
                'total_price'=>$request->totalAmount,
            ]);

            // tạo order item
            foreach (json_decode($request->productVariants) as $item) {
                $item->order_id = $order->id;
                OrderItem::query()->create((array) $item);

                // xóa sản phẩm đã mua trong giỏ hàng
                CartItem::query()->join('carts', 'carts.id', '=', 'cart_items.cart_id')
                    ->where(['product_variant_id' => $item->product_variant_id,
                        'carts.user_id' => $request->userId])->delete();
            }

            return redirect()->route('welcome')->with('success', 'Đặt hàng thành công');

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
   
}
