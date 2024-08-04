@extends('admin.layouts.master')

@section('title')
    Sửa danh mục sản phẩm
@endsection

@section('content')
    <form action="{{route('admin.categories.update', $category)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Tên:</label>
            <input type="text" name="name" value="{{$category->name}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh:</label>
            <input type="file" name="cover">
            <div style="width: 100px; height: 100px;">
                <img src="{{Storage::url($category->cover)}}" style="max-width: 100%; max-height: 100%;" alt="">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Trạng thái:</label>
            <input class="form-check-input" type="checkbox" name="is_active" @checked($category->is_active)>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
@endsection
