<div class="col-md-12 border-bottom">
    <div class="card">
        <div class="card-body">
           
            <h5 class="card-title mb-3">
                {{ @$instance->batch_name }}  <label class="mx-3"> @include('common.status-badge')
                </label> </h5>
            <div class="d-flex flex-sm-row flex-column">
                @if (@$instance->batch_time)
                    <label class="p-1 text-info rounded border border-dark  mx-1">Time  {{ @$instance->batch_time }}</label>
                @endif
                @if (@$instance->students)
                <label class="p-1 text-info rounded border border-dark  mx-1">Students :  {{ @$instance->students->count() }}</label>
            @endif
            </div>
        </div>
    </div>
</div>
