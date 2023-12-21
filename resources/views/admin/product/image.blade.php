@extends('admin.layouts.app')
@section('title')
    Product Images
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Product Images</h1>
            <a href="{{ route('admin.product') }}" class="btn btn-secondary btn-icon-split btn-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Upload Image</h6>
                    </div>
                    <div class="card-body">
                        @include('admin.message')
                        <form action="{{ route('admin.product.image.store', $product->slug) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="text">Upload</span>
                                    </button>
                                </div>
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Product : {{ $product->name }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($productImages as $item)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-3 text-center">
                                    <img src="{{ asset('uploads/products/thumb/'.$item->image) }}" class="img-thumbnail" width="100%" alt="image">
                                    <br>
                                    <button type="button" class="btn btn-danger btn-block btn-sm" onclick="modalDelete({{ $item->id }}, '{{ route('admin.product.image.delete', $item->id) }}')">Delete</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.modalDelete')
@endsection