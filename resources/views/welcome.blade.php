@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white text-uppercase">{{ __('Create your tasks') }}</div>
                <div class="card-body text-center">
                    @if(!Auth::check())
                        <a href="{{ route('login') }}" class="btn btn-success btn-sm">{{ __('Login to proceed') }}</a>
                        <p>Or</p>   
                        <a href="{{ route('register') }}" class="btn btn-info btn-sm">{{ __('Create an Account') }}</a>
                        @else
                        <a href="{{ route('home') }}" class="btn btn-info btn-sm">{{ __('Proceed to your dashboard') }}</a>
                    @endif
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection