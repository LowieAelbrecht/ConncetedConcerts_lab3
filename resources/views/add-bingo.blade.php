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
        <div class="bg-white mb-5" id="1">
            <div class="card-body">
                <div class="row">
                    <div id="image-upload2" class="image-upload col-4 my-2">
                        <label class="custom-file-upload">


                            <input class="inpFileBingo" id="inpFileBingo" type="file" name="photo[1]" required/>
                            <label for="inpFileBingo" class="labelImgBingo image-preview__default-text material-icons">add_a_photo</span>

                            <div id="image-upload2">

                            <img src="" alt="Image Preview" class="image-preview__image">

                            </div>
                           <!-- <span class="material-icons">image</span>-->
                        </label>
                        

                    </div>
                    <div class="col-8">
                        <div class="my-2">
                            <input type="text" name="name[1]" class="form-control" value="{{ old('name[1]') }}" placeholder="Name item"> 
                        </div>
                        <div class="my-2">
                            <input type="text" name="amount[1]" class="form-control" value="{{ old('amount[1]') }}" placeholder="Amount"> 
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <input type="text" name="info[1]" class="form-control" value="{{ old('info[1]') }}" placeholder="Pick up location / Extra info"> 
                </div>    
            </div>
        </div>
        <div class="addItem">
            <h5 class="text-center addBtn">ADD ITEM</h5>
        </div>
    </div>

@endsection

@section('steps')
    <!-- <div class="steps row justify-content-center">
        <div class="text-center">
            <h5>Bingo</h5>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="selected-dot dot"></span>        
        </div>
        <div class="pull-right">
            <input class="nextBtn" type="submit" name="upload" value="Finish"></input>
        </div>        
    </div> -->
    <div class="bottom-nav">
        <div class="text-center">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="selected-dot dot"></span>
            <input class="nextBtn" type="submit" name="upload" value="Next">Next</input>        
        </div>
    </div>
</form>   
@endsection

@section('js')
<script>
$(document).ready(function(){
    $(".addItem").click(function(){
        var itemId = $(".bg-white").last().attr("id");
        var newItemId = (+itemId +1);
    // var newImg = getElementById("#inpFile");
       // var addNewImg =(+newImg +1);
        $("#" + itemId).after('<div class="bg-white mb-5" id="'+ newItemId +'"><div class="card-body"><div class="row"><div class="image-upload col-4 my-2"><label class="custom-file-upload"><input id="inpFile" type="file" name="photo['+newItemId+']"/><img src="" alt="Image Preview" class="image-preview__image"> </label></div><div class="col-8"><div class="my-2"><input type="text" name="name['+newItemId+']" class="form-control" value="" placeholder="Name item"></div><div class="my-2"><input type="text" name="amount['+newItemId+']" class="form-control" value="" placeholder="Amount"></div></div></div><div class="row"><input type="text" name="info['+newItemId+']" class="form-control" value="" placeholder="Pick up location / Extra info"></div></div></div>');  
    });
});



        const inpFile =document.getElementById("inpFileBingo");
        const previewContainer = document.getElementById("image-upload2");
        const previewImage = previewContainer.querySelector(".image-preview__image");
        const labelImg =previewContainer.querySelector(".labelImgBingo");
        const previewDefaultText =previewContainer.querySelector(".image-preview__default-tet");  

        inpFile.addEventListener("change", function(){
        const file =this.files[0];

        if(file){
        const reader = new FileReader(); //image lezen als url

        previewImage.style.display ="block"; //geladen image tonen.
        previewImage.style.width ="100%"; //geladen image tonen.
        previewContainer.style.overflow ="auto"; //geladen image tonen.

        inpFile.style.display = "none"
        labelImg.style.display ="none"; //geladen image tonen.

         reader.addEventListener("load", function(){      //toegevoegde img laden
        previewImage.setAttribute("src", this.result);   //src veranderen in html, this verwijst nr fileReader

         });

         reader.readAsDataURL(file); //gelezen data tonen als image
        }else{
        previewImage.style.display = null; //als user niks kiest toon default css
        previewDefaultText.Style.display =null;
        inpFile.style.display = null;
        previewImage.setAttribute("src","");
}
});







</script>
@endsection
