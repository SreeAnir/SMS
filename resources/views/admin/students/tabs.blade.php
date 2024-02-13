<div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#contact" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Contact Information') }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#id_details" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('ID Details') }}</span></a>
            </li>

            @if( @$user->student->parent_name !="")
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#parentInfo" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Parent Info') }}</span></a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kachaInfo" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Kacha Info') }}</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#moreInfo" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('More Info') }}</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#paymentInfo" role="tab"><span
                        class="hidden-sm-up"></span>
                    <span class="hidden-xs-down">{{ __('Payment Info') }}</span></a>
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
                                                <em class="fas fa-paper-plane"></em> Contact & Communication Info
                                            </h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="20%">{{ __('Country') }}</th>
                                        <th width="30%">{{ @$user->country?->name }}</th>
                                        <th width="20%" >{{ __('Residency Ph.') }}</th>
                                        <th width="30%">{{ @$user->student->residency_phone }}</th>
                                    </tr>
                                    <tr>
                                        <th width="20%">{{ __('Emergency contact') }}</th>
                                        <th width="30%">{{ @$user->student->emergency_contact }} </th>
                                        <th width="20%">{{ __('Emergency contact 2 ') }}</th>
                                        <th width="30%">{{ @$user->student?->emergency_contact_2 }} </th>
                                        
                                    </tr>
                                    <tr>
                                        <th width="20%">{{ __('PO Number') }}</th>
                                        <th width="30%">{{ @$user->student->po_box }} </th>
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
                                            <th>Passport Number</th>
                                            <th>{{ @$user->student->passport_number }}</th>
                                        </tr>
                                        <tr>
                                            <th>Passport Expiry</th>
                                            <th>{{ @$user->student->passport_expiry }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Emirates ID</th>
                                            <th>{{ @$user->student->emirates_id }}</th>
                                        </tr>
                                        <tr>
                                            <th>Emirates ID Expiry</th>
                                            <th>{{ @$user->student->emirates_id_expiry }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if( @$user->student->parent_name !="")

            <div class="tab-pane p-20" id="parentInfo" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">

                            <div class="col-md-3">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="col">{{ __('Parent Name') }}</th>
                                            <th scope="col">{{ @$user->student->parent_name != null ? $user->student->parent_name : 'NA' }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="col">{{ __('Parent Phone') }}</th>
                                            <th scope="col">{{ @$user->parent_phone != null ? $user->parent_phone : 'NA' }}</th>
                    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="col">{{ __('Parent Occupation') }}</th>
                                            <th scope="col">{{ @$user->parent_occupation != null ? $user->parent_occupation : 'NA' }}</th>
                    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="tab-pane p-20" id="kachaInfo" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                           
                            <div class="col-md-8">
                                <h6 class="text-center text-info">
                                    Details of the kachas achieved by student.
                                </h6>
                                  <table class="table">
                                    <thead class="thead-light">
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kacha</th>
                                        <th scope="col">Date Updated</th>
                                        <th scope="col">Classes</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @if ($user->student->kachaStudents()->count() > 0) 
                                         
                                        @foreach ($user->student->kachaStudents as $katchastudent)
                                      <tr>
                                        <th scope="row">1</th>
                                        <td>{{ $katchastudent?->kacha?->label }}</td>
                                        <td>{{ $katchastudent?->created_at }}</td>
                                        <td>{{ $katchastudent?->class_count }}</td>
                                      </tr>
                                      @endforeach

                                     @endif
                                       
                                    </tbody>
                                  </table>   
                            </div>
                             
                             

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-20" id="moreInfo" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                    
                                        <tr>
                                            <th scope="col" width="40%">{{ __('Relative enrolled') }}</th>
                                            <th scope="col">{{ $user->relative_enrolled ? 'Yes' : 'No' }}</th>
                    
                                        </tr>
                    
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
              
            <div class="tab-pane" id="paymentInfo" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody>
                                        
                                        <tr>
                                            <th scope="col" width="40%">{{ __('Active Payment') }} <a href="{{ route('admin.student-fees.manage', ['student_id' => $user->id]) }}"> Go to Fee Details</a></th>
                                            <th scope="col">{{ $user->fee ? 'Active Payments Available' : 'No active payments available.' }}</th>
                                        </tr>

                                        
                    
                                    </tbody>
                                </table>
                                @include('admin.fees.partials.installments')

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>