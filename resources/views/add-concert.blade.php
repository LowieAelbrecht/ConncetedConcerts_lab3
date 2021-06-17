@extends('layouts/back-nav')

@section('title')
    Add concert
  
@endsection

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Select concert</h2>
            <p>Select the concert in the list for which you want to make a concert room for & click Next.</p>
        </div>
        <div class="hasDimmed">
        @foreach( $concerts as $key => $concert )
            @if(!in_array($concert['id'], $myConcerts))
            <div class="card mb-4" id="{{ $key }}">
                <img  src="{{ $concert['images'][0]['url'] }}" class="card-img-top" alt="concert picture">
                <div class="card-body" id="{{ $concert['id'] }}">
                    <h3 class="card-title name">{{ $concert['name'] }}</h3>
                    <h5 class="venue" id="{{ $concert['_embedded']['venues'][0]['location']['latitude'] }}">Venue: {{ $concert['_embedded']['venues'][0]['name'] }}</h5>
                    <h5 class="city" id="{{ $concert['_embedded']['venues'][0]['location']['longitude'] }}">City: {{ $concert['_embedded']['venues'][0]['city']['name'] }}</h5>   
                    <p class="dateTime" id="{{ $concert['dates']['access']['startDateTime'] }}">{{ date("H:i", strtotime($concert['dates']['start']['localTime'])) }} {{ date("d/m/'y", strtotime($concert['dates']['start']['localDate'])) }}</p> 
                </div>
            </div>
            @endif
        @endforeach
        </div>

    </div>      
@endsection

@section('steps')
<div class="bottom-nav">
    <div class="text-center">
        <span class="selected-dot dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <input class="nextBtn" type="submit" name="upload" value="Next"></input>        
    </div>
</div>
@endsection


@section('js')
<script>
$(document).ready(function(){
    $(".card").click(function(){
        if($(".hasDimmed").children().hasClass( "dimmed")){
            $( ".dimmed" ).removeClass( "dimmed" );
        }
        
        $(this).addClass("dimmed");
    });

    $(".nextBtn").click(function(){
        if($(".hasDimmed").children().hasClass( "dimmed")){
        var itemId = $( ".dimmed" ).attr("id");
        var concertName = $("#" + itemId).children(".card-body").children(".name").text();  
        var venue = $("#" + itemId).children(".card-body").children(".venue").text();
        var latitude = $("#" + itemId).children(".card-body").children(".venue").attr("id");
        var city = $("#" + itemId).children(".card-body").children(".city").text(); 
        var longitude = $("#" + itemId).children(".card-body").children(".city").attr("id");
        var dateTime = $("#" + itemId).children(".card-body").children(".dateTime").attr("id");
        var img = $("#" + itemId).children(".card-img-top").attr("src");
        var tm_id = $("#" + itemId).children(".card-body").attr("id");

        
        $.ajax({
            url:'/add-concert',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "concertName": concertName,
                "venue": venue,
                "city": city,
                "dateTime": dateTime,
                "img": img,
                "tm_id": tm_id,
                "latitude": latitude,
                "longitude": longitude},
            dataType: 'json',
            success: function(response){
                location.href = '/add-songvote';             
            }
        }); 
        
        } else {
            $(".text-center p").after('<h5 style="color:red;">Please select a concert</h5>');
        }
        
    });   

});
</script>
@endsection