@extends('layouts.app')

@section('title', 'Report')

@section('content')

<div>
    <section class="report-box">
          <div class="container">
            <div class="mx-4 link mb-3">
                <h1>Reports</h1>
             </div>
             
            <div class="row">
              <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                          <i class="fa fa-regular fa-users fa-2x mt-2 mx-2"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Lead</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <a href="{{ route('lead_reports') }}">Look now</a>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div>
              <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                        <i class="fa fa-regular fa-money-bill-wave fa-2x teal mt-2 mx-2"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Collection</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <a href="{{ route('collection_reports') }}">Look now </a>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div>
              
              <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                        <i class="ni ni-notification-70 ni-2x teal mt-2 mx-2" aria-hidden="true"></i>
                       
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Complaint</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <a href="{{ route('complaint_reports') }}">Look now </a>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div>
              
              
              
              {{-- <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                        <i class="ni ni-single-copy-04 ni-2x teal mt-2 mx-2"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Jobsheet</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <div>Look now </div>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div> --}}
              <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                        <i class="ni ni-chart-bar-32 ni-2x mt-2 mx-2" aria-hidden="true"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Order</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <a href="{{ route('order_reports') }}">Look now </a>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div> 
              <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                        <i class="ni ni-chart-bar-32 ni-2x mt-2 mx-2" aria-hidden="true"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Calls</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <a href="{{ route('call_reports') }}">Look now </a>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div> 
              <div class="col-sm-4  mb-4">
                <div class="promotion-card-deck">
                  <div class="promotion-card dark">
                    <div class="promotion-blob"></div>
                    <div class="promotion-content">
                      <div class="picture background-color border-pink">
                        <i class="ni ni-chart-bar-32 ni-2x mt-2 mx-2" aria-hidden="true"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <div>
                          <h1>Appointment</h1>
                          <h3 class="text-primary">Report</h3>
                        </div>
                      <div class="price text-primary mt-3">
                        <a href="{{ route('appointment_reports') }}">Look now </a>
                      </div>
                      </div>
                    </div>
                  </div>  
                  <div class="border-bottom-span"></div>
                </div>
              </div> 
          </div>
      </section>
      
</div>
@endsection