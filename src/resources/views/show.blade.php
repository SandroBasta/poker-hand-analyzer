@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            @if (isset($count))
                                <h3 class="font-weight-bold"> Player One wins: {{$count}} times</h3>
                            @else
                                <h3 class="font-weight-bold"> There is no records. Sorry try again.</h3>
                            @endif
                            <a href="{{route('home')}}">
                                <button type="button" class="btn btn-primary">
                                    {{ __('Back') }}
                                </button>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

