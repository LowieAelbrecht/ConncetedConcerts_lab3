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

    <form class="text-center" action="" method="get">
        <button class="btn-outline-purple" type="submit" name="logout" value="logout">Log out</button>
    </form>
    
@endsection