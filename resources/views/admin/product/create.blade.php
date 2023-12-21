@extends('admin.layouts.app')
@section('title')
    Create Product
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
            <a href="{{ route('admin.product') }}" class="btn btn-secondary btn-icon-split btn-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
        <form id="form" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Content Row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" readonly>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea id="details" name="details" class="form-control @error('details') is-invalid @enderror">{{ old('details') }}</textarea>
                                @error('details')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Price</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="price">Price</label>
                                    <input type="number" min="0" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col form-group mb-0">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="number" min="0" id="compare_price" name="compare_price" class="form-control @error('compare_price') is-invalid @enderror" value="{{ old('compare_price') }}">
                                    @error('compare_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <small class="text-muted">To show a reduced price, move the product's original price into compare at price. Enter a lower value in price.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Inventory</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="sku">SKU</label>
                                    <input type="text" id="sku" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                                    @error('sku')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" id="barcode" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}">
                                    @error('barcode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" id="track_qty" name="track_qty" class="custom-control-input" value="Yes" {{ old('track_qty') ? 'checked': null }}>
                                    <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                </div>
                                <input type="number" min="0" id="qty" name="qty" class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty') }}">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Related Product</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <select id="related_products" name="related_products[]" class="form-control" style="width:100%" multiple>
                                    @if (isset($relatedProducts))
                                        @foreach ($relatedProducts as $item)
                                            @if (old('related_products'))
                                                @foreach (old('related_products') as $val)
                                                    @if ($item->id == $val)
                                                        <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <select id="status" name="status" class="form-control">
                                    <option value="">-- Select Status --</option>
                                    <option {{ old('status') == 1 ? 'selected' : null }} value="1">Active</option>
                                    <option {{ old('status') == 0 ? 'selected' : null }} value="0">Block</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Categories</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $item)
                                        <option {{ old('category_id') == $item->id ? 'selected' : null }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label for="sub_category_id">Sub Category</label>
                                <select id="sub_category_id" name="sub_category_id" class="form-control">
                                    <option value="">-- Select Sub Category --</option>
                                    @foreach ($subcategories as $item)
                                        <option {{ old('sub_category_id') == $item->id ? 'selected' : null }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Brand</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <select id="brand_id" name="brand_id" class="form-control">
                                    <option value="">-- Select Brand --</option>
                                    @foreach ($brand as $item)
                                        <option {{ old('brand_id') == $item->id ? 'selected' : null }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Image</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <img src="" id="image-preview" class="mb-3" width="180" alt="image">
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Product Featured</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <select id="is_featured" name="is_featured" class="form-control">
                                    <option {{ old('is_featured') == 'No' ? 'selected' : null }} value="No">No</option>
                                    <option {{ old('is_featured') == 'Yes' ? 'selected' : null }} value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <button type="submit" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Submit</span>
                    </button>
                    <a href="{{ route('admin.product') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="text">Cancel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('customStyles')
    <link href="{{ asset('assets/admin/vendor/summernote/summernote.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('customScripts')
    <script src="{{ asset('assets/admin/vendor/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#related_products').select2({
                ajax: {
                    url: "{{ route('admin.product.related') }}",
                    dataType: "json",
                    tags: true,
                    multiple: true,
                    minimunInputLength: 3,
                    processResults: function(data){
                        return {
                            results: data.tags
                        }
                    }
                }
            });
            $('#description').summernote({
                height: 300
            });
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#name').change(function(){
                $('button[type="submit"]').prop('disabled',true);
                var name = $(this).val();
                $.ajax({
                    url: "{{ route('get.slug') }}",
                    type: "post",
                    data: {title:name},
                    dataType: "json",
                    success: function(response){
                        $('button[type="submit"]').prop('disabled',false);
                        if (response['status'] == true) {
                            $('#slug').val(response['slug']);
                        }
                    },
                    error: function(jqXHR, exception){
                        $('button[type="submit"]').prop('disabled',false);
                        console.log("Something went wrong");
                    }
                });
            });
        });
    </script>
@endsection