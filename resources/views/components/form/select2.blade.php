<!--begin::Input group-->
 
<div class="fv-row">
    <div class="form-floating form-control-solid-bg rounded select2-component"> 
        <select    {{( $attributes->has('id') ?  "id=".$attributes->get('id'):'' )}}
          data_parent_id="{{ $attributes->get('parent_id') }}"? {{$attributes->get('tags','false') === 'true'?'multiple':''}}  
                data-allow-clear="true" data-component-init="initSelect2"
                {{$attributes->merge(['class'=>'form-select form-select-transparent'])->except(['id'])}}
                @if($sourceUrl) source_url="{{$sourceUrl}}" @endif>
            <option></option>
            @foreach($getOptions() as $option)
                <option value="{{$option['value']}}"  data-attr="{{$option['data_key']}}"   @if($option['selected']) selected @endif>{{$option['text']}}</option>
            @endforeach
        </select>
        <label for="{{$getId()}}">{{$label}}</label>
    </div>
</div>
<!--end::Input group-->

@once
    @push('styles')
        <style>
            .select2-component .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) {
                padding-top: 2.15rem;
            }
        </style>
    @endpush
@endonce
@push('scripts')
    @once
        <script>
            BladeComponents.initSelect2 = function (element) {
                let config = {
                    placeholder: element.attr('placeholder') ?? element.closest('div').find('label').text(),
                    allowClear: true,
                    minimumResultsForSearch: 10,
                }

                if (element.attr('tags') === 'true') {
                    // config.multiple = true;
                    config.tags = true;
                }

                //Source url section
                if (element.attr('source_url')) {
                    config.minimumInputLength = 2;
                    config.ajax = {
                        url: element.attr('source_url'),
                        dataType: 'json'
                    }
                }
                


                if (element.attr('data_parent_id')) {
                    config.dropdownParent = $(element.attr('data_parent_id'));
                }

                element.select2(config);
            }

            $(() => {
                $('.select2-component select').each((i, el) => {
                    if ($(el).closest('.repeater-component-container').length <= 0) {
                        BladeComponents.initSelect2($(el));
                    }
                })
            });
        </script>
    @endonce
@endpush
