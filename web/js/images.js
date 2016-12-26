//capturar imagenes subidas
function previewImage(file) {
    var galleryId = "gallery";

    var gallery = document.getElementById(galleryId);
    var imageType = /image.*/;

    if (!file.type.match(imageType)) {
        throw "File Type must be an image";
    }
    $.ajax({
      type: "POST",
      url:"/orchard/images/upload",
      data: {
        'name':image.title,
        'src':image.src,
        'description':'descripción vacia'
      },
      success: function(){createImageElement(file)}
    });

}

function createImageElement(file){
  var thumb = document.createElement("div");
  thumb.classList.add('thumbnail'); // Add the class thumbnail to the created div

  var img = document.createElement("img");
  var des = document.createElement("INPUT");
  des.setAttribute("type","text");
  des.classList.add("descripcion");
  img.file = file;
  thumb.appendChild(img);
  thumb.appendChild(des);
  gallery.appendChild(thumb);

  // Using FileReader to display the image content
  var reader = new FileReader();
  reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
  reader.readAsDataURL(file);
}
var files = null;
var uploadfiles = document.querySelector('#fileinput');
uploadfiles.addEventListener('change', function () {
    var files = this.files;
    for(var i=0; i<files.length; i++){
        previewImage(this.files[i]);

    }

}, false);
