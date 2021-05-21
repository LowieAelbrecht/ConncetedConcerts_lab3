@extends('layouts/back-nav')

@section('title')
    settings
@endsection


@section('content')
    <ul class="list-settings pt-5">
        <li><a class="setting">About<a></li>
        <div class="purple-line"></div>
        <li><a class="setting">FAQ<a></li>
        <div class="purple-line"></div>
        <li><a class="setting">Partners<a></li>
        <div class="purple-line"></div>
        <li><a class="setting">Contact<a></li>
        <div class="purple-line"></div>
    </ul>
    <?php if((session()->get('userType')) == ("user")) : ?>
        <form action="/changeArtist" method="get">
            <button class="btn btn-info mb-2" type="submit" value="change">Change to artist</button>
        </form>
    <?php else: ?>
        <form action="/changeArtist" method="get">
            <button class="btn btn-info mb-2" type="submit" value="change">Change to normal user</button>
        </form>
    <?php endif; ?>

    <form class="text-center" action="" method="get">
        <button class="btn-outline-purple" type="submit" name="logout" value="logout">Log out</button>
    </form>
    
@endsection