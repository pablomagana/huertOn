//capturar imagenes subidas
function previewImage(file) {
    var galleryId = "gallery";
    var gallery = document.getElementById(galleryId);
    var imageType = /image.*/;

    if (!file.type.match(imageType)) {
        throw "El archivo debe ser una imagen";
    }
    //añado al fichero una nueva propiedad descripción
    file.des="nada";
    var lector = new FileReader();
    lector.onloadend = function() {
      file.src = lector.result;
      console.log(imagenes);
      //createImageElement(file,id);
      $.ajax({
        type: "POST",
        url:"/orchard/images/upload",
        data: {
          'name':file.name,
          'src':file.src,
          'description':'descripción vacia'
        },
         success: function(id){file.id=id;imagenes.push(file);createImageElement(file,id);},
         error: function(){alert("Error al subir la imagen")}
       });
    }
    if(imagenes.length>0){
      $("#btn-siguiente").text("Siguiente");
    }else {
      $("#btn-siguiente").text("Ahora no");
    }

    lector.readAsDataURL(file);


}

function createImageElement(file,id){
  var thumb = document.createElement("div");
  thumb.classList.add('thumbnail'); // Add the class thumbnail to the created div

  var img = document.createElement("img");
  var del = document.createElement("span");
  var des = document.createElement("textarea");
  var name = document.createElement("p");

  name.append(document.createTextNode(file.name));
  name.setAttribute("title",file.name);

  des.setAttribute("type","text");
  des.setAttribute("placeholder","Describe la imagene");
  des.classList.add("descripcion");
  des.setAttribute("maxlength","100");

  img.file = file;

  del.setAttribute("class","fa fa-times-circle topRight deleteImage");
  del.setAttribute("id",id);
  del.onclick=function() {
    //alert("eliminando");
    $(this).parent().remove();
    for (var i = 0; i < imagenes.length; i++) {
      alert("pos "+$(this).attr('pos'));
      alert("id "+imagenes[i].id);
      if (imagenes[i].id==$(this).attr('pos')) {
        alert("eli");
      }
    }

    console.log(imagenes);
    if(imagenes.length>0){
      $("#btn-siguiente").text("Siguiente");
    }else {
      $("#btn-siguiente").text("Ahora no");
    }
  };

  thumb.appendChild(del);
  thumb.appendChild(img);
  thumb.appendChild(name);
  thumb.appendChild(des);

  gallery.appendChild(thumb);

  // Using FileReader to display the image content
  var reader = new FileReader();
  reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
  reader.readAsDataURL(file);
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
  //var file;
  console.log(ev.dataTransfer.files);

  if (f) {
    //[].forEach.call(files, readAndPreview);
    [].forEach.call(f, previewImage);
  }
  $("#loading-images").fadeOut("slow");
}
