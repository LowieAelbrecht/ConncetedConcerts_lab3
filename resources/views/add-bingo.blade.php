@extends('layouts/back-nav')

@section('title')
    Add bingo
@endsection

@section('content')
<form method="post" action="/add-bingo" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="text-center">
            <h2>Bingo</h2>
            <p>All fans that bought a ticket for your room make an equal chance of winning prices. Add prices and activate the bingo after the performance.</p>
        </div>
        <div class="card">
            <div>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name item"> 
            </div>
            <div>
                <input type="text" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="Amount"> 
            </div>
            <div>
                <input type="text" name="info" class="form-control" value="{{ old('info') }}" placeholder="Pick up location / Extra info"> 
            </div>    
        </div>
    </div>

@endsection

@section('steps')
    <div class="steps row justify-content-center">
        <div class="text-center">
            <h5>Bingo</h5>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="selected-dot dot"></span>        
        </div>
        <div class="pull-right">
            <input type="submit" name="upload" value="Finish"></input>
        </div>        
    </div>
</form>   
@endsection

