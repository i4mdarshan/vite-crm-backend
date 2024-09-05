@extends('layouts.app')

@section('title', 'Manage Customers')

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

        @include('layouts.partials.customer-nav-menu')

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    {{-- <h1 class="m-3">Page Under Construction</h1> --}}
                    <div class="d-flex justify-content-between card-header">
                        <h1 class="mb-0">Edit Customer Collection Details</h1>
                    </div>
                    <form
                        action="{{ route('updateCollection_customers', ['customer_id' => $customer_id, 'collection_id' => $collection_details->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mt-3">
                                {{-- <div class="col-md-3"></div> --}}
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="collected_person_name">Enter Collected by Person's Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="collected_person_name"
                                                    class="form-control @error('collected_person_name') is-invalid @enderror"
                                                    id="collected_person_name"
                                                    value="{{ $collection_details->collected_by_person_name }}"
                                                    placeholder="Enter Person Name" readonly>
                                                @error('collected_person_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="received_money">Enter Money Recieved <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="received_money"
                                                    class="form-control @error('received_money') is-invalid @enderror"
                                                    id="received_money" value="{{ old("received_money",$collection_details->money_received) }}"
                                                    placeholder="Enter Value">
                                                @error('received_money')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="pending_money">Enter Money Pending <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="pending_money"
                                                    class="form-control @error('pending_money') is-invalid @enderror"
                                                    id="pending_money" value="{{ old("pending_money",$collection_details->money_pending) }}"
                                                    placeholder="Enter value">
                                                @error('pending_money')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="mode_of_payment">Payment Mode <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control @error('mode_of_payment') is-invalid @enderror"
                                                    name="mode_of_payment" id="mode_of_payment">
                                                    <option class="form-control" value="">Choose</option>
                                                    <option class="form-control" value="cash" {{ old("mode_of_payment",$collection_details->mode_of_payment) == 'cash' ? 'selected' : ''}}>Cash</option>
                                                    <option class="form-control" value="cheque" {{ old("mode_of_payment",$collection_details->mode_of_payment) == 'cheque' ? 'selected' : ''}}>Cheque</option>
                                                    <option class="form-control" value="pdc_cheque" {{ old("mode_of_payment",$collection_details->mode_of_payment) == 'pdc_cheque' ? 'selected' : ''}}>PDC Cheque</option>
                                                    <option class="form-control" value="neft" {{ old("mode_of_payment",$collection_details->mode_of_payment) == 'neft' ? 'selected' : ''}}>NEFT</option>
                                                    <option class="form-control" value="rtgs" {{ old("mode_of_payment",$collection_details->mode_of_payment) == 'rtgs' ? 'selected' : ''}}>RTGS</option>
                                                </select>
                                                @error('mode_of_payment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="person_name_collected_from">Enter Collected from Person's Name
                                                    <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control @error('person_name_collected_from') is-invalid @enderror"
                                                    name="person_name_collected_from" id="person_name_collected_from">
                                                    @if (count($customer_contacts) == 0)
                                                        <option class="form-control" value="">Please add contact
                                                            first.
                                                        </option>
                                                    @else
                                                        <option class="form-control" value="">Select Contact</option>
                                                        @foreach ($customer_contacts as $customer_contact)
                                                            <option class="form-control" value="{{ $customer_contact->id }}"
                                                                {{ old("person_name_collected_from",$collection_details->collected_from_person_name) == $customer_contact->id ? 'selected' : '' }}>
                                                                {{ ucwords($customer_contact->contact_person_name) }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('person_name_collected_from')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="received_money_date">Money Received Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="received_money_date"
                                                    class="form-control @error('received_money_date') is-invalid @enderror"
                                                    id="received_money_date"
                                                    value="{{ old('received_money_date',$collection_details->money_received_date) }}"
                                                    max="{{ date('Y-m-d') }}">
                                                @error('received_money_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="pending_money_date">Money Pending Date</label>
                                                <input type="date" name="pending_money_date"
                                                    class="form-control @error('pending_money_date') is-invalid @enderror"
                                                    id="pending_money_date"
                                                    value="{{ old('pending_money_date',$collection_details->money_pending_date) }}">
                                                @error('pending_money_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="collection_status">Collection status <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control @error('collection_status') is-invalid @enderror"
                                                    name="collection_status" id="collection_status">
                                                    <option value="received"
                                                        {{ old("collection_status",$collection_details->status) == "received" ? 'selected' : '' }}>
                                                        Received</option>
                                                    <option value="pending"
                                                        {{ old("collection_status",$collection_details->status) == "pending" ? 'selected' : '' }}>
                                                        Pending</option>
                                                </select>
                                                @error('collection_status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <button class="btn btn-primary" type="submit">Update</button>
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
            $('.customer-menu').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        });
    </script>

@endsection
