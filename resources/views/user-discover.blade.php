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
        <h4 class="concert-date"><a href="/concerts/{{ $concert->id }}">{{ date("d/m/'y ", strtotime($concert->concert_date)) }}</a></h4>
        <div class="card">
            <img class src="uploads/{{ $concert->file_path }}" alt="">
            <h3 class="card-title"><a href="/concerts/{{ $concert->id }}">{{ $concert->artist_name }}</a></h3>
            <h5><a href="/concerts/{{ $concert->id }}">{{ $concert->name }}</a></h5>
            <h5><a href="/concerts/{{ $concert->id }}">{{ $concert->locatie }}</a></h5>
        </div>
    @endforeach

@endsection