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

    <div href="#" class="input-container d-flex justify-content-center mt-3">
      <input class="" id="searchBar" type="text">
      <i class="material-icons">search</i>
    </div>
    <div class="pt-3 text-center">
        <button class="btn-filter selected-filter" id="date">Date</button>
        <button class="btn-filter" id="locatie">Locatie</button>
    </div>

    <ul id='searchResult' class="search-results">

    </ul>

    <div class="php-output">
    @foreach( $concerts as $key => $concert )
        @if (!in_array($concert->id, $concertIds))
        <h4 class="concert-date">{{ date("d/m/'y ", strtotime($concert->concert_date)) }}</h4>
        <a href="/concerts/{{ $concert->id }}" class="concertId"> 
        <div class="card" id="{{ $key }}">
                <img src="{{ $concert->file_path }}" class="card-img-top" alt="concert picture">
                <div class="card-body">
                    <h3>{{ $concert->artist_name }}</h3>
                    <h5>{{ $concert->name }}</h5>
                    <?php $var = explode('|', $concert->locatie); ?>
                    <h5 class="latitude" id="{{ $concert->latitude }}">{{ $var[0] }}</h5>
                    <h5 class="longitude" id="{{ $concert->longitude }}">{{ $var[1] }}</h5>
                </div>                         
        </div>
        </a>
        @endif
    @endforeach
    </div>

@endsection

@section('js')
<script>
$(document).ready(function(){
    var searchBar = document.getElementById("searchBar");

    searchBar.addEventListener('keyup', (e) => {
    var target = e.target.value;
    if(target.length > 0){
        search(target);
    } else {
        $('.php-output').show();
        $('.added').remove();
    }
    });

    function search(target) {
    $.ajax({
    url:'/search',
    method: 'post',
    data: { "_token": "{{ csrf_token() }}",
            "target": target},
    dataType: 'json',
    success: function(response){
    var data = response;
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + '/' + mm + '/' + dd;
    
            $.ajax({
            url:'/check',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}"},
            dataType: 'json',
            success: function(response){
                $('.added').remove();
                if(data.length > 0){
                    $('.php-output').hide();
                    for (var i = 0; i < data.length; i++){
                        if(!(response.includes(data[i]['id']))){
                            if(data[i]['published'] == 1){
                                var concertDate = data[i]['concert_date'];
                                var concertDate = new Date(concertDate);
                                var dd = String(concertDate.getDate()).padStart(2, '0');
                                var mm = String(concertDate.getMonth() + 1).padStart(2, '0'); //January is 0!
                                var yyyy = concertDate.getFullYear();
                                concertDate = yyyy + '/' + mm + '/' + dd;
                                var yy = String(new Date(concertDate).getFullYear().toString().substr(-2));
                                concertDateOutput = dd + '/' + mm + '/\'' + yy;
                                if(today < concertDate) {
                                    var location = data[i]['locatie'].split('|', 2);
                                    $("#searchResult").append('<li class="added"><h4 class="concert-date">' +  concertDateOutput + '</h4><a href="/concerts/' + (data[i]['id']) + '"><div class="card"><img src="' + (data[i]['file_path']) + '" class="card-img-top" alt="concert picture"><div class="card-body"><h3 class="card-title">'+ (data[i]['artist_name']) + '</h3><h5>' + (data[i]['name']) + '</h5><h5>' + (location[0]) + '</h5><h5>' + (location[1]) + '</h5></div></div></a></li>');
                                }
                            }
                        }
                    }
                } else {
                    $('.added').remove();
                    $('.php-output').hide();
                }
        }
    });
    }
    });
    }
    $("#locatie").click(function(){
        var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
        };
        $("#locatie").addClass("selected-filter");
        $("#date").removeClass("selected-filter");

        function success(pos) {
        var crd = pos.coords;
        getArray();
        function getArray() {    

            var distances = new Array(2);

            var concerts = $( ".card" ).length;
            for (var i = 0; i < concerts; i++){
                var lat2 = $("#" + i).children(".card-body").children(".latitude").attr("id");
                var long2 = $("#" + i).children(".card-body").children(".longitude").attr("id");
                var concertId = $("#" + i).parent(".concertId").attr("href");
                var n = concertId.lastIndexOf('/');
                var id = concertId.substring(n + 1);
                calcCrow(crd.latitude, crd.longitude, lat2, long2, id, distances);  
            }
            post(distances, concerts);
        }

        function post(distances, concerts) {
                // SORT ARRAY  
        distances.sort(function(a, b) {
            return a[1] - b[1];
        });

        
        
        for (var i = 0; i < concerts; i++){
            console.log(distances[i][0]);
            var ids = distances[i][0];
            ajax(ids); 
        }
        }

        function ajax(ids){
            $.ajax({
                url:'/sortDistance',
                method: 'post',
                data: { "_token": "{{ csrf_token() }}",
                "ids": ids},
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    $('.php-output').hide();
                    var data = response;
                    var concertDate = data['concert_date'];
                    var concertDate = new Date(concertDate);
                    var dd = String(concertDate.getDate()).padStart(2, '0');
                    var mm = String(concertDate.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = concertDate.getFullYear();
                    concertDate = yyyy + '/' + mm + '/' + dd;
                    var yy = String(new Date(concertDate).getFullYear().toString().substr(-2));
                    concertDateOutput = dd + '/' + mm + '/\'' + yy;
                    var location = data['locatie'].split('|', 2);
                    $(".search-results").append('<li class="added"><h4 class="concert-date">' +  concertDateOutput + '</h4><a href="/concerts/' + (data['id']) + '"><div class="card"><img src="' + (data['file_path']) + '" class="card-img-top" alt="concert picture"><div class="card-body"><h3 class="card-title">'+ (data['artist_name']) + '</h3><h5>' + (data['name']) + '</h5><h5>' + (location[0]) + '</h5><h5>' + (location[1]) + '</h5></div></div></a></li>');
                }
            });
        }
        

        function calcCrow(lat1, lon1, lat2, lon2, id, distances) 
        {
        var R = 6371; // km
        var dLat = toRad(lat2-lat1);
        var dLon = toRad(lon2-lon1);
        var lat1 = toRad(lat1);
        var lat2 = toRad(lat2);

        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c;
        distances.push([id, d]);
        }

        function toRad(Value) 
        {
            return Value * Math.PI / 180;
        }
        }

        function error(err) {
        console.warn(`ERROR(${err.code}): ${err.message}`);
        }

        navigator.geolocation.getCurrentPosition(success, error, options);
    });
    $("#date").click(function(){
        $('.added').remove();
        $('.php-output').show();
        $("#locatie").removeClass("selected-filter");
        $("#date").addClass("selected-filter");
    });

});


</script>
@endsection