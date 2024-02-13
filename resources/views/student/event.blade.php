@foreach ($event_list as $event)
    <li class="list-group-item">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">{{ $event->title }} </h6>

            <div>
                <p>
                    <small>Date: {{ $event->event_date }} </small>
                    @include('common.status-badge', ['instance' => $event])
                </p>
            </div>

        </div>
        <div class="mb-1">Time: {{ $event->event_time }} , Location: {{ $event->address }}</div>
        <div class="text-muted">
            About Event :
            <div class="text-secondary">
                {!! $event->description !!}</div>
        </div>
        <hr />
    </li>
@endforeach
@if ($event_list->count() > 0)
    <li class="list-group-item">
        {{ $event_list->links() }}
    </li>
@else
    <li class="list-group-item">
        <p class="bg-light text-danger p-3 text-center rounded">
            No Events to show.
        </p>
    </li>
@endif
