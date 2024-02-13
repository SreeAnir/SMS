<section class="theme-border  bg-white">
    <div class="row">
        <div class="col-lg-5  col-sm-12">
            <table class="table table-borderless ">
                <tbody>
                    <tr>
                        <td   colspan="2" scope="col">
                            <h6 class="text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                                Contact & Communication Info</h6>
                        </td>

                    </tr>
                    <tr>
                        <td  class="text-muted" scope="col" width="40%">Country</td>
                        <td scope="col">{{ $user->country->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"   scope="col">Residency Ph.</td>
                        <td scope="col">{{ @$user->student->residency_phone }}</td>

                    </tr>
                    <tr>
                        <td class="text-muted"   scope="col">Emergency Ph.</td>
                        <td scope="col">{{ @$user->student->emergency_contact }}/{{ @$user->student->emergency_contact_2 }}</td>

                    </tr>
                    
                    <tr>
                        <td class="text-muted"   scope="col">Po box</td>
                        <td scope="col">{{ @$user->student->po_box }}</td>

                    </tr>


                </tbody>
            </table>
        </div>
        <div class="col-lg-4 col-sm-12">
            <table class="table table-borderless ">
                <tbody>
                    <tr>
                        <td   colspan="2" scope="col">
                            <h6 class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg> More Info
                            </h6>
                        </td>

                    </tr>

                    <tr>
                        <td  class="text-muted"  scope="col" width="40%">Relative enrolled</td>
                        <td    scope="col">{{ $user->student->relative_enrolled ? 'Yes' : 'No' }}</td>

                    </tr>
                    <tr>
                        <td class="text-muted"   scope="col">Relative name</td>
                        <td scope="col">{{ @$user->student?->relative_name != null ? $user->student->relative_name : 'NA' }}</td>

                    </tr>
                    <tr>
                        <td class="text-muted"   scope="col">Previous Training</td>
                        <td scope="col">{{ $user->student?->pre_trained_martial ? 'Yes' : 'No' }}</td>

                    </tr>
                    <tr>
                        <td class="text-muted"   scope="col">Previous style</td>
                        <td scope="col">
                            {{ @$user->student?->pre_martial_style != null ? $user->student?->pre_martial_style : 'NA' }}
                        </td>

                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-lg-3 col-sm-12">
            <table class="table  table-borderless">
                <tbody>
                    <tr>
                        <td   colspan="2" scope="col">
                            <h6 class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                    <path
                                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                </svg>
                                Parents Info
                            </h6>
                        </td>

                    </tr>
                    <tr>
                        <td  class="text-muted"  scope="col" width="40%">Name</td>
                        <td scope="col">{{ @$user->student?->parent_name }}</td>

                    </tr>
                    <tr>
                        <td  class="text-muted"  scope="col">Company</td>
                        <td scope="col">{{ @$user->student?->parent_occupation != null ? $user->student?->parent_occupation : 'NA' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"   scope="col">Phone</td>
                        <td scope="col">{{ @$user->student?->parent_phone != null ? $user->student?->parent_phone : 'NA' }}</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $('.payment_summary,.close_btn').hide();
            $(document).on('click', '.close_btn', function(e) {
                // $(".payment_summary").hide();
                $(".payment_summary").slideUp("slow");
                $(".view_btn").fadeIn();
                
            });
            $(document).on('click', '.payment_details', function(e) {
                $(this).parent().find(".view_btn").fadeOut();
                $(this).parent().find(".payment_summary").slideDown("slow");
                $(this).parent().find(".close_btn").show();
                // $(this).parent().find(".payment_summary").show();
               
            });
            $(document).on('change', '#filter_event', function(e) {
                loadEvents();
            });

            $(document).on('change', '#filter_notification', function(e) {
                loadNotification();
            });
            let page = 1; 

            let url= "{{ route('event.list') }}";
            let url_notifcation= "{{ route('user-notifications.index') }}";

            
            let clicked_url = null;
            $(document).on('click', '#event_list .page-link', function (event) {
                    event.preventDefault();

                    clicked_url = $(this).attr('href') ;

                    var url = new URL(clicked_url);

                    var pageValue = url.searchParams.get('page');
                    
                    if (pageValue !== null) {
                        page = pageValue;
                    } else {
                        page = 1;
                    }
                    loadEvents();
                    
            });
           
            $(document).on('click', '#events-tab', function (event) {
                loadEvents();
            });
            $(document).on('click', '#notifications-tab', function (event) {
                loadNotification();
            });
            $(document).on('click', '#notification_list .page-link', function (event) {
                    event.preventDefault();

                    clicked_url = $(this).attr('href') ;

                    var url = new URL(clicked_url);

                    var pageValue = url.searchParams.get('page');
                    
                    if (pageValue !== null) {
                        page = pageValue;
                    } else {
                        page = 1;
                    }
                    loadNotification();
                    
            });
            loadEvents();
            loadNotification();
            function loadNotification() {
                $.ajax({
                    url: url_notifcation +'?notification_type='+ $('#filter_notification').val()+"&page="+page ,
                    type: 'GET',
                    beforeSend: function () {
                        console.log("Loading Notification");
                    }
                })
                .done(function (data) {
                   console.log("Loading done");
                    if (data.status == "success") {
                        $("#notification_list").html(data.html);
                        return;
                    }else{
                        $("#notification_list").html("Failed to load events");
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    $("#notification_list").html("Server not responding...");
                });
            }

            function loadEvents() {
                $.ajax({
                    url: url +'?filter_event='+ $('#filter_event').val() +"&page="+page,
                    type: 'GET',
                    beforeSend: function () {
                        console.log("Loading");
                    }
                })
                .done(function (data) {
                   console.log("Loading done");
                    if (data.status == "success") {
                        $("#event_list").html(data.html);
                        return;
                    }else{
                        $("#event_list").html("Failed to load events");
                    }
                        
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    alert('Server not responding...');
                    $("#event_list").html("Server not responding...");
                });
            }
// });
    });
</script>
@endpush