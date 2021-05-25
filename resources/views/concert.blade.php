@extends('layouts/back-nav')

@section('title')
   {{ $concert->name }} 
@endsection

@section('content')
    <div>
        <h2>{{ $concert->artist_name }}</h2>
        <h3>{{ $concert->name }}</h3>
        <h3>{{ date("d/m/Y ", strtotime($concert->concert_date)) }} at {{ date("h:i", strtotime($concert->concert_date)) }}</h3>
        <div class="row">
            <div class="col-9">
                <h3>{{ $concert->locatie }}</h3>
            </div>
            <div class="col-auto price">
                <h3>€{{ $concert->prijs }}</h3>
            </div>            
        </div>        
    </div>
    <div>
        <h2>Get exclusive content</h2>
        <h2>Vote for your favorite song</h2>
        <div>
            <h2>Bingo</h2>
            <h3>Have a change of winning:</hh3>
        </div>        
    </div>
    <form class="text-center" action="" method="get">
        <button class="btn-orange" type="submit" name="room" value="room">Buy room ticket</button>
    </form>
@endsection