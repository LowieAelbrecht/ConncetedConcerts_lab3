@extends('layouts/main-nav')

@section('title')
    My rooms
@endsection


@section('content')
    <?php if((session()->get('userType')) == ("user")) : ?>  
        <div class="row justify-content-center pt-3 rooms">
            <a href="/user-rooms" class="active-link">My rooms</a>
            <p class="px-3"> | </p>
            <a href="/user-discover" class="non-active-link">Discover</a>
        </div>
    <?php endif; ?>
    <?php if(empty($myConcerts[0])) : ?> 
        <div class="row justify-content-center">
            <i class="material-icons">folder_open</i>
            <h2 class="text-center">You have no concert rooms</h2>
            <p class="text-center">Start by making your first room for an upcoming concert!</p>
            <form class="text-center" action="" method="get">
                <button class="btn-orange" type="submit" name="room" value="room">Make room</button>
            </form>
        </div>        
    <?php endif; ?>
@endsection