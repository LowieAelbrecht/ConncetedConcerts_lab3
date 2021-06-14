@extends('layouts/frontend')

@section('title')
   Choose artist 
@endsection

@section('content')
    <h2 class="choose-artist">Choose an artist to use the app as</h2>
    <form method="post" action="/choose-artist">
    @csrf
    <div class="">
        <div class="row mb-3">
            <div class="col-6 artist">
                <img class="artist-image mb-2" src="<?php echo $balthazar->images[0]->url; ?>" alt="profile_image">
                <input class="choose-artistBtn" type="submit" name="balthazar" value="<?php echo $balthazar->name; ?>"></input>
            </div>
            <div class="col-6 artist">
                <img class="artist-image mb-2" src="<?php echo $equalIdiots->images[0]->url; ?>" alt="profile_image">
                <input class="choose-artistBtn" type="submit" name="equalIdiots" value="<?php echo $equalIdiots->name; ?>"></input>
            </div>
        </div>
        <div class="row">
            <div class="col-6 artist">
                <img class="artist-image mb-2" src="<?php echo $hooverphonic->images[0]->url; ?>" alt="profile_image">
                <input class="choose-artistBtn" type="submit" name="hooverphonic" value="<?php echo $hooverphonic->name; ?>"></input>
            </div>
            <div class="col-6 artist">
                <img class="artist-image mb-2" src="<?php echo $milow->images[0]->url; ?>" alt="profile_image">
                <input class="choose-artistBtn" type="submit" name="milow" value="<?php echo $milow->name; ?>"></input>
            </div>
        </div>
    </div>
    </form>
@endsection