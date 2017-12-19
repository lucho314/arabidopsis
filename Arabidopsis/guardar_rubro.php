<?php

include_once('../lib/connect_mysql.php');
include_once('../lib/funciones.php');

$descripcion = LimpiarXSS($_POST['rubro']);

        //Cuento el total de registro y creo el id -----------------------------------------------------
        $contar="SELECT MAX(id_rubro) FROM rubros";
        $resultado=mysql_db_query($NombreDB,$contar,$link);
        $total_registros=mysql_fetch_array($resultado); //Cuenta el total de registros de la tabla.
        $id_rubro=($total_registros[0]+1);  //al total le suma uno (este será el id)
        //----------------------------------------------------------------------------------------------


        //Guardo los datos en la fotos -----------------------------------------------------------------
        $sql = "INSERT INTO rubros VALUES ('$id_rubro','$descripcion')";
        mysql_db_query($NombreDB,$sql,$link);
        //-------------------------------------------------

        echo $id_rubro;
        echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
        echo $descripcion;
        echo "<br><br>"

?>

<font color="Red">Rubro agregado satisfactoriamente.</font>