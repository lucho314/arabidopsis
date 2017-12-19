<?php

include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');

	//si este es vacio no lo cargo en la DB
	$id_filtro 	= LimpiarXSS($_GET['id_filtro']);
	$id_tabla  	= LimpiarXSS($_GET['id_tabla']);
	$tabla	   	= LimpiarXSS($_GET['tabla']);
	$totalcolumnas 	= LimpiarXSS($_GET['totalcolumnas']);


        //Cuento el total de registro y creo el id -----------------------------------------------------
        $contar="SELECT MAX($id_tabla) FROM $tabla";
        $resultado=mysql_query($contar,$link);
        $total_registros=mysql_fetch_array($resultado); //Cuenta el total de registros de la tabla.
        $id_registro=($total_registros[0]+1);  //al total le suma uno (este será el id)
        //----------------------------------------------------------------------------------------------


	// ESTO ES PARA COMPLETAR LOS CAMPOS VACIOS DEL INSERT ########
	if (!empty($id_filtro))
	{
	  $principiosql = "'$id_registro','$id_filtro'";
	  $totalcolumnas = $totalcolumnas - 1;
	}
	else
	{
	  $principiosql = "'$id_registro'";
	}

	for ($i=1; $i<$totalcolumnas; $i++) {
		$completosql = $completosql.",''";
	}
	//#############################################################



        //Guardo los datos en la fotos -----------------------------------------------------------------
	//creo el insert según la cantidad de columnas

        $sql = "INSERT INTO $tabla VALUES (".$principiosql.$completosql.")";

	//echo $sql;

        mysql_query($sql,$link);
        //-------------------------------------------------

        echo $id_registro;




?>