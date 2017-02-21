function previewImage(file){var filesId="files";var files=document.getElementById(filesId);var fileType=/application.*/;fileNormas=file;checkNumFile();createFileElement(file)}
function createFileElement(file){var thumb=document.createElement("div");thumb.classList.add('thumbnail');var img=document.createElement("img");var del=document.createElement("span");var name=document.createElement("p");img.src="/img/pdf_logo.jpg";del.setAttribute("class","fa fa-times-circle topRight deleteImage");name.appendChild(document.createTextNode(file.name));del.onclick=function(){imagenes=removeItem();$(this).parent().remove();checkNumFile()};thumb.appendChild(del);thumb.appendChild(img);thumb.appendChild(name);files.prepend(thumb)}
function allowDrop(ev){ev.preventDefault()}
function drag(ev){}
function drop(ev){ev.preventDefault();var f=ev.dataTransfer.files;$("#loading-file").fadeIn("slow");if(f&&fileNormas==null){[].forEach.call(f,previewImage)}else{}
$("#loading-file").fadeOut("slow")}
function checkNumFile(){if(fileNormas!=null){$(".btn-siguiente").text("Siguiente");$(".more").fadeOut(500)}else{$(".btn-siguiente").text("Ahora no");$(".more").fadeIn(500)}}
function removeItem(){fileNormas=null;$("#fileinput").val("");checkNumFile()}
function deleteUpload(element){deleteFromServer($(element).attr("id"),element)}
function deleteFromServer(id,element){$.ajax({type:"POST",url:"/orchard/upload/files/delete/"+id,success:function(data){if(data=="ok"){$(element).parent().remove()}
$(".more").removeAttr('hidden');$("#h1Upload").attr("hidden","hidden");$(".btn-siguiente").text("Ahora no")},error:function(){}})}
