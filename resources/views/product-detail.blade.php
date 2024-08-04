@extends('layouts.app')
@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
            <div class="image-wrapper">
                @if(str_contains( 'product/', $product->img_thumb))
                    <img class="img-fluid w-100" src="{{\Illuminate\Support\Facades\Storage::url($product->img_thumb)}}">
                @else
                    <img class="img-fluid w-100" src="{{Storage::url($product->img_thumb)}}">

                @endif
            </div>
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="content pl-lg-3 pl-0">
              <h2>{{$product->name}}</h2>
                <p class="h4 text-muted">{{$product->category ? 'Danh mục sản phẩm: ' . $product->category->name : ''}}</p>
                <span class="text-danger">{{$product->price_sale ?: $product->price}}</span>
                <span class="text-gray"> {{$product->price_sale ? $product->price : ''}}</span>
                <p>{{$product->description}}</p>

                <div class="mt-3">
                    <form action="{{route('cart.add')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                         <div>
                             <label class="form-check-label">Màu:</label>
                             @foreach($colors as $id=>$name)
                                 <input type="radio" style="pointer-events: none; clip: rect(0,0,0,0); position: absolute"
                                 class="btn-check" id="radio_color_{{$id}}" name="product_color_id" value="{{$id}}">
                                 <label class="btn btn-light" for="radio_color_{{$id}}">{{$name}}</label>
                             @endforeach
                         </div>
                        <div>
                            <label class="form-check-label">Kích thước:</label>
                            @foreach($sizes as $id=>$name)
                                <input type="radio" style="pointer-events: none; clip: rect(0,0,0,0); position: absolute"
                                       class="btn-check" id="radio_size_{{$id}}" name="product_size_id" value="{{$id}}">
                                <label class="btn btn-light" for="radio_size_{{$id}}">{{$name}}</label>
                            @endforeach
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" name="quantity" required value="1" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
