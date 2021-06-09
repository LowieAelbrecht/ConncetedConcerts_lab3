@extends('layouts/back-nav')

@section('title')
    Add post
@endsection

@section('content')
<div class="container">
    <div class="text-center">
        <h2>New post</h2>
    </div>

    <form action="/add-post/{{ request()->route('concerts') }}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="pb-3">
            <input type="text" name="title" class="form-control" value="" placeholder="Your title"> 
        </div>
        <div>
            <textarea type="text" cols="40" name="tekst" rows="5" placeholder="Your text"></textarea> 
        </div>

        <input type="file" name="photo" id="inpFile">

        <div class="image-preview" id="imagePreview">

        <img src="" alt="Image Preview" class="image-preview__image">
        <span class="image-preview__default-text"></span>
        </div>
        <div class="bottom-buttons">
            <button class="btn-orange btn-orange2 mb-2" type="submit" name="room" value="room">Publish post</button>
            <a class="cancel" href="/social-room/{{ request()->route('concerts') }}">cancel</a>
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


        const inpFile =document.getElementById("inpFile");
        const previewContainer = document.getElementById("imagePreview");
        const previewImage = previewContainer.querySelector(".image-preview__image");
        const previewDefaultText =previewContainer.querySelector(".image-preview__default-tet");  

        inpFile.addEventListener("change", function(){
        const file =this.files[0];

        if(file){
        const reader = new FileReader(); //image lezen als url

        previewImage.style.display ="block"; //geladen image tonen.
       // previewDefaultText.style.display ="none"; //geladen image tonen.

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