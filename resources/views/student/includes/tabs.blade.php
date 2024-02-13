@php
    use App\Models\Notification;
@endphp
<section class="theme-border  bg-white">
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs profile_tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="events-tab" data-bs-toggle="tab" href="#events">Events</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="payments-tab" data-bs-toggle="tab" href="#payments">Payments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="notifications-tab" data-bs-toggle="tab" href="#notifications">Notifications</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        <!-- Class Schedule Tab -->

        <div class="tab-pane fade show active" id="events">
            <div class="row">
                <div class="d-flex flex-row  flex-row-reverse">
                    <div class="form-group float-right">
                        <select id="filter_event" class="p-2 rounded">
                            <option value="">All Events</option>
                            <option value="1">Upcoming</option>
                            <option value="2">Past</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <ul id="event_list" class="list-group">
                </ul>
            </div>
        </div>

        <div class="tab-pane fade " id="notifications">
            <div class="row">
                <div class="d-flex flex-row flex-row-reverse">

                    <div class="form-group float-right">
                        <select id="filter_notification" class="p-2 rounded">
                            <option value="">All Notification</option>
                            @foreach (Notification::list() as $key => $value)
                                <option {{ $key == @$notification->notification_type ? " selected ='selected' " : '' }}
                                    value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
            <ul id="notification_list" class="list-group ">
                
            </ul>
            </div>
            <!-- Add content for class schedule here -->
        </div>

        <!-- Progress Tracking Tab -->
        <div class="tab-pane fade " id="payments">
            @include('student.fee_info')
            @include('student.past_pay')
        </div>

    </div>
    <!-- Add content for class schedule here -->
</section>
