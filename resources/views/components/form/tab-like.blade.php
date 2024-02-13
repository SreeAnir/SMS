<div class="row">
    @foreach($attributes->get('options') as $option)
        <div class="col">
            <!--begin::Option-->
            <input type="radio" class="btn-check" name="{{$attributes->get('name')}}"
                   value="{{$option['value']}}" id="{{$attributes->get('name')}}_{{$option['value']}}"
                   @if((string)$attributes->get('value') === (string)$option['value'] || (!$attributes->get('value') && $loop->first)) checked @endif>
            <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center mb-5"
                   for="{{$attributes->get('name')}}_{{$option['value']}}">
                <em class="{{$option['icon']}} fs-2x me-5"></em>
                <span class="d-block fw-bold text-start">
                    <span class="text-dark fw-bolder d-block fs-3">{{$option['text']}}</span>
                </span>
            </label>
            <!--end::Option-->
        </div>
    @endforeach
</div>