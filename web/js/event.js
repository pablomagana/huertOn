//capturar imagenes subidas para eventos
function previewImage(file) {
    var galleryId = "gallery";
    var gallery = document.getElementById(galleryId);
    var imageType = /image.*/;

    if (!file.type.match(imageType)) {
        throw "El archivo debe ser una imagen";
    }
    // if(file.size>10240){
    //   throw "El archivo supera el tamaño maximo";
    // }
    var lector = new FileReader();
    lector.onloadend = function() {
      file.src = lector.result;
      imagenes.push(file);
      console.log(imagenes);
      //createImageElement(file,id);
      checkNumImage();
      createImageElement(file);
    }
    lector.readAsDataURL(file);
}
//Drag&drop cargar imagenes
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  console.log("dragevent");
  ev.dataTransfer.setData("text", 'gallery');
}

function drop(ev) {
  console.log('dropevent');
  ev.preventDefault();
  $("#loading-images").fadeIn("slow");
  var data = ev.dataTransfer.getData("text");
  var f = ev.dataTransfer.files;

  if (f.length+imagenes.length<maxfiles+1) {
    previewImage(f);
  }else{
    alert("solo se permite un maximo de "+maxfiles+" imagenes");
  }
  $("#loading-images").fadeOut("slow");
}

function createImageElement(file){
  var thumb = document.createElement("div");
  thumb.classList.add('thumbnail'); // Add the class thumbnail to the created div

  var img = document.createElement("img");
  var del = document.createElement("span");

  img.file = file;

  del.setAttribute("class","fa fa-times-circle topRight deleteImage");
  del.setAttribute("id",file.id);

  //funcion que se ejecuta al eliminar una imagen de la interfaz
  del.onclick=function() {
    //alert("eliminando imagen");
    imagenes=removeItem();
    $(this).parent().remove();

    console.log(imagenes);
    checkNumImage();
  };

  thumb.appendChild(del);
  thumb.appendChild(img);
//añade la imagen al principio del div, antes que todas las imagenes
  gallery.prepend(thumb);

  // Using FileReader to display the image content
  var reader = new FileReader();
  reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
  reader.readAsDataURL(file);
}
function checkNumImage() {
  if (imagenes.length>0) {
    $(".more").attr("hidden","hidden");
  }else{
    $(".more").removeAttr("hidden");
  }
}
function removeItem() {
  $('input:file').val("");
  imagenes=new Array();
  return imagenes;
}
