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
    <form method="post" action="/finish-concert">
    @csrf 
    <div class="range-wrap col-12">
        <label for="price" class="form-label h3-label">Price</label>
        <input type="range" name="price" class="range" min="5" max="10" step="1">
        <output class="bubble"></output>
    </div>

    <h3>Example</h3>
    <div class="card">
        <img  src="{{ $myConcert->file_path }}" class="card-img-top" alt="concert picture">
        <div class="card-body">
            <h3 class="card-title">{{ $myConcert->artist_name }}</h3>
            <h5>{{ $myConcert->name }}</h5>
            <h5>{{ $myConcert->locatie }}</h5>
        </div>
    </div>
    
        <div class="text-center">
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

