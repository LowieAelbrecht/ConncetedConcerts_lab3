@extends('layouts/frontend')

@section('title')
   Choose user 
@endsection

@section('content')
<div class="choose">
    <h2 class="text-white loginMessage">Choose how you want to use the app</h2>
    <form method="post" action="/checkUser">
    @csrf
    <div class="row justify-content-center">
        <div class="mr-3">
            <input class="userBtn" type="submit" name="user" value="User"></input>
        </div>
        <div class="ml-3">
            <input class="artistBtn" type="submit" name="artist" value="Artist"></input>
        </div>
    </div>
    </form>
</div>
@endsection