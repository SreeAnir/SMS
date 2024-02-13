<!--begin::Card-->
<div class="card index-card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6" id="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            {{ $title??'' }}
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
        {{ $toolbar??'' }}
        <!--end::Toolbar-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    @isset($filter)
        <div class="table-filters">
            <div {{$filter->attributes->merge(['class'=>'accordion'])}}>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="{{$filter->attributes->get('id')}}_header">
                        <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{$filter->attributes->get('id')}}_body" aria-expanded="false"
                                aria-controls="{{$filter->attributes->get('id')}}_body">
                            @lang('Filters')
                        </button>
                    </h2>
                    <div id="{{$filter->attributes->get('id')}}_body" class="accordion-collapse collapse"
                         data-bs-parent="#{{$filter->attributes->get('id')}}">
                        <div class="accordion-body">
                            <div class="row">
                            {{$filter??''}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
    @isset($summary)
    {{$summary??''}}
    @endisset
    <div class="card-body py-4">
        <div class="table-responsive">
            {{ $table }}
        </div>
    </div>
</div>
<!--end::Card-->