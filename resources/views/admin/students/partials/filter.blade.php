<form method="post" action="#" id="user_filter_form" class="filter_search_form">
    @csrf
    <div class="row mt-3">
        <div class="row">
            <div class="col-md-2  col-sm-12">
                <label>Filter By Status
                </label>
                <div class="fv-row">
                    <select class="form-control" name="status_id" id="status_id">
                        <option value="">{{ __('Choose Status') }}</option>
                        @foreach (statusList() as $option)
                            <option value="{{ $option['id'] }}" data-attr="{{ $option['id'] }}"
                                @if ($option['selected']) selected @endif>{{ $option['status'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (auth()->user()->location_id == '')
            <div class="col-md-2">
                <label>Filter By Location
                </label>
              
                    @php
                        $locationList = locationList();
                    @endphp
                    <select class="form-control" id="location_id" name="location_id" required>
                        <option value="">Select Location</option>
                        @if (!empty($locationList))
                            @foreach ($locationList as $ll)
                                <option value="{{ $ll->id }}" {{ @$accounting->location_id }}
                                    {{ isset($accounting) && $accounting->location_id == $ll->id ? 'selected' : '' }}>
                                    {{ $ll->name }}</option>
                            @endforeach
                        @endif
                    </select>
                 
            </div>
            @else 
            <input type="hidden"  value="{{ auth()->user()->location_id }}" id="location_id" name="location_id" />
           @endif
            <div class="col-md-3  col-sm-12">
                <label>Filter By Batch</label>
                <div class="fv-row"> 
                    <select class="form-control" name="batch_id" id="batch_id">
                        <option value="">{{ __('Choose batch') }}</option>
                        @foreach (batchList() as $option) 
                            <option value="{{ $option->id }}" data-attr="{{ $option->id }}" data-location="{{ $option->location_id }}"
                                @if ($option['selected']) selected @endif>{{ $option->batch_name }}({{ $option->location->name }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-12">
                <label>Filter By Kacha</label>
                <div class="fv-row">
                    <select class="form-control" name="kacha_id" id="kacha_id">
                        <option value="">{{ __('Choose kacha') }}</option>
                        @foreach (kachaList() as $option)
                            <option data-class_count="{{ $option['class_count'] }}" value="{{ $option['id'] }}"
                                data-attr="{{ $option['id'] }}" @if ($option['selected']) selected @endif>
                                {{ $option['next_label'] != '' ? $option['next_label'] : $option['label'] }}({{  $option['class_count']}} )</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1  col-sm-12 class_count_wrapper">
                <label>Classes</label>
                <div class="fv-row">
                    <input style="width:50px" type="text" class="form-control" name="class_count" id="class_count"
                        value="10" />
                </div>
            </div>
            <div class="col-md-1  col-sm-12">
                <label>&nbsp;</label>
                <div class="fv-row">
                    <input  style="width:80px" type="reset" class="btn btn-secondary"  id="reset"
                        value="Reset" />
                </div>
            </div>
            

        </div>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
 
            $('.class_count_wrapper').hide();
            $(document).on('change', '#class_count', function(e) {
                checkClassCountMax();
            });
            
            $(document).on('click', '#reset', function(e) {
                setTimeout(() => {
                    console.log("reset")
                    $("#status_id").trigger('change');
                }, 20);
               
            });
            $(document).on('click', '#show_pending', function(e) {
                $('#reset').trigger('click');
                setTimeout( function(){
                    $('#status_id').val(3).trigger('change');
                    $('#users_filter_body').collapse('show');
                },30);
                
            });
            $(document).on('change', '#location_id', function(e) {
                changeLocation();
            });
            
            $(document).on('change', '#kacha_id', function(e) {
                $('#class_count').val('');
                console.log( this.value);
                if( this.value == '' ){
                    $('.class_count_wrapper').hide();
                }else{
                    $('.class_count_wrapper').show();
                }
                checkClassCountMax();
            });
        });
        function changeLocation(){
            var selectedLocation = $('#location_id').val();
            $('#batch_id').val('');
            $('#batch_id option').hide();
            $('#batch_id option[data-location="' + selectedLocation + '"]').show();

        }
        function checkClassCountMax(){
            var dataClassCount = parseInt( $("#kacha_id option:selected").attr("data-class_count"));
            let value =  $('#class_count').val();
            if(  value > dataClassCount  ){
                $('#class_count').val( dataClassCount )  ;
            }
        }
    </script>
@endpush
