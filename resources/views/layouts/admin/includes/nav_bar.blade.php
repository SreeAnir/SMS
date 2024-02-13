<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
@php
use App\Models\{
    Batch,Student,Fee,
    Accounting,
    AccountingCategory,
    StaffPayment
    // Category,
    // Country,
    // Location,
    // User,
    // Fee,
    // Payment
};@endphp
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.dashboard') }}"
                        aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">Dashboard</span></a>
                </li>
                 @if ( auth()->user()->can('List users') ||  auth()->user()->can('List users')  ||  auth()->user()->can('List roles' ) )
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false"><i class="fas fa-university"></i>
                        <span class="hide-menu">Organization</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @if (  auth()->user()->can('List users') )  
                        <li class="sidebar-item">
                            <a href="{{ route('users.index') }}" class="sidebar-link"><i
                                    class="fas fa-user"></i><span class="hide-menu"> {{ __('Users') }}
                                </span></a>
                            {{-- <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('users.index')}}"
                                aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span
                                    class="hide-menu">{{ __('Users') }}</span></a> --}}
                        </li>
                        @endif
                        @if ( auth()->user()->can('List users')  )  
                        <li class="sidebar-item">
                            <a href="{{ route('staffs.index') }}" class="sidebar-link"><i
                                    class="fas fa-user-md"></i><span class="hide-menu"> {{ __('Staffs') }}
                                </span></a>
                        </li>
                        @endif
                        @if (auth()->user()->can('List roles') )  
                            <li class="sidebar-item">
                                <a href="{{ route('roles.index') }}" class="sidebar-link"><i
                                        class="fas fa-lock"></i><span class="hide-menu">
                                        {{ __('Permissions') }} </span></a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if ( auth()->user()->can(Batch::PERMISSION_BATCH_LIST)  || auth()->user()->can(Student::PERMISSION_STUDENT_LIST)  ||  auth()->user()->can( Fee::PERMISSION_FEE_LIST) ) 
                <li class="sidebar-item"> 
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false"><i class="mdi mdi-chart-bubble"></i>
                        <span class="hide-menu">Management</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @if ( auth()->user()->can(Batch::PERMISSION_BATCH_LIST)  ) 
                        <li class="sidebar-item">
                            <a href="{{ route('batches.index') }}" class="sidebar-link"><i
                                    class=" fas fa-list-alt"></i><span class="hide-menu"> {{ __('Batches') }}
                                </span></a>
                            {{-- <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('users.index')}}"
                                aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span
                                    class="hide-menu">{{ __('Users') }}</span></a> --}}
                        </li>
                        @endif
                        @if ( auth()->user()->can(Student::PERMISSION_STUDENT_LIST)  ) 
                        <li class="sidebar-item">
                            <a href="{{ route('students.index') }}" class="sidebar-link"><i
                                    class=" fas fa-users"></i><span class="hide-menu"> {{ __('Students') }}
                                </span></a>
                        </li>
                        @endif
                            @if ( auth()->user()->can(Fee::PERMISSION_FEE_LIST)  ) 
                            <li class="sidebar-item">
                                <a href="{{ route('student-fees.index') }}" class="sidebar-link"><i
                                        class="mdi mdi-relative-scale"></i><span class="hide-menu">
                                        {{ __('Student Fee') }} </span></a>
                            </li>
                            @endif
                            <li class="sidebar-item">
                                <a href="{{ route('student.attendance.index') }}" class="sidebar-link"><i
                                        class="mdi mdi-relative-scale"></i><span class="hide-menu">
                                        {{ __('Student Attendance') }} </span></a>
                            </li>  
                            <li class="sidebar-item">
                                <a href="{{ route('staff.attendance.index') }}" class="sidebar-link"><i
                                        class="mdi mdi-relative-scale"></i><span class="hide-menu">
                                        {{ __('Staff Attendance') }} </span></a>
                            </li>   
                    </ul>
                </li>
                @endif
                @if ( auth()->user()->can( Accounting::PERMISSION_ACCOUNTING_LIST ) ||  auth()->user()->can(StaffPayment::PERMISSION_STAFF_PAYMENT_LIST)  ||  
                auth()->user()->can(AccountingCategory::PERMISSION_CATEGORY_LIST)  ) 
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false"><i class=" fas fa-bars"></i>
                        <span class="hide-menu"> Accounting </span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @if ( auth()->user()->can( AccountingCategory::PERMISSION_CATEGORY_LIST )  ) 
                        <li class="sidebar-item">
                            <a href="{{ route('accounting-categories.index') }}" class="sidebar-link"><i class="fas fa-braille"></i><span class="hide-menu"> {{ __('Categories') }}
                                </span></a>
                        </li>
                        @endif

                        @if ( auth()->user()->can( Accounting::PERMISSION_ACCOUNTING_LIST )  ) 
                        <li class="sidebar-item">
                            <a href="{{ route('accounting.index') }}" class="sidebar-link"><i
                                    class=" fas fa-object-ungroup
                                    "></i><span class="hide-menu"> {{ __('Income & Expense') }}
                                </span></a>
                        </li>
                        @endif
                        @if ( auth()->user()->can( StaffPayment::PERMISSION_STAFF_PAYMENT_LIST )  ) 
                        <li class="sidebar-item">
                            <a href="{{ route('staff-payments.index') }}" class="sidebar-link"><i
                                    class=" fas fa-box"></i><span class="hide-menu"> {{ __('Staff Payments') }}
                                </span></a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if ( auth()->user()->can('List Events')    ) 
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('events.index') }}"
                        aria-expanded="false"><i class="fas fas fa-calendar-check"></i><span
                            class="hide-menu">{{ __('Events') }}</span></a>
                </li>
                @endif
                @if ( auth()->user()->can('List Notification')    ) 
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('notifications.index') }}" aria-expanded="false"><i
                            class=" fas fa-envelope"></i><span
                            class="hide-menu">{{ __('Notifications') }}</span></a>
                </li>
                @endif


                {{-- @endif --}}
                <li class="sidebar-item">

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();"
                        class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"><i
                            class="fa fa-power-off me-1 ms-1"></i><span
                            class="hide-menu">{{ __('Logout') }}</span></a>
                </li>
                 
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
