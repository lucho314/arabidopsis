
<?php
/*
 * nuevo_pais: Funcion que permite cargar en la base de datos todas las provincias y localidades
 * que pertenezcan a un pais indicada en el parametro clave.
 * Esta funcion descarga desde http://download.geonames.org/export/dump/($clave).zip un archivo en formato zip
 * luego descomprime este archivo con las funciones de la clase ZipArchive obteniendo un archivo txt cuyo nombre es
 * el que le pertenece al pais segun la iso 3166-1 almacenandolo el el directorio paises_descomprimidos.
 * Luego toma este txt y lo procesa por lineas; como cada registro esta separado por una tabulacion se toma este caracter
 * como delimitador para generar un array con los registros a incertar. Segun la documentacion de geoname en el campo n°7
 * nos encontraremos con una clave que nos permite determinar si los datos contenidos en esta line son de una provincia
 * o de una ciudad. Con una sentencia if clasificamos estos datos para generar un paquetes de consultas de inserccion de provincias
 * y localidades correspondintes.
 * 
 * @author: Luciano Zapata
 * @param string $clave clave del pais correspondiente a la iso 3166-1.
 * @param int $pais_id clave primaria del pais al cual se le van a cargar las provincias y localidades
 *  
 *  */
function nuevo_pais($clave, $pais_id) {
    $url = "http://download.geonames.org/export/dump/" . $clave . ".zip";
    echo "<h3>Archivo descagado: ".$url."</h3>";
    $path = 'paises_descomprimidos/archivo.zip';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    curl_close($ch);

    file_put_contents($path, $data);

    $zip = new ZipArchive;
    if ($zip->open('paises_descomprimidos/archivo.zip') === TRUE) {
        $zip->extractTo('paises_descomprimidos');
        $zip->close();
        echo '<h4>Base de datos actualizada correctamente</h4>';
    } else {
        echo '<h4>No se ha podido descargar el archivo de datos.</h4>';
    }
    $sql_orden = "SELECT AUTO_INCREMENT FROM information_schema.TABLES
                    WHERE TABLE_SCHEMA =  'arabidopsis'
                    AND TABLE_NAME =  'provincias'";
    $query = mysql_query($sql_orden);

    while ($r = mysql_fetch_array($query)) {
        $provincia_id = $r[0];
    }

    $fp = fopen("paises_descomprimidos/" . $clave . ".txt", "r");

    $sql = "";
    $sql_provincias = "INSERT INTO `provincias` (`id`,`descripcion`, `pais_id`, `latitud`, `longitud`,admin_1,usuario_id,empresa_id) VALUES";
    $sql_ciudades = "INSERT INTO `localidads` (`descripcion`, `provincia_id`, `latitud`, `longitud`,admin_1,usuario_id,empresa_id) VALUES ";
    while (!feof($fp)) {
        $linea = fgets($fp);
        $linea = str_replace("'", "", $linea);
        $linea = str_replace('"', "", $linea);

        $linea_array = $string = explode("\t", $linea);
        if (isset($linea_array[7])) {
            if ($linea_array[7] == "ADM1") {

                $sql_provincias.="('" . $provincia_id . "','" . $linea_array[1] . "','" . $pais_id . "','" . $linea_array[4] . "','" . $linea_array[5] . "','" . $clave . $linea_array['10'] . "',1,1),";
                $provincia_id++;
            }
            if (strpos($linea_array[7], "PPL") !== FALSE) {
                $sql_ciudades.="('" . $linea_array[1] . "','1','" . $linea_array[4] . "','" . $linea_array[5] . "','" . $clave . $linea_array['10'] . "',1,1),";
            }
        }
    }

    $sql_provincias = substr($sql_provincias, 0, -1);
    $sql_ciudades = substr($sql_ciudades, 0, -1);


    $sql_ciudades = mb_convert_encoding($sql_ciudades, "auto", "UTF-8");

    $sql_provincias = mb_convert_encoding($sql_provincias, "auto", "UTF-8");


    //echo $sql_ciudades;
    mysql_query($sql_provincias);
    mysql_query($sql_ciudades);

    actualizar($clave);
    
    //echo $sql_provincias;
}

/* 
 * Esta funcion permite modificar las claves de referencia de los registros localidades
 * se  modifican los campos de las localidades que coinicen con las provincias con el atibuto admin_1
 * cambiando el aributo provincia_id por la clave de la provincia con la cual coincidio, permitiendo de esa manera 
 * generar la conexion necesaria entre provincias y localidades
 *  @author: Luciano Zapata
 * @param string $clave clave del pais correspondiente a la iso 3166-1.
 *  */
function actualizar($clave) {
    $sql = "select id, admin_1 from provincias where admin_1 like '%$clave%'";
    //echo $sql;
    $query = mysql_query($sql);

    while ($row = mysql_fetch_array($query)) {
        $sql_2 = "update localidads set provincia_id='$row[0]' where admin_1='$row[1]'";
        //echo $sql_2;
        mysql_query($sql_2);
    }
}
?>
