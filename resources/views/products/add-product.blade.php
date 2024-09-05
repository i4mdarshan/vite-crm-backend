@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
    <div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="m-1">
                    <a href="{{ url()->previous() }}" class="btn btn-primary px-3">
                        <span class="text-secondary h3"><i class="ni ni-bold-left mr-2"
                                style="font-size: 14px; vertical-align: middle;"></i>Back</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h1 class="mb-0">Add Product</h1>
                    </div>
                    <form action="{{ route('save_products') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="m-3">
                            <div class="row mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Enter Product Name<span class="text-danger">*</span></label>
                                        <input type="text" name="product_name"
                                            class="form-control @error('product_name') is-invalid @enderror"
                                            id="product_name" value="{{ old('product_name') }}" maxlength="40"
                                            placeholder="Enter Product Name">
                                        @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Choose Product Category<span class="text-danger">*</span></label>
                                        <select class="form-control @error('product_category') is-invalid @enderror"
                                            name="product_category" id="product_category">
                                            <option value="">Choose Type</option>
                                            @foreach ($active_product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ old("product_category") == $product_category->id ? "selected" : "" }}>
                                                    {{ $product_category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="product_origin">Enter Product Origin<span class="text-danger">*</span></label>
                                        <input type="text" name="product_origin"
                                            class="form-control @error('product_origin') is-invalid @enderror"
                                            id="product_origin" value="{{ old('product_origin') }}" maxlength="30"
                                            placeholder="Enter Product Origin">
                                        @error('product_origin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="product_msds">Product MSDS<small> (File size should be less than 2Mb)</small></label>
                                        <input type="file" name="product_msds" accept=".jpg, .jpeg, .png, .pdf, docx"
                                            class="form-control @error('product_msds') is-invalid @enderror"
                                            id="product_msds" value="{{ old('product_msds') }}" />
                                        @error('product_msds')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 px-auto">
                                            <div class="form-group">
                                                <label for="product_hsn">Enter HSN Code<span class="text-danger">*</span></label>
                                                <input type="number" name="product_hsn"
                                                    class="form-control @error('product_hsn') is-invalid @enderror"
                                                    id="product_hsn" value="{{ old('product_hsn') }}" maxlength="8"
                                                    placeholder="Enter HSN Code">
                                                @error('product_hsn')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-auto">
                                            <div class="form-group">
                                                <label for="product_tax">Enter Product Tax <small>(in %)</small> <span class="text-danger">*</span></label>
                                                <input type="number" name="product_tax"
                                                    class="form-control @error('product_tax') is-invalid @enderror"
                                                    id="product_tax" value="{{ old('product_tax') }}" maxlength="2"
                                                    placeholder="Enter Product Tax">
                                                @error('product_tax')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 px-auto">
                                            <div class="form-group">
                                                <label for="product_packaging">Enter Product Packaging<span class="text-danger">*</span></label>
                                                <input type="number" name="product_packaging"
                                                    class="form-control @error('product_packaging') is-invalid @enderror"
                                                    id="product_packaging" value="{{ old('product_packaging') }}"
                                                    placeholder="Enter Product Packaging">
                                                @error('product_packaging')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-auto">
                                            <label for="product_unit">Select Product Unit<span class="text-danger">*</span></label>
                                            <select class="form-control @error('product_unit') is-invalid @enderror"
                                                name="product_unit" id="product_unit">
                                                <option value="">Select Unit</option>
                                                @foreach ($product_units as $product_unit)
                                                
                                                    <option value="{{ intval($product_unit->id) }}" {{ (old("product_unit") == intval($product_unit->id)) ? "selected" : "" }} >
                                                        {{ ucwords(str_replace('_', ' ', $product_unit->name)) }}</option>
                                                @endforeach
                                            </select>
                                            
                                            {{-- <input type="number" name="product_unit"
                                                class="form-control @error('product_unit') is-invalid @enderror"
                                                id="product_unit" value="{{ old('product_unit') }}"
                                                placeholder="Enter Product Unit"> --}}
                                            @error('product_unit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_status">Product Status<span class="text-danger">*</span></label>
                                        <select class="form-control @error('product_status') is-invalid @enderror"
                                            name="product_status" id="product_status">
                                            <option value="1" {{ old('product_status') == 1 ? "selected" : "" }}>Active</option>
                                            <option value="0" {{ old('product_status') == 0 ? "selected" : "" }}>Inactive</option>
                                        </select>
                                        @error('product_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="product_tds">Product TDS<small> (File size should be less than 2Mb)</small></label>
                                        <input type="file" name="product_tds" accept=".jpg, .jpeg, .png, .pdf, docx"
                                            class="form-control @error('product_tds') is-invalid @enderror"
                                            id="product_tds" value="{{ old('product_tds') }}" />
                                        @error('product_tds')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <button class="btn btn-primary" id="addProduct" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#product_unit").select2({
                placeholder: "Select Product Unit",
                dropdownAutoWidth: true,
                width: "auto",
                selectionCssClass: "form-control form-control-sm",
                theme: "bootstrap4",
                tags: true,
            });
        });
    </script>
@endsection
