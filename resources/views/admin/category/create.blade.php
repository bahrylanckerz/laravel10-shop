@extends('admin.layouts.app')
@section('title')
    Add New Category
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add New Category</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form id="form" action="" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" readonly>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="is_show_home">Show on Home</label>
                                <select id="is_show_home" name="is_show_home" class="form-control">
                                    <option {{ old('is_show_home') == 'No' ? 'selected' : null }} value="No">No</option>
                                    <option {{ old('is_show_home') == 'Yes' ? 'selected' : null }} value="Yes">Yes</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                            <a href="{{ route('admin.category') }}" class="btn btn-secondary btn-icon-split">
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
                    url: "{{ route('admin.category.store') }}",
                    type: "post",
                    data: form.serializeArray(),
                    dataType: "json",
                    success: function(response){
                        $('button[type="submit"]').prop('disabled',false);
                        if (response['status'] == true) {
                            $('#name').removeClass('is-invalid').siblings('small').html('');
                            $('#slug').removeClass('is-invalid').siblings('small').html('');
                            window.location.href = "{{ route('admin.category') }}";
                        } else {
                            var errors = response['errors'];
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