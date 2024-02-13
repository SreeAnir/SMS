@if (@$instance != null &&  $instance?->kacha !=null)
@php
    $kacha =  $instance?->kacha ;
    $contrastColor = '#fffcfa';
    if( in_array( strtolower($kacha?->color) , ['white','yellow','orange'] ) ){
        $contrastColor = '#1f364c';
    }
    elseif( in_array( strtolower($kacha?->color) , ['purple'] ) ){
        $contrastColor = '#ffea9d';
    }
@endphp
    <span class="mx-1 badge px-2 kachabadge" style="border:2px solid  {{ $kacha?->color}} ;border-right:1px dashed {{ $kacha?->color}}; color:{{ $kacha?->color }};background:{{ $contrastColor }}">
        {{-- <i class="fas fa-id-badge"></i>  --}}
         <b> {{ strtoupper($kacha->label) }} </b>
    </span>
        {{-- @php
        $lastKacha = $instance->kachaStudents()->latest()->first();
        @endphp
        @if($lastKacha!=null)
        <span class="mx-1 badge  px-2  border border-success text-success"  >
            {{ @$lastKacha?->class_count }} CLASSES
        </span>
        @endif --}}
@endif

 