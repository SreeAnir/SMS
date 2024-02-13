@extends('layouts.app')

@section('content')
    <header style="position: fixed;width: 100%;top: 0;background: rgb(60 27 27) !important ;opacity:1 ;z-index:1;">
        {{-- rgb(26 0 0 / 80%) --}}
        <div class="container ">

            <nav class="navbar navbar-expand-lg navbar-ligh ">
                <a class="navbar-brand" href="{{ route('home')}}">  <img class="logo-header" src="{{ asset('/assets/images/logo-icon.jpg') }}"> 
                    </span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <h5 class="text-white brand_text">KALARI CLUB DUBAI</h5>

                </div>
            </nav>


        </div>
    </header>
    <div class="container login-container1">

        @if ($errors->any())
            <div class="alert alert-danger">
                Validtion Failed
            </div>
        @endif
        <div class="row ">
            {{-- <div class="card mx-auto">
                <h5 class="text-info">Student Application form</h5>
            </div> --}}
            <div class="card p-1  login-container">
                <div class="card-title p-2">
                    <h5 class="text-info text-center">Student Application form | Kalari Club</h5>
                    <div class="message-container  col-md-8 col-sm-12">
                        <p class="text-dark px-3" >Thank you for considering us. Kindly fill in the required details and
                            submit your form.
                            Our dedicated team will carefully review your application and reach out to you with further
                            instructions.
                            We look forward to welcoming you to our community!</p>
                    </div>

                </div>
                <form class="form-horizontal p-3" method="POST"
                    action="{{ isset($user) ? route('application.update', ['user' => $user]) : route('application.store') }}"
                    id="create-student">
                    @csrf()
                    <input type="hidden" value="3" name="status_id" id="status_id" />
                    <input type="hidden" value="1" name="application" id="application" />
                    <div class="card-body  p-9 ">
                        <h5 class="card-title my-4 text-secondary  ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </svg>
                            {{ __('Basic Info') }}
                        </h5>
                        @if (isset($user))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">{{ __('First Name') }} / الاسم الأول</label>
                                    <input maxlength="20" placeholder="{{ __('First name') }}/ الاسم الأول" type="text"
                                        class="form-control  rounded  border-secondary  " id="first_name" name="first_name"
                                        value="{{ isset($user->first_name) ? $user->first_name : old('first_name') }}">
                                    @error('first_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">{{ __('Last name') }}/اسم العائلة</label>
                                    <input maxlength="20" type="text" class="form-control  rounded  border-secondary  "
                                        id="last_name" name="last_name" placeholder="{{ __('Last name') }}/اسم العائلة"
                                        value="{{ isset($user->last_name) ? $user->last_name : old('last_name') }}">
                                    @error('last_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">

                                <div class="form-group">
                                    <label for="dob">{{ __('DOB') }}/تاريخ الميلاد</label>
                                    <input autocomplete="off" placeholder="{{ __('Date of Birth') }}/تاريخ الميلاد"
                                        type="text" class="form-control  rounded  border-secondary  " id="dob"
                                        name="dob" value="{{ isset($user->dob) ? $user->dob : old('dob') }}">
                                    @error('dob')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="blood_group">{{ __('Blood Group') }}/فصيلة الدم</label>
                                    <select id="bloodGroup" class="form-control  rounded  border-secondary  "
                                        name="blood_group">
                                        @php
                                            $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'O+', 'O-'];
                                        @endphp
                                        @foreach ($bloodGroups as $bloodg)
                                            <option value="{{ @$bloodg }}"
                                                {{ isset($user->blood_group) && $user->blood_group == $bloodg ? 'selected' : '' }}>
                                                {{ $bloodg }}</option>
                                        @endforeach
                                    </select>
                                    @error('blood_group')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    {{-- <input placeholder="{{ __('Blood Group') }}" type="text" class="form-control  rounded  border-secondary  "
                                        id="blood_group" name="blood_group"> --}}
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="weight">{{ __('Weight') }} {{ '(Kg)' }}/الوزن</label>
                                    <input maxlength="3" style="width:150px;"
                                        placeholder="{{ __('weight') }}/الوزن (كجم)" type="text"
                                        class="form-control  rounded  border-secondary  " id="weight" name="weight"
                                        value="{{ old('weight') }}">
                                    @error('weight')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            
                            <div class="col-md-3 col-sm-12 ml-3">
                                <div class="form-group row d-flex flex-column text-center">
                                    <label class="">{{ __('Gender') }}/جنس</label>
                                    <div
                                        class="col-md-12  d-flex flex-row  justify-content-center">
                                        <div class="form-check form-control">
                                            <input type="radio" class="form-check-input" id="male" value="1"
                                                name="gender" required=""
                                                {{ old('gender') == 1 ? ' checked ' : '' }} >
                                            <label class="form-check-label mb-0 mr-2"
                                                for="male">{{ __('Male') }}/ذكر</label>
                                        </div>
                                        <div class="form-check form-control  ">
                                            <input type="radio" class="form-check-input" id="female" value="2"
                                                name="gender" required=""
                                                {{ old('gender') == 2 ? ' checked ' : '' }}>
                                            <label class="form-check-label mb-0"
                                                for="female">{{ __('Female') }}/أنثى</label>
                                        </div>

                                    </div>
                                    @error('gender')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="occupation">{{ __('Occupation') }}/إشغال</label>
                                    <input maxlength="150" placeholder="{{ __('Occupation') }}/إشغال" type="text"
                                        class="form-control  rounded  border-secondary  " id="occupation"
                                        name="occupation"
                                        value="{{ isset($user->occupation) ? $user->occupation : '' }}">
                                    @error('occupation')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="country">{{ __('Country') }}/دولة</label>
                                    <select name="country_id" class="select2 form-control  rounded  border-secondary ">
                                        @foreach (countryList() as $country)
                                            <option {{ old('country_id') == $country->id ? ' selected ' : '' }}
                                                value="{{ $country->id }}">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('country_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            {{-- <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="country">{{ __('Country') }}</label>
                                <select   name="country_id"  class="select2">
                                    <option>sdfsd</option>
                                    <option>sdfssssd</option>
                                </select>
                            </div>
                        </div> --}}
                        </div>

                        <hr />
                        <h5 class="card-title my-4 text-secondary  ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-telephone-minus" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                            {{ __('Contact Details') }}/بيانات المتصل
                        </h5>

                        <div class="row">


                            <div class="col-md-3 col-sm-12">
                                <label for="phone_number">{{ __('Phone') }}<br/>/هاتف</label>
                                <div class="form-group">
                                    <input maxlength="10" name="phone_number"
                                        value="{{ old('phone_number') }}" type="tel"
                                        id="phone_number" class="form-control  rounded  border-secondary tel-input"
                                        placeholder="Phone Number/رقم التليفون">
                                     
                                    <input type="hidden" name="phone_code" id="phone_code" value="{{ isset($user) ? $user->phone_code :  ( old('phone_code') !="" ?  old('phone_code') : defaultCode() ) }}" placeholder="Dialing Code" readonly>
    

                                    @error('phone_number')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="residency_phone">{{ __('Telephone (Home)') }}/الهاتف (سكني)</label>
                                    <input maxlength="14" type="text"
                                        class="form-control  rounded  border-secondary  " id="residency_phone"
                                        name="residency_phone"
                                        value="{{ isset($student->residency_phone) ? $student->residency_phone : old('residency_phone') }}">

                                    @error('residency_phone')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="emergency_contact">{{ __('Emergency No.') }} /رقم الاتصال في حالات الطوارئ </label>
                                    <input maxlength="14" type="text" class="form-control  rounded  border-secondary"
                                        id="emergency_contact" name="emergency_contact"
                                        value="{{ isset($student->emergency_contact) ? $student->emergency_contact : old('emergency_contact') }}">

                                    @error('emergency_contact')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="emergency_contact">{{ __('Emergency No 2.') }} /رقم إتصال الطوارئ 2 </label>
                                    <input maxlength="14" type="text" class="form-control  rounded  border-secondary"
                                        id="emergency_contact_2" name="emergency_contact_2"
                                        value="{{ isset($student->emergency_contact_2) ? $student->emergency_contact_2 : old('emergency_contact_2') }}">

                                    @error('emergency_contact')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="po_box">{{ __('P.O.Box') }}<br/>/صندوق بريد</label>
                                    <input maxlength="6" type="text"
                                        class="form-control  rounded  border-secondary  " id="po_box" name="po_box"
                                        value="{{ isset($student->po_box) ? $student->po_box : old('po_box') }}">
                                    @error('po_box')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}/عنوان البريد الإلكتروني</label>
                                    <input maxlength="120" type="text"
                                        class="form-control  rounded  border-secondary  " id="email" name="email"
                                        value="{{ isset($user->email) ? $user->email : old('email') }}">
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <p class="card-title">
                            <div class="col-md-12 col-sm-12">
                                {{ __('Parent Details (applicable if the applicant is Minor/Student)') }} /
                                تفاصيل ولي الأمر (ينطبق إذا كان مقدم الطلب قاصراً/طالباً)
                                </p>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="parent_name">{{ __('Name') }}/اسم</label>
                                    <input maxlength="30" type="text"
                                        class="form-control  rounded  border-secondary  " id="parent_name"
                                        name="parent_name"
                                        value="{{ isset($student->parent_name) ? $student->parent_name : '' }}">
                                    @error('parent_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="parent_occupation">{{ __('Parent Occupation') }}/الشركة الام</label>
                                    <input maxlength="30" type="text"
                                        class="form-control  rounded  border-secondary  " id="parent_occupation"
                                        name="parent_occupation"
                                        value="{{ isset($student->parent_occupation) ? $student->parent_occupation : '' }}">
                                    @error('parent_occupation')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="parent_phone">{{ __('Contact Number') }}/رقم الاتصال</label>
                                    <input maxlength="15"
                                        value="{{ isset($student->parent_phone) ? $student->parent_phone : '' }}"
                                        type="text" class="form-control  rounded  border-secondary  "
                                        id="parent_phone" name="parent_phone">
                                    @error('parent_phone')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr />
                        <h5 class="card-title my-4 text-secondary  ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-list-stars" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z" />
                            </svg>
                            {{ __('More Info') }}/معلومات اكثر
                        </h5>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-12 d-flex  ">
                                        {{ __('Do you have any relatives or friends enrolled?') }}/هل لديك أي أقارب أو
                                        أصدقاء مسجلين؟
                                        <div class="form-check mx-3">
                                            <input value="1" type="radio" class="form-check-input "
                                                id="customControlValidation1" name="relative_enrolled" required=""
                                                {{  old('relative_enrolled') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label mb-0"
                                                for="customControlValidation1">{{ __('Yes') }}/أجل</label>
                                        </div>
                                        <div class="form-check">
                                            <input value="0" type="radio" class="form-check-input"
                                                id="customControlValidation2" name="relative_enrolled" required=""   {{  old('relative_enrolled') == 0 ? 'checked' : '' }}
                                                >
                                            <label class="form-check-label mb-0"
                                                for="customControlValidation2">{{ __('No') }}/لا</label>
                                        </div>
                                        @error('relative_enrolled')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12" id="relative_details" style="display: none;">
                                <div class="form-group">
                                    <label for="parent_name">{{ __('Relative\'s Name') }}/اسم قريب</label>
                                    <input maxlength="35" type="text" class="form-control  rounded  border-secondary"
                                        id="relative_name" name="relative_name"
                                        value="{{ isset($student->relative_name) ? $student->relative_name : '' }}">
                                    @error('relative_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                        {{ __('Have you practice any Martial arts?') }}/هل مارست أي فنون قتالية؟
                                        <div class="form-check mx-2">
                                            <input value="1" type="radio" class="form-check-input"
                                                id="pre_trained_martial" name="pre_trained_martial" required="" 
                                                {{  old('pre_trained_martial') == true ? 'checked' : '' }}
                                               >
                                            @error('pre_trained_martial')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <label class="form-check-label mb-0"
                                                for="pre_trained_martial1">{{ __('Yes') }}/أجل</label>
                                        </div>
                                        <div class="form-check">
                                            <input value="0" type="radio" class="form-check-input"
                                                id="pre_trained_martial" name="pre_trained_martial" required=""
                                                {{  old('pre_trained_martial') == false ? 'checked' : ''  }}>
                                            <label class="form-check-label mb-0"
                                                for="pre_trained_martial2">{{ __('No') }}/لا</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4" id="mart_style" style="display: none;">
                                <div class="form-group">
                                    <label for="pre_martial_style">{{ __('Martial Art Style') }}/نمط فنون الدفاع عن
                                        النفس</label>
                                    <input maxlength="30"
                                        placeholder="{{ __('Martial Art Style') }}/نمط فنون الدفاع عن النفس"
                                        type="text" class="form-control  rounded  border-secondary"
                                        id="pre_martial_style" name="pre_martial_style"
                                        value="{{ isset($student->pre_martial_style) ? $student->pre_martial_style : '' }}">

                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-12 d-flex  ">
                                        @php
                                            $info_source_array = [];
                                            if (!empty($student->info_source)) {
                                                $info_source_array = json_decode($student->info_source, true);
                                            }
                                        @endphp
                                        {{ __('Please let us know, How did you know about us?') }}/
                                        من فضلك أخبرنا، كيف عرفت عنا؟


                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">

                                <div class="d-flex justify-content-between flex-column flex-md-row mt-2">
                                    <div class="form-check">
                                        <input value="1" type="checkbox" class="form-check-input"
                                            id="info_source_1" name="info_source[]" required=""
                                            {{ in_array('1', $info_source_array) ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0"
                                            for="info_source_2">{{ __('Online') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input value="2" type="checkbox" class="form-check-input"
                                            id="info_source_2" name="info_source[]" required=""
                                            {{ in_array('2', $info_source_array) ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0"
                                            for="info_source_2">{{ __('Billboard') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input value="3" type="checkbox" class="form-check-input"
                                            id="info_source_3" name="info_source[]" required=""
                                            {{ in_array('3', $info_source_array) ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0"
                                            for="info_source_3">{{ __('Demonstration') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input value="4" type="checkbox" class="form-check-input"
                                            id="info_source_4" name="info_source[]" required=""
                                            {{ in_array('4', $info_source_array) ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0"
                                            for="info_source_4">{{ __('Instagram') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input value="5" type="checkbox" class="form-check-input"
                                            id="info_source_6" name="info_source[]" required=""
                                            {{ in_array('5', $info_source_array) ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0"
                                            for="info_source_6">{{ __('Facebook') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input value="6" type="checkbox" class="form-check-input"
                                            id="info_source_7" name="info_source[]" required=""
                                            {{ in_array('6', $info_source_array) ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0"
                                            for="info_source_7">{{ __('WhatsApp Brochure') }}</label>
                                    </div>
                                </div>
                                @error('info_source')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <hr />
                        <h5 class="card-title my-4 text-secondary  ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-list-stars" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z" />
                            </svg>
                            {{ __('Passport & Emirates ID Details') }} /
                            تفاصيل جواز السفر والهوية الإماراتية
                        </h5>
                        <div class="row">

                            <div class="col-md-3 col-sm-12">
                                <label for="phone_number">{{ __('Passport Number') }}/هاتف</label>
                                <div class="form-group">
                                    <input   maxlength="15" name="passport_number"
                                        value="{{  old('passport_number') }}" type="text"
                                        id="passport_number" class="form-control  rounded  border-secondary"
                                        placeholder="Passport Number/رقم جواز السفر">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="phone_number">{{ __('Passport Expiry') }}/هاتف</label>
                                <div class="form-group">
                                    <input maxlength="15" name="passport_expiry"
                                        value="{{ old('passport_expiry') }}" type="text"
                                        id="passport_expiry" class="form-control  rounded  border-secondary"
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
                                    <input  maxlength="15" name="emirates_id"
                                        value="{{ old('emirates_id') }}" type="text"
                                        id="emirates_id" class="form-control  rounded  border-secondary"
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
                                        value="{{ old('emirates_id_expiry') }}" type="text"
                                        id="emirates_id_expiry" class="form-control  rounded  border-secondary"
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
                            <div class="d-flex d-flex justify-content-center">
                                <button type="submit" class="btn btn-success rounded text-white mx-2 px-5">
                                    {{ __('Submit Application') }}
                                </button>
                                <button type="submit" class="btn btn-danger rounded text-white ml-2  mx-2 px-5">
                                    {{ __('Cancel') }}
                                </button>
                            </div>


                        </div>


                </form>

            </div>

        </div>

    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                
            $(document).ready(function() {
                $('.select2').select2();
                $('#dob').datepicker({
                    format: 'yyyy-mm-dd', // You can adjust the format as needed
                    autoclose: true,
                    endDate: 'today', // Prevent selecting future dates
                    
                }).on('changeDate', function(e) {
                        $('#dob-error').remove();
                });
                $('#emirates_id_expiry').datepicker({
                    format: 'yyyy-mm-dd', // You can adjust the format as needed
                    autoclose: true,
                    startDate: 'today', // Prevent selecting future dates
                    // startView: 2, // Start with the year view for faster navigation
                }).on('changeDate', function(e) {
                        $('#emirates_id_expiry-error').remove();
                });
                $('#passport_expiry').datepicker({
                    format: 'yyyy-mm-dd', // You can adjust the format as needed
                    autoclose: true,
                    startDate: 'today', // Prevent selecting future dates
                    // startView: 2, // Start with the year view for faster navigation
                }).on('changeDate', function(e) {
                        $('#passport_expiry-error').remove();
                });

                
                $("#create-student").validate({
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
                            maxlength: 16,
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
                            maxlength: "Emirates ID Number must be less than 15 characters"
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
                $(document).on('keyup', '#phone_number', function() {
                    var inputElement = document.getElementById("phone_number");
                    // Get the value from the input field
                    var inputValue = inputElement.value;

                    if (!isNaN(inputValue)) {} else {
                        inputElement.value = inputValue.slice(0, -1);
                    }


                });

                // Listen for changes in the selected country
                // phoneInput.addEventListener("countrychange", function() {
                //     var selectedCountryData = iti.getSelectedCountryData();
                //     if (selectedCountryData) {
                //         dialingCodeInput.value = "" + selectedCountryData.dialCode;
                //     }
                // });
                // Set the initial value of the intl-tel-input based on the prepopulated data
                if (dialingCodeInput.value != "") {
                    iti.setNumber("+" + dialingCodeInput.value + phoneInput.value);
                } else {
                    iti.setNumber("+" + 1);
                }
            });

            toggelRelative();
            toggelMartStyle();

            function toggelRelative() {
                if ($('input[name="relative_enrolled"]:checked').val() == 1) {
                    $('#relative_details').show();
                } else {
                    $('#relative_details').hide();
                }
            }

            function toggelMartStyle() {
                if ($('input[name="pre_trained_martial"]:checked').val() == 1) {
                    $('#mart_style').show();
                } else {
                    $('#mart_style').hide();
                }
            }
        </script>
    @endpush
    @push('styles')
        <style>
            .message-container {
                position: absolute;
                text-align: center;
                color: white;
                z-index: 1;
            }
            .error{
                padding: 4px 14px;
                width: 100%;
                background: #fbf3f3;
                border-radius: 0px 3px 3px 0px; 
                border-left: 1px solid red;
                margin-top: 3px;
                display: block;
            }
            .form-check-input.is-invalid ~ .form-check-label{
                color:#212529;
            }
            #gender-error{
                margin-left: 3px;
            }
        </style>
    @endpush
    
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
        <link rel="stylesheet" href="{{ asset('dist_login/css/form-style.css') }} ">
    @endpush
@endsection
