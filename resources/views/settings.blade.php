@extends('layouts/back-nav')

@section('title')
    settings
@endsection


@section('content')
<div class="container">
    <ul class="list-settings pt-5">
        <li><a href="http://www.connectedconcerts.be" target="_blank" class="setting">About<a></li>
        <div class="purple-line"></div>
        <li><a href="/tutorial" class="setting">Tutorial<a></li>

        <div class="purple-line"></div>
        <li><a class="setting">Partners<a></li>
        <div class="purple-line"></div>
        <li><a href="http://www.connectedconcerts.be" target="_blank" class="setting">Contact<a></li>
        <div class="purple-line"></div>
    </ul>

    <form class="text-center" action="" method="get">
        <button class="btn-outline-purple" type="submit" name="logout" value="logout">Log out</button>
    </form>
</div>   
@endsection