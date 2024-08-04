@extends('layouts.app')
@section('content')
    <div class="mt-16">
        <div class="row mb-3">
            @foreach($products as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3 pb-3">
                    <div class="card border-0 rounded-0 text-center shadow-none overflow-hidden">
                        <a href="" class="text-decoration-none">
                            @if($item->is_best_sale)
                                <span class="badge badge-primary">BEST SALE</span>
                            @elseif($item->is_40_sale)
                                <span class="badge badge-warning">SALE 40%</span>
                            @elseif($item->is_hot_online)
                                <span class="badge badge-primary">HOST ONLINE</span>
                            @endif
                            <img src="{{Storage::url($item->img_thumb)}}" alt="" class="card-img-top rounded-0">
                            <div class="card-body">
                                <h4 class="mb-3">{{Str::limit($item->name, 30)}}</h4>
                                <p class="h4 text-muted font-weight-light mb-3">{{$item->category->name}}</p>
                                <span class="text-dark">{{$item->price_sale ?: $item->price}}</span>
                                <span class="text-danger">
                                        {{$item->price_sale ? $item->price : ''}}
                                    </span>

                            </div>
                            <a href="{{route('product.detail', $item->slug)}}" class="btn btn-primary rounded-pill">
                                Xem chi tiết
                            </a>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
