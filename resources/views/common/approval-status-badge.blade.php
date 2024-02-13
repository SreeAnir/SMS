@if(in_array(\App\Traits\HasStatus::class,class_uses($instance)))
    @if($instance->approval_status_id === \App\Models\ApprovalStatus::STATUS_TUTOR_APPROVED)
        <span class="badge badge-light-success status-badge-approve fs-8 fw-bolder"
              data-model="{{get_class($instance)}}" data-key="{{$instance->getKey()}}">
                    {{$instance->approvalStatus->status}}
    </span>
    @elseif($instance->approval_status_id === \App\Models\ApprovalStatus::STATUS_TUTOR_REJECTED)
        <span class="badge badge-light-danger status-badge-approve fs-8 fw-bolder"
              data-model="{{get_class($instance)}}" data-key="{{$instance->getKey()}}">
                    {{$instance->approvalStatus->status}}
        </span>
    @elseif($instance->approval_status_id === \App\Models\ApprovalStatus::STATUS_TUTOR_PENDING)
        <span class="badge badge-light-warning status-badge-approve fs-8 fw-bolder"
              data-model="{{get_class($instance)}}" data-key="{{$instance->getKey()}}">
                    {{$instance->approvalStatus->status}}
        </span>
    @else
        --
    @endif
@endif
