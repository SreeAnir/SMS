    @foreach ($notification_listing as $list)
    @php
      
        if($list?->notification_type == App\Models\Notification::EVENT){ 
            $title =  $list?->notification?->notifiable->title;
            $notification_date  =  $list?->notifiable?->event_date;
        }else{
            $title = $list->notification?->notification_type_label;
            $notification_date  = $list->notification?->notification_date;
        }
    @endphp

        <li class="list-group-item border-bottom">
            <div class="d-flex flex-column  flex-lg-row justify-content-between ">
                <div class="mr-auto ">
                    <h5 class="mb-1">{{ $list->notification?->title }}
                        <span class="badge bg-info mx-2">{{ $title }}</span>
                    </h5>
                </div>

                <div>
                    <p class="mb-1 small text-info">Recieved at: {{ $notification_date  }}</p>
                </div>
            </div>
            <div class="text-muted">Message</div>
            <div class="text-secondary">
                {{ $list->notification?->message }}
            </div>
        </li>
    @endforeach

    @if ($notification_listing->count() > 0)
        <li class="list-group-item">
            {{ $notification_listing->links() }}
        </li>
    @else
        <li class="list-group-item">
            <p class="bg-light text-danger p-3 text-center rounded">
                No Notifications to show.
            </p>
        </li>
    @endif
