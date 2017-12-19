<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");
?>
<script type="text/javascript">
jQuery(document).ready(function() 
    { 
        $('#lista').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        
       
       "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            }
    });
    
        /*$("#lista").tablesorter({
        }); */
    } 
); 
</script>
<?php
new Scaffold(
        "editable",
        "provincias",
        10000,
        array('descripcion','pais_id','latitud','longitud'),
        array('empresa_id'),               // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array(),
        array(),
        array(),                                                          // Campos a ocultar del maestro en el detalle
        array(),          
	'0',
	'1'
        );
include_once('html_inf.php');
?>