@extends('layouts/back-nav')

@section('title')
    profile
@endsection


@section('content')
    <img src="<?php echo $profile->images[0]->url; ?>" alt="profile_image" class="profile-image">
    <h3><?php echo $profile->display_name; ?></h3>

@endsection