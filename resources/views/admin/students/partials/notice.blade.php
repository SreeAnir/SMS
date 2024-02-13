@if($new_application_count > 0)
<div class="card p-0 m-0">
    <div class="card-body p-1 m-0">
        <div class="bg-white shadow-sm p-2 text-warning d-flex flex-row">

            <h4> <i class="mdi mdi-alert p-2"></i></h4>
            <h6 class="text-info  p-2"><label>
                    {{ @$new_application_count }} Student(s) awating approval.<a   id="show_pending" role="button" class=" small p-2"><b><u>Show the list</u></b>
                </a></label></h6>

        </div>
    </div>
</div>
@endif
