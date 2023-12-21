@extends('layouts.app')
@section('title')
    Shop
@endsection
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('shop') }}">Shop</a>
                    @if (isset($categoryName))
                        <span class="breadcrumb-item active">{{ $categoryName }}</span>
                    @else
                        <span class="breadcrumb-item active"></span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            @include('layouts.shopSidebar')
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-dark" href="#">Latest</a>
                                        <a class="dropdown-item text-dark" href="#">Popularity</a>
                                        <a class="dropdown-item text-dark" href="#">Best Rating</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ asset('uploads/products/thumb/'.$product->image) }}" alt="image">
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('product', $product->slug) }}">{{ Str::limit($product->name, 30) }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>Rp. {{ number_format($product->price, 0, ',','.') }},-</h5>
                                        @if ($product->compare_price)
                                            <h6 class="text-muted ml-2"><del>Rp. {{ number_format($product->compare_price, 0, ',','.') }}</del></h6>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="far fa-star text-primary mr-1"></small>
                                        <small class="far fa-star text-primary mr-1"></small>
                                        <small>(99)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection