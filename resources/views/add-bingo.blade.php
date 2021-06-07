@extends('layouts/back-nav')

@section('title')
    Add bingo
@endsection

@section('content')
<form method="post" action="/add-bingo" enctype="multipart/form-data">
    @csrf
    <div class="container pb-5">
        <div class="text-center">
            <h2>Bingo</h2>
            <p>All fans that bought a ticket for your room make an equal chance of winning prices. Add prices and activate the bingo after the performance.</p>
        </div>
        <h3>Give away items</h3>
        <div class="card mb-5" id="1">
            <div class="card-body">
                <div class="row">
                    <div class="image-upload col-4 my-2">
                        <label class="custom-file-upload">
                            <input type="file" name="photo[1]"/>
                            <span class="material-icons">image</span>
                        </label>
                    </div>
                    <div class="col-8">
                        <div class="my-2">
                            <input type="text" name="name[1]" class="form-control" value="" placeholder="Name item"> 
                        </div>
                        <div class="my-2">
                            <input type="text" name="amount[1]" class="form-control" value="" placeholder="Amount"> 
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <input type="text" name="info[1]" class="form-control" value="" placeholder="Pick up location / Extra info"> 
                </div>    
            </div>
        </div>
        <div class="addItem">
            <h5 class="text-center">ADD ITEM</h5>
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

@section('js')
<script>
$(document).ready(function(){
    $(".addItem").click(function(){
        var itemId = $(".card").last().attr("id");
        var newItemId = (+itemId +1);
        $("#" + itemId).after('<div class="card mb-5" id="'+ newItemId +'"><div class="card-body"><div class="row"><div class="image-upload col-4 my-2"><label class="custom-file-upload"><input type="file" name="photo['+newItemId+']"/><span class="material-icons">image</span></label></div><div class="col-8"><div class="my-2"><input type="text" name="name['+newItemId+']" class="form-control" value="" placeholder="Name item"></div><div class="my-2"><input type="text" name="amount['+newItemId+']" class="form-control" value="" placeholder="Amount"></div></div></div><div class="row"><input type="text" name="info['+newItemId+']" class="form-control" value="" placeholder="Pick up location / Extra info"></div></div></div>');  
    });
});
</script>
@endsection
