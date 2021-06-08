@extends('layouts/back-nav')

@section('title')
    Bingo
@endsection

@section('content')
    @if(empty($bingoResults[0]))
    <div class="container mt-3">
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
                <h3>The prices</h3>
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
        @if((session()->get('userType')) == ("artist"))
        <div  class="d-flex justify-content-center">
            <form method="post" action="/bingo-room/{{ request()->route('concerts') }}">
            @csrf 
                <button class="button bingo-btn">START <br>BINGO</button>
            </form>    
        </div>
    </div>    
    @endif  
    @else
        @if((session()->get('userType')) == ("artist")) 
            <div class="text-center">
                <h2>Bingo</h2>
                <p>The winners are confirmed!</p>
            </div>   
            <h3>Winners</h3>
            @foreach($prices as $price)
                <h2>{{ $price->item_name }}</h2>
                @foreach($bingoResults as $bingoResult)
                    @foreach($users as $user)
                        @if($user->id == $bingoResult->user_id && $price->id == $bingoResult->bingo_id)
                            <h3 class="winners">{{ $user->name }}</h3>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        @else
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
                    </div>
                </div>
            @endif
        @endif
    @endif
   
@endsection

@section('steps')
    <div class="bottom-nav">
        <div class="justify-content-center row bottom-nav">
            <a class="row px-4" href="/social-room/{{ request()->route('concerts') }}">
                <i class="material-icons">people</i>
                <h5>Social</h5>
            </a>
            <a class="row px-4" href="/vote-room/{{ request()->route('concerts') }}">
                <i class="material-icons">recommend</i>
                <h5>Vote</h5>
            </a>
            <a class="row px-4  selected-nav">
                <i class="material-icons">celebration</i>
                <h5>Bingo</h5>
            </a>                  
        </div>      
    </div>
@endsection