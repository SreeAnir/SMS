@extends('layouts.admin.app')
@section('title', $title ?? 'Staff details')
@section('content')
@section('header_buttons')
    @if (!$userDetails->isSuperAdmin())
        <a 1target="_blank" href="{{ route('staffs.edit', [$userDetails]) }}" type="button" class="btn btn-primary btn-lg">
            <em class="fas fa-pencil-alt px-2"></em>@lang('Edit Staff')
        </a>
    @endif
@endsection
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            @php
                $instance = $userDetails;
            @endphp
            <h5 class="card-title mb-3">
                {{ @$userDetails->full_name }} <label class="mx-3"> @include('common.status-badge')

                </label> </h5>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    {{-- 
               <thead>
               </thead>
               --}}
                    <tbody>
                        <tr>
                            <th scope="col">{{ __('Email') }}</th>
                            <th scope="col">{{ @$userDetails->email }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('Contact Number') }}</th>
                            <th scope="col">{{ @$userDetails->full_phone_number }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('Gender') }}</th>
                            <th scope="col">{{ @$userDetails->gender_label }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    {{-- 
               <thead>
               </thead>
               --}}
                    <tbody>
                        <tr>
                            <th scope="col">{{ __('Staff Id') }}</th>
                            <th scope="col">{{ @$userDetails->ID_Number }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('RFID Number') }}</th>
                            <th scope="col">{{ @$userDetails->rfid }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('Branch Location') }}</th>
                            <th scope="col">{{ @$userDetails->location->name }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-sm-row flex-column">
                    @if (@$userDetails->ID_Number)
                        <label class="p-1 text-info rounded border border-dark  mx-1">ID
                            {{ @$userDetails->ID_Number }}</label>
                    @endif
                    <label class="p-1 text-info rounded border border-dark  mx-1"> <em
                            class="fas fa-envelope-open"></em>
                        {{ @$userDetails->email }}</label> <label
                        class="p-1 text-info rounded border border-dark  mx-1"><em class="fas fa-phone-volume"></em>
                        {{ @$userDetails->full_phone_number }} </label>
                    <label class="p-1 text-info rounded border border-dark  mx-1"> <em class="fas fa-user"></em>
                        {{ @$userDetails->gender_label }}</label>
                    <label class="p-1 text-info rounded border border-dark mx-1">
                        <em class=" fas fa-pencil-alt"></em>
                        {{ __('RFID') }} {{ @$userDetails->rfid }}</label>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#contact" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Contact Details') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#id_details" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('ID Details') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#accounts" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Accounts & Payments') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#insurance" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Insurance') }}</span></a>
            </li>

        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="contact" role="tabpanel">
                <div>
                    <div class="col">
                        <!--begin::Label-->
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th colspan="4" scope="col">
                                            <h6 class="text-info">
                                                <em class="fas fa-paper-plane"></em> Contact  $ Communication Info
                                            </h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="20%">Present Address</th>
                                        <th width="30%">{{ @$staffDetails->present_address }}</th>
                                        <th width="20%">Permanent Address</th>
                                        <th width="30%">{{ @$staffDetails->permanent_address }}</th>
                                    </tr>
                                    <tr>
                                        <th width="20%">Alternative Contact Number</th>
                                        <th width="30%">{{ @$staffDetails->alt_phone_code }}
                                            {{ @$staffDetails->alt_phone_number }}</th>
                                        <th width="20%">Home Country Phone Number</th>
                                        <th width="30%">{{ @$staffDetails->home_phone_code }}
                                            {{ @$staffDetails->home_phone_number }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" scope="col">
                                            <h6 class="text-info"><em class="fas fa-phone"></em>
                                                {{ __(' Emergency Contact') }}</h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="20%">Contact Number</th>
                                        <th width="30%">{{ @$staffDetails->emergency_phone_code }}
                                            {{ @$staffDetails->emergency_phone_number }}</th>
                                        <th width="20%">Contact Person Name</th>
                                        <th width="30%">{{ @$staffDetails->emergency_contact_person }}</th>
                                    </tr>
                                    <tr>
                                        <th width="20%">Contact Person Relationship</th>
                                        <th width="30%">{{ @$staffDetails->emergency_contact_person_relation }}</th>
                                        <th colspan="2">&nbsp</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="id_details" role="tabpanel">
                <div class="col">
                    <!--begin::Label-->
                    <div class="card-body">
                        <h6 class="card-title my-4 text-info">
                            <b>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                    <path
                                        d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z" />
                                </svg>
                            </b>
                            {{ __(' Visa,Passport & Emirates ID Details') }}
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Visa UID</th>
                                            <th>{{ @$staffDetails->visa_uid }}</th>
                                        </tr>
                                        <tr>
                                            <th>Visa File Number</th>
                                            <th>{{ @$staffDetails->visa_file_no }}</th>
                                        </tr>
                                        <tr>
                                            <th>Visa Issue Date</th>
                                            <th>{{ @$staffDetails->visa_issue_date }}</th>
                                        </tr>
                                        <tr>
                                            <th>Visa Expiry Date</th>
                                            <th>{{ @$staffDetails->visa_expiry_date }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Passport Number</th>
                                            <th>{{ @$staffDetails->passport_number }}</th>
                                        </tr>
                                        <tr>
                                            <th>Passport Issue Date</th>
                                            <th>{{ @$staffDetails->passport_issue_date }}</th>
                                        </tr>
                                        <tr>
                                            <th>Passport Expiry</th>
                                            <th>{{ @$staffDetails->passport_expiry }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Emirates ID</th>
                                            <th>{{ @$staffDetails->emirates_id }}</th>
                                        </tr>
                                        <tr>
                                            <th>Emirates ID Expiry</th>
                                            <th>{{ @$staffDetails->emirates_id_expiry }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-20" id="accounts" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title my-4 text-info"><em class="fas fa-mobile"></em>
                            {{ __('Salary Transfer Details') }}</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>IBAN Number</th>
                                            <th>{{ @$staffDetails->iban_no }}</th>
                                        </tr>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>{{ @$staffDetails->bank_name }}</th>
                                        </tr>
                                        <tr>
                                            <th>Bank Branch</th>
                                            <th>{{ @$staffDetails->bank_branch }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-20" id="insurance" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title my-4 text-info"><em class="fas fa-hospital"></em>
                            {{ __('Medical Insurance') }}</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="20%">Insurance Provider</th>
                                            <th>{{ @$staffDetails->insurance_provider }}</th>
                                            <th width="20%">Policy Number</th>
                                            <th>{{ @$staffDetails->policy_no }}</th>
                                        </tr>
                                        <tr>
                                            <th width="20%">Policy Plan</th>
                                            <th>{{ @$staffDetails->policy_plan }}</th>
                                            <th width="20%">Expiry Date</th>
                                            <th>{{ @$staffDetails->policy_expiry_date }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- accoridan part -->
<!-- card new -->
</div>
@endsection
@push('scripts')
@endpush
