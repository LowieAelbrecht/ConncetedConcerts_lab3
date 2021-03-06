@extends('layouts/back-nav')

@section('title')
    Bingo
@endsection

@section('content')
    @if(empty($bingoResults[0]))
    <div class="container">
        <div class="text-center">
            <h2>Bingo</h2>
            @if((session()->get('userType')) == ("user"))
            <p>The artist starts the bingo at the end of the concert. The winnners can recieve their prices at the mentioned point.</p>
            @else
            <p>Press the "Start Bingo" button after your concert and make your fans happy with prices!</p>
            @endif
        </div>
        <div class="bg-white"> 
            <div class="text-center">
                <h3>The prizes</h3>
            </div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
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
        @if((session()->get('userType')) == ("artist"))
        <div  class="d-flex justify-content-center">
            <form method="post" action="/bingo-room/{{ request()->route('concerts') }}">
            @csrf 
                <button class="button bingo-btn">START <br>BINGO</button>
            </form>    
        </div>
        @endif 
    @else
        @if((session()->get('userType')) == ("artist")) 
        <div class="container">
            <div class="text-center">
                <h2>Bingo</h2>
                <p>The winners are confirmed!</p>
            </div>   
            <h3>Winners</h3>
            @foreach($prices as $price)
            <div class="bg-white winners">
                <div class="row">
                    <div class="col-8">
                        <h3>{{ $price->item_name }}</h3>
                    </div>
                    @if($prices[0]->item_name == $price->item_name) 
                    <div  class="col-4">
                        <p>Received</p>
                    </div>
                     @endif
                </div>
                @foreach($bingoResults as $bingoResult)
                    @foreach($users as $user)
                        @if($user->id == $bingoResult->user_id && $price->id == $bingoResult->bingo_id)
                        <div class="row">
                            <div class="col-10">
                                <h4>{{ $user->name }}</h4>
                            </div>
                            <div class="col-2">
                                <input type="checkbox" class="received" value="<?php echo $bingoResult->received; ?>" id="<?php echo $bingoResult->id; ?>" <?php if($bingoResult->received == true)  :?> checked <?php endif; ?>>
                            </div>                             
                        </div>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
            </div>
        </div>    
        @else
        <div class="winnersReveiled">
            @if(empty($winnerOrNot))
                <div class="lostBingo">
                    <div class="bingoEndConcent">
                        <h1>More luck next time!</h1>
                    </div>
                </div>
            @else
                <div class="wonBingo">
                    <div class="bingoEndConcent">
                        <h1 class="pb-2">{{ $user->name }} YOU WON!</h1>
                        <img  src="/uploads/{{ $price->file_path }}" class="bingo-picture" alt="Picture of bingo price">
                        <h3 class="py-2">1 {{ $price->item_name }}</h3>
                        <p>{{ $price->item_info }}</p>
                        <!-- <img src="../images/giphy.gif" alt="gif" class="confetti"> -->
                        <img src="../images/giphyfirework.gif" alt="gif" class="firework">
                    </div>
                </div>
            @endif 
        </div>                        
        @endif
    @endif 
@endsection

@section('steps')
    <div class="main-bottom-nav">
        <div class="justify-content-center row main-bottom-nav">
            <a class="row px-4" href="/social-room/{{ request()->route('concerts') }}">
                <i class="material-icons navSocial">people</i>
                <h5>Social</h5>
            </a>
            <a class="row px-4" href="/vote-room/{{ request()->route('concerts') }}">
                <i class="material-icons navSocial">recommend</i>
                <h5>Vote</h5>
            </a>
            <a class="row px-4  selected-nav">
                <i class="material-icons navSocial">celebration</i>
                <h5>Bingo</h5>
            </a>                  
        </div>      
    </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    var url = window.location.pathname;
    var concertId = url.substring(url.lastIndexOf('/') + 1);

    $(".received").click(function(){
        var id = $(this).attr("id");
        var checked = $(this).attr("value");
        console.log(checked);

        $.ajax({
            url:'/checkReceived',
            method: 'post',
            data: { "_token": "{{ csrf_token() }}",
                "id": id,
                "checked": checked},
            dataType: 'json'
            
        });

    });

    window.onload = function() {
        $.ajax({
        url:'/checkWinners',
        method: 'post',
        data: { "_token": "{{ csrf_token() }}",
        "concertId": concertId,},
        dataType: 'json',
        success: function(response){
            if(response == true){
               var check = true;
            }  
        }
    });
    };


        var intervalID = window.setInterval(myCallback, 5000);    
        function myCallback() {
            $.ajax({
                url:'/checkWinners',
                method: 'post',
                data: { "_token": "{{ csrf_token() }}",
                "concertId": concertId,},
                dataType: 'json',
                success: function(response){
                    if(response == true){
                        console.log("reload");
                        location.reload(true); 
                    } else {
                        console.log("not ok");
                    }
                }
                
            });
        }

    

});
</script>
@endsection