<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connected concerts - @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet"  type="text/css" href="{{ asset('/css/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="containter main-nav d-flex justify-content-between">
        <div class="ml-1 mt-1">
            <a <?php if(Session::has('concertId')) : ?> href="/delete-room"  <?php else : ?> href="/user-rooms" <?php endif; ?>><i class="material-icons">arrow_back</i></a>
        </div>
        <div>
            <img class="orange-logo" src="../images/LogoLetterOrange.png" alt="">
        </div>
        <div class="mr-1 mt-1">
            <i class="material-icons invisible">more_vert</i>
        </div>     
    </nav>
    <div class="content">
        @yield('content')
    </div>
    <div>
        @yield('steps')
    </div>
</body>
</html>
@yield('js')