@if(count($actions))
{{-- 
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <span class="d-none d-md-block">Create New <i class="fa fa-angle-down"></i></span>
      <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li><a class="dropdown-item" href="#">Action</a></li>
      <li><a class="dropdown-item" href="#">Another action</a></li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <a class="dropdown-item" href="#">Something else here</a>
      </li>
    </ul>
  </li>

   --}}
   <div class="nav-item dropdown">
    <a class="nav-link "   id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
     
        <span class="svg-icon svg-icon-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                <rect x="10" y="3" width="4" height="4" rx="2" fill="currentColor"/>
                <rect x="10" y="17" width="4" height="4" rx="2" fill="currentColor"/>
            </svg>
        </span>
    </a>
    <ul  class="dropdown-menu" aria-labelledby="navbarDropdown">
        @foreach($actions as $action)
        <li class="menu-item CCCpx-3 pb-1 mb-2 {{isset($action['attributes'])?$action['attributes']->get('class'):''}}"
                        {!! isset($action['attributes'])?$action['attributes']->except('class'):'' !!}>
                    <a @if(isset($action['target'])) target="{{$action['target']}}" @endIf href="{{$action['url']}}"
                       class="menu-link   pb-1 mb-2  btn-{{ $action['label'] }}"><em
                                class="{{$action['icon']??'fas fa-question'}} px-2"></em>{{$action['label']??''}}
                    </a>
                 
             </li>
            @endforeach

       
    </ul>
    {{-- <a class="dropdown-item" href="#">Action</a></li> --}}
  </div>
    {{-- <div class="me-0">
        <a href="#" class="btn btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click"
           data-kt-menu-placement="bottom-end" title="More">
            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen053.svg-->
            <span class="svg-icon svg-icon-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                <rect x="10" y="3" width="4" height="4" rx="2" fill="currentColor"/>
                <rect x="10" y="17" width="4" height="4" rx="2" fill="currentColor"/>
            </svg>
        </span>
            <!--end::Svg Icon-->
        </a>
        <!--begin::Menu 3-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3"
             data-kt-menu="true" style="">
            @foreach($actions as $action)
                <div class="menu-item px-3 {{isset($action['attributes'])?$action['attributes']->get('class'):''}}"
                        {!! isset($action['attributes'])?$action['attributes']->except('class'):'' !!}>
                    <a @if(isset($action['target'])) target="{{$action['target']}}" @endIf href="{{$action['url']}}"
                       class="menu-link px-3"><em
                                class="{{$action['icon']??'fas fa-question'}} px-2"></em>{{$action['label']??''}}
                    </a>
                </div>
            @endforeach
        </div>
        <!--end::Menu 3-->
    </div> --}}
@endif