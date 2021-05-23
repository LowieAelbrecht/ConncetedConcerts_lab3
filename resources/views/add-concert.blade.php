@extends('layouts/back-nav')

@section('title')
    Add concert
@endsection

@section('content')
    <form action="">
        <div>
            <label for="concertName" class="form-label">Room name</label>
            <input type="text" name="concertName" class="form-control" value=""> 
        </div>
        <div class="row">
            <div class="col-8">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value=""> 
            </div>
            <div class="col-4">
                <label for="time" class="form-label">Time</label>
                <input type="time" name="time" class="form-control" value=""> 
            </div>
        </div>
        <div>
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value=""> 
        </div>
        <div class="range-wrap col-12">
            <label for="price" class="form-label">Price</label>
            <input type="range" class="range" min="4" max="10" step="1">
            <output class="bubble"></output>
        </div>
    </form>
@endsection

@section('steps')
    <div class="steps row justify-content-center">
        <div class="text-center">
            <h5>Basic info</h5>
            <span class="selected-dot dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>        
        </div>
        <div class="pull-right">
            <h4>Next</h4>
        </div>        
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