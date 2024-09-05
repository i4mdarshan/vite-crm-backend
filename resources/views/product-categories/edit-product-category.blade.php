@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="m-1">
                <a href="{{ url()->previous() }}" class="btn btn-primary px-3">
                    <span class="text-secondary h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Back</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- /# column -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title mt-2">Edit Product Category</h1>
                </div>
                <form action="{{ route('updateCategory_products',$edit_product_category->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="m-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="col-form-label" for="product_category_name">Category
                                    Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                class="form-control @error('product_category_name')
                                is-invalid
                            @enderror "
                                id="product_category_name" value="{{ old("category_name",$edit_product_category->category_name) }}" name="product_category_name"  maxlength="40" placeholder="Enter Category Name">
                                @error('product_category_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="product_category_status">Status <span class="text-danger">*</span> </label>
                                <select class="form-control @error('product_category_status') is-invalid @enderror" name="product_category_status" id="product_category_status">
                                    <option value="">Choose</option>
                                    <option value="1" {{ $edit_product_category->isActive == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $edit_product_category->isActive == 0 ? 'selected' : '' }}>InActive</option>
                                </select>
                                @error('product_category_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title mt-2">Product Categories List</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered verticle-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Date Added</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($product_categories) < 0)
                                    <tr>
                                        <td>No Records Available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                                @foreach ($product_categories as $product_category)
                                    {{-- @dd(count($product_category->products)) --}}
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product_category->category_name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($product_category->created)) }}</td>
                                        <td>
                                            @if ($product_category->isActive == 1)
                                                <span class="badge badge-success px-2">Active</span>
                                            @else
                                                <span class="badge badge-danger px-2">InActive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span>
                                                <a href="{{ route('editCategory_products',$product_category->id) }}" class="btn btn-primary" id="edit_product_category" title="Edit">
                                                    <i class="fas fa-pencil-ruler color-muted m-r-5"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>

@endsection
