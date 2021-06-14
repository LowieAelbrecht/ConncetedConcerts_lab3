@extends('layouts/frontend')

@section('title')
    Login
@endsection



@section('content')  
<div class="login">
    <div class="logofull"></div>

    <form class="text-center" action="" method="get">
        <button class="btn-orange" type="submit" name="login" value="login">Login with spotify</button>
    </form>
</div>
@endsection