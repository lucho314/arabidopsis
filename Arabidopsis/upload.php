
<?php

include_once('html_sup.php');
?>


<link href="css/uploadfile.css" rel="stylesheet">
<script src="js/jquery.uploadfile.min.js"></script>
<script src="js/jquery.form.js"></script>

<style type="text/css">
	.ajax-file-upload-filename{
		float: left;
	}
	
	.ajax-file-upload-statusbar{
		margin-right: 39%;
		text-align: left;
		font-weight: bold;
	}
</style>
<div id="botones" style="margin-right: 72%">
	<button class="btn btn-success" onclick="cagargar()" id="btn-cargar">Cargar archivos</button>
	<button class="btn btn-default" onclick="listado()" id="btn-listado">Lista de archivos</button>
</div>
<div id="cargar_archivo">
<div class="panel panel-primary">
	
	      <div class="panel-heading">Carga de archivos</div>
	      <div class="panel-body">
	      	<div id="archivos">
			<div id="mulitplefileuploader">Subir</div>

			<div id="status"></div>
		</div>
			<div id="startbutton" class="ajax-file-upload-green">Comenzar subida</div>
			<button id="limpiarCargas">Limpiar cargas</button>
	      </div>
      </div>
     
    </div>

 <div id="listado_archivo" style="display: none">
      	<?php include 'archivos_lista.php' ?>
      </div>
<script>

$(document).ready(function()
{

var settings = {
	url: "uploadAjax.php",
	method: "POST",
	allowedTypes:"jpg,png,gif,doc,pdf,zip,txt",
	fileName: "myfile",
	multiple: true,
	autoSubmit:false,
	dragDropStr: "<span><b>Seleccione o arrastre archivos</b></span>",
    abortStr:"abandonner",
	cancelStr:"cancelar",
	doneStr:"fait",
	multiDragErrorStr: "Plusieurs Drag &amp; Drop de fichiers ne sont pas autorisés.",
	extErrorStr:"archivo invalido, no es una extención autorizada:",
	sizeErrorStr:"exede el tamaño permitido. Admis taille max:",
	uploadErrorStr:"Upload n'est pas autorisé",
	uploadStr:"Seleccionar",

	dragdropWidth:800,
	statusBarWidth: 446,


	onSuccess:function(files,data,xhr)
	{
		console.log(xhr);
		$("#status").html("<font color='green'>Upload is success</font>");
		
	},
	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload is Failed</font>");
	},
	extraHTML:function(files,data,xhr)
    {
    	console.log(files);
            var html = "<label><input type='checkbox' name='visible' class='visible' value='0'>Visible</label><textarea class='form-control' name='descripcion' placeholder='Agregue una descripcion del archivo'></textarea>";
            return html;            
    },
    onSuccess:function(files,data,xhr,pd)
	{
	   	data=JSON.parse(data);
	   	if(typeof data.error != 'undefined')
	   	{
		    $(pd.progressbar[0]).css('background','red');
		    $(pd.statusbar[0]).append('<div><span style="color:red;font-size: 12px;">'+data.error+'<span></div>');
	    }
	},
	onLoad:function(files,data,xhr){
		console.log("hola");
	}
}
var uploadObj =$("#mulitplefileuploader").uploadFile(settings);
$("#startbutton").click(function()
	{
		uploadObj.startUpload();
		
	});



});
	$('html').on('change','.visible',function(){
		$(this).val(+$(this).is(':checked'));
	})

	$("#limpiarCargas").click(function(){
		$('.ajax-file-upload-container').html('');
	})


$('.btn').click(function(){

	$('.btn btn-success').removeClass('btn-success').addClass('btn-default')
	$(this).addClass('.btn btn-success');
})

function cagargar(){
	$("#btn-listado").removeClass('btn-success').addClass("btn-default");
	$('#btn-cargar').removeClass('btn-default').addClass('btn-success');
	$("#cargar_archivo").show();
	$("#listado_archivo").hide();


}

function listado(){
	$("#btn-cargar").removeClass('btn-success').addClass("btn-default");
	$("#btn-listado").removeClass('btn-default').addClass('btn-success');
	$("#listado_archivo").show();
	$("#cargar_archivo").hide();
	table.ajax.reload();
}


</script>


<?php
include 'html_inf.php';

?>