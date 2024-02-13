@if ($event_upcoming->count() > 0)
    <div class="row mx-1">
        <!-- Column -->
        <div class="col-md-12">
            <div class="card">
                <div class="box  shadow-sm  text-left">
                    @foreach ($event_upcoming as $event)
                        <p class="mb-1"> <i class="text-danger fas fa-bookmark"></i>   <a href="{{ route('events.index') }}" > {{ $event->title }}</a> on {{ @$event->event_date }} {{ @$event->event_time }}  </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
