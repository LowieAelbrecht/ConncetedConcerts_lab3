@extends('layouts/frontend')

@section('title')
   Tutorial artist
@endsection

@section('content')
<div class="choose">
    <div class="logofull"></div>

    <h2 class="text-center mb-5">Welcome!</h2>

    <form class="text-center" action="/tutorial-artist2" method="get">
        <button class="btn-orange btn-orange2" type="submit" name="login" value="login">Tutorial of the app</button>
    </form>
    <a class="text-center mt-3" href="/user-rooms">Skip</a>

</div>
@endsection