@extends('layouts/back-nav')

@section('title')
    Finish concert
@endsection

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Finish</h2>
        <p>Your room is currently private, you can either publish it or keep it private for a while by saving it.</p>
    </div>

    <h3>Example</h3>
    <div class="card">
        <img  src="uploads/{{ $myConcert->file_path }}" class="card-img-top" alt="concert picture">
        <div class="card-body">
            <h3 class="card-title">{{ $myConcert->artist_name }}</h3>
            <h5>{{ $myConcert->name }}</h5>
            <h5>{{ $myConcert->locatie }}</h5>
        </div>
    </div>
    <form method="post" action="/finish-concert">
    @csrf 
        <div class="text-center">
            <button class="btn-orange btn-orange2" type="submit" name="action" value="publish">Publish room</button>
            <p>or</p>
            <button class="btn-outline-purple" type="submit" name="action" value="save">Save room</button>
        </div>
    </form>  
</div>
@endsection


