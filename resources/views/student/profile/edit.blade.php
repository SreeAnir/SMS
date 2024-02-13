 @extends('layouts.student.web')
 @section('content')
 @section('title', isset($user) ? 'Edit Student' : 'New Student')

 @include('student.includes.top-info')
 <div class="container theme-border bg-white">
    <h5 class="text-success py-3">Change Profile</h5>
     <form id="edit-profile" action="{{ route('profile.update') }}" method="post">
         @csrf
         @method('put')

         <div class="row">
             <div class="card">
                 <form class="form-horizontal p-2"
                     action="{{ isset($user) ? route('students.update', ['user' => $user]) : route('students.store') }}"
                     method="POST" id="create-student">
                     @csrf()

                     <h6 class="card-title my-4 text-info"><em class="fab fa-expeditedssl"></em>
                         {{ __('Basic Info') }}
                     </h6>
                     <div class="card-body border-top p-9">
                         @if (isset($user))
                             {{ method_field('PUT') }}
                         @endif
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="first_name">{{ __('First Name') }}</label>
                                     <input maxlength="20" placeholder="{{ __('First name') }}" type="text"
                                         class="form-control" id="first_name" name="first_name"
                                         value="{{ isset($user->first_name) ? $user->first_name : old('first_name') }}">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="last_name">{{ __('Last name') }}</label>
                                     <input maxlength="20" type="text" class="form-control" id="last_name"
                                         name="last_name"
                                         value="{{ isset($user->last_name) ? $user->last_name : old('last_name') }}">
                                 </div>
                             </div>
                             <div class="col-md-3 col-sm-12">

                                 <div class="form-group">
                                     <label for="dob">{{ __('Date of Birth') }}</label>
                                     <input autocomplete="off" placeholder="{{ __('Date of Birth') }}" type="text"
                                         class="form-control" id="dob" name="dob"
                                         value="{{ isset($user->dob) ? $user->dob : old('dob') }}">
                                 </div>
                             </div>

                             <div class="col-md-2 col-sm-12">
                                 <div class="form-group">
                                     <label for="blood_group">{{ __('Blood Group') }}</label>
                                     <select id="bloodGroup" class="form-control" name="blood_group">
                                         @php
                                             $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                         @endphp
                                         @foreach ($bloodGroups as $bloodg)
                                             <option value="{{ @$bloodg }}"
                                                 {{ isset($user->blood_group) && $user->blood_group == $bloodg ? 'selected' : '' }}>
                                                 {{ $bloodg }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>

                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                     <label for="weight">{{ __('Weight') }} {{ '(Kg)' }}</label>
                                     <input maxlength="3" style="width:150px;" placeholder="{{ __('weight') }}"
                                         type="text" class="form-control" id="weight" name="weight"
                                         value="{{ isset($user->weight) ? $user->weight : old('weight') }}">
                                 </div>
                             </div>

                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group row d-flex flex-column">
                                     <label class="col-md-3 col-sm-12 ">{{ __('Gender') }}</label>
                                     <div
                                         class="col-md-9 d-flex flex-row justify-content-lg-between justify-content-sm-start">
                                         <div class="form-check ">
                                             <input type="radio" class="form-check-input" id="male"
                                                 value="1" name="gender" required=""
                                                 {{ old('gender') == 1 ? ' checked ' : '' }}
                                                 {{ isset($user->gender) && $user->gender == '1' ? 'checked' : '' }}>
                                             <label class="form-check-label mb-0 mr-2"
                                                 for="male">{{ __('Male') }}</label>
                                         </div>
                                         <div class="form-check mx-3 ">
                                             <input type="radio" class="form-check-input" id="female"
                                                 value="2" name="gender" required=""
                                                 {{ old('gender') == 2 ? ' checked ' : '' }}
                                                 {{ isset($user->gender) && $user->gender == '2' ? 'checked' : '' }}>
                                             <label class="form-check-label mb-0"
                                                 for="female">{{ __('Female') }}</label>
                                         </div>

                                     </div>
                                 </div>
                             </div>

                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="occupation">{{ __('Occupation') }}</label>
                                     <input maxlength="150" placeholder="{{ __('Occupation') }}" type="text"
                                         class="form-control" id="occupation" name="occupation"
                                         value="{{ isset($user->occupation) ? $user->occupation : old('occupation') }}">
                                 </div>
                             </div>

                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="country">{{ __('Country') }}</label>

                                     <select id="country_id" class="form-control" name="country_id">
                                        @php
                                            $countries = countryList(@$user->country_id);
                                        @endphp
                                        @foreach ($countries as $country)
                                            <option value="{{ @$country->id }}"  
                                                 {{ isset($user->country_id) && $user->country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                  
                                 </div>
                             </div>
                         </div>

                         <hr />
                         <h6 class="card-title my-4 text-info"><em
                                 class="fas fa-paper-plane"></em>{{ __('Contact Details') }}
                         </h6>

                         <div class="row">


                             <div class="col-md-3 col-sm-12">
                                 <label for="phone_number">{{ __('Phone') }}</label>
                                 <div class="form-group">
                                     <input maxlength="10" name="phone_number"
                                         value="{{ isset($user) ? $user->phone_number : old('phone_number') }}"
                                         type="tel" id="phone_number" class="form-control tel-input"
                                         placeholder="Phone Number">
                                    <input type="hidden" name="phone_code" id="phone_code" value="{{ isset($user) ? $user->phone_code :  ( old('phone_code') !="" ?  old('phone_code') : defaultCode() ) }}" placeholder="Dialing Code" readonly>
                                 </div>
                             </div>

                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                     <label for="emergency_contact">{{ __('Telephone (Residential)') }}</label>
                                     <input maxlength="14" type="text" class="form-control" id="residency_phone"
                                         name="residency_phone"
                                         value="{{ isset($student->residency_phone) ? $student->residency_phone : old('residency_phone') }}">
                                 </div>
                             </div>

                             <div class="col-md-2 col-sm-12">
                                 <div class="form-group">
                                     <label for="emergency_contact">{{ __('Emergency Contact') }}</label>
                                     <input maxlength="14" type="text" class="form-control"
                                         id="emergency_contact" name="emergency_contact"
                                         value="{{ isset($student->emergency_contact) ? $student->emergency_contact : old('emergency_contact') }}">
                                 </div>
                             </div>
                             <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="emergency_contact">{{ __('Emergency Contact 2') }}</label>
                                    <input maxlength="14" type="text" class="form-control"
                                        id="emergency_contact_2" name="emergency_contact_2"
                                        value="{{ isset($student->emergency_contact_2) ? $student->emergency_contact_2 : old('emergency_contact_2') }}">
                                </div>
                            </div>
                             <div class="col-md-2 col-sm-12">
                                 <div class="form-group">
                                     <label for="po_box">{{ __('P.O.Box') }}</label>
                                     <input maxlength="6" type="text" class="form-control" id="po_box"
                                         name="po_box"
                                         value="{{ isset($student->po_box) ? $student->po_box : old('po_box') }}">
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                     <label for="po_box">{{ __('Email') }}</label>
                                     <input maxlength="120" type="text" class="form-control" id="email"
                                         name="email"
                                         value="{{ isset($user->email) ? $user->email : old('email') }}">
                                 </div>
                             </div>
                         </div>
                         <div class="row mt-1">
                             <p class="card-title">
                                 {{ __('Parent\'s Details (applicable if the applicant is Minor/Student)') }}</p>

                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                     <label for="parent_name">{{ __('Name') }}</label>
                                     <input maxlength="60" type="text" class="form-control" id="parent_name"
                                         name="parent_name"
                                         value="{{ isset($student->parent_name) ? $student->parent_name : old('parent_name') }}">
                                 </div>
                             </div>
                             <div class="col-md-3 col-sm-12">
                                 <div class="form-group">
                                     <label for="parent_occupation">{{ __('Parent Occupation') }}</label>
                                     <input maxlength="30" type="text" class="form-control" id="parent_occupation"
                                         name="parent_occupation"
                                         value="{{ isset($student->parent_occupation) ? $student->parent_occupation : old('parent_occupation') }}">
                                 </div>
                             </div>

                             <div class="col-md-4 col-sm-12">
                                 <div class="form-group">
                                     <label for="parent_phone">{{ __('Contact Number') }}</label>
                                     <input maxlength="15"
                                         value="{{ isset($student->parent_phone) ? $student->parent_phone : old('parent_phone') }}"
                                         type="text" class="form-control" id="parent_phone" name="parent_phone">
                                 </div>
                             </div>
                         </div>
                         <h6 class="card-title my-4 text-info"><em class="fas fa-sitemap"></em> {{ __('More Info') }}
                         </h6>

                         <div class="row mt-3">
                             <div class="col-md-6">
                                 <div class="form-group row">
                                     <div class="col-md-12 d-flex  ">
                                         {{ __('Do you have any relatives or friends enrolled?') }} 
                                         <div class="form-check mx-2">
                                             <input value="1" type="radio" class="form-check-input"
                                                 id="customControlValidation1" name="relative_enrolled"
                                                 required=""
                                                 {{ old('relative_enrolled') === 1 ? ' checked ' : '' }}
                                                 {{ isset($student->relative_enrolled) && (bool) $student->relative_enrolled == true ? 'checked' : '' }}>
                                             <label class="form-check-label mb-0"
                                                 for="customControlValidation1">{{ __('Yes') }}</label>
                                         </div>
                                         <div class="form-check">
                                             <input value="0" type="radio" class="form-check-input"
                                                 id="customControlValidation2" name="relative_enrolled"
                                                 required=""
                                                 {{ old('relative_enrolled') === 0 ? ' checked ' : '' }}
                                                 {{ isset($student->relative_enrolled) && $student->relative_enrolled == '0' ? 'checked' : '' }}>
                                             <label class="form-check-label mb-0"
                                                 for="customControlValidation2">{{ __('No') }}</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-md-4 col-sm-12" id="relative_details">
                                 <div class="form-group">
                                     <label for="parent_name">{{ __('Relative\'s Name') }}</label>
                                     <input maxlength="35" type="text" class="form-control" id="relative_name"
                                         name="relative_name"
                                         value="{{ isset($student->relative_name) ? $student->relative_name : old('relative_name') }}">
                                 </div>
                             </div>

                         </div>
                         {{-- If yes, Name :
                            Yes
                            No
                            If Yes, Sty:
                             --}}


                         <div class="row mt-3">
                             <div class="col-md-6">
                                 <div class="form-group row">
                                     <div class="col-md-12 d-flex  ">
                                         {{ __('Have you practiced any Martial Art ?') }}
                                         <div class="form-check mx-2">
                                             <input value="1" type="radio" class="form-check-input"
                                                 id="pre_trained_martial" name="pre_trained_martial" required=""
                                                 {{ old('pre_trained_martial') === 0 ? ' checked ' : '' }}
                                                 {{ isset($student->pre_trained_martial) && $student->pre_trained_martial == true ? 'checked' : '' }}>
                                             <label class="form-check-label mb-0"
                                                 for="pre_trained_martial1">{{ __('Yes') }}</label>
                                         </div>
                                         <div class="form-check">
                                             <input value="0" type="radio" class="form-check-input"
                                                 id="pre_trained_martial" name="pre_trained_martial" required=""
                                                 {{ old('pre_trained_martial') === 0 ? ' checked ' : '' }}
                                                 {{ isset($student->pre_trained_martial) && $student->pre_trained_martial == false ? 'checked' : '' }}>
                                             <label class="form-check-label mb-0"
                                                 for="pre_trained_martial2">{{ __('No') }}</label>
                                         </div>
                                     </div>
                                 </div>

                             </div>

                             <div class="col-md-4" id="mart_style">
                                 <div class="form-group">
                                     <label for="pre_martial_style">{{ __('Martial Art Style') }}</label>
                                     <input maxlength="30" placeholder="{{ __('Martial Art Style') }}"
                                         type="text" class="form-control" id="pre_martial_style"
                                         name="pre_martial_style"
                                         value="{{ isset($student->pre_martial_style) ? $student->pre_martial_style : old('pre_martial_style') }}">
                                 </div>
                             </div>
                         </div>

                         <div class="row mt-3">
                             <div class="col-md-12">
                                 @php
                                     $info_source_array = [];
                                     if (!empty($student->info_source)) {
                                         $info_source_array = json_decode($student->info_source, true);
                                     }
                                 @endphp
                                 <div class="form-group row">
                                     <div class="col-md-12 p-1 mt-2">
                                         {{ __('Please let us know, How did you know about us ?') }}
                                         <div class="d-flex justify-content-between flex-column flex-md-row mt-2">
                                             <div class="form-check">
                                                 <input value="1" type="checkbox" class="form-check-input"
                                                     id="info_source_1" name="info_source[]"  
                                                     {{ in_array(old('info_source_1'), $info_source_array) ? 'checked' : '' }}
                                                     {{ in_array('1', $info_source_array) ? 'checked' : '' }}>
                                                 <label class="form-check-label mb-0"
                                                     for="info_source_2">{{ __('Online') }}</label>
                                             </div>
                                             <div class="form-check">
                                                 <input value="2" type="checkbox" class="form-check-input"
                                                     {{ in_array(old('info_source_2'), $info_source_array) ? 'checked' : '' }}
                                                     id="info_source_2" name="info_source[]"  
                                                     {{ in_array('2', $info_source_array) ? 'checked' : '' }}>
                                                 <label class="form-check-label mb-0"
                                                     for="info_source_2">{{ __('Billboard') }}</label>
                                             </div>
                                             <div class="form-check">
                                                 <input value="3" type="checkbox" class="form-check-input"
                                                     {{ in_array(old('info_source_3'), $info_source_array) ? 'checked' : '' }}
                                                     id="info_source_3" name="info_source[]"  
                                                     {{ in_array('3', $info_source_array) ? 'checked' : '' }}>
                                                 <label class="form-check-label mb-0"
                                                     for="info_source_3">{{ __('Demonstration') }}</label>
                                             </div>
                                             <div class="form-check">
                                                 <input value="4" type="checkbox" class="form-check-input"
                                                     {{ in_array(old('info_source_4'), $info_source_array) ? 'checked' : '' }}
                                                     id="info_source_4" name="info_source[]"  
                                                     {{ in_array('4', $info_source_array) ? 'checked' : '' }}>
                                                 <label class="form-check-label mb-0"
                                                     for="info_source_4">{{ __('Instagram') }}</label>
                                             </div>
                                             <div class="form-check">
                                                 <input value="5" type="checkbox" class="form-check-input"
                                                     {{ in_array(old('info_source_6'), $info_source_array) ? 'checked' : '' }}
                                                     id="info_source_6" name="info_source[]" 
                                                     {{ in_array('5', $info_source_array) ? 'checked' : '' }}>
                                                 <label class="form-check-label mb-0"
                                                     for="info_source_6">{{ __('Facebook') }}</label>
                                             </div>
                                             <div class="form-check">
                                                 <input value="6" type="checkbox" class="form-check-input"
                                                     {{ in_array(old('info_source_7'), $info_source_array) ? 'checked' : '' }}
                                                     id="info_source_7" name="info_source[]" 
                                                     {{ in_array('6', $info_source_array) ? 'checked' : '' }}>
                                                 <label class="form-check-label mb-0"
                                                     for="info_source_7">{{ __('WhatsApp Brochure') }}</label>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             </div>

                         </div>


                         <hr />
                         <h6 class="card-title my-4 text-info">
                             <b> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                                     <path fill-rule="evenodd"
                                         d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                     <path
                                         d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z" />
                                 </svg> </b>
                             {{ __('Passport & Emirates ID Details') }} /
                             تفاصيل جواز السفر والهوية الإماراتية
                         </h6>

                         <div class="row">

                             <div class="col-md-3 col-sm-12">
                                 <label for="phone_number">{{ __('Passport Number') }}/هاتف</label>
                                 <div class="form-group">
                                     <input   maxlength="15" name="passport_number"
                                         value="{{ isset($student) ? $student->passport_number : '' }}"
                                         type="text" id="passport_number"
                                         class="form-control  rounded"
                                         placeholder="Passport Number/رقم جواز السفر">
                                 </div>
                             </div>
                             <div class="col-md-3 col-sm-12">
                                 <label for="passport_expiry">{{ __('Passport Expiry') }}/هاتف</label>
                                 <div class="form-group">
                                     <input maxlength="15" name="passport_expiry"
                                         value="{{ isset($student) ? $student->passport_expiry : '' }}"
                                         type="text" id="passport_expiry"
                                         class="form-control  rounded"
                                         placeholder="Passport Expiry/انتهاء جواز السفر">
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
                                 <label for="phone_number">{{ __('Emirates ID') }}/هاتف</label>
                                 <div class="form-group">
                                     <input   maxlength="15" name="emirates_id"
                                         value="{{ isset($student) ? $student->emirates_id : '' }}" type="text"
                                         id="emirates_id" class="form-control  rounded "
                                         placeholder="Emirates ID/هويه الإمارات">
                                     @error('emirates_id')
                                         <span class="text-danger" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                     @enderror
                                 </div>
                             </div>

                             <div class="col-md-3 col-sm-12">
                                 <label for="phone_number">{{ __('Emirates ID Expiry') }}/هاتف</label>
                                 <div class="form-group">
                                     <input maxlength="15" name="emirates_id_expiry"
                                         value="{{ isset($student) ? $student->emirates_id_expiry : '' }}"
                                         type="text" id="emirates_id_expiry"
                                         class="form-control  rounded "
                                         placeholder="Emirates ID Expiry/انتهاء صلاحية الهوية الإماراتية">
                                     @error('emirates_id_expiry')
                                         <span class="text-danger" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                     @enderror
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

         </div>

     </form>
 </div>
@endsection
@push('styles')
 <link rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
@endpush
@push('scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

 <script>
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
   

     window.addEventListener('load', function() {
         $('#dob').datepicker({
             format: 'yyyy-mm-dd', // You can adjust the format as needed
             autoclose: true,
             endDate: 'today', // Prevent selecting future dates
             // startView: 2, // Start with the year view for faster navigation
         });

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

         $("#edit-profile").validate({
             rules: {
                 
                 first_name: {
                     required: true,
                     maxlength: 30,
                 },
                 last_name: {
                     required: true,
                     maxlength: 30,
                 },
                 email: {
                     required: true,
                     email: true,
                     maxlength: 100
                 },
                 dob: {
                     required: true,
                 },
                 gender: {
                     required: true,
                 },
                 phone_number: {
                     required: true,
                     maxlength: 15
                 },
                 weight: {
                     required: true,
                     maxlength: 5
                 },
                 country_id: {
                     required: true,
                     maxlength: 2
                 },

                 phone_number: {
                     required: true,
                     maxlength: 15
                 },
                 residency_phone: {
                     required: true,
                     maxlength: 15
                 },
                 emergency_contact: {
                     required: true,
                     maxlength: 15
                 },
                 po_box: {
                     required: true,
                     maxlength: 8
                 },
                 relative_enrolled: {
                     required: true,
                 },
                 pre_trained_martial: {
                     required: true,
                 },
                 emirates_id: {
                    required: true,
                    regex: /^\d{15}$/
                },
                passport_number: {
                    regex: /^[A-Z0-9]{6,9}$/
                },
                 emirates_id_expiry: {
                     required: true,
                 },
                 parent_name: {
                     required: function(element) {
                         var dobValue = $('#dob').val();
                         var today = new Date();
                         var birthDate = new Date(dobValue);
                         var age = today.getFullYear() - birthDate.getFullYear();

                         return age < 18;
                     },
                     maxlength: 60,
                 },
                 parent_occupation: {
                     required: function(element) {
                         var dobValue = $('#dob').val();
                         var today = new Date();
                         var birthDate = new Date(dobValue);
                         var age = today.getFullYear() - birthDate.getFullYear();

                         return age < 18;
                     },
                     maxlength: 30
                 },
                 parent_phone: {
                     required: function(element) {
                         var dobValue = $('#dob').val();
                         var today = new Date();
                         var birthDate = new Date(dobValue);
                         var age = today.getFullYear() - birthDate.getFullYear();

                         return age < 18;
                     },
                     maxlength: 15
                 },
                  
             },
             messages: {
                first_name: {
                            required: "First Name is required",
                            maxlength: "Name cannot be more than 20 characters"
                        },
                        last_name: {
                            required: "Last Name is required",
                            maxlength: "Name cannot be more than 20 characters"
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
                        emirates_id: {
                            required: "Emirates ID required",
                            maxlength: "Emirates ID Number be less than 15 characters"
                        },
                        emirates_id_expiry: {
                            required: "Emirates ID Expiry date is required",
                        },
                        parent_name: {
                            required: "Parent Name is required in case of minor student",
                            maxlength: "Parent Name must be less than 60 characters"
                        },
                        parent_occupation: {
                            required: "Parent Company is required in case of minor student",
                            maxlength: "Parent Name must be less than 30 characters"
                        },
                        parent_phone: {
                            required: "Parent Phone is required in case of minor student",
                            maxlength: "Parent Name must be less than 15 characters"
                        },
                        dob: {
                            required: "Date of Birth is required",
                        },
                        weight: {
                            required: "Weight is required",
                        },
                        gender: {
                            required: "Gender is required",
                        },
                        country_id: {
                            required: "Country is required",
                        },
                        phone_number : {
                            required: "Phone number is required",
                        },
                        residency_phone : {
                            required: "Residency phone number is required",
                        },
                        emergency_contact : {
                            required: "Emergency contact number is required",
                        },
                        po_box : {
                            required: "PO box number is required",
                        },
                        'info_source[]' :{
                            required: "Select atleast one",
                        }
                 
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
         toggelRelative();
         toggelMartStyle();

         function toggelRelative() {
             //   console.log($('input[name="relative_enrolled"]').val() ) ;
             if ($('input[name="relative_enrolled"]:checked').val() == 1) {
                 $('#relative_details').show();
             } else {
                 $('#relative_details').hide();
             }
         }

         function toggelMartStyle() {
             //   console.log($('input[name="relative_enrolled"]').val() ) ;
             if ($('input[name="pre_trained_martial"]:checked').val() == 1) {
                 $('#mart_style').show();
             } else {
                 $('#mart_style').hide();
             }
         }

         $(document).ready(function() {
             $(document).on('click', 'input[name="relative_enrolled"]', function() {
                 toggelRelative();
             });
             $(document).on('click', 'input[name="pre_trained_martial"]', function() {
                 toggelMartStyle();
             });


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



         // $(document).ready(function () {
         //     var phoneInput = document.querySelector("#phone");
         //     var dialingCodeInput = document.querySelector("#dialing_code");

         //     // Initialize the intl-tel-input
         //     var iti = window.intlTelInput(phoneInput, {
         //         separateDialCode: true,
         //         utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
         //     });

         //     // Listen for changes in the selected country
         //     phoneInput.addEventListener("countrychange", function () {
         //         var selectedCountryData = iti.getSelectedCountryData();
         //         if (selectedCountryData) {
         //             dialingCodeInput.value = "+" + selectedCountryData.dialCode;
         //         }
         //     });
         // });
     });
 </script>
@endpush

@push('styles')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
 <style>
     @media screen and (max-width: 768px) {
         .select2-container {
             max-width: 200px !important;
         }

         /* Styles for screens with a maximum width of 768px (typical for mobile devices) */
     }

     .select2-container {
         min-width: 280px !important;
     }

     @media screen and (min-width: 1300px) {

         .tel-input {
             padding-left: 75px;
             height: calc(2.1rem + 2px);
         }

         /* Modify the height and padding for the select2 dropdown */
         .select2-dropdown {
             padding: 4px !important;
             /*  10px; Change the padding as needed */
         }

         /* Increase the height for the select2 container */
         .select2-container .select2-selection {
             /* height: calc(3.5rem + 2px); */
             height: calc(2.1rem + 2px);
             padding: 4px !important;
             /* 10px;  Adjust the padding as needed */
         }

         /* Increase the height and padding for the select2 dropdown */
         .select2-container .select2-dropdown {
             padding: 20px;
             /* Adjust the padding as needed */
         }
     }

     .select2-container--default .select2-selection--single {
         border: 1px solid #eaecef;
     }
 </style>
@endpush
