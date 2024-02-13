<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex flex-md-row flex-column no-block --1align-items-center">
            <h4 class="page-title mx-1">@yield('title')</h4>
            <div class="align-items-center">
             @yield('header_buttons')
            </div>

            <div class="ms-auto text-end">
                @unless ($breadcrumbs->isEmpty())
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if (!is_null($breadcrumb->url) && !$loop->last)
                                <li class="breadcrumb-item"><a href="{{ @$breadcrumb->url }}">{{ @$breadcrumb->title }}</a></li>
                            @else
                                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endunless

                {{-- <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Library
                                    </li>
                                </ol>
                            </nav> --}}
            </div>
        </div>
    </div>
</div>
