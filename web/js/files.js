//capturar imagenes subidas
function previewImage(file) {
  console.log(file);
    var filesId = "files";
    var files = document.getElementById(filesId);
    var fileType = /application.*/;
    fileNormas=file;
    // application/pdf

    // if (!file.type.match(fileType)) {
    //   console.log(file.type);
    //     throw "El formato del fichero no es valido. Formatos Validos:.pdf,.docx,.txt,.doc,.odf";
    // }

    checkNumFile();
    createFileElement(file);

}

function createFileElement(file){
  var thumb = document.createElement("div");
  thumb.classList.add('thumbnail'); // Add the class thumbnail to the created div

  var img = document.createElement("img");
  var del = document.createElement("span");
  var name = document.createElement("p");

  img.src = "/img/pdf_logo.jpg";

  del.setAttribute("class","fa fa-times-circle topRight deleteImage");

  name.appendChild(document.createTextNode(file.name));
  //funcion que se ejecuta al eliminar una imagen de la interfaz
  del.onclick=function() {
    //alert("eliminando imagen");
    imagenes=removeItem();
    $(this).parent().remove();

    checkNumFile();
  };

  thumb.appendChild(del);
  thumb.appendChild(img);
  thumb.appendChild(name);
//añade la imagen al principio del div, antes que todas las imagenes
  files.prepend(thumb);
}


//Drag&drop cargar imagenes
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  console.log("dragevent");
  //ev.dataTransfer.setData("text", 'gallery');
}

function drop(ev) {
  console.log('dropevent');
  ev.preventDefault();
  //var data = ev.dataTransfer.getData("text");
  var f = ev.dataTransfer.files;
  console.log(ev.dataTransfer.files);
  $("#loading-file").fadeIn("slow");
  if (f && fileNormas==null) {
    [].forEach.call(f, previewImage);
  }else {
    alert("solo se permite un maximo de 1 archivo");
  }
  $("#loading-file").fadeOut("slow");
}

function checkNumFile() {
  if(fileNormas!=null){
    $(".btn-siguiente").text("Siguiente");
    $(".more").fadeOut(500);
  }else {
    $(".btn-siguiente").text("Ahora no");
    $(".more").fadeIn(500);
  }
}

function removeItem() {
  fileNormas=null;
  $("#fileinput").val("");
  checkNumFile();
}
function deleteUpload(element) {
    deleteFromServer($(element).attr("id"),element);
}
function deleteFromServer(id,element) {
  $.ajax({
    type: "POST",
    url:"/orchard/upload/files/delete/"+id,
     success: function(data){
       if (data=="ok") {
         $(element).parent().remove();console.log($(element).attr("id"));}
         $(".more").removeAttr('hidden');
         $("#h1Upload").attr("hidden","hidden");
         $(".btn-siguiente").text("Ahora no");
       },
     error: function(){console.log("imagen no borrada");}
   });
}
