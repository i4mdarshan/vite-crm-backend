<div class="row mb-3">
    <div class="col-md-12">
        {{-- <div class="lead-menu m-3"> 
            <a href="{{ route('viewProfile_leads',$lead_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_leads/view/profile*') ? 'active' : '' }}" role="button">Profile</a>
            <a href="{{ route('viewContacts_leads',$lead_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_leads/view/contacts*') ? 'active' : '' }}" role="button">Contacts</a>
            <a href="{{ route('viewAppointments_leads',$lead_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_leads/view/appointments*') ? 'active' : '' }}" role="button">Appointments</a>
            <a href="{{ route('viewCalls_leads',$lead_id) }}" class="btn btn-primary sub-nav-menu-btn {{ request()->is('manage_leads/view/calls*') ? 'active' : '' }}" role="button">Calls</a>
        </div> --}}

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;"  href="{{ route('viewProfile_leads',$lead_id) }}" class="nav-link mx-1 font-weight-bold  {{ request()->is('manage_leads/view/profile*') ? 'active' : '' }}" type="button" role="tab">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;"  href="{{ route('viewContacts_leads',$lead_id) }}" class="nav-link mx-1 font-weight-bold  {{ request()->is('manage_leads/view/contacts*') ? 'active' : '' }}" type="button" role="tab">Contacts</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;"  href="{{ route('viewAppointments_leads',$lead_id) }}" class="nav-link mx-1 font-weight-bold  {{ request()->is('manage_leads/view/appointments*') ? 'active' : '' }}" type="button" role="tab">Appointments</a>
            </li>
            <li class="nav-item" role="presentation">
                <a style="font-size: 16px;"  href="{{ route('viewCalls_leads',$lead_id) }}" class="nav-link mx-1 font-weight-bold  {{ request()->is('manage_leads/view/calls*') ? 'active' : '' }}" type="button" role="tab">Calls</a>
            </li>
          </ul>
    </div>
</div>