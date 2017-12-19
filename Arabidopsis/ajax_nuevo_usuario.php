<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$funcion = $_POST['funcion'];
$funcion=$_REQUEST['funcion'];

switch ($funcion){
    case 'dato_usuario':
        $usuario=$_POST['usuario'];
        $telefono=$_POST['telefono'];
        $domicilio=$_POST['domicilio'];
        $localidad=$_POST['localidad'];
        $pass=  md5($_POST['pass']);
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $provincia=$_POST['provincia'];
        $email=$_POST['email'];
        $descripcion=$nombre." ".$apellido;
        $sql="INSERT INTO `usuarios` (`descripcion`, `usuario`, `pass`, `nivel_acceso`, `nombre`, `apellido`, `domicilio`, `localidad`,provincia, `telefono`, `email`, `usuario_id`, `empresa_id`) VALUES ('$descripcion', '$usuario', '$pass', '1', '$nombre', '$apellido', '$domicilio', '$localidad', '$provincia', '$telefono', '$email', 1, 1);";
        mysql_query($sql);
        echo mysql_insert_id();
        break;
    case 'modulos':
        break;
}

