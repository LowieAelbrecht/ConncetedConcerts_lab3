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

    <ul id='searchResult' class="search-results">

    </ul>

    <div class="php-output">
    @foreach( $concerts as $concert )
        @if (!in_array($concert->id, $concertIds))
        <h4 class="concert-date">{{ date("d/m/'y ", strtotime($concert->concert_date)) }}</h4>
        <a href="/concerts/{{ $concert->id }}"> 
        <div class="card">
                <img src="uploads/{{ $concert->file_path }}" class="card-img-top" alt="concert picture">
                <div class="card-body">
                    <h3>{{ $concert->artist_name }}</h3>
                    <h5>{{ $concert->name }}</h5>
                    <h5>{{ $concert->locatie }}</h5>
                </div>                         
        </div>
        </a>
        @endif
    @endforeach
    </div>

@endsection

@section('js')
<script>
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
            console.log(response);
            $('.added').remove();
            if(data.length > 0){
                $('.php-output').hide();
                for (var i = 0; i < data.length; i++){
                    if(data[i]['id'] != response){
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
                                $("#searchResult").append('<li class="added"><h4 class="concert-date">' +  concertDateOutput + '</h4><a href="/concerts/' + (data[i]['id']) + '"><div class="card"><img src="uploads/' + (data[i]['file_path']) + '" class="card-img-top" alt="concert picture"><div class="card-body"><h3 class="card-title">'+ (data[i]['artist_name']) + '</h3><h5>' + (data[i]['name']) + '</h5><h5>' + (data[i]['locatie']) + '</h5></div></div></a></li>');
                            }
                        }
                    }
                }
            } else {
                $('.added').remove();
            }
    }
 });
}
});
}
</script>
@endsection