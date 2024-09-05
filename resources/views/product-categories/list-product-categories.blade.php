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
        @if ($module_access[0] == 1)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title mt-2">Add Product Category</h1>
                    </div>
                    <form action="{{ route('saveCategory_products') }}" method="POST">
                        @csrf
                        <div class="m-3">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="col-form-label" for="product_category_name">Category
                                        Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" maxlength="30"
                                        class="form-control @error('product_category_name') is-invalid @enderror "
                                        id="product_category_name" value="{{ old('product_category_name') }}"
                                        name="product_category_name" placeholder="Enter Category Name">
                                    @error('product_category_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="product_category_status">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('product_category_status') is-invalid @enderror"
                                        name="product_category_status" id="product_category_status">
                                        <option value="">Choose</option>
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
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
        @endif
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title mt-2">Product Categories List</h1>
                    <div class="mt-3">
                        <h3>
                            Total records: 
                            <strong>
                                {{ number_format($product_categories->count()) }}
                            </strong>
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Date Added</th>
                                    <th scope="col">Status</th>
                                    @if ($module_access[0] == 1)
                                        <th scope="col">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($product_categories) == 0)
                                    <tr>
                                        <td>No records available</td>
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
                                        @if ($module_access[0] == 1)
                                            <td>
                                                <span>
                                                    {{-- <a href="{{ route('editCategory_products',$product_category->id) }}" class="btn btn-sm btn-primary" id="edit_product_category" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-pencil-ruler color-muted m-r-5"></i>
                                                </a> --}}

                                                    <a href="{{ route('editCategory_products', $product_category->id) }}"
                                                        class="btn btn-sm btn-secondary" id="edit_product_category">
                                                        <span class="p" style="font-size: 12px;">Edit</span>
                                                        <i class="fas fa-pencil-ruler"></i>
                                                    </a>

                                                    {{-- @if (count($product_category->ordered_products) == 0 && count($product_category->quotation_products) == 0)
                                                        
                                                    @endif --}}

                                                    <a href="{{ route('deleteCategory_products', $product_category->id) }}"
                                                        class="btn btn-sm btn-danger deleteCategory
                                                        {{ (count($product_category->ordered_products) == 0 && count($product_category->quotation_products) == 0) ? '' : 'disabled' }}
                                                        "
                                                        id="edit_product_category" data-toggle="tooltip"
                                                        data-placement="top" title="Delete">
                                                        <i class="fas fa-trash color-muted m-r-5"></i>
                                                    </a>

                                                    {{-- <a href="{{ route('deleteCategory_products',$product_category->id) }}" class="btn btn-sm btn-danger deleteCategory" id="deleteProduct{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <span class="p" style="font-size: 12px;">Delete</span>
                                                    <i class="fas fa-trash"></i>
                                                </a> --}}

                                                </span>
                                            </td>
                                        @endif
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


@section('custom_scripts')

    <script>
        $(document).ready(function() {

            $('.deleteCategory').on('click', function(e) {

                if (!confirm("Are you sure to delete ?")) {
                        e.preventDefault();
                }
            });

        });
    </script>

@endsection
