@extends('layouts.admin.app')
@section('title', $title ?? 'Notifications details')
@section('content')
@section('header_buttons')
    <a  href="{{ route('notifications.edit', [$notification]) }}" type="button" class="btn btn-primary btn-lg">
        <em class="fas fa-pencil-alt px-2"></em>@lang('Edit Notification')
    </a>
@endsection
<div class="card  box-card">
    <div class="card-body">
        <h5 class="card-title mb-3">
                {{  $notification->title}}
                     @include('common.status-badge', ['instance' => $notification])

            </label> </h5>
        <div class="d-flex flex-sm-row flex-column">
            <label class="p-1 text-info rounded border border-dark  mx-1"> <em class="fas fa-bullseye"></em>
                {{ @$notification->notification_type_label }}</label>
            <label class="p-1 text-info rounded border border-dark mx-1">
                <em class=" fas fa-calendar-alt"></em>
                @if(@$notification->notification_date != "")
                Send Date {{ @$notification->notification_date }}
                @else 
                Date not added
               @endif
            </label>
        </div>
    </div>
</div>
<div class="card  box-card">
    @include('admin.notifications.partials.tabs')

</div>
@endsection


@push('scripts')
<script></script>
@endpush
