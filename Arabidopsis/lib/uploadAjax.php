<?php
include_once('connect_mysql.php');
$output_dir = "C:\\xampp\\htdocs\\Arabidopsis\\uploads\\";

if(isset($_FILES["myfile"]))
{
	$ret = array();
	
	$error =$_FILES["myfile"]["error"];

	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 	 	$ret[]= $fileName;
 	 	echo "asd";
 	 	if(insertDb($fileName))
 	 	{
	 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
	    	
    	}
    	else{
    		$ret['error']='El archivo no se pudo cargar porque ya existe uno con ese nombre';
    	}

	}
    ///echo json_encode($ret);
 }


 function insertDb($nombre)
 {

 	if(isset($_REQUEST['visible']))
		{
			$visible=$_REQUEST['visible'];
			 $sql='SELECT * FROM archivos where nombre="'.$nombre.'"';
			 $descripcion=$_REQUEST['descripcion'];
			$query=mysql_query($sql);
			if(mysql_affected_rows()==0)
			{
				echo $sql="INSERT INTO `archivos` (`id`, `nombre`,descripcion, `usuario_alta`, `usuario_modificacion`, `fecha_alta`, `fecha_modificacion`,visible_colaborador) VALUES (NULL, '$nombre','$descripcion', '1', NULL, CURRENT_TIMESTAMP, NULL,$visible)";
				return mysql_query($sql);
				
			}
		}
		return false;
 }
 ?>