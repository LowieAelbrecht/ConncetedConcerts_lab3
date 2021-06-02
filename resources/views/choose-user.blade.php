@extends('layouts/frontend')

@section('title')
   Choose user 
@endsection

@section('content')
    <h2 class="text-white">Choose how you want to use the app</h2>
    <form method="post" action="/checkUser">
    @csrf
    <div class="row justify-content-center">
        <div class="mr-4">
            <input type="submit" name="user" value="User"></input>
        </div>
        <div class="ml-4">
            <input type="submit" name="artist" value="Artist"></input>
        </div>
    </div>
    </form>
@endsection