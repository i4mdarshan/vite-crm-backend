@extends('layouts.app')

@section('title', 'Product Details')


@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h1 class="mb-0">Products List</h1>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            @if ($module_access[0] == 1)
                                <a href="{{ route('add_products') }}" class="btn btn-secondary float-right mx-1 my-2 my-md-0">
                                    Add <i class="fas fa-plus-circle"></i></a>
                            @endif
                                <a href="{{ route('manageCategories_products') }}" class="btn btn-secondary float-md-right mx-1 my-2 my-md-0 float-right">Manage Product Categeories</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="mt-3">
                                <h3>
                                    Total records: 
                                    <strong>
                                        {{ number_format($all_products->total()) }}
                                    </strong>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{-- Search Form --}}
                            <form action="{{ route('search_products') }}" class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto" method="GET">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative">
                                        <input class="form-control" placeholder="Search By Name, Category, Origin..." name="q" type="text" autocomplete="off">
                                    </div>
                                    <button class="btn btn-secondary btn-icon mx-1" type="submit">
                                        <span><i class="fas fa-search"></i></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 75vh; overflow-y: auto">
                        <table class="table align-items-center">
                            <thead class="thead-light" style="position: sticky; top:0;background-color: #f3f3f2;z-index: 999">
                                <tr>
                                    <th class="pr-2 pl-3" scope="col"></th>
                                    <th class="pl-2" scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">HSN</th>
                                    <th scope="col">Origin</th>
                                    <th scope="col">Packaging</th>
                                    <th scope="col">GST</th>
                                    <th scope="col">Status</th>
                                    @if ($module_access[0] == 1)
                                        <th scope="col">Action</th>
                                    @endif
                                    
                                </tr>
                            </thead>
                            <tbody class="list">

                                @if (count($all_products) == 0)
                                    <tr>
                                        <td>No records available</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                                @foreach ($all_products as $key=>$product)
                                    {{-- @dd(count($product_category->products)) --}}
                                    <tr>
                                        <td class="pr-2 pl-3">{{ $all_products->firstItem() + $key }}</td>
                                        <td class="pl-2" style="min-width: 200px; white-space:normal; vertical-align:middle">{{ $product->product_name }}
                                        <h5>
                                            <a target="_blank"
                                                class="btn-link {{ !isset($product->product_tds) ? "disabled" : "" }}"
                                                title="{{ !isset($product->product_tds) ? "No file available" : "Click to view" }}"
                                                href="{{ isset($product->product_tds) ? asset('uploads/products/product_tds/' . $product->product_tds) : "javascript:void(0)" }}">
                                                TDS 
                                            </a>
                                            |
                                            <a target="_blank"
                                                class="btn-link {{ !isset($product->product_msds) ? "disabled" : "" }}"
                                                title="{{ !isset($product->product_msds) ? "No file available" : "Click to view" }}"
                                                href="{{ isset($product->product_msds) ? asset('uploads/products/product_msds/' . $product->product_msds) : "javascript:void(0)" }}">
                                                MSDS
                                            </a>
                                        </h5>
                                        </td>
                                        <td>{{ $product->category->category_name }}</td>
                                        <td>{{ $product->product_hsn }}</td>
                                        <td>{{ $product->product_origin }}</td>
                                        {{-- <td>Rs {{ $product->product_price }}</td> --}}
                                        <td>{{ $product->product_packaging." ".ucwords(str_replace('_',' ',$product->unit->name)) }}</td>
                                        <td>{{ $product->product_tax." %" }}</td>
                                        <td>
                                            @if ($product->isActive == 1)
                                                <span class="badge badge-success px-2">Active</span>
                                            @else
                                                <span class="badge badge-danger px-2">InActive</span>
                                            @endif
                                        </td>
                                        @if ($module_access[0] == 1)
                                        <td>
                                            <span>
                                                <a href="{{ route('edit_products',$product->id) }}" class="btn btn-sm btn-secondary" id="edit_employee">
                                                    <span class="p" style="font-size: 12px;">Edit</span>
                                                    <i class="fas fa-pencil-ruler"></i>
                                                </a>
                                                <a href="{{ route('delete_products',$product->id) }}" class="btn btn-sm btn-danger deleteProduct" id="deleteProduct{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    {{-- <span class="p" style="font-size: 12px;">Delete</span> --}}
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </span>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $all_products->links('layouts.partials.pagination-links') }}
                    </nav>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
</div>
@endsection

@section('custom_scripts')

    <script>

    $(document).ready(function() {

        $('.deleteProduct').on('click', function(e){
            
            if(!confirm("Are you sure you want to delete ?")){
                e.preventDefault();
            }
        });

    });

    </script>
    
@endsection
