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
            @if($errors->first('title'))   
                <h5 class="errors text-center">{{ $errors->first('title') }}</h5>    
            @endif
            <input type="text" name="title" class="form-control" value="" placeholder="Your title" <?php if($errors->first('title')) : ?> style="border-color: red"; <?php endif; ?>>  
        </div>
        <div>
            @if($errors->first('tekst'))   
                <h5 class="errors text-center">{{ $errors->first('tekst') }}</h5>    
            @endif
            <textarea type="text" cols="40" name="tekst" rows="5" placeholder="Your text" <?php if($errors->first('tekst')) : ?> style="border-color: red"; <?php endif; ?>></textarea> 
        </div>

        <input accept=".mp4,.jpg,.png,.jpeg" type="file" name="photo" id="inpFile">

        <div class="image-preview" id="imagePreview">
        <video class="videoPost" src="" width="400" controls></video>        
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
        const videoUpload = previewContainer.querySelector(".videoPost");

        inpFile.addEventListener("change", function(){
        const file =this.files[0];

        if(file){
        const reader = new FileReader(); //image lezen als url

        previewImage.style.display="block";
        videoUpload.style.display="block"; //geladen image tonen.
       // previewDefaultText.style.display ="none"; //geladen image tonen.

        reader.addEventListener("load", function(){      //toegevoegde img laden
        previewImage.setAttribute("src", this.result);
        videoUpload.setAttribute("src", this.result);   //src veranderen in html, this verwijst nr fileReader   //src veranderen in html, this verwijst nr fileReader
        previewImage.style.objectFit="none";
        previewImage.style.width="100%";
        videoUpload.style.objectFit="none";
        videoUpload.style.width="100%";

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