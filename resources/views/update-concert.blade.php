@extends('layouts/back-nav')

@section('title')
    Update room
@endsection

@section('content')
<div class="container mt-3">
    <h2 class="text-center">Manage basic info</h2>
    <form method="post" action="/update-concert/{{ $myConcert->id }}" enctype="multipart/form-data"> 
    @csrf
        <div>
            <input type="text" name="concertName" class="form-control" value="<?php echo $myConcert->name; ?>"> 
        </div>
        <div class="row">
            <div class="col-8">
                <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($myConcert->concert_date)); ?>"> 
            </div>
            <div class="col-4">
                <input type="time" name="time" class="form-control" value="<?php echo date('H:i', strtotime($myConcert->concert_date)); ?>"> 
            </div>
        </div>
        <div>
            <input type="text" name="location" class="form-control" value="<?php echo $myConcert->locatie; ?>"> 
        </div>
        <div class="range-wrap col-12">
            <label for="price" class="form-label h3-label">Price</label>
            <input type="range" name="price" class="range" min="5" max="10" value="<?php echo $myConcert->prijs; ?>" step="1">
            <output class="bubble"></output>
        </div>
        <div class="card">
            <img src="/uploads/{{ $myConcert->file_path }}" alt="concert picture">
            <input type="file" name="photo">
        </div>
        <div class="text-center">
            <p>Your room is currently private, if you want to keep it that way use the save button otherwise publish it now!</p>
            <button class="btn-orange btn-orange2" type="submit" name="action" value="publish">Publish room</button>
            <p>or</p>
            <button class="btn-outline-purple" type="submit" name="action" value="save">Save room</button>
        </div>  
    </form>
</div>    
@endsection

@section('js')
    <script>
        const allRanges = document.querySelectorAll(".range-wrap");
        allRanges.forEach(wrap => {
        const range = wrap.querySelector(".range");
        const bubble = wrap.querySelector(".bubble");

        range.addEventListener("input", () => {
            setBubble(range, bubble);
        });
        setBubble(range, bubble);
        });

        function setBubble(range, bubble) {
        const val = range.value;
        const min = range.min ? range.min : 4;
        const max = range.max ? range.max : 10;
        const newVal = Number(((val - min) * 100) / (max - min));
        bubble.value = "€ " + val;
        }
    </script>
@endsection