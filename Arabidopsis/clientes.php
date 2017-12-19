<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    razon_social=document.getElementById('razon_social').value;
    nombre=document.getElementById('nombre').value;
    apellido=document.getElementById('apellido').value;

    descripcion = razon_social+' - '+apellido+', '+nombre;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
 <script languaje="JavaScript">
<!--
provincias = new Array();
provincias[0] = new Array();
<?php 
$c_provincias = "SELECT id, descripcion FROM provincias ORDER BY id";
$r_c_p        = mysql_query($c_provincias);




while($a = mysql_fetch_array($r_c_p)){
$i        = $a['id'];
$des_prov = $a['descripcion'];

$provincias[$i] = $des_prov;
/*
//Localidades id
$consulta = "SELECT id, descripcion FROM localidads WHERE provincia_id = $i";
$rconsulta = mysql_query($consulta);


echo "localidadid[".$i."] = new Array(";
$total_localidades = mysql_num_rows($rconsulta);
$actual = 0;

while($b = mysql_fetch_array($rconsulta)){
    
    $actual = $actual + 1;    
    $localidad  = $b['id'];
    echo "'".$localidad."'";
    if ($actual != $total_localidades) echo ",";
    
    
}
echo ");\n";

*/

//Localidades descripcion
$consulta = "SELECT id, descripcion FROM localidads WHERE provincia_id = $i";
$rconsulta = mysql_query($consulta);


echo "provincias[".$i."] = new Array(";
$total_localidades = mysql_num_rows($rconsulta);
$actual = 0;

while($b = mysql_fetch_array($rconsulta)){
    
    $actual = $actual + 1;    
    $descripcion  = $b['descripcion'];
    echo "'".$descripcion."'";
    if ($actual != $total_localidades) echo ",";
    
    
}
echo ");\n";






}



?>

localidadid = new Array();
localidadid[0] = new Array();
<?php 
$c_provincias = "SELECT id, descripcion FROM provincias ORDER BY id";
$r_c_p        = mysql_query($c_provincias);


while($a = mysql_fetch_array($r_c_p)){
$i        = $a['id'];


//Localidades id
$consulta = "SELECT id, descripcion FROM localidads WHERE provincia_id = $i";
$rconsulta = mysql_query($consulta);


echo "localidadid[".$i."] = new Array(";
$total_localidades = mysql_num_rows($rconsulta);
$actual = 0;

while($b = mysql_fetch_array($rconsulta)){
    
    $actual = $actual + 1;    
    $localidad  = $b['id'];
    echo "'".$localidad."'";
    if ($actual != $total_localidades) echo ",";
    
    
}
echo ");\n";


}



?>


function CambiarSelect(formulario){
  var i = 0;
  var select1 = formulario['provincia_id'];
  var select2 = formulario['localidad_id'];
  var vector = provincias[select1.selectedIndex];
  var vector2 = localidadid[select1.selectedIndex];
  
  if(vector.length)select2.length=vector.length;
  while(vector[i]){
    select2.options[i].value = vector2[i];
    select2.options[i].text = vector[i];
    i++;
  }
  select2.options[0].selected = 1;
}
-->
</script> 


<?php



        $clientes = new Scaffold(
                            "editable",                                                      // si se puede editar o no la descripcion
                            "colaboradors",                                                     // Tabla a mostrar
                            3000000,                                                              // Cantidad de registros a mostrar por página   
                            array('descripcion','cuit','domicilio','email','telefono'),                                                         // Campos a mostrar en el listado
                            array(),                      // Campos a ocultar en el formulario
                            array(),                                                         // Campos relacionados
                            array(),                // Campos a ocultar del maestro en el detalle
                            array('D','E','B','N'),
                            array(),
                            '1',  
                            '',
                            400
                    );


include_once('html_inf.php');
?>