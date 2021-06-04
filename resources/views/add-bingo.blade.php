@extends('layouts/back-nav')

@section('title')
    Add bingo
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