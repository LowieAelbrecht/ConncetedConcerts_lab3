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
        <h4 class="concert-date">{{ date("d/m/'y ", strtotime($concert->concert_date)) }}</h4>
        <a href="/concerts/{{ $concert->id }}"> 
        <div class="card">
            <img src="uploads/{{ $concert->file_path }}" alt="concert picture">
            <h3 class="card-title">{{ $concert->artist_name }}</h3>
            <h5>{{ $concert->name }}</h5>
            <h5>{{ $concert->locatie }}</h5>
        </div>
        </a>
    @endforeach

@endsection