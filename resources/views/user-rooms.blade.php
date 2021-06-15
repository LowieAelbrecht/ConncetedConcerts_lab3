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
        <div class="row justify-content-center no-rooms">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI3Ni4xNTcgMjc2LjE1NyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgY2xhc3M9IiI+PGc+CjxwYXRoIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgc3R5bGU9IiIgZD0iTTI3My4wODEsMTAxLjM3OGMtMy4zLTQuNjUxLTguODYtNy4zMTktMTUuMjU1LTcuMzE5aC0yNC4zNHYtMjYuNDdjMC0xMC4yMDEtOC4yOTktMTguNS0xOC41LTE4LjUgIGgtODUuMzIyYy0zLjYzLDAtOS4yOTUtMi44NzYtMTEuNDM2LTUuODA2bC02LjM4Ni04LjczNWMtNC45ODItNi44MTQtMTUuMTA0LTExLjk1NC0yMy41NDYtMTEuOTU0SDU4LjczMSAgYy05LjI5MywwLTE4LjYzOSw2LjYwOC0yMS43MzgsMTUuMzcybC0yLjAzMyw1Ljc1MmMtMC45NTgsMi43MS00LjcyMSw1LjM3MS03LjU5Niw1LjM3MUgxOC41Yy0xMC4yMDEsMC0xOC41LDguMjk5LTE4LjUsMTguNSAgdjE2Ny4wN2MwLDAuODg1LDAuMTYxLDEuNzMsMC40NDMsMi41MTljMC4xNTIsMy4zMDYsMS4xOCw2LjQyNCwzLjA1Myw5LjA2NGMzLjMsNC42NTIsOC44Niw3LjMxOSwxNS4yNTUsNy4zMTloMTg4LjQ4NiAgYzExLjM5NSwwLDIzLjI3LTguNDI0LDI3LjAzNS0xOS4xNzlsNDAuNjc3LTExNi4xODhDMjc3LjA2MSwxMTIuMTU5LDI3Ni4zODEsMTA2LjAzLDI3My4wODEsMTAxLjM3OHogTTE4LjUsNjQuMDg5aDguODY0ICBjOS4yOTUsMCwxOC42NC02LjYwOCwyMS43MzgtMTUuMzcybDIuMDMyLTUuNzVjMC45NTktMi43MTEsNC43MjItNS4zNzIsNy41OTctNS4zNzJoMjkuNTY0YzMuNjMsMCw5LjI5NSwyLjg3NiwxMS40MzcsNS44MDYgIGw2LjM4Niw4LjczNGM0Ljk4Miw2LjgxNSwxNS4xMDQsMTEuOTU0LDIzLjU0NiwxMS45NTRoODUuMzIyYzEuODk4LDAsMy41LDEuNjAzLDMuNSwzLjV2MjYuNDdINjkuMzQgIGMtMTEuMzk1LDAtMjMuMjcsOC40MjQtMjcuMDM1LDE5LjE3OUwxNSwxOTEuMjMxVjY3LjU4OUMxNSw2NS42OTIsMTYuNjAzLDY0LjA4OSwxOC41LDY0LjA4OXogTTI2MC43OTEsMTEzLjIzOGwtNDAuNjc3LDExNi4xODggIGMtMS42NzQsNC43ODEtNy44MTIsOS4xMzUtMTIuODc3LDkuMTM1SDE4Ljc1MWMtMS40NDgsMC0yLjU3Ny0wLjM3My0zLjAyLTAuOTk4Yy0wLjQ0My0wLjYyNS0wLjQyMy0xLjgxNCwwLjA1Ni0zLjE4MSAgbDQwLjY3Ny0xMTYuMTg4YzEuNjc0LTQuNzgxLDcuODEyLTkuMTM1LDEyLjg3Ny05LjEzNWgxODguNDg2YzEuNDQ4LDAsMi41NzcsMC4zNzMsMy4wMjEsMC45OTggIEMyNjEuMjksMTEwLjY4MiwyNjEuMjcsMTExLjg3MSwyNjAuNzkxLDExMy4yMzh6IiBmaWxsPSIjMjQwMDQ2IiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAyIiBjbGFzcz0iIj48L3BhdGg+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjwvZz48L3N2Zz4=" />            <h2 class="text-center">You are not in any rooms</h2>
            <p class="text-center">Please go to the discover tab to start looking for concert rooms.</p>
            <form class="text-center" action="/user-discover" method="get">
                <button class="btn-orange btn-orange2" type="submit" name="room" value="room">Discover rooms</button>
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
                            <?php $var = explode('|', $myConcert->locatie); ?>
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
            <div class="row justify-content-center no-rooms">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI3Ni4xNTcgMjc2LjE1NyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgY2xhc3M9IiI+PGc+CjxwYXRoIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgc3R5bGU9IiIgZD0iTTI3My4wODEsMTAxLjM3OGMtMy4zLTQuNjUxLTguODYtNy4zMTktMTUuMjU1LTcuMzE5aC0yNC4zNHYtMjYuNDdjMC0xMC4yMDEtOC4yOTktMTguNS0xOC41LTE4LjUgIGgtODUuMzIyYy0zLjYzLDAtOS4yOTUtMi44NzYtMTEuNDM2LTUuODA2bC02LjM4Ni04LjczNWMtNC45ODItNi44MTQtMTUuMTA0LTExLjk1NC0yMy41NDYtMTEuOTU0SDU4LjczMSAgYy05LjI5MywwLTE4LjYzOSw2LjYwOC0yMS43MzgsMTUuMzcybC0yLjAzMyw1Ljc1MmMtMC45NTgsMi43MS00LjcyMSw1LjM3MS03LjU5Niw1LjM3MUgxOC41Yy0xMC4yMDEsMC0xOC41LDguMjk5LTE4LjUsMTguNSAgdjE2Ny4wN2MwLDAuODg1LDAuMTYxLDEuNzMsMC40NDMsMi41MTljMC4xNTIsMy4zMDYsMS4xOCw2LjQyNCwzLjA1Myw5LjA2NGMzLjMsNC42NTIsOC44Niw3LjMxOSwxNS4yNTUsNy4zMTloMTg4LjQ4NiAgYzExLjM5NSwwLDIzLjI3LTguNDI0LDI3LjAzNS0xOS4xNzlsNDAuNjc3LTExNi4xODhDMjc3LjA2MSwxMTIuMTU5LDI3Ni4zODEsMTA2LjAzLDI3My4wODEsMTAxLjM3OHogTTE4LjUsNjQuMDg5aDguODY0ICBjOS4yOTUsMCwxOC42NC02LjYwOCwyMS43MzgtMTUuMzcybDIuMDMyLTUuNzVjMC45NTktMi43MTEsNC43MjItNS4zNzIsNy41OTctNS4zNzJoMjkuNTY0YzMuNjMsMCw5LjI5NSwyLjg3NiwxMS40MzcsNS44MDYgIGw2LjM4Niw4LjczNGM0Ljk4Miw2LjgxNSwxNS4xMDQsMTEuOTU0LDIzLjU0NiwxMS45NTRoODUuMzIyYzEuODk4LDAsMy41LDEuNjAzLDMuNSwzLjV2MjYuNDdINjkuMzQgIGMtMTEuMzk1LDAtMjMuMjcsOC40MjQtMjcuMDM1LDE5LjE3OUwxNSwxOTEuMjMxVjY3LjU4OUMxNSw2NS42OTIsMTYuNjAzLDY0LjA4OSwxOC41LDY0LjA4OXogTTI2MC43OTEsMTEzLjIzOGwtNDAuNjc3LDExNi4xODggIGMtMS42NzQsNC43ODEtNy44MTIsOS4xMzUtMTIuODc3LDkuMTM1SDE4Ljc1MWMtMS40NDgsMC0yLjU3Ny0wLjM3My0zLjAyLTAuOTk4Yy0wLjQ0My0wLjYyNS0wLjQyMy0xLjgxNCwwLjA1Ni0zLjE4MSAgbDQwLjY3Ny0xMTYuMTg4YzEuNjc0LTQuNzgxLDcuODEyLTkuMTM1LDEyLjg3Ny05LjEzNWgxODguNDg2YzEuNDQ4LDAsMi41NzcsMC4zNzMsMy4wMjEsMC45OTggIEMyNjEuMjksMTEwLjY4MiwyNjEuMjcsMTExLjg3MSwyNjAuNzkxLDExMy4yMzh6IiBmaWxsPSIjMjQwMDQ2IiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAyIiBjbGFzcz0iIj48L3BhdGg+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjwvZz48L3N2Zz4=" /> 
                <h2 class="text-center">You have no concert rooms</h2>
                <p class="text-center">Start by making your first room for an upcoming concert!</p>
                <form class="text-center" action="" method="get">
                    <button class="btn-orange btn-orange2" type="submit" name="room" value="room">Make room</button>
                </form>
            </div>        
        @else
            @if(!empty($published))
                <h4>My rooms</h4>
            @endif
            @foreach( $myConcerts as $myConcert )
                @if($myConcert->published == true) 
                    <h4 class="concert-date">{{ date("d/m/'y ", strtotime($myConcert->concert_date)) }}</h4>
                    <a href="/social-room/{{ $myConcert->id }}">
                    <div class="card">
                        <img  src="{{ $myConcert->file_path }}" class="card-img-top" alt="concert picture">
                        <div class="card-body">
                            <h3>{{ $myConcert->name }}</h3>
                            <?php $var = explode('|', $myConcert->locatie); ?>
                            <h5>{{ $var[0] }}</h5>
                            <h5>{{ $var[1] }}</h5>
                            <h5>{{ $myConcert->tickets_sold }} ticket(s) sold</h5>
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