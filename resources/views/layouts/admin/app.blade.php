<!DOCTYPE html>
<html dir="ltr" lang="en">
@include('layouts.admin.includes.head')
@stack('styles')
<script>
    var BaseUrl = "{{ url('/')}}";
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js"></script>
<style type="text/css">
    span.error, label.error {
    color: red;
    border-color: red;
    text-align: center;
    font-size: 11px;
    padding: 3px;
    font-weight: 500 !important;
    }
    .swal2-icon.swal2-question{
        font-size: 1rem !important;
    }
    .swal2-popup .swal2-title{
        font-size: 19px !important;
        padding: 30px  !important;
    }
    .swal2-popup .swal2-styled{
        margin: 2px 5px 0 !important;
    }
</style>
<body>
    @include('layouts.admin.includes.preloader')

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        @include('layouts.admin.includes.header')

        @include('layouts.admin.includes.nav_bar')



        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
        {{ Breadcrumbs::render() }}

           
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @include('layouts.admin.includes.common-alert')
                <div class="main-content">

              @yield('content')
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
               © 2023 Tricta Technologies. All Rights Reserved.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    @include('layouts.admin.includes.scripts')


</body>
<style>
.data-table-class tbody {
    border-color: #eee;
}
.dataTables_wrapper{
    padding: 1rem !important;
}
.data-table-class tbody a{
    color : #3166d0;
}
a{
    color : #3166d0;
}
    </style>
    <link href="{{ asset('/dist/css/common.css') }}" rel="stylesheet" />


</html>
