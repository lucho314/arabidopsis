<?php

include_once('../lib/connect_mysql.php');
include_once('../lib/funciones.php');

$id_empresa = LimpiarXSS($_GET['id_empresa']);

    $sql = "DELETE FROM 'empresas' WHERE 'id_empresa'= $id_empresa";
    mysql_db_query($NombreDB,$sql,$link);

?>