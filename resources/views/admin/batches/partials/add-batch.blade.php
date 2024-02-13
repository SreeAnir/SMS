<div class="card">
    <div class="card-body">
        @csrf()
        <div class="form-group row">
            @if (!empty($batch->id))
                <input type="hidden" name="id" value="{{ $batch->id }}">
            @endif
            <label  for="batch_name" class="col-sm-6 text-end control-label col-form-label">
                {{ __('Batch Name') }}
            </label>
            <div class="col-sm-6">
                <input name="batch_name" value="{{ isset($batch) ? $batch->batch_name : '' }}" type="text"
                    maxlength="15" class="form-control" placeholder="Enter Batch Name" required />
            </div>
        </div>

        <div class="form-group row">
            <label for="batch_time" class="col-sm-6 text-end control-label col-form-label">
                {{ __('Batch Time') }}
            </label>
            <div class="col-sm-6">
                <input name="batch_time" value="{{ isset($batch) ? $batch->batch_time : '' }}" type="text"
                    maxlength="10" class="form-control timepicker" placeholder="Enter Batch Time" required />
            </div>
        </div>

        <div class="form-group row">
            <label for="batch_location" class="col-sm-6 text-end control-label col-form-label">
                {{ __('Batch Location') }}
            </label>
            <div class="col-sm-6">
                @if (auth()->user()->location_id == '')
                    @php
                        $locationList = locationList();
                    @endphp

                    <select class="form-control" name="batch_location">
                        <option value="">Select Location</option>
                        @if (!empty($locationList))
                            @foreach ($locationList as $ll)
                                <option value="{{ $ll->id }}" {{ @$batch->location_id }}
                                    {{ isset($batch) && $batch->location_id == $ll->id ? 'selected' : '' }}>
                                    {{ $ll->name }}</option>
                            @endforeach
                        @endif

                    </select>
                @else
                    <input name="location_id" value="{{ auth()->user()->location_id }}" type="hidden"
                        class="form-control" value="{{ auth()->user()->location->name }}" required />
                    <input type="text" class="form-control" value="{{ auth()->user()->location->name }}" readonly />
                @endif
                <!-- Options will be added dynamically by JavaScript -->
                </select>
            </div>
        </div>



    </div>
</div>
