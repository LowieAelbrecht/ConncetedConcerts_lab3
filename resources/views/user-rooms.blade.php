@extends('layouts/main-nav')

@section('title')
    My rooms
@endsection


@section('content')
    @if((session()->get('userType')) == ("user")) 
        <div class="row justify-content-center pt-3 rooms">
            <a href="/user-rooms" class="active-link">My rooms</a>
            <p class="px-3"> | </p>
            <a href="/user-discover" class="non-active-link">Discover</a>
        </div>
    @else
        @if(empty($myConcerts[0]))
            <div class="row justify-content-center">
                <i class="material-icons">folder_open</i>
                <h2 class="text-center">You have no concert rooms</h2>
                <p class="text-center">Start by making your first room for an upcoming concert!</p>
                <form class="text-center" action="" method="get">
                    <button class="btn-orange" type="submit" name="room" value="room">Make room</button>
                </form>
            </div>        
        @else
            @foreach( $myConcerts as $myConcert )
                @if($myConcert->published == true)
                    <h4>Published rooms</h4>
                    <h4 class="concert-date"><a href="/concerts/{{ $myConcert->id }}">{{ date("d/m/'y ", strtotime($myConcert->concert_date)) }}</a></h4>
                    <div class="card">
                        <h3 class="card-title"><a href="/concerts/{{ $myConcert->id }}">{{ $myConcert->name }}</a></h3>
                        <h5><a href="/concerts/{{ $myConcert->id }}">{{ $myConcert->locatie }}</a></h5>
                        <h5><a href="/concerts/{{ $myConcert->id }}">X tickets sold</a></h5>
                    </div>
                @else
                    <h4>Unpublished rooms</h4>
                    <h4 class="concert-date"><a href="/concerts/{{ $myConcert->id }}">{{ date("d/m/'y ", strtotime($myConcert->concert_date)) }}</a></h4>
                    <div class="card">
                        <img class src="uploads/{{ $myConcert->file_path }}" alt="">
                        <h3 class="card-title"><a href="/concerts/{{ $myConcert->id }}">{{ $myConcert->name }}</a></h3>
                        <h5><a href="/concerts/{{ $myConcert->id }}">{{ $myConcert->locatie }}</a></h5>
                    </div>
                @endif
            @endforeach
            <form action="" method="get">
                <button class="btn-add" type="submit" name="room" value="room">+</button>
            </form>
        @endif
    @endif
@endsection