@extends('admin.layouts.app')
@section('title')
    Category
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category</h1>
            <a href="{{ route('admin.category.create') }}" class="btn btn-danger btn-icon-split btn-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add New</span>
            </a>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        @include('admin.message')
                        <div class="row justify-content-end mb-2">
                            <div class="col-lg-4 col-md-6 col-sm-8">
                                <form action="" method="get">
                                    <div class="input-group input-group-sm mb-2">
                                        <input type="text" id="keyword" name="keyword" class="form-control form-control-sm" autocomplete="off" value="{{ Request::get('keyword') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="datatable" width="100%" cellspacing="0">
                                <thead class="bg-gradient-danger text-white">
                                    <tr>
                                        <td class="text-center">#</td>
                                        <td>Name</td>
                                        <td>Slug</td>
                                        <td class="text-center">Status</td>
                                        <td class="text-center"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->slug }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 1)
                                                        <button class="btn btn-outline-success btn-circle btn-sm"><i class="fas fa-check"></i></button>
                                                    @else
                                                        <button class="btn btn-outline-danger btn-circle btn-sm"><i class="fas fa-times"></i></button>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.category.edit', $item->id) }}" class="btn btn-warning btn-circle btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-circle btn-sm" title="Delete" onclick="modalDelete({{ $item->id }}, '{{ route('admin.category.delete', 'ID') }}')"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">-- No Data --</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <nav class="d-flex justify-content-end">
                            {{ $categories->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete-->
    @include('admin.modalDelete')
@endsection