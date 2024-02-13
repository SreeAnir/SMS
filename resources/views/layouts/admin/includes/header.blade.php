<!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon ps-2">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('/assets/images/logo-icon.png') }}" alt="homepage" class="light-logo"
                                width="25" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text ms-2">
                            <!-- dark Logo text -->
                            Kalari Club
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="{{ asset('/assets/images/logo-text.png') }}" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                      
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  {{ auth()->user()->email}} <br /><span class="text-warning"><small> {{ auth()->user()->user_type_label}}</small></span>
                            </a>
                          </li>
                        <li class="nav-item dropdown">
                            <a class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  "
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ asset('/assets/images/users/1.jpg') }}" alt="user"
                                    class="rounded-circle" width="31" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">
                               
                                 <a class="dropdown-item" href="javascript:void(0)"><i
                                    class="mdi mdi-album  me-1 ms-1"></i> {{ auth()->user()->full_name }}   
                                    @if(auth()->user()->location_id != "")
                                     <span class="bagde bg-info text-white p-1 rounded mx-1 ">  {{ auth()->user()->location?->name}} </span> 
                                    @endif
                                 </a>

                                {{-- <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-account me-1 ms-1"></i> My Profile</a> --}}

                                <a class="dropdown-item" href="{{ route('change-password')}}"><i
                                        class="mdi mdi-pencil me-1 ms-1"></i> Change Password</a>
                               <!--  <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-wallet me-1 ms-1"></i> My Balance</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-email me-1 ms-1"></i> Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-settings me-1 ms-1"></i> Account
                                    Setting</a>
                                <div class="dropdown-divider"></div> -->

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                 <i
                                 class="fa fa-power-off me-1 ms-1"></i>{{ __('Logout') }}
                             </a>
     
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                 @csrf
                             </form>

                                {{-- <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="fa fa-power-off me-1 ms-1"></i> Logout</a> --}}
                                <div class="dropdown-divider"></div>
                                <div class="ps-4 p-10">
                                    <a href="{{ route('admin.profile') }}"
                                        class="btn btn-sm btn-success btn-rounded text-white">View Profile</a>
                                </div>
                            </ul>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>