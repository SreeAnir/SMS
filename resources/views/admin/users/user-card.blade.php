<div class="row"  >
    <div class="col-md-3">
        <div class="form-group">
            <label for="user_id">@lang('Name') </label>
             :{{ $user->full_name}}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="last_name">@lang('E-Mail')</label>
            :{{ $user->email}}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="last_name">@lang('Phone')</label>
           : {{ $user->full_phone_number}}
        </div>
    </div>

</div>