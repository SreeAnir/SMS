 @if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($instance)) && $instance->trashed())
     <span class="badge bg-warning fs-8 fw-bold">
         @lang('Trashed')
     </span>
 @elseif(in_array(\App\Traits\HasStatus::class, class_uses($instance)))
     {{-- <span class="badge badge-pill badge-primary">Primary</span> --}}
     @if ($instance->status_id === 1)
         <span class="badge bg-success status-badge  fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
             data-key="{{ $instance->getKey() }}">
             {{ $instance->status->status }}
         </span>
     @elseif($instance->status_id === 3)
         <span class="badge bg-warning  status-badge fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
             data-key="{{ $instance->getKey() }}">
             {{ $instance->status->status }}
         </span>
    @elseif($instance->status_id === 6 )
    <span class="badge bg-info  status-badge fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
        data-key="{{ $instance->getKey() }}">
        {{ $instance->status->status }}
    </span>  
    @elseif($instance->status_id === 7 )
    <span class="badge bg-success  status-badge fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
        data-key="{{ $instance->getKey() }}">
        {{ $instance->status->status }}
    </span>   
    @elseif($instance->status_id === 8 )
    <span class="badge bg-success  status-secondary fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
        data-key="{{ $instance->getKey() }}">
        {{ $instance->status->status }}
    </span>
    @elseif($instance->status_id === 9 )
    <span class="badge bg-success  status-secondary fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
        data-key="{{ $instance->getKey() }}">
        {{ $instance->status->status }}
    </span>
    @elseif($instance->status_id === 10 )
    <span class="badge bg-danger  status-secondary fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
        data-key="{{ $instance->getKey() }}">
        {{ $instance->status->status }}
    </span>
    @elseif($instance->status_id === 11 )
    <span class="badge bg-success  status-secondary fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
        data-key="{{ $instance->getKey() }}">
        {{ $instance->status->status }}
    </span>
     @else
         <span class="badge bg-danger  status-badge fs-8 fw-bolder" data-model="{{ get_class($instance) }}"
             data-key="{{ $instance->getKey() }}">
             {{ $instance->status->status ?? $instance->status_id }}
         </span>
     @endif
 @else
 @endif
 