<?php

include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$funcion = $_POST['funcion'];

switch ($funcion) {
    case 'dato_usuario':
        $usuario = $_POST['usuario'];
        $telefono = $_POST['telefono'];
        $domicilio = $_POST['domicilio'];
        $localidad = $_POST['localidad'];
        $pass = md5($_POST['pass']);
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $provincia = $_POST['provincia'];
        $email = $_POST['email'];
        $descripcion = $nombre . " " . $apellido;
        $sql = "INSERT INTO `usuarios` (activo, `descripcion`, `usuario`, `pass`, `nivel_acceso`, `nombre`, `apellido`, `domicilio`, `localidad`,provincia, `telefono`, `email`, `usuario_id`, `empresa_id`) VALUES (1,'$descripcion', '$usuario', '$pass', '1', '$nombre', '$apellido', '$domicilio', '$localidad', '$provincia', '$telefono', '$email', 1, 1);";
        mysql_query($sql);
        echo mysql_insert_id();
        break;
    case 'editar':
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $telefono = $_POST['telefono'];
        $domicilio = $_POST['domicilio'];
        $localidad = $_POST['localidad'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $provincia = $_POST['provincia'];
        $email = $_POST['email'];
        $descripcion = $nombre . " " . $apellido;
       echo $sql = "UPDATE `usuarios` SET `descripcion` = '$descripcion', `usuario` = '$usuario', `nombre` = '$nombre', `apellido` = '$apellido', `domicilio` = '$domicilio', `localidad` = '$localidad', `provincia` = '$provincia', `telefono` = '$telefono', `email` = '$email' WHERE `usuarios`.`id` =$id";
        mysql_query($sql);
        break;
    case 'checkUsuarioColaborador':
        $cuit=$_POST['cuit'];
        $sql="SELECT email FROM colaboradors WHERE cuit = '$cuit'";
        $result= mysql_query($sql);
        echo json_encode(mysql_fetch_array($result));
        break;
    case 'checkUsuarioExistente':
     $sql="SELECT * from usuarios where usuario='".$_POST['usuario']."' or  descripcion like '%".$_POST['cuit']."'";
        $result= mysql_query($sql);
        echo json_encode(mysql_fetch_array($result));
        break;


}

