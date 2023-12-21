@extends('layouts.app')
@section('title')
    Cart
@endsection
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $subtotal = 0;
                            $discount = 0;
                        @endphp
                        @if (count($carts) > 0)
                            @foreach ($carts as $row)
                                @php
                                    $product   = Product::findOrFail($row->product_id);
                                    $subtotal += $row->total_price;
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        <img src="{{ asset('/admin/uploads/products/'.$product->image) }}" alt="" style="width: 50px;"> 
                                    </td>
                                    <td class="align-middle" align="left">{{ $product->name }}</td>
                                    <td class="align-middle" align="right">Rp. {{ number_format($product->price, 0, ',','.') }},-</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus" >
                                                <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{ $row->quantity }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle" align="right">Rp. {{ number_format($row->total_price, 0, ',','.') }},-</td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="id" value="{{ $row->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" align="center">-- No Data --</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>Rp. {{ number_format($subtotal, 0, ',','.') }},-</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Discount</h6>
                            <h6 class="font-weight-medium">Rp. {{ number_format($discount, 0, ',','.') }},-</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            @php
                                $total = $subtotal - $discount;
                            @endphp
                            <h5>Total</h5>
                            <h5>Rp. {{ number_format($total, 0, ',','.') }},-</h5>
                        </div>
                        @if ($total > 0)
                            <a href="{{ route('checkout') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</a>
                        @else
                            <button type="button" class="btn btn-block btn-primary font-weight-bold my-3 py-3" disabled>Proceed To Checkout</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection