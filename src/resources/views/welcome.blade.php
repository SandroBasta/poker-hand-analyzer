@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="jumbotron p-4 p-md-5 text-white rounded bg-remote-blue">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">#analytico</h1>
                <p class="lead my-3">Your poker tool to analyze a player's winning hand.<br> Player vs Player, upload your
                    file with the player's hands and we'll do the rest.</p>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <h3 class="d-inline-block mb-2 text-primary mb-0">Let's get started!</h3>
                        <p class="card-text mb-auto">The file hands.txt, contains 1000 random hands dealt to two
                            players. Each line of the file contains ten cards (space separated). the first five are
                            Player 1's cards and the last five are Player 2's cards. You can assume that all hands are
                            valid, each player's hand is in no specific order and in each hand there is a clear
                            winner.</p>
                        <p> Please <a href="{{ route('login') }}">{{ __('Login') }}</a> or
                            <a href="{{ route('register') }}">{{ __('Register') }}</a>
                            to upload file</p>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img width="200" height="250" src="{{asset('image/card.jpeg')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
