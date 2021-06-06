@extends('layouts/back-nav')

@section('title')
    Social
@endsection

@section('content')
    @if((session()->get('userType')) == ("artist"))
    <form action="/new-post/{{ request()->route('concerts') }}" method="get">
        <button class="btn-add bottom-nav-btn" type="submit" name="room" value="room">+</button>
    </form>
    @endif
@endsection

@section('steps')
    <div class="bottom-nav">
        <div class="justify-content-center row bottom-nav">
            <a class="row px-4 selected-nav">
                <i class="material-icons">people</i>
                <h5>Social</h5>
            </a>
            <a class="row px-4" href="/vote-room/{{ request()->route('concerts') }}">
                <i class="material-icons">recommend</i>
                <h5>Vote</h5>
            </a>
            <a class="row px-4" href="/bingo-room/{{ request()->route('concerts') }}">
                <i class="material-icons">celebration</i>
                <h5>Bingo</h5>
            </a>                  
        </div>      
    </div>
@endsection