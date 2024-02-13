<div class="row-repeat">
    <div class="form-group row">
        <div class="col-md col-sm-12 item-name"
            @if ($attributes->get('data-cod')) data-cod="{{ $attributes->get('data-cod') }}" @endif
            @if ($attributes->get('data-country-label')) data-country-label="{{ $attributes->get('data-country-label') }}" @endif
            @if ($attributes->get('data-price')) data-price="{{ $attributes->get('data-price') }}"
             @endif>
            @if ($attributes->get('text'))
                {{ $attributes->get('text') }}
            @endif
        </div>
        <div class="col-auto mb-7 d-flex flex-inline">
            <a href="javascript:void(0)" data-repeater-edit class="btn btn-light-danger w-100 edit-class"
                @if ($attributes->get('data-cod')) data-cod="{{ $attributes->get('data-cod') }}"  data-price="{{ $attributes->get('data-price') }}" @endif>
                <em class="la la-pen"></em>
            </a>
            <a href="javascript:void(0)" data-repeater-delete class="btn btn-light-danger w-100 delete-class"
                @if ($attributes->get('data-cod')) data-cod="{{ $attributes->get('data-cod') }}" @endif>
                <em class="la la-trash-o"></em>
            </a>
        </div>
    </div>
</div>
