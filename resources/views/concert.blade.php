@extends('layouts/back-nav')

@section('title')
   {{ $concert->name }} 
@endsection

@section('content')
<div class="concert-info">
    <div class="bg">
        <div class="row mt-2">
            <div class="col-10">
                <h2>{{ $concert->artist_name }}</h2>   
                <h3>{{ $concert->name }}</h3>
            </div>
            <div class="col-auto price">
                <h4>€{{ $concert->prijs }}</h4>
            </div>            
        </div>
        <div class="row mt-2">
            <h5>{{ date("d/m/Y ", strtotime($concert->concert_date)) }} at {{ date("H:i", strtotime($concert->concert_date)) }}</h5>
        </div>
                <div class="row mt-2">
                    <div class="col-2">
                        <i class="material-icons">place</i>
                    </div>
                    <div class="col-10">
                        <?php $var = explode('|', $concert->locatie); ?>
                        <h4>{{ $var[0] }}</h4>
                        <h4>{{ $var[1] }}</h4>
                    </div>
                    
                </div> 
            </div>       
    </div>
    <div>
        <div class="bg-concert-info mt-4">
            <h2>Get exclusive content</h2>
        </div>
        <p class="p-concert-info">AND</p>
        <div class="bg-concert-info">
            <h2>Vote for your favorite song</h2>
        </div>       
        <p class="p-concert-info">AND</p>
        <div class="bg-concert-info"> 
            <div class="text-center">
                <h3>The prizes</h3>
            </div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner2">
                    @foreach($bingoPrices as $key => $bingoPrice)
                    <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                        <h5 class="text-center" id="item">{{ $bingoPrice->item_amount }} {{ $bingoPrice->item_name }}</h5>
                        <img src="{{url('uploads', $bingoPrice->file_path)}}"  class="bingo-picture" id="image" alt="...">      <!-- class="d-block w-100 h-100" -->
                    </div>                
                    @endforeach
                </div>
                
                <a class="carousel-control-prev" href="#myCarousel" role="button"  data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>        
    </div>
    <form class="text-center my-3" action="/concertspayment/{{ request()->route('concerts') }}" method="get">
        <button class="btn-orange btn-orange2" type="submit" name="room" value="room">Buy room ticket</button>
    </form>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    var items = "<?php echo $prices; ?>" - 1;
    console.log(items);
    $("#previous").click(function(){
        $("#item").html("{{ $bingoPrices[0]->item_amount }} {{ $bingoPrices[0]->item_name }}");
    });

    $("#next").click(function(){
        $("#item").html("{{ $bingoPrices[0]->item_amount }} {{ $bingoPrices[0]->item_name }}");
    });

});
</script>
@endsection