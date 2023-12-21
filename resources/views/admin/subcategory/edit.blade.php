@extends('admin.layouts.app')
@section('title')
    Edit Sub Category
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Sub Category</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form id="form" action="" method="post">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option {{ $subcategory->category_id == $category->id ? 'selected' : null }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ?: $subcategory->name }}">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') ?: $subcategory->slug }}" readonly>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">-- Select Status --</option>
                                    <option {{ $subcategory->status == 1 ? 'selected' : null }} value="1">Active</option>
                                    <option {{ $subcategory->status == 0 ? 'selected' : null }} value="0">Block</option>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <button type="submit" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                            <a href="{{ route('admin.subcategory') }}" class="btn btn-secondary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="text">Cancel</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customScripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#form').submit(function(e){
                e.preventDefault();
                var form = $(this);
                $('button[type="submit"]').prop('disabled',true);
                $.ajax({
                    url: "{{ route('admin.subcategory.update', $subcategory->id) }}",
                    type: "put",
                    data: form.serializeArray(),
                    dataType: "json",
                    success: function(response){
                        $('button[type="submit"]').prop('disabled',false);
                        if (response['status'] == true) {
                            window.location.href = "{{ route('admin.subcategory') }}";
                        } else {
                            var errors = response['errors'];
                            if (errors['category_id']) {
                                $('#category_id').addClass('is-invalid').siblings('small').html(errors['category_id']);
                            } else {
                                $('#category_id').removeClass('is-invalid').siblings('small').html('');
                            }
                            if (errors['name']) {
                                $('#name').addClass('is-invalid').siblings('small').html(errors['name']);
                            } else {
                                $('#name').removeClass('is-invalid').siblings('small').html('');
                            }
                            if (errors['slug']) {
                                $('#slug').addClass('is-invalid').siblings('small').html(errors['slug']);
                            } else {
                                $('#slug').removeClass('is-invalid').siblings('small').html('');
                            }
                        }
                    },
                    error: function(jqXHR, exception){
                        $('button[type="submit"]').prop('disabled',false);
                        console.log("Something went wrong");
                    }
                });
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