    @if ($batches->count() > 0)
        <select class="form-control" name="batch_id" id="batch_id">

            <option value="">{{ __('Choose Batch') }}</option>
            @foreach ($batches as $batch)
                <option value="{{ $batch->id }}" data-attr="{{ $batch->id }}"
                    @if ($batch->id) selected @endif>{{ $batch->batch_name }} ,{{ $batch->batch_time }}
                </option>
            @endforeach
        </select>
    @else
        <label>{{ __('No batches available') }}</label>
    @endif
