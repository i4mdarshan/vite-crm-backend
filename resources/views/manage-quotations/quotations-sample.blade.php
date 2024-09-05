<div class="row mb-3">
    <div class="col-md-12">
        <div class="m-1">
            <a href="{{ route('manage_quotations') }}" class="btn btn-primary px-3">
                <span class="h3"><i class="ni ni-bold-left mr-2" style="font-size: 14px; vertical-align: middle;"></i>Manage Quotations</span>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-header border-0">
                <h1 class="mb-0">Generate Quotation</h1>
            </div>
            <form action="{{ route('stream_quotations') }}" method="POST">
                @csrf
                <div class="m-3">
                    <div class="row mx-2">
                        <div class="col-md-12 d-flex justify-content-end">
                            {{-- <div class="card-footer border-0"> --}}
                                <button class="btn btn-secondary" id="addInvoice" type="submit">
                                    <i class="fas fa-eye" style="font-size: 12px;"></i> Preview
                                </button>
                                <button class="btn btn-primary" id="addInvoice" type="submit">
                                    <i class="fas fa-check" style="font-size: 12px;"></i> Save
                                </button>
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from_company">From Company</label>
                                <input type="text" name="from_company"
                                    class="form-control @error('from_company') is-invalid @enderror" id="from_company"
                                    value="Anjali Chemicals">
                                @error('from_company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <label for="from_address">Address</label>
                                <textarea class="form-control pt-3" name="from_address" id="from_address" rows="6">604,Shiv Parvati Apartment, &#013;&#010;House No.2023,Near Pyarelal Prajapati Hall,&#013;&#010;Sector -1,Airoli,Navi Mumbai-400708 &#013;&#010;Maharashtra, India. &#013;&#010;Contact No .: 9326337723 /8425849806
                                </textarea>
                                @error('from_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_company">Proforma Invoice To</label>
                                <input type="text" name="to_company"
                                    class="form-control @error('to_company') is-invalid @enderror" id="to_company"
                                    placeholder="Enter Company Name">
                                @error('to_company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <label for="to_address">Address</label>
                                <textarea class="form-control pt-3" name="to_address" id="to_address" rows="6" placeholder="Enter Company Address"></textarea>
                                @error('to_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="table-responsive">

                            <table class="table" id="main">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Particular</th>
                                        <th scope="col">Per Area/Equally</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <tr>
                                        <td colspan="4">
                                            <button class="btn btn-md btn-secondary" id="button-add" type="button" style="width: 100%">
                                               <i class="fas fa-plus-circle" style="font-size: 12px"></i>&nbsp;Add Item
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table id="clone" style="display: none;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="particulars[]"
                                                    class="form-control @error('particulars[]') is-invalid @enderror"
                                                    id="particulars[]" placeholder="Enter Particular">
                                                @error('particulars[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select
                                                    class="form-control @error('per_area_equally[]') is-invalid @enderror"
                                                    name="per_area_equally[]" id="per_area_equally[]">
                                                    <option value="">Choose Type</option>
                                                    <option value="per_area">Per Area</option>
                                                    <option value="equal">Equal</option>
                                                </select>
                                                @error('per_area_equally[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="amount[]"
                                                    class="form-control amount @error('amount[]') is-invalid @enderror"
                                                    id="amount[]" placeholder="Enter amount">
                                                @error('amount[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <button class="remRow btn btn-md btn-danger" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>