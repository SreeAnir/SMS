@if ($instance->visiility === 1)
<span class="badge bg-danger status-badge  fs-8 fw-bolder"   >
  {{ __('Public')}}
</span>
@else 
<span class="badge bg-info status-badge  fs-8 fw-bolder"   >
    {{ __('Private')}}
  </span>

@endif