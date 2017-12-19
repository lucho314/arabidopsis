<?php
//CONECTO CON UNA BASE DE DATOS Y TRAIGO LAS LOCALIDADES
$Servidor = "localhost";
$Usuario = "arabidopsis";
$Clave = "nh6Uz~33"; 
$NombreDB = "pymeser_arabidopsis";
$link=mysql_pconnect($Servidor, $Usuario, $Clave) or die("Error al conectar a mysql");



//TOMO LOS DATOS DE LA TABLA LOCALIDAD

mysql_select_db($NombreDB) or die("Error al seleccionar base de datos");
$sql = "SELECT * FROM localidads WHERE provincia_id = 5";
$query = mysql_query($sql,$link);


while ($r = mysql_fetch_array($query)) {
$Servidor2 = "localhost";
$Usuario2 = "impulso";
$Clave2 = "Nq8iz^27"; 
$NombreDB2 = "pymeser_impulso";
$link2 = mysql_pconnect($Servidor2, $Usuario2, $Clave2) or die("Error al conectar a mysql");
mysql_select_db($NombreDB2) or die("Error al seleccionar base de datos");
    
    $sql2 = "INSERT INTO `localidads`("
            . "`id`, "
            . "`descripcion`, "
            . "`provincia_id`, "
            . "`latitud`, "
            . "`longitud`, "
            . "`admin_1`, "
            . "`cp`, "
            . "`usuario_id`, "
            . "`empresa_id`"
            . ") VALUES ("
            . "$r[0],"
            . "'$r[1]',"
            . "$r[2],"
            . "'$r[3]',"
            . "'$r[4]',"
            . "'$r[5]',"
            . "'$r[6]',"
            . "$r[7],"
            . "$r[8]"
            . ")";
    echo $sql2."<br>";
    mysql_query($sql2,$link2);
}

/*
Columna	Tipo	Comentario
id	int(11) Incremento automático	 
descripcion	varchar(45) NULL	 
provincia_id	int(11) NULL	 
latitud	varchar(45) NULL	 
longitud	varchar(45) NULL	 
admin_1	varchar(45) NULL	 
cp	varchar(45) NULL	 
usuario_id	int(11) NULL	 
empresa_id	int(11) NULL	 
*/
