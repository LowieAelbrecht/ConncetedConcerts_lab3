@extends('layouts/main-nav')

@section('title')
    My rooms
@endsection


@section('content')  
    <div class="row justify-content-center pt-3 rooms">
        <a href="/user-rooms" class="non-active-link">My rooms</a>
        <p class="px-3"> | </p>
        <a href="/user-discover" class="active-link">Discover</a>
    </div>

    @foreach( $concerts as $concert )
        <div>
            <h3><a href="/concerts/{{ $concert->id }}">{{ $concert->name }}</a></h3>
        </div>
    @endforeach

@endsection