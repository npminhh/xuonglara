<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    public function list() {
        // Lấy thông tin user đăng nhập
        // $user = Auth::user();
        // Tamj thời laasy user đầu tiên
        $user = User::query()->first();

        // thông tin cart
        $cart = Cart::query()->where('user_id', $user->id)->first();
        $totalAmount = 0 ;
        $productVariants = $cart->cartItems()
        ->join('product_variants', 'product_variants.id', '=' ,'cart_items.product_variant_id')
        ->join('products', 'products.id', '=', 'product_variants.product_id')
        ->join('product_sizes', 'product_sizes.id' , '=', 'product_variants.product_size_id')
        ->join('product_colors', 'product_colors.id' , '=', 'product_variants.product_color_id')
        ->get(['product_variants.id as product_variant_id', 'products.name as product_name',
            'products.sku as product_sku', 'products.img_thumb as product_img_thumb',
            'products.price as product_price', 'products.price_sale as product_price_sale',
            'product_sizes.name as variant_size_name', 'product_colors.name as variant_color_name',
            'cart_items.quantity as quantity']);

//        dd($productVariants->toArray());
        foreach (collect($productVariants) as $item) {
            $totalAmount += $item['quantity'] * ($item['product_price_sale'] ?: $item['product_price']);
        }
        $userId = $cart->user_id;
        return view('cart', compact('totalAmount', 'productVariants', 'userId'));

    }

    public function add(Request $request)
    {
//        dd($request->all());
        $product = Product::query()->where('id', $request->product_id)->first();
        $productVariant = ProductVariant::query()->where([
            'product_id' => $request->product_id,
            'product_size_id' => $request->product_size_id,
            'product_color_id' => $request->product_color_id
        ])->first();
        // giả định người đặt hàng là user 1
        $user = \App\Models\User::query()->first();

        $cart = Cart::query()->where('user_id', $user->id)->first();
        // kiểm tra chưa có giỏ hàng thì tạo mới
        if (empty($cart)) {
            $cart = Cart::query()->create(['user_id' => $user->id]);
        }

        // chuẩn bị data để lưu vào cartItem
        $data = [
            'product_variant_id' => $productVariant->id,
            'cart_id' => $cart->id,
            'quantity' => $request->quantity
        ];
        // kiểm tra nếu có product_variant_id thì phải cộng số lượng
        $cartItems = CartItem::query()->where('product_variant_id',  $productVariant->id)->first();
        if (empty($cartItems)) {
            CartItem::query()->create($data);
        } else {
            $data["quantity"] += $cartItems->quantity;
            $cartItems->update(["quantity" => $data["quantity"]]);
        }

        return redirect()->route('cart.list');
    }
}
