
    

          <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('/dist/js/custom.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <!--This page JavaScript -->
    <!-- <script src="{{ asset('/dist/js/pages/dashboards/dashboard1.js') }}"></script> -->
    <!-- Charts js Files -->
    {{-- <script src="{{ asset('/assets/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/chart/chart-page-init.js') }}"></script> --}}
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>

  <script>
  $(document).ready(function() {
      $('input[type="tel"]').on('change', function() {
          $(this).val($(this).val().replace(/[^0-9]/g, ''));
      });

      $(document).on('click', '#export_btn', function(event) {
            if($('.status-badge').length ==  0){
                swalError('No records to export!Reset the filter and try again!', 'Failed', '');return false;
            }
            swalLoader();
            let link = $(this).attr('href') ;
            var serializedFormData = serializeFormWithoutToken('user_filter_form');

            link += '?'+  serializedFormData;
            //   $('#user_filter_form').serialize();
            event.preventDefault();  
            window.open(link);   
            swalSuccess("Export Competed", 'Done', '').then((result) => {

            })
            });
  });
  function serializeFormWithoutToken(formId) {
    // Serialize the form data
    var formDataArray = $('.filter_search_form'  ).serializeArray();

    // Filter out the CSRF token input
    var filteredDataArray = $.grep(formDataArray, function(input) {
        return input.name !== '_token';
    });

    // Convert the filtered array back to a serialized string
    var serializedData = $.param(filteredDataArray);

    return serializedData;
}
  </script>



  <script src="{{ asset('/dist/js/common.js') }}"></script>

       {{-- <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  /> --}}
  <script src="{{ asset('/dist/js/index.global.min.js') }}"></script>


@stack('scripts')
@stack('modals')
