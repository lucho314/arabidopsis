<?php

include_once('lib/connect_mysql.php');
 $row=  mysql_query("select descripcion from paiss");
while ($row1 = mysql_fetch_row($row)) {
    echo quitar_tildes($row1[0])."<br>";
}


function quitar_tildes($cadena) {
    $cade = $cadena;
    $no = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
    $si = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
   $i=0;
    foreach ($no as $n){
       $no_permitidas[]= mb_convert_encoding($n,'ISO-8859-1', 'UTF-8');
        $permitidas[]=mb_convert_encoding($si[$i], 'ISO-8859-1','UTF-8');
        $i++;
    }
    $texto = str_replace($no_permitidas, $permitidas, $cade);
    return $texto;
}
