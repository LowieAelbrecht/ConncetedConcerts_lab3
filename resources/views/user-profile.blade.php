@extends('layouts/back-nav')

@section('title')
    profile
@endsection


@section('content')
<?php if((session()->get('userType')) == ("user")) : ?>
    <div>
        <img class="profile-image" src="<?php echo $profile->images[0]->url; ?>" alt="profile_image">
        <h3><?php echo $profile->display_name; ?></h3>
    </div>
<?php else: ?>
    <div>
        <img class="profile-image" src="<?php echo $profile->images[0]->url; ?>" alt="profile_image">
        <h3><?php echo $profile->name; ?></h3>
    </div>
<?php endif; ?>
@endsection