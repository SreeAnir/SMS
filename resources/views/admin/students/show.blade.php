@extends('layouts.admin.app')
@section('title', $title ?? 'Student details')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
@section('header_buttons')

    @if (!$user->isSuperAdmin())
        <a 11target="_blank" href="{{ route('students.edit', [$user]) }}" type="button"
            class="btn btn-info rounded btn-sm mx-1">
            <em class="fas fa-pencil-alt px-2"></em>@lang('Edit Student')
        </a>
        {{-- @if (@$user != null)
            <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-1target="#updateBatch"
                aria-expanded="false" aria-controls="updateBatch">
                @lang('Update Batch')
            </button>
        @endif --}}
    @endif
@endsection

<div class="row ">
    @if (count($profile_alerts) > 0)
        <div class="col-md-12 shadow-sm">

            @foreach ($profile_alerts as $text)
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>   {{ $text }}
                </div>
            @endforeach
        </div>
    @endif
    <div class="col-md-12 col-sm-12  bg-light border-success">
        @include('admin.students.partials.rfid-update')
    </div>
    <div class="col-md-6 col-sm-12  bg-light border-success">
        @include('admin.students.partials.batch-update')
    </div>
    <div class="col-md-6 col-sm-12  bg-light border-success">
        @include('admin.students.partials.kacha-update')
    </div>

    <div class="col-md-12 shadow-sm">

        <div class="card ">
            <div class="card-body ">
                @php
                    $instance = $user;
                @endphp
                <h5 class="card-title mb-3">
                    {{ @$user->full_name }}

                    {{-- @if (@$user->student->kacha_id > 0)
                        <label class="px-2">
                            @include('common.kacha-badge', ['instance' => $user->student])</label>
                    @endif --}}
                    <p class="mx-1 d-inline-flex flex-sm-row flex-column">


                        <label class="px-1"> @include('common.status-badge')</label>

                        @if (@$user->student->batches->count() > 0)
                            <label class="mx-1 badge bg-info">
                                @lang('Batch') : <span id="batch_label" class="font-weight-normal"
                                    alt="View batch">{{ @$user->student->batches[0]->batch_name }}</span></label>
                        @endif

                        @if (@$user->joining_date != null)
                            <label class="mx-1 badge bg-secondary">
                                @lang('Joined on') : <span id="joining_date_label" class="font-weight-normal"
                                    alt="View batch">{{ Carbon::parse($user->joining_date)->format('M d, Y') }}</span></label>
                        @endif

                        <label class="mx-1 badge bg-secondary">
                            @lang('Classes') : <span id="joining_date_label" class="font-weight-normal"
                                alt="Classes">{{ $user->student?->class_count }}</span></label>

                    </p>
                </h5>
                <div class="d-flex flex-sm-row flex-column">
                    @if (@$user->ID_Number)
                        <label class="p-1 text-info rounded border border-dark  mx-1">ID No :
                            {{ @$user->ID_Number }}</label>
                    @endif
                    @if (@$user->user_name)
                        <label class="p-1 text-info rounded border border-dark  mx-1">User Name :
                            {{ @$user->user_name }}</label>
                    @endif
                    <label class="p-1 text-info rounded border border-dark  mx-1"> <em
                            class="fas fa-envelope-open"></em>
                        {{ @$user->email }}</label> <label class="p-1 text-info rounded border border-dark  mx-1"><em
                            class="fas fa-phone-volume"></em> {{ @$user->full_phone_number }} </label>
                    <label class="p-1 text-info rounded border border-dark  mx-1"> <em
                            class="fas fa-user-circlelt"></em>
                        {{ @$user->gender_label }}</label>
                    <label class="p-1 text-info rounded border border-dark mx-1">
                        <em class=" fas fa-calendar-alt"></em>
                        {{ __('DOB') }} {{ @$user->dob }}</label>
                </div>
            </div>
        </div>

        @include('admin.students.tabs')
        {{-- @include('admin.students.old') --}}
    </div>

</div>
<!-- accoridan part -->
@push('styles')
    <style>
        .mini-table tr,
        .mini-table th {
            border: none !important;
        }
    </style>
@endpush
@endsection
