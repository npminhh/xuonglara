@extends('admin.layouts.master')

@section('title')
    Tạo mới danh mục sản phẩm
@endsection

@section('content')
    <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên:</label>
            <input type="text" name="name">
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh:</label>
            <input type="file" name="cover">
        </div>
        <div class="mb-3">
            <label class="form-label">Trạng thái:</label>
            <input class="form-check-input" type="checkbox" name="is_active" checked>
        </div>
        <button type="submit" class="btn btn-success">Tạo mới</button>
    </form>
@endsection
