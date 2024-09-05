<div class="row mb-3">
    <div class="col-md-12">
        {{-- <div class="customer-menu m-3">
            <a href="{{ route('viewProfile_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/profile*') ? 'active' : '' }}" role="button">Profile</a>
            <a href="{{ route('viewContacts_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/contacts*') ? 'active' : '' }}" role="button">Contacts</a>
            <a href="{{ route('viewAppointments_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/appointments*') ? 'active' : '' }}" role="button">Appointments</a>
            <a href="{{ route('viewCalls_customers',$customer_id) }}" id="customer-calls-tab" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/calls*') ? 'active' : '' }}" role="button">Calls</a>
            <a href="{{ route('viewNotes_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/notes*') ? 'active' : '' }}" role="button">Notes</a>
            <a href="{{ route('viewOrders_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/orders*') ? 'active' : '' }}" role="button">Orders</a>
            <a href="{{ route('viewComplaints_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/complaints*') ? 'active' : '' }}" role="button">Complaints</a>
            <a href="{{ route('viewCollections_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/collections*') ? 'active' : '' }}" role="button">Collections</a>
            <a href="{{ route('viewBehaviourDetails_customers',$customer_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_customers/view/behaviours/*') ? 'active' : '' }}" role="button">Behaviours</a>
            
        </div> --}}

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewProfile_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/profile*') ? 'active' : '' }}" type="button" role="tab">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewContacts_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/contacts*') ? 'active' : '' }}" type="button" role="tab">Contacts</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewAppointments_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/appointments*') ? 'active' : '' }}" type="button" role="tab">Appointments</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewCalls_customers',$customer_id) }}" id="customer-calls-tab" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/calls*') ? 'active' : '' }}" type="button" role="tab">Calls</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewNotes_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/notes*') ? 'active' : '' }}" type="button" role="tab">Notes</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewOrders_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/orders*') ? 'active' : '' }}" type="button" role="tab">Orders</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewComplaints_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/complaints*') ? 'active' : '' }}" type="button" role="tab">Complaints</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewCollections_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/collections*') ? 'active' : '' }}" type="button" role="tab">Collections</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;" href="{{ route('viewBehaviourDetails_customers',$customer_id) }}" class="nav-link mx-1 font-weight-bold {{ request()->is('manage_customers/view/behaviours/*') ? 'active' : '' }}" type="button" role="tab">Behaviours</a>
            </li>
          </ul>
    </div>
</div>