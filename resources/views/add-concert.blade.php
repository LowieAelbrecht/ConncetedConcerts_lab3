@extends('layouts/back-nav')

@section('title')
    Add concert
  
@endsection

@section('content')
 
<form method="post" action="/add-concert" enctype="multipart/form-data"> 
    @csrf
    <div class="container">
        <div>
            <label for="concertName" class="form-label h3-label">Room name</label>
            <input type="text" name="concertName" class="form-control" value=""> 
        </div>
        <div class="row">
            <div class="col-8">
                <label for="date" class="form-label h3-label">Date</label>
                <input type="date" name="date" class="form-control" value=""> 
            </div>
            <div class="col-4">
                <label for="time" class="form-label h3-label">Time</label>
                <input type="time" name="time" class="form-control" value=""> 
            </div>
        </div>
        <div>
            <label for="location" class="form-label h3-label">Location</label>
            <input type="text" name="location" class="form-control" value=""> 
        </div>
        <div class="range-wrap col-12">
            <label for="price" class="form-label h3-label">Price</label>
            <input type="range" name="price" class="range" min="5" max="10" step="1">
            <output class="bubble"></output>
        </div>
        <div>
            <label for="photo" class="form-label h3-label inpFile">Add Image</label>
        <!---    <input type="file" name="photo">-->
        </div>

        <!--- <input type="file" name="photo" id="inpFile">-->
        <input type="file" name="file-4[] photo" id="inpFile" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple />
		<label for="file-4"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure><span>Choose a file&hellip;</span></label>
       
        <div class="image-preview" id="imagePreview">
        <img src="" alt="Image Preview" class="image-preview__image">
        <span class="image-preview__default-text"></span>




        </div>
    </div>
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
            <input type="submit" name="upload" value="Next"></input>
        </div>        
    </div>
</form>
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


        const inpFile =document.getElementById("inpFile");
        const previewContainer = document.getElementById("imagePreview");
        const previewImage = previewContainer.querySelector(".image-preview__image");
        const previewDefaultText =previewContainer.querySelector(".image-preview__default-tet");  

        inpFile.addEventListener("change", function(){
        const file =this.files[0];

        if(file){
        const reader = new FileReader(); //image lezen als url

        previewImage.style.display ="block"; //geladen image tonen.
        //previewDefaultText.style.display ="none"; //geladen image tonen.

         reader.addEventListener("load", function(){      //toegevoegde img laden
        previewImage.setAttribute("src", this.result);   //src veranderen in html, this verwijst nr fileReader

         });

         reader.readAsDataURL(file); //gelezen data tonen als image
        }else{
    previewImage.style.display = null; //als user niks kiest toon default css
    previewDefaultText.Style.display =null;
    previewImage.setAttribute("src","");
}
});

    </script>
@endsection