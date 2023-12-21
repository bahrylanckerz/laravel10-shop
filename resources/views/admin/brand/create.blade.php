@extends('admin.layouts.app')
@section('title')
    Create Brand
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Brand</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form id="form" action="{{ route('admin.brand.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" readonly>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                            <a href="{{ route('admin.brand') }}" class="btn btn-secondary btn-icon-split">
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