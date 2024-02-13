@extends('layouts.app')

@section('content')
@php
    use App\Models\Role;
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header txt-404">404 - Not Found</div>
                <div class="card-body">
                    <p>Oops! The page you are looking for could not be found.</p>
                    <a class="custom-button" href="{{ url('/') }}">Go back to the home page</a>
                </div>
            </div>
        </div>
    </div>
</div>
    <style>
       
        /* Custom styles for the button */
        .custom-button {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            transition-duration: 0.4s;
            cursor: pointer;
            border: none;
        }

        .custom-button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        .txt-404{
            color: #a51212;
    font-size: 22px;
    font-family: cursive;
    font-weight: bold;
        }
           /* Overlay effect */
    </style>
@endsection
