<div class="row mb-7">
    <div class="col-md-6">
        <div class="form-floating">
            <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="1" name="send_notification"
                    id="notification_switch" />
                <label class="form-check-label" for="notification_switch">
                    @lang('Send Notification')
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row notification_container d-none">
    <div class="col-md-6 mb-7">
        <div class="form-floating fv-row fv-plugins-icon-container">
            <input type="text" class="form-control" name="notification_title_en" id="notification_title_en" placeholder="Title (En)" value="">
            <label for="notification_title_en">@lang('Title (En)')</label>
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
    </div>
    <div class="col-md-6 mb-7">
        <div class="form-floating fv-row fv-plugins-icon-container">
            <input type="text" class="form-control" name="notification_title_ar" id="notification_title_ar" placeholder="Title (Ar)" value="">
            <label for="notification_title_ar">@lang('Title (Ar)')</label>
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
    </div>
</div>
<div class="row notification_container d-none">
    <div class="col-md-6 mb-7">
        <div class="form-floating fv-row">
            <textarea class="form-control" name="notification_message_en" id="notification_message_en" placeholder="Message (En)"
                rows="5"></textarea>
            <label for="notification_message_en">@lang('Message (En)')</label>
        </div>
    </div>
    <div class="col-md-6 mb-7">

        <div class="form-floating fv-row">
            <textarea class="form-control" name="notification_message_ar" id="notification_message_ar" placeholder="Message (Ar)"
                rows="5"></textarea>
            <label for="notification_message_ar">@lang('Message (Ar)')</label>
        </div>
    </div>
</div>
<div class="row notification_container d-none">
    <div class="col-auto">
        <div class="form-check form-switch form-check-custom form-check-solid mt-3">
            <input class="form-check-input" type="checkbox" value="schedule" id="schedule" name="schedule"/>
            <label class="form-check-label" for="schedule">
                @lang('Schedule')
            </label>
        </div>
    </div>
    <div class="col">
        <div class="row schedule-selection-row d-none">
            <div class="col-md-6">
                <x-form.date-picker label="{{__('Date')}}" name="schedule_on_date"
                    value="{{old('schedule_on_date')}}" />
            </div>
            <div class="col-md-6">
                <x-form.clock-picker label="{{__('Time')}}" name="schedule_on_time"
                    value="{{old('schedule_on_time')}}" />
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('#notification_switch').change(function () {
        $('.notification_container').toggleClass('d-none');
    })

    $('#schedule').change(function () {
        $('.schedule-selection-row').toggleClass('d-none');
    })
</script>
@endpush