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
        @if(empty($myConcerts[0]))
        <div class="row justify-content-center">
            <i class="material-icons">folder_open</i>
            <h2 class="text-center">You are not in any rooms</h2>
            <p class="text-center">Please go to the discover tab to start looking for concert rooms.</p>
            <form class="text-center" action="/user-discover" method="get">
                <button class="btn-orange" type="submit" name="room" value="room">Discover rooms</button>
            </form>
        </div>   
        @else
            @for($x = 0; $x < $amount; $x++)
                @foreach( $myConcerts[$x] as $myConcert )
                    <h4 class="concert-date">{{ date("d/m/'y ", strtotime($myConcert->concert_date)) }}</h4>
                    <a href="/social-room/{{ $myConcert->id }}">
                    <div class="card">
                        <img src="{{ $myConcert->file_path }}" alt="concert picture">
                        <div class="card-body">
                            <h3>{{ $myConcert->artist_name }}</h3>
                            <h5>{{ $myConcert->name }}</h5>
                            <?php $var = explode('|', $concert->locatie); ?>
                            <h5>{{ $var[0] }}</h5>
                            <h5>{{ $var[1] }}</h5>
                        </div>
                    </div>
                    </a>
                @endforeach
            @endfor  
        @endif
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
            @if(!empty($published))
                <h4>Published rooms</h4>
            @endif
            @foreach( $myConcerts as $myConcert )
                @if($myConcert->published == true) 
                    <h4 class="concert-date">{{ date("d/m/'y ", strtotime($myConcert->concert_date)) }}</h4>
                    <a href="/social-room/{{ $myConcert->id }}">
                    <div class="card">
                        <img  src="{{ $myConcert->file_path }}" class="card-img-top" alt="concert picture">
                        <div class="card-body">
                            <h3>{{ $myConcert->name }}</h3>
                            <?php $var = explode('|', $concert->locatie); ?>
                            <h5>{{ $var[0] }}</h5>
                            <h5>{{ $var[1] }}</h5>
                            <h5>{{ $myConcert->tickets_sold }} ticket(s) sold</h5>
                        </div>                        
                    </div>
                    </a>
                @endif    
            @endforeach
            @if(!empty($unPublished))
                <h4>Unpublished rooms</h4>
            @endif
            @foreach( $myConcerts as $myConcert )
                @if($myConcert->published == false)  
                    <h4 class="concert-date"><a href="/update-concert/{{ $myConcert->id }}">{{ date("d/m/'y ", strtotime($myConcert->concert_date)) }}</a></h4>
                    <a href="/update-concert/{{ $myConcert->id }}">
                    <div class="card">
                        <img  src="{{ $myConcert->file_path }}" class="card-img-top" alt="concert picture">
                        <div class="card-body">
                            <h3>{{ $myConcert->name }}</h3>
                            <?php $var = explode('|', $concert->locatie); ?>
                            <h5>{{ $var[0] }}</h5>
                            <h5>{{ $var[1] }}</h5>
                        </div>
                    </div>
                    </a>
                @endif 
            @endforeach
            <form action="/add-concert" method="get">
                <button class="btn-add bottom" type="submit" name="room" value="room">+</button>
            </form>
        @endif
    @endif
@endsection