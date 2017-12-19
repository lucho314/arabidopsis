<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

$provincia_id = htmlentities($_POST['provincia_id']);
$variablecontrol = $_POST['variablecontrolposnavegacion'];
if (!empty($variablecontrol)) {
    if (($variablecontrol != "list")) {
        if (empty($provincia_id)) {
            $evento_id = $_POST['id'];
            $localidad_id = DevuelveValor($evento_id, 'localidad_id', 'colaboradors', 'id');
            $provincia_id = DevuelveValor($localidad_id, 'provincia_id', 'localidads', 'id');
            $_POST['provincia_id'] = $provincia_id;

            //echo "Provincia: " . $provincia_id;
        }
    }
}

$clientes = new Scaffold(
        "noeditable", // si se puede editar o no la descripcion
        "colaboradors", // Tabla a mostrar
        3000000, // Cantidad de registros a mostrar por página   
        array('descripcion', 'cuit', 'domicilio', 'email', 'telefono'), // Campos a mostrar en el listado
        array(), // Campos a ocultar en el formulario
        array(), // Campos relacionados
        array(), // Campos a ocultar del maestro en el detalle
        array('D', 'E', 'B'), array(), array('localidad_id'), // Campos a ocultar del maestro en el detalle
        array('provincia_id'), '1', '', 400
);




include_once('html_inf.php');
?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nuevo usuario generado</h4>
      </div>
      <div class="modal-body">
        <p><b>Usuario:</b> <span id="usuario"></span></p>
        <p><b>contraseña:</b> <span id="pass"></span></p>
        <br>
        <br>
        <p>Envie esta informacion al sr/sra: <span id="colaborador" style="font-weight:bold;"></span></p>
        <p>Email:<span id="email" style="font-weight:bold;></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<script>
    $('.tabla_localidad_id').eq(1).append("<a href='#' class='btn btn-default' id='modificar_pais'> Cambiar pais<a>");
    $('#modificar_pais').click(function () {

        window.open("formulario_modificar_ciudad.php", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=600");
    })
    modificar='modificar';
$('#lista').DataTable({

        "columnDefs": [
                    {
                    
                        "render": function ( data, type, row ) {
                            var email=$(row[3]).text();
                             return "<div class='form-inline' style='width: 106px;'>"+data+'<button style="margin-left: 18px" class="btn btn-default user" _data="'+email+'" title="Generar usuario"><i class="glyphicon glyphicon-user"></i><a/></div>';
                        },
                        "targets": 7
                    }
          ]

});


$(".user").click(function(){

var email=$(this).attr("_data");

$.get('generar_usuarioAjax.php',{'email':email},function(data){

    if(data.accion)
    {
            $('#usuario').text(data.email);
            $('#pass').text(data.pass);
            $('#colaborador').text(data.colaborador);
            $('#email').text(data.email);
            $('#myModal').modal({ backdrop: 'static', keyboard: false }, 'toggle')

    }


},'json');


})


</script>