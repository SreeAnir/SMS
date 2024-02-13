<div class="card">
    <!-- Nav tabs -->

    <ul class="nav nav-tabs  nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder" role="tablist">
        <li class="nav-item ">
            <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab"><span class="hidden-sm-up"></span>
                <span class="hidden-xs-down">Basic Info</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"></span>
                <span class="hidden-xs-down">Recipients</span></a>
        </li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content tabcontent-border">
        <div class="tab-pane p-20 active" id="info" role="tabpanel">
            <div class="p-20">

                <div class="card">
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center"> 
                            <span
                                class="svg-icon svg-icon-2 svg-icon-primary me-3 lh-0"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"
                                    fill="none">
                                    <rect y="6" width="16" height="3" rx="1.5" fill="currentColor"></rect>
                                    <rect opacity="0.3" y="12" width="8" height="3" rx="1.5"
                                        fill="currentColor"></rect>
                                    <rect opacity="0.3" width="12" height="3" rx="1.5"
                                        fill="currentColor"></rect>
                                </svg></span>
                            <h5 class="fw-bolder m-0 text-gray-800">Timeline</h5>
                        </div>
                        <!--end::Title-->
                    </div>
                    <div class="card-body">
        
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th class="fw-bolder">Title</th>
                                    <td> {{ $notification->title }}</td>
                                </tr>
                            <tr>
                                <th class="fw-bolder">Message</th>
                                <td> {{ $notification->message }}</td>
                            </tr>
                            @if($notification->notifiable !=null )
                            {{-- <tr>
                                <th class="fw-bolder">Title</th>
                                <td> {{ $notification->notifiable->title }}</td>
                            </tr> --}}
                            <tr>
                                <th class="fw-bolder">Event Date & Time</th>
                                <td> {{ $notification->notifiable->event_date }} {{ $notification->notifiable->event_time }}  </td>
                            </tr>
                            <tr>
                                <th class="fw-bolder">Event Location</th>
                                <td> {{ $notification->notifiable->address }}    </td>
                            </tr>
                            @endif
                        
                            </tbody>
                        </table>
                    </div>
                     
                </div>
            </div>
        </div>

        <div class="tab-pane" id="home" role="tabpanel">
            <div class="p-20">

                <div class="col">
                    <!--begin::Label-->
                        @if($notification->users->count() ==0 )
                        <div class="alert alert-info">No Recipients</div>
                        @else 
                         <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center"> 
                                <span
                                    class="svg-icon svg-icon-2 svg-icon-primary me-3 lh-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                      </svg>
                                   </span>
                                <h5 class="fw-bolder m-0 text-gray-800">Notification Recipients</h5>
                            </div>
                            <!--end::Title-->
                        </div>
                         <div class="card-body">
                       
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notification->users as $recipient)
                                    <!-- Replace this with dynamic data from your backend -->
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{ $recipient->user->full_name }}</td>
                                        <td>{{ $recipient->user->email }}</td>
                                        <td>@include('common.status-badge', ['instance' => $recipient])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                    </div>
                    <!--end::Label-->
                    <!--begin::Roles-->

                </div>

            </div>
        </div>

    </div>
</div>
