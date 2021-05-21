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
@endsection