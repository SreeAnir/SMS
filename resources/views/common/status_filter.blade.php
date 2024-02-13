@php 
    use App\Models\Status;
    $option_json = (isset($option_json ) ? $option_json : Status::list());
    $all_label = new Status([
                        "id" => "-1", "status" => __('All')
                    ]);
     $option_json->push($all_label);
    
  
   
@endphp
<div class="col-md-4"> 
    <x-form.select2 label="{{__('Status')}}" text_key="status"
    name="filter_by" id="filter_by"
    :options="$option_json"
    placeholder="{{__('Select Status')}}"></x-form.select2>
    
    
</div>

