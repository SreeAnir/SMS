@extends('layouts.admin.app') @section('title', isset($staff) ? 'Edit staff' : 'New staff') @push('style') @section('content') 
@php  
        $filter = [];
            if( auth()->user()->location_id !=null ){
                $filter['location_id'] =  auth()->user()->location_id ;
            }
        $locationList = locationList($filter);
 @endphp <div class="row">
    <div class="card">
        <form class="form-horizontal p-2" action="{{ isset($staff) ? route('staffs.update', [$staff]) : route('staffs.store') }}" method="POST" id="create-staff"> @csrf() <input name="user_type" value="{{ isset($staff) ? $staff->user_type : App\Models\Role::USER_TYPE_STAFF }}" type="hidden" class="form-control" />
            <h6 class="card-title my-4 text-info">
                <em class="fab fa-expeditedssl"></em>
                {{ __('Basic Info') }}
            </h6>
            <div class="card-body border-top p-9"> @if (isset($staff)) {{ method_field('PUT') }} @endif <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">
                                {{ __('First Name') }}</label>
                            <input maxlength="20" placeholder="{{ __('First name') }}" type="text" class="form-control" id="first_name" name="first_name" value="{{ isset($staff->first_name) ? $staff->first_name : old('first_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">{{ __('Last name') }}</label>
                            <input maxlength="20" type="text" class="form-control" id="last_name" name="last_name" value="{{ isset($staff->last_name) ? $staff->last_name :  old('last_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="dob">{{ __('Email') }}</label>
                            <input autocomplete="off" placeholder="{{ __('Email') }}" type="text" class="form-control" id="email" name="email" value="{{ isset($staff->email) ? $staff->email :  old('email') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="phone_number">{{ __('Contact Number')}}</label>
                        <div class="form-group">
                            <input name="phone_number" maxlength="10" value="{{ isset($staff) ? $staff->phone_number : old('phone_number') }}" type="tel" id="phone_number" class="form-control" placeholder="Phone Number">
                            <input type="hidden" name="phone_code" id="phone_code" value="{{ isset($staff) ? $staff->phone_code :  ( old('phone_code') !="" ?  old('phone_code') : defaultCode() ) }}" placeholder="Dialing Code" readonly>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group row d-flex flex-column">
                            <label class="col-md-3 col-sm-12 ">{{ __('Gender') }}</label>
                            <div class="col-md-9 d-flex flex-row justify-content-lg-between justify-content-sm-start">
                                <div class="form-check ">
                                    <input type="radio" class="form-check-input" id="male" value="1" name="gender" required="" {{ (isset($staff->gender) && $staff->gender ==  1) ||  ( old('gender') == 1  )   ? 'checked' : '' }}>
                                    <label class="form-check-label mb-0 mr-2" for="male">{{ __('Male') }}</label>
                                </div>
                                <div class="form-check mx-3 ">
                                    <input type="radio" class="form-check-input" id="female" value="2" name="gender" required="" {{ (isset($staff->gender) && $staff->gender == 2 ) ||  ( old('gender') == 2  )   ? 'checked' : '' }}>
                                    <label class="form-check-label mb-0" for="female">{{ __('Female') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>  
                                      
                    
                </div>
                <hr />
                <h6 class="card-title my-4 text-info">
                    <em class="fas fa-sitemap"></em> {{ __('Professional Info') }}
                </h6>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label for="phone_number">{{ __('Staff Id') }}</label>
                        <div class="form-group">
                            <input maxlength="5" name="ID_Number" value="{{ isset($staff) ? $staff->ID_Number : old('ID_Number')   }}" type="text" class="form-control" placeholder="Staff Id" />
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="phone_number">{{ __('RFID Number') }}</label>
                        <div class="form-group">
                            <input maxlength="5" name="rfid" value="{{ isset($staff) ? $staff->rfid : old('ID_Number')   }}" type="text" class="form-control" placeholder="RFID Number" />
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="location_id">{{ __('Branch Location') }}</label>
                        <div class="form-group">
                            <select class="form-control" name="location_id">
                                <option value="">Select Location</option> @if (!empty($locationList)) @foreach ($locationList as $ll) <option value="{{ $ll->id }}" {{ @$staff->location_id }} {{ (isset($staff) && $staff->location_id == $ll->id ) || old('location_id') ==  $ll->id  ? 'selected' : '' }}>
                                    {{ $ll->name }}
                                </option> @endforeach @endif
                            </select>
                        </div>
                    </div>
                </div>
                <hr />
                <h6 class="card-title my-4 text-info">
                    <em class="fas fa-paper-plane"></em> {{ __('Contact Details') }}
                </h6>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="present_address">{{ __('Present Address') }}</label>
                        <div class="form-group">
                           <textarea placeholder="{{ __('Present Address') }}" class="form-control" name="present_address" id="present_address">{{ isset($staffData) ? $staffData->present_address : old('present_address')   }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="permanent_address">{{ __('Permanent Address') }}</label>
                        <div class="form-group">
                           <textarea placeholder="{{ __('Permanent Address') }}" class="form-control" name="permanent_address" id="permanent_address">{{ isset($staffData) ? $staffData->permanent_address : old('permanent_address')   }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="alt_phone_number">{{ __('Alternative Contact Number')}}</label>
                        <div class="form-group">
                            <input name="alt_phone_number" maxlength="10" value="{{ isset($staffData) ? $staffData->alt_phone_number : old('alt_phone_number') }}" type="tel" id="alt_phone_number" class="form-control" placeholder="{{ __('Alternative Contact No.')}}">
                            <input type="hidden" name="alt_phone_code" id="alt_phone_code" value="{{ isset($staffData) ? $staffData->alt_phone_code : ( old('alt_phone_code') !="" ?  old('alt_phone_code') : defaultCode() ) }}" placeholder="Dialing Code" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="alt_phone_number">{{ __('Home Country Phone Number')}}</label>
                        <div class="form-group">
                            <input name="home_phone_number" maxlength="10" value="{{ isset($staffData) ? $staffData->home_phone_number : old('home_phone_number') }}" type="tel" id="home_phone_number" class="form-control" placeholder="{{ __('Home Country Phone Number')}}">
                            <input type="hidden" name="home_phone_code" id="home_phone_code" value="{{ isset($staffData) ? $staffData->home_phone_code : ( old('home_phone_code') !="" ?  old('home_phone_code') : defaultCode() )  }}" placeholder="Dialing Code" readonly>
                        </div>
                    </div>                    
                </div>

                <hr />
                <h6 class="card-title my-4 text-info">
                    <em class="fas fa-phone"></em> {{ __('Emergency Contact') }}
                </h6>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label for="emergency_phone_number">{{ __('Contact Number')}}</label>
                        <div class="form-group">
                            <input name="emergency_phone_number"  maxlength="10" value="{{ isset($staffData) ? $staffData->emergency_phone_number : old('emergency_phone_number') }}" type="tel" id="emergency_phone_number" class="form-control" placeholder="{{ __('Contact Number')}}">
                            <input type="hidden" name="emergency_phone_code" id="emergency_phone_code" value="{{ isset($staffData) ? $staffData->emergency_phone_code :  ( old('emergency_phone_number') !="" ?  old('emergency_phone_number') : defaultCode() ) }}" placeholder="Dialing Code" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="emergency_contact_person">{{ __('Contact Person Name')}}</label>
                        <div class="form-group">
                            <input name="emergency_contact_person" value="{{ isset($staffData) ? $staffData->emergency_contact_person : old('emergency_contact_person') }}" type="text" id="emergency_contact_person" class="form-control" placeholder="{{ __('Contact Person')}}">
                            
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="emergency_contact_person_relation">{{ __('Contact Person Relationship')}}</label>
                        <div class="form-group">
                            <input maxlength="15" name="emergency_contact_person_relation" value="{{ isset($staffData) ? $staffData->emergency_contact_person_relation : old('emergency_contact_person_relation') }}" type="text" id="emergency_contact_person_relation" class="form-control" placeholder="{{ __('Contact Person Relationship')}}">
                            
                        </div>
                    </div>                                        
                </div>
                <hr />
                        <h6 class="card-title my-4 text-info">
                            <b> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-list-stars" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                    <path
                                        d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z" />
                                </svg> </b>
                            {{ __(' Visa,Passport & Emirates ID Details') }}
                        </h6>
                         <div class="row">

                            <div class="col-md-3 col-sm-12">
                                <label for="visa_uid">{{ __('Visa UID') }}</label>
                                <div class="form-group">
                                    <input maxlength="15" name="visa_uid" 
                                        value="{{ isset($staffData) ? $staffData->visa_uid : old('visa_uid') }}" type="text"
                                        id="visa_uid" class="form-control  rounded  border-secondary"
                                        placeholder="Visa UID">
                                    @error('visa_uid')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="visa_uid">{{ __('Visa File Number') }}</label>
                                <div class="form-group">
                                    <input maxlength="15" name="visa_file_no"
                                        value="{{ isset($staffData) ? $staffData->visa_file_no : old('visa_file_no') }}" type="text"
                                        id="visa_uid" class="form-control  rounded  border-secondary"
                                        placeholder="{{ __('Visa File Number') }}">
                                    @error('visa_file_no')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="visa_issue_date">{{ __('Visa Issue Date') }}</label>
                                <div class="form-group">
                                    <input maxlength="15" name="visa_issue_date"
                                        value="{{ isset($staffData) ? $staffData->visa_issue_date : old('visa_issue_date') }}" type="text"
                                        id="visa_issue_date" class="form-control  rounded  border-secondary"
                                        placeholder="{{ __('Visa Issue Date') }}">
                                    @error('visa_issue_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="visa_expiry_date">{{ __('Visa Expiry Date') }}</label>
                                <div class="form-group">
                                    <input maxlength="15" name="visa_expiry_date"
                                        value="{{ isset($staffData) ? $staffData->visa_expiry_date : old('visa_expiry_date')  }}" type="text"
                                        id="visa_expiry_date" class="form-control  rounded  border-secondary"
                                        placeholder="{{ __('Visa expiry Date') }}">
                                    @error('visa_expiry_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <label for="passport_number">{{ __('Passport Number') }}</label>
                                <div class="form-group">
                                    <input maxlength="13" name="passport_number"  
                                        value="{{ isset($staffData) ? $staffData->passport_number : old('passport_number') }}" type="text"
                                        id="passport_number" class="form-control  rounded  border-secondary"
                                        placeholder="Passport Number">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="passport_issue_date">{{ __('Passport Issue Date') }}</label>
                                <div class="form-group">
                                    <input maxlength="15" name="passport_issue_date"
                                        value="{{ isset($staffData) ? $staffData->passport_issue_date : old('passport_issue_date') }}" type="text"
                                        id="passport_issue_date" class="form-control  rounded  border-secondary"
                                        placeholder="Passport Issue Date">
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-sm-12">
                                <label for="phone_number">{{ __('Passport Expiry') }}</label>
                                <div class="form-group">
                                    <input maxlength="15" name="passport_expiry"
                                        value="{{ isset($staffData) ? $staffData->passport_expiry : old('passport_expiry') }}" type="text"
                                        id="passport_expiry" class="form-control  rounded  border-secondary"
                                        placeholder="Passport Expiry">
                                    @error('passport_expiry')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>                       
                        <div class="row">

                            <div class="col-md-3 col-sm-12">
                                <label for="phone_number">{{ __('Emirates ID') }}</label>
                                <div class="form-group">
                                    <input   maxlength="15" name="emirates_id"
                                        value="{{ isset($staffData) ? $staffData->emirates_id :  old('emirates_id')  }}" type="text"
                                        id="emirates_id" class="form-control  rounded  border-secondary"
                                        placeholder="Emirates ID">
                                    @error('emirates_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <label for="phone_number">{{ __('Emirates ID Expiry') }}</label>
                                <div class="form-group">
                                    <input maxlength="16" name="emirates_id_expiry"
                                        value="{{ isset($staffData) ? $staffData->emirates_id_expiry : old('emirates_id_expiry')  }}" type="text"
                                        id="emirates_id_expiry" class="form-control  rounded  border-secondary"
                                        placeholder="Emirates ID Expiry">
                                    @error('emirates_id_expiry')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <hr />
                <h6 class="card-title my-4 text-info">
                    <em class="fas fa-mobile"></em> {{ __('Salary Transfer Details') }}
                </h6>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label for="iban_no">{{ __('IBAN Number')}}</label>
                        <div class="form-group">
                            <input name="iban_no" maxlength="16" value="{{ isset($staffData) ? $staffData->iban_no : old('iban_no') }}" type="text" id="iban_no" class="form-control" placeholder="{{ __('IBAN Number')}}">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="bank_name">{{ __('Bank Name')}}</label>
                        <div class="form-group">
                            <input name="bank_name" maxlength="16"  value="{{ isset($staffData) ? $staffData->bank_name : old('bank_name') }}" type="text" id="bank_name" class="form-control" placeholder="{{ __('Bank Name')}}">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="bank_branch">{{ __('Bank Branch')}}</label>
                        <div class="form-group">
                            <input name="bank_branch" maxlength="16"  value="{{ isset($staffData) ? $staffData->bank_branch : old('bank_branch') }}" type="text" id="bank_branch" class="form-control" placeholder="{{ __('Bank Branch')}}">
                        </div>
                    </div>
                                                           
                </div>
                <h6 class="card-title my-4 text-info">
                    <em class="fas fa-hospital"></em> {{ __('Medical Insurance') }}
                </h6>
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <label for="insurance_provider">{{ __('Insurance Provider')}}</label>
                        <div class="form-group">
                            <input name="insurance_provider" maxlength="16"  value="{{ isset($staffData) ? $staffData->insurance_provider : old('insurance_provider') }}" type="text" id="insurance_provider" class="form-control" placeholder="{{ __('Insurance Provider')}}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="policy_no">{{ __('Policy Number')}}</label>
                        <div class="form-group">
                            <input name="policy_no" maxlength="16"  value="{{ isset($staffData) ? $staffData->policy_no : old('policy_no') }}" type="text" id="policy_no" class="form-control" placeholder="{{ __('Policy Number')}}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="insurance_provider">{{ __('Policy Plan')}}</label>
                        <div class="form-group">
                            <input name="policy_plan" maxlength="16"  value="{{ isset($staffData) ? $staffData->policy_plan : old('policy_plan') }}" type="text" id="policy_plan" class="form-control" placeholder="{{ __('Policy Plan')}}">
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-12">
                        <label for="policy_expiry_date">{{ __('Expiry Date')}}</label>
                        <div class="form-group">
                            <input maxlength="16"   name="policy_expiry_date" value="{{ isset($staffData) ? $staffData->policy_expiry_date : old('policy_expiry_date') }}" type="text" id="policy_expiry_date" class="form-control" placeholder="{{ __('Expiry Date')}}">
                        </div>
                    </div>
                                                           
                </div>
                
                <div class="card-body mt-2 ">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success text-white mx-2">
                            {{ __('Submit') }}
                        </button>
                        <button type="submit" class="btn btn-danger text-white ml-2">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div> @endsection @push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"> @endpush 
@push('scripts') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
<script>
    window.addEventListener('load', function() {
        $('#emirates_id_expiry').datepicker({
                    format: 'yyyy-mm-dd', // You can adjust the format as needed
                    autoclose: true,
                    startDate: 'today', // Prevent selecting future dates
                    // startView: 2, // Start with the year view for faster navigation
        });
        $('#passport_expiry').datepicker({
            format: 'yyyy-mm-dd', // You can adjust the format as needed
            autoclose: true,
            startDate: 'today', // Prevent selecting future dates
            // startView: 2, // Start with the year view for faster navigation
        });

        $('#passport_issue_date').datepicker({
            format: 'yyyy-mm-dd', // You can adjust the format as needed
            autoclose: true,
            startDate: 'today', // Prevent selecting future dates
            // startView: 2, // Start with the year view for faster navigation
        });
        $('#visa_issue_date').datepicker({
            format: 'yyyy-mm-dd', // You can adjust the format as needed
            autoclose: true,
            startDate: 'today', // Prevent selecting future dates
            // startView: 2, // Start with the year view for faster navigation
        });
        $('#visa_expiry_date').datepicker({
            format: 'yyyy-mm-dd', // You can adjust the format as needed
            autoclose: true,
            startDate: 'today', // Prevent selecting future dates
            // startView: 2, // Start with the year view for faster navigation
        });
        $('#policy_expiry_date').datepicker({
            format: 'yyyy-mm-dd', // You can adjust the format as needed
            autoclose: true,
            startDate: 'today', // Prevent selecting future dates
            // startView: 2, // Start with the year view for faster navigation
        });
        
        jQuery.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    if (regexp.constructor != RegExp)
                        regexp = new RegExp(regexp);
                    else if (regexp.global)
                        regexp.lastIndex = 0;
                        return this.optional(element) || regexp.test(value);
                },"Invalid Format"
        );
        $("#create-staff").validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 30,
                },
                last_name: {
                    maxlength: 30,
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 100
                },
                gender: {
                    required: true,
                },
                ID_Number: {
                    required: true,
                    maxlength: 5
                },
                phone_number: {
                    required: true
                },
                phone_code: {
                    required: true
                },
                gender: {
                    required: true
                },
                present_address: {
                    required: true
                },
                permanent_address: {
                    required: true
                },
                // alt_phone_number: {
                //     required: true
                // },
                // alt_phone_code: {
                //     required: true
                // },
                // home_phone_number: {
                //     required: true
                // },
                // home_phone_code: {
                //     required: true
                // },
                emergency_phone_number: {
                    required: true
                },
                emergency_phone_code: {
                    required: true
                },
                emergency_contact_person: {
                    required: true
                },
                emergency_contact_person_relation: {
                    required: true,
                    maxlength: 15,
                },
                visa_uid: {
                    // required: true,
                    maxlength: 15,
                },
                visa_file_no: {
                    // required: true ,
                    maxlength: 20,
                },
                visa_issue_date: {
                    // required: true,
                    maxlength: 10,
                },
                visa_expiry_date: {
                    // required: true,
                    maxlength: 10,
                },
                emirates_id: {
                    required: true,
                    regex: /^\d{15}$/
                },
                passport_number: {
                    regex: /^[A-Z0-9]{6,9}$/
                },
                passport_issue_date: {
                    // required: true
                    maxlength: 10,
                },
                passport_expiry: {
                    // required: true,
                    maxlength: 10,
                },
                
                emirates_id_expiry: {
                    required: true
                },
                iban_no: {
                    // required: true,
                    maxlength: 16,
                },
                bank_name: {
                    // required: true
                    maxlength: 16,
                },
                bank_branch: {
                    // required: true
                    maxlength: 16,
                },
                insurance_provider: {
                    // required: true,
                    maxlength: 16,
                },
                policy_no: {
                    // required: true,
                    maxlength: 16,
                },
                policy_plan: {
                    // required: true,
                    maxlength: 16,
                },
                policy_expiry_date: {
                    // required: true,
                    maxlength: 10,
                }
                
            },
            messages: {
                first_name: {
                    required: "First Name is required",
                    maxlength: "Name cannot be more than 20 characters"
                },
                last_name: {
                    maxlength: "Name cannot be more than 30 characters"
                },
                email: {
                    required: "Email is required",
                    email: "Email must be a valid email address",
                    maxlength: "Email cannot be more than 30 characters",
                },
                ID_Number: {
                    required: "ID Number is required",
                    maxlength: "Password must be less than 5 characters"
                },
                // confirm_password: {
                //     required:  "Confirm password is required",
                //     equalTo: "Password and confirm password should same"
                // }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        
        $(document).ready(function() {
            var phoneInput = document.querySelector("#phone_number");
            var dialingCodeInput = document.querySelector("#phone_code");
            // Initialize the intl-tel-input
            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
            // Listen for changes in the selected country
            phoneInput.addEventListener("countrychange", function() {
                var selectedCountryData = iti.getSelectedCountryData();
                if (selectedCountryData) {
                    dialingCodeInput.value = "" + selectedCountryData.dialCode;
                }
            });
            // Set the initial value of the intl-tel-input based on the prepopulated data
            if (dialingCodeInput.value != "") {
                iti.setNumber("+" + dialingCodeInput.value + phoneInput.value);
            } else {
                iti.setNumber("+" + 1);
            }
        });
        $(document).ready(function() {
            var phoneInput = document.querySelector("#alt_phone_number");
            var dialingCodeInput = document.querySelector("#alt_phone_code");
            // Initialize the intl-tel-input
            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
            // Listen for changes in the selected country
            phoneInput.addEventListener("countrychange", function() {
                var selectedCountryData = iti.getSelectedCountryData();
                if (selectedCountryData) {
                    dialingCodeInput.value = "" + selectedCountryData.dialCode;
                }
            });
            // Set the initial value of the intl-tel-input based on the prepopulated data
            if (dialingCodeInput.value != "") {
                iti.setNumber("+" + dialingCodeInput.value + phoneInput.value);
            } else {
                iti.setNumber("+" + 1);
            }
        });
        $(document).ready(function() {
            var phoneInput = document.querySelector("#home_phone_number");
            var dialingCodeInput = document.querySelector("#home_phone_code");
            // Initialize the intl-tel-input
            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
            // Listen for changes in the selected country
            phoneInput.addEventListener("countrychange", function() {
                var selectedCountryData = iti.getSelectedCountryData();
                if (selectedCountryData) {
                    dialingCodeInput.value = "" + selectedCountryData.dialCode;
                }
            });
            // Set the initial value of the intl-tel-input based on the prepopulated data
            if (dialingCodeInput.value != "") {
                iti.setNumber("+" + dialingCodeInput.value + phoneInput.value);
            } else {
                iti.setNumber("+" + 1);
            }
        });
        $(document).ready(function() {
            var phoneInput = document.querySelector("#emergency_phone_number");
            var dialingCodeInput = document.querySelector("#emergency_phone_code");
            // Initialize the intl-tel-input
            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
            // Listen for changes in the selected country
            phoneInput.addEventListener("countrychange", function() {
                var selectedCountryData = iti.getSelectedCountryData();
                if (selectedCountryData) {
                    dialingCodeInput.value = "" + selectedCountryData.dialCode;
                }
            });
            // Set the initial value of the intl-tel-input based on the prepopulated data
            if (dialingCodeInput.value != "") {
                iti.setNumber("+" + dialingCodeInput.value + phoneInput.value);
            } else {
                iti.setNumber("+" + 1);
            }
        });
        
        
    });
</script> @endpush