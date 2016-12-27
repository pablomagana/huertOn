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
    imagenes.push(file);
    console.log(imagenes);
    createImageElement(file);
    /*$.ajax({
      type: "POST",
      url:"/orchard/images/upload",
      data: {
        'name':image.title,
        'src':image.src,
        'description':'descripción vacia'
      },
      success: function(){createImageElement(file)}
    });*/

}

function createImageElement(file){
  var thumb = document.createElement("div");
  thumb.classList.add('thumbnail'); // Add the class thumbnail to the created div

  var img = document.createElement("img");
  var des = document.createElement("textarea");
  var name = document.createElement("p");
  name.append(document.createTextNode(file.name));
  name.setAttribute("title",file.name);
  des.setAttribute("type","text");
  des.classList.add("descripcion");
  img.file = file;
  thumb.appendChild(img);
  thumb.appendChild(name);
  thumb.appendChild(des);
  gallery.appendChild(thumb);

  // Using FileReader to display the image content
  var reader = new FileReader();
  reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
  reader.readAsDataURL(file);
}
