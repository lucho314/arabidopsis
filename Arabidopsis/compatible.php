<?php
/*
  Parametros
  
  $query = llamada a procedimiento almacenado, puede ser un string o un objeto mysqli_stmt, en caso de ser un string se prepara la nueva consulta y se cierra al finalizar el metodo, de ser un objeto mysqli_stmt simplemente se utiliza y no se cierra al finalizar
  $types = Lista de tipo de dato de los parametros recibidos por el procedimiento almacenado, si no hay parametros utilizar '' o false
  $params = Parametros para el procedimiento almacenado, si no hay parametros utilizar array() o false
  $results = Array con lista de valores devueltos por el procedimiento almacenado para crear el arreglo $results utilizado por el callback, si no hay resultados utilizar array() o false, nota: igualmente al pasar false si la consulta devuelve resultados estos se armaran en un array automaticamente con el nombre de las columnas devuelvas en el resultado
  $callback = Function que recibe la variable results con los resultados del procedimiento almacenado, se ejecuta por cada resultset devuelto, si no es necesario un callback utilizar function($results){} o false
  $mysqli = Objeto mysqli_connection, conexion a utilizar para realizar la consulta
*/
	function ExecutePreparedCallableStatement($query, $types = false, $params = false, $results = false, $callback = false, $mysqli = false){
		// Verificamos si no se especifico una conexion mysql
		if(!$mysqli){
			// Aqui necesitan actualizar por la forma en que accederan a una conexion mysql por defecto, en mi caso una variable global $mysqli = new mysqli(...)
			global $mysqli;
		}
		
		// Si el primer argumento es un mysqli_stmt utilizamos esa consulta preparada, caso contrario preparamos una nueva consulta
		$new_prepared_statement = true;
		
		if($query instanceof mysqli_stmt){
			$stmt = $query;
			$new_prepared_statement = false;
		}else if(!($stmt = $mysqli->prepare($query))){
			echo $mysqli->error;
		}
		
		// Verificamos primero si se recibio parametros para la consulta
		if($types && $params){
			// Si el parametro no es un array lo convertimos en uno
			if(!is_array($params)){
				$params = array($params);
			}
			
			// Cambiamos los parametros de manera que se puedan pasar por referencia, esto es necesario para mysqli::bind_param
			$referencedParams = array();
			foreach($params as $k => $param){
				$referencesParams[$k] = &$params[$k];
			}
			
			// Si recibimos parametros llamamos a mysqli::bind_result combinando la lista de tipo de datos con los parametros
			if(sizeof($params) > 0){
				call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $referencesParams));
			}
		}
		
		// Ejecutamos la consulta, TODO: Controlar algun posible error si la consulta no se ejecuta correctamente
		$success = $stmt->execute();
		
		if($success){
			// Si no se especifico la lista de resultados los obtenemos de los metadatos del resultado
			if(!$results){
				$result = $stmt->result_metadata();
				$info_fields = $result->fetch_fields();
				$results = array();
				foreach ($info_fields as $field){
					$results[] = $field->name;
				}
			}
		}
		
		if($results){
			// Preparamos el contenedor para recibir los resultados del procedimiento almacenado en base a la lista de resultados recibida por parametro
			$formattedResults = array();
			$valuesContainer = array();
			foreach($results as $k => $value){
				$valuesContainer[$k] = null;
				$formattedResults[$value] = &$valuesContainer[$k];
			}
		
			// Si se especifico que se recibiria resultados del procedimiento llamamos a mysqli::bind_result para enlazar los resultados
			if(sizeof($results) > 0){
				call_user_func_array(array($stmt, "bind_result"), $formattedResults);
			}
		}
		
		// Verificamos si se esta utilizando mysql native driver ya que de ser asi la forma de limpiar los result sets de estado del procedimiento almacenado es diferente y suele causar problemas
		if(function_exists('mysqli_fetch_all')){
		  // Se esta utilizando mysql native driver
			do {
				$stmt->store_result();
				while($stmt->fetch()){
				  // Ejecutamos el callback con los resultados del procedimiento almacenado como parametro
					$callback && $callback($formattedResults);
				}
				// Limpiamos los result sets para poder seguir realizando consultas con la misma conexion a mysql
			} while ($stmt->more_results() && $stmt->next_result());
		}else{
		  // No se esta utilizando mysql native driver
			$stmt->store_result();
			while($stmt->fetch()){
			  // Ejecutamos el callback con los resultados del procedimiento almacenado como parametro
				$callback && $callback($formattedResults);
			}
			// Limpiamos los result sets para poder seguir realizando consultas con la misma conexion a mysql
			$stmt->free_result();
			// Si la consulta preparada se creo en esta funcion entonces la cerramos
			if($new_prepared_statement){
				$stmt->close();
			}
			while ($mysqli->more_results()){
				$mysqli->next_result();
				$result = $mysqli->use_result();
				if ($result instanceof mysqli_result) {
					$result->free();
				}
			}
		}
		return $success;
	}
	
	// Ejemplo: 
	
	$mysqli = new mysqli($config['DB']['HOST'], $config['DB']['USR'], $config['DB']['PSW'], $config['DB']['NAME'], $config['DB']['PORT']);
	
	$pictures = array();
	$params = array($product['id'], $color);
	if(ExecutePreparedCallableStatement('CALL getProductPictures(?,?)', 'is', $params, false, function($results) use (&$pictures){
		$picture = array();
		foreach($results as $key => $value) $picture[$key] = $value;
		$pictures[] = $picture;
	})){
		// Consulta ejecutada exitosamente, ahora podemos trabajar con los datos obtenidos
		$product['pictures'] = $pictures;
	}
	
	
	// Ejemplo 2:
	$getPackagesItemsByPackageQuery = reset($CONFIG['DB'])['CONN']->prepare('CALL getPackagesItemsByPackage(?)');

	foreach($packages as &$package){
		$items = array();
		ExecutePreparedCallableStatement($getPackagesItemsByPackageQuery, 'i', $package['id'], false, function($results) use (&$items){
			$item = array();
			foreach($results as $key => $value) $item[$key] = $value;
			$items[] = $item;
		});
		$package['items'] = $items;
	}

	$service['packages'] = $packages;
	
	// Ejemplo 3:
	return ExecutePreparedCallableStatement('UPDATE product SET `status` = 0 WHERE id = ?', 'i', $product['id']);
?>