function previewImage(file){var galleryId="gallery";var gallery=document.getElementById(galleryId);var imageType=/image.*/;if(!file.type.match(imageType)){throw "El archivo debe ser una imagen"}
var lector=new FileReader();lector.onloadend=function(){file.src=lector.result;imagenes.push(file);checkNumImage();createImageElement(file)}
lector.readAsDataURL(file)}
function allowDrop(ev){ev.preventDefault()}
function drag(ev){ev.dataTransfer.setData("text",'gallery')}
function drop(ev){ev.preventDefault();$("#loading-images").fadeIn("slow");var data=ev.dataTransfer.getData("text");var f=ev.dataTransfer.files;if(f.length+imagenes.length<maxfiles+1){previewImage(f)}else{}
$("#loading-images").fadeOut("slow")}
function createImageElement(file){var thumb=document.createElement("div");thumb.classList.add('thumbnail');var img=document.createElement("img");var del=document.createElement("span");img.file=file;del.setAttribute("class","fa fa-times-circle topRight deleteImage");del.setAttribute("id",file.id);del.onclick=function(){imagenes=removeItem();$(this).parent().remove();checkNumImage()};thumb.appendChild(del);thumb.appendChild(img);gallery.prepend(thumb);var reader=new FileReader();reader.onload=(function(aImg){return function(e){aImg.src=e.target.result}})(img);reader.readAsDataURL(file)}
function checkNumImage(){if(imagenes.length>0){$(".more").attr("hidden","hidden")}else{$(".more").removeAttr("hidden")}}
function removeItem(){$('input:file').val("");imagenes=new Array();return imagenes}
