@extends('layouts/back-nav')

@section('title')
   {{ $concert->name }} 
@endsection

@section('content')
<div class="container">
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
        <div class="bg-white"> 
            <div class="text-center">
                <h3>Bingo!</h3>
                <h4>Have a change of winning:</h4>
            </div>
            @foreach($bingoPrices as $key => $bingoPrice)
                @if($key == 0)
                <div>                        
                    <div class="d-flex justify-content-center">
                        <span class="material-icons my-auto" id="previous">chevron_left</span>
                        <img  src="/uploads/{{ $bingoPrice->file_path }}" class="bingo-picture" alt="Picture of bingo price" id="image">
                        <span class="material-icons my-auto" id="next">chevron_right</span>
                    </div>
                    <h5 class="text-center" id="item">{{ $bingoPrice->item_amount }} {{ $bingoPrice->item_name }}</h5>
                </div>
                @endif
            @endforeach 
        </div>        
    </div>
    <form class="text-center" action="" method="get">
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