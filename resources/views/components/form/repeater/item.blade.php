<div data-repeater-item>
    <div class="form-group row">
        <div class="col-md col-sm-12">
            {{$slot}}
        </div>
        <div class="col-auto mb-7">
            <a href="javascript:void(0)" data-repeater-delete class="btn btn-light-danger w-100">
                <em class="la la-trash-o"></em> @lang('Delete')
            </a>
        </div>
    </div>
</div>