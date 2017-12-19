<?php
$id=$_GET['id'];
include_once('html_sup_min.php');
$array_anterior= explode('/', $_SERVER['HTTP_REFERER']);
$anterior= $array_anterior[count($array_anterior)-1];
?>
<form id="editar" style="display:inline" method="post" action="movimientos.php" name="newrecord_">
<input type="hidden" value="edit" name="variablecontrolposnavegacion"></form>


<div class="form-inline" id="botonera">
    <button class="btn btn-default" id="enviar">Enviar</button>
    <button class="btn btn-danger" id='cancelar'>Cancelar</button>
</div>
<object data="imprimir_comprobante.php?apertura=pre&id=<?= $id?>" type="application/pdf" id="objeto">
    <embed src="imprimir_comprobante?apertura=pre&id=<?= $id?>" type="application/pdf" />
</object>


<?php include_once('html_inf.php'); ?>

 
<script>
    $('#cancelar').click(function(){
        <?php echo ($_REQUEST['ban']!=='ver')? 'window.opener.modificar_recibo("'.$id.'")':''?>;
        window.close();
    })
    $('#enviar').click(function(){
        window.location.href='imprimir_comprobante.php?volver=<?= $anterior?>&apertura=enviar&id=<?= $id?>';
    })
</script>


<style>
    #objeto{
        width: 80%;
        height: 500px;
    }
    #botonera{
        margin-left: 60%
    }
</style>