@extends('layouts.student.web')

@section('content')
    @php
        $user = auth()->user();
    @endphp
    {{-- @include('layouts.student.includes.top-info') --}}
    {{-- @include('student.includes.top-info')  --}}

    <div class="container ">
        <section class="theme-border  bg-white">
            <div class="row">
                <div class=" col-sm-12">
                    <div class="card p-1">
                        <div class="card-body border-none p-1">
                            <h6 class="text-muted text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-credit-card-2-front" viewBox="0 0 16 16">
                                    <path
                                        d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z" />
                                    <path
                                        d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5" />
                                </svg>

                                Payment Information
                            </h6>
                            @if ($status == 'success')
                                <div class="col-12 text-center ">
                                    <p class="text-success">
                                        {{ __('Payment was successful!') }}
                                        {{ __('Order ID') }} <b> <u>{{ $transaction?->order_id }}</u></b></p>
                                </div>
                                @elseif ($status == 'canceled')  
                            
                            
                            <div class="col-12 text-muted ">
                                <p class="text-info">
                                    {{ __('Payment was Canceled!') }}
                                    {{ __('Order ID') }} <b> <u>{{ $transaction?->order_id }}</u></b></p>
                            </div>
                            @elseif ($status == 'declined')  
                            
                            <div class="col-12 text-center ">
                                <p class="text-info">
                                    {{ __('Payment was declined!') }}
                                     </p>
                            </div> 
                            @else
                            
                            <div class="col-12 text-center">
                                <p class="text-danger">
                                    {{ __('Payment was failed!') }}
                                    {{ __('Order ID') }} <b> <u>{{ $transaction?->order_id }}</u></b></p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-2 p-9  text-right">
                <a class="text-info" href="{{ route('web.dashboard')}}" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
                  </svg>Go to Dashboard </a>     
            </div>
            @include('telr.transaction-info')
            
        </section>

    </div>
@endsection
