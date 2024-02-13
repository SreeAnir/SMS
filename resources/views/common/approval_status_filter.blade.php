@php 
use App\Models\ApprovalStatus;
$option_json = (isset($app_option_json ) ? $app_option_json : ApprovalStatus::list());
@endphp
        <div class="col-md-4"> 
            <x-form.select2 label="{{__('Approval Status')}}" text_key="status"
            name="filter_by_approval" id="filter_by_approval"
            :options="$option_json"
            placeholder="{{__('Select Approval Status')}}"></x-form.select2>
           
        </div>