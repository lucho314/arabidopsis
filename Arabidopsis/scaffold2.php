<?php


class Scaffold {


// configuracion
	var $db_host = '10.0.0.133';
	var $db_user = 'sigescal';
	var $db_password = '23368818';
	var $db_name = 'epregov_rpiep';

	/**
	Los siguientes arrays contienen los campos de las fk que estan relacionados con tablas que no llevan el mismo nombre.
	*/

	var $singular = array ('ente','recibe_reclamo','reclamo_sobre','forma_de_reclamo','seguimiento','subarea_origen','subarea_destino','tipo_doc_empleado','empleado_alta_reclamo');	// las fk
	var $plural = array ('ente_externos','ente_externos','ente_externos','medio_de_comunicacions','empleados','subareas','subareas','tipo_docs','empleados'); //las tabas correspondientes a las fk anteriores

	/**
	* colores de filas alternados
	*/
	var $row_odd = '#fff';
	var $row_even = '#E9FEFF';
// fin configuracion

	var $table = '';								// Variable interna para la tabla

	function Scaffold($mostrar, $table, $max_records = 100, $fields = array(), $ocultos=array(), $htmlsafe = true, $width = NULL){
		$this->mostrar = $mostrar;
		$this->table = $table;	// Seteo la tabla
		$this->max_records = intval($max_records);	// Seteo el limite de registros por tabla
		$this->fields = $fields; // Campos a mostrar
		$this->ocultos = $ocultos; // Campos a ocultar
		$this->htmlsafe = $htmlsafe;	// html seguro
		$this->width = intval($width);	//
		// Variable de pagina
		(!empty($_GET['page']) && is_numeric($_GET['page'])) ? $this->page = intval($_GET['page']) : $this->page = 1;




		$connection = mysql_connect($this->db_host,
							$this->db_user,
							$this->db_password);
		mysql_select_db($this->db_name, $connection) or die('Error al conectar a la base de datos.');

		$action = (!empty($_POST['variablecontrolposnavegacion'])) ? $_POST['variablecontrolposnavegacion'] : 'list' ;
		switch($action){
			default:
				$this->list_table();
			break;

			case 'list':
				$this->list_table();
			break;

			case 'new':
				$this->new_row();
			break;

			case 'create':
				$this->create();
			break;

			case 'edit':
				$this->edit_row();
			break;

			case 'update':
				$this->update();
			break;

			case 'delete':
				$this->delete_row();
			break;

			case 'search':
				$this->search();
			break;

		}
	}

	/**
	* Lista de registros
	*
	* string $msg 		// Mensaje opcional
	* strgin $where		// WHERE opcional como parametro para SQL
	*
	*/
	function list_table($msg = NULL, $where = null){
		$start = (($this->page-1)*$this->max_records);				// Parametros por pagina
		$end = $this->max_records;	// Fin parametros por pagina
		$page = '';
		$totalQuery = mysql_query ('SELECT COUNT(*) FROM '.$this->table.$where) or die(mysql_error());
		$totalA = mysql_fetch_array($totalQuery);
		$total = $totalA[0];

		if (!empty($this->fields)) {
		// Muestra los campos seleccionados solamente
			$query = 'SELECT id';
			foreach($this->fields as $val){
				$query .= ', '.$val;
			}
			$query .= ' FROM '.$this->table;
		}else{
			$query = 'SELECT * FROM '.$this->table;
		}

		if(!empty($where)){ $query .= $where; }
		$query = $query.' LIMIT '.$start.', '.$end;
		$select = mysql_query($query) or die(mysql_error());
		$i = 0;


		(!empty($this->width)) ? $width = ' width="'.$this->width.'"' : $width = NULL;

		$this->build_search_bar();
		echo $total.' Registro/s encontrado/s. Secci&oacute;n: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong>. | '
			. '<form name="newrecord" id="newrecord" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline"><input type="hidden" name="variablecontrolposnavegacion" value="new"><a href="javascript:document.newrecord.submit()">Registro nuevo</a></form><br /><br />';
		if(!empty($msg)) { echo $msg; }
		$this->paginate($total, $this->page);
		$page .= '<table cellpadding="2" cellspacing="0" border="0"'.$width.'">';
		$page .= '<tr>';
		while($i < mysql_num_fields($select)){
			$column = mysql_fetch_field($select, $i);
			if($column->name != 'id' && $column->name != 'updated_at' && $column->name != 'created_at'){
				$page .= '<th nowrap>'.$this->build_friendly_names($column->name).'</th>';

			}
			$i++;
		}
		$page .= '</tr>';

		$count = 0;
		while($array = mysql_fetch_array($select)){
			$page .= (!($count % 2) == 0) ? '<tr style="background:'.$this->row_even.';">' : '<tr style="background:'.$this->row_odd.';">';
			foreach($array as $column => $value){
				if(!is_int($column) && $column != 'id' && $column != 'updated_at' && $column != 'created_at'){
					$page .= '<td>';
					if($column == 'foto') {
						$page .= '<img width="30" height="30" src="'.$value.'">';

					}else{
					if($this->htmlsafe) {
						if(substr($column, -3) == '_id'){

						$page .= $this->build_foreign_key_title($column,$value);
						}
						else $page .= htmlentities($value);
					}else{
						if(substr($column, -3) == '_id'){
						$page .= $this->build_foreign_key_title($column.$value);}
						else
						$page .= $value;
					}
					}
					$page .= '</td>';
				}
			}
			$count ++;
			$page .= '<td><form name="edit_'.$array[0].'" id="edit_'.$array[0].'" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline"><input type="hidden" name="variablecontrolposnavegacion" value="edit"><input type="hidden" name="id" value="'.$array[0].'"><a href="javascript:document.edit_'.$array[0].'.submit()">Editar</a></form></td>
				<td>
				<form name="delete_'.$array[0].'" id="delete_'.$array[0].'" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline"><input type="hidden" name="variablecontrolposnavegacion" value="delete"><input type="hidden" name="id" value="'.$array[0].'"><a href="javascript:" onClick="if (confirm(\'Est&aacute; seguro?\')){document.delete_'.$array[0].'.submit();}else{return false;}">Borrar</a></form></td>';
			$page .= '</tr>';
		}

		$page .= "</table>";
		echo $page;
		$this->paginate($total);


		}










	/**
	* Este metodo crea el formulario para un nuevo registro
	*
	*/
	function new_row(){
		$page = '';
		$selectFields = mysql_query('SELECT * FROM '.$this->table);
		$i = 0;
		echo '<h2>Formulario de carga de datos: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong></h2><br>';
		$page .= '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="crear" id="crear" enctype="multipart/form-data">'
				. '<input type="hidden" name="variablecontrolposnavegacion" value="create">'
				. '<table cellpadding="2" cellspacing="0" border="0" width="700">';
		$counthidden = 0;
		$totalhidden = count($this->ocultos);
		while($i < mysql_num_fields($selectFields)){
			$column = mysql_fetch_field($selectFields);
			if($column->name != 'id'){
				if (strpos($column->name, "fecha") !== false) { $clase = ':date_au :required';	}
				else { $clase = ':required'; }
				$page .= '<tr>';
				// revisa las claves foraneas..
				if(substr($column->name, -3) == '_id'){
					$page .= $this->build_foreign_key_dropdowns_auto($column->name);
				}elseif(($counthidden <= $totalhidden-1) AND ($this->ocultos[$counthidden] == $column->name)){
					$variable = $this->ocultos[$counthidden];
					$page .= '<input type="hidden"  name="'.$variable.'" id="'.$variable.'" />';
					$counthidden = $counthidden + 1;
				}elseif($column->blob == 1){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><textarea name="'.$column->name.'" id="'.$column->name.'" rows="5" cols="40"></textarea></td>';
				}elseif($column->type == 'timestamp'){
					$page .= '<input type="hidden" name="'.$column->name.'" id="'.$column->name.'" />';
				}elseif($column->type == 'date'){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><input type="text" class="calendario" name="'.$column->name.'" id="'.$column->name.'" /></td>';
				}elseif($column->type == 'time'){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><input type="text" name="'.$column->name.'" id="'.$column->name.'" class="timepickr" /></td>';
				}elseif($column->name == 'descripcion'){
					if($this->mostrar=='editable'){
					$page .= '<td width="200" align="right" ><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><input class="'.$clase.'" type="text" name="'.$column->name.'" id="'.$column->name.'" />';
					}else{
					$page .= '<input type="hidden" name="'.$column->name.'" id="'.$column->name.'" />';
					}
				}elseif($column->name == 'fecha_y_hora'){
					$page .= '<input type="hidden" name="'.$column->name.'" id="'.$column->name.'" />';
				}else{
					$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><input class="'.$clase.'" type="text" name="'.$column->name.'" id="'.$column->name.'" value="" size="35" /></td>';
				}
			}
			$i++;
		}
		$page .= '<tr><td>&nbsp;</td><td><input type="submit" value="Agregar registro"  onClick="javascript:creardescripcion();" /></td></tr>'
		 		. '</table>'
		 		. '</form>'
		 		. '<a href="'.$_SERVER['PHP_SELF'].'">Volver al listado</a>';
		echo $page;
	}



	/**
	* Este metodo inserta un nuevo registro
	* Asume que en la base de datos no hay un campo llamado 'variablecontrolposnavegacion'
	*
	*
	*/
	function create(){
		$select = mysql_query('SELECT * FROM '.$this->table);
		$insert = 'INSERT INTO '.$this->table.' VALUES(\'\', ';
		$i = mysql_num_fields($select);
		$i--;
		foreach($_POST as $key => $value){

			if($key != 'variablecontrolposnavegacion'){
				($key == 'updated_at' || $key == 'created_at')? $value = 'NOW()' : (get_magic_quotes_gpc) ? $value =  "'".mysql_real_escape_string(stripslashes($value))."'" : $value = "'".mysql_real_escape_string($value)."'";
				$i--;
				if($i > 0){
					$insert .= strtoupper($value).", ";
				}
			}
		}
		$insert .= strtoupper($value).')';
		echo $insert;
		mysql_query($insert) or die(mysql_error());
		$last_idq = mysql_query('SELECT LAST_INSERT_ID()')or die(mysql_error());
		$last_id = mysql_fetch_array($last_idq);
		$this->list_table('<div style="color:#090;"><p>Registro guardado..</p></div>');
	}

	/**
	* Este metodo construye el formulario para editar registros
	*
	*/
	function edit_row(){
		$page = '';
		$fields = mysql_query('SELECT * FROM '.$this->table) or die(mysql_error());
		$select = mysql_query('SELECT * FROM '.$this->table.' WHERE id = '.intval($_POST['id']));
		$row = mysql_fetch_row($select);
		$i = 0;
		echo '<h2>Formulario de carga de datos: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong></h2><br>';
		$page .= '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="crear" enctype="multipart/form-data">'
				. '<input type="hidden" name="variablecontrolposnavegacion" value="update">'
		 		. '<table cellpadding="2" cellspacing="0" border="0" width="700">';
		while($i < mysql_num_fields($fields)){
			$field = mysql_fetch_field($fields);
			if($field->name != 'id'){
				if (strpos($field->name, "fecha") !== false) { $clase = ':date_au :required';	}
				else { $clase = ':required'; }
				$page .= '<tr>';
				// reviso las claves foraneas..
				if(substr($field->name, -3) == '_id'){
					$page .= $this->build_foreign_key_dropdowns($field->name, $row[$i]);
				}elseif($field->blob == 1){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td> <textarea class="'.$clase.'" name="'.$field->name.'" id="'.$field->name.'" rows="5" cols="40">'.$row[$i].'</textarea></td>';
				}elseif($field->type == 'timestamp'){
					$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'</td>';
				}elseif($column->type == 'date'){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><input type="text" class="calendario" name="'.$column->name.'" id="'.$column->name.'" /></td>';
				}elseif($column->type == 'time'){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td><input type="text" name="'.$column->name.'" id="'.$column->name.'" class="timepickr" /></td>';
				}elseif($field->name == 'descripcion'){
					if($this->mostrar=='editable'){
					$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td><input class="'.$clase.'" class=":required" type="text" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" />';
					}else{
					$page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" />';
					}
				}else{
					$page .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td> <input class="'.$clase.'" class=":required"  type="text" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" size="35" /></td>';
				}

			}else{
				$page .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'<input type="hidden" name="id" value="'.$row[$i].'"></td>';
			}
			$i++;
			$page .= '</tr>';
		}
		$page .= '<tr><td>&nbsp;</td><td><input type="submit" value="Editar registro" onClick="javascript:creardescripcion();" /></td></tr>'
				 . '</table>'
				 . '</form>'
				 . '<a href="'.$_SERVER['PHP_SELF'].'">Volver al listado</a>';

		echo $page;
	}

	/**
	* This method updates the record
	*
	*/
	function update(){
		$select = mysql_query('SELECT * FROM '.$this->table.' WHERE id = '.intval($_POST['id']));
		$num = mysql_num_fields($select);
		$update = 'UPDATE '.$this->table.' SET ';
		$i = 1;
		$comma = '';
		while($i <= $num){
			$column = mysql_fetch_field($select);
			if($column->name != 'id' && $column->name != 'created_at' && $column->name != 'updated_at'){
					$update .= $comma.$column->name.' = ';
					$update .= (get_magic_quotes_gpc) ? '\''.mysql_real_escape_string(stripslashes($_POST["$column->name"])).'\'' : '\''.mysql_real_escape_string($_POST["$column->name"]).'\'';
					$comma =', ';
			}
			$i++;
		}
		$update .= '  WHERE id = '.intval($_POST['id']);
		mysql_query($update) or die(mysql_error());
		$this->list_table('<div style="color:#090;"><p>Registro modificado..</p></div>');
	}

	/**
	* Este metodo borra un registro
	*
	*/
	function delete_row(){
		mysql_query('DELETE FROM '.$this->table.' WHERE id = '.$_POST['id']) or die(mysql_error());
		$this->list_table('<div style="color:#900;"><p>Registro borrado..</p></div>');
	}

	/**
	* Construye una busqueda para ser pasada a list_table
	*
	*/
	function search(){
		if(!empty($_POST['searchterm'])){
			// Seguridad
			$searchterm = (get_magic_quotes_gpc) ? '\''.mysql_real_escape_string(stripslashes($_POST['searchterm'])).'\'' : '\''.mysql_real_escape_string($_POST['searchterm']).'\'';

			$field = (get_magic_quotes_gpc) ? '\''.mysql_real_escape_string(stripslashes($_POST['field'])).'\'' : '\''.mysql_real_escape_string($_POST['field']).'\'';
			switch ($_POST['compare']){
				default:
					$compare = '1';
					$compare = NULL;
					$searchterm = NULL;
					break;
				case '=':
					$compare = ' = ';
					break;
				case '>':
					$compare = ' > ';
					break;
				case '<':
					$compare = ' < ';
					break;
				case 'LIKE':
					$compare = ' LIKE ';
					$searchterm = (get_magic_quotes_gpc) ? "'%".mysql_real_escape_string(stripslashes($_POST["searchterm"]))."%'" : "'%".mysql_real_escape_string($_POST["searchterm"])."%'";
					break;

			}
			$where = ' WHERE '.$_POST['field'].$compare.$searchterm;
		}else{
			$where = NULL;
		}
		$this->list_table('<div style="color:#090">Resultados de la b&uacute;squeda..</div>',$where);

	}


	/**
	* Genera selects estáticos. Este se usa en el "editar fila"
	* **IMPORTANTE:**
	* Los nombres de las tablas deben terminar en s, las fk deben terminar en
	* _id y las tablas de las fk deben tener un campo 'descripcion'
	* Si ademas tienen un campo 'detalle', este es usado como title del
	* option
	*
	* string $field				// campo fk
	* string $value				// valor
	*/
	function build_foreign_key_dropdowns($field, $value = null) {
		// revisa las relaciones
		$match = FALSE;
		$dd = '';
		for($i=0; $i<count($this->singular); $i++){
			$match = preg_match('/^'.$this->singular[$i].'$/', substr($field, 0, -3));
			if($match){break;}
		}
		if($match){
			$foreignTable = str_replace($this->singular, $this->plural, substr($field, 0, -3));
		}else{
			// corta _id y pluraliza el nombre
			$foreignTable = substr($field, 0, -3);
			(substr($foreignTable, -1) != 'y') ? $foreignTable .= 's' : $foreignTable = substr($foreignTable, 0, -1).'ies';
		}
		$select = mysql_query('SELECT * FROM '.$foreignTable) or die(mysql_error());
		$foreign = mysql_fetch_assoc($select);
		$dd .= '<td align="right" ><strong>'.$this->build_friendly_names(substr($field, 0, -3)).'</strong></td><td>'
		. '<select name="'.$field.'">';
		do{
			$dd .= "<option title=\"".$foreign['detalle']."\"   value='".$foreign['id']."'";
			if ($foreign['id'] == $value){ $dd .= ' selected';}
			if (!empty($foreign['descripcion'])){
				$dd .= '>'.$foreign['descripcion'].'</option>';
			}else{
				$dd .= '>'.$foreign['id'].'</option>';
			}
		}while($foreign = mysql_fetch_assoc($select));
		$dd .= '</td>';
		return $dd;
	}



	/**
	* Genera los SELECT dinamicos. Dependen de la cantidad de datos de la
	* tabla
	* **IMPORTANTE:**
	* Los nombres de las tablas deben terminar en s, las fk deben terminar en
	* _id y las tablas de las fk deben tener un campo 'descripcion'
	* Si ademas tienen un campo 'detalle', este es usado como title del
	* option
	*
	* string $field				// campo fk
	* string $value				// valor
	*/
	function build_foreign_key_dropdowns_auto($field, $value = null) {
		// revisa las relaciones
		$match = FALSE;
		$dd = '';
		for($i=0; $i<count($this->singular); $i++){
			$match = preg_match('/^'.$this->singular[$i].'$/', substr($field, 0, -3));
			if($match){break;}
		}
		if($match){
			$foreignTable = str_replace($this->singular, $this->plural, substr($field, 0, -3));
		}else{
			// corta _id y pluraliza el nombre
			$foreignTable = substr($field, 0, -3);
			(substr($foreignTable, -1) != 'y') ? $foreignTable .= 's' : $foreignTable = substr($foreignTable, 0, -1).'ies';
		}
		$select = mysql_query('SELECT * FROM '.$foreignTable) or die(mysql_error());
		$foreign = mysql_fetch_assoc($select);
		$totalrows = mysql_num_rows($select);
		if ($totalrows>=30) {
		$dd .= '<script type="text/javascript">
		$(function()
		{
			// Updated script
			var categories = $.map($("#s'.$field.' option"),function(e, i)
			{
			return e;
			});

			$("#my'.$field.'").autocomplete(categories,
			{
			matchContains : true,
			formatItem : function(item) { return item.text; }
			});
			// Added to fill hidden field with option value
			$("#my'.$field.'").result(function(event, item, formatted)
			{
			$("#'.$field.'").val(item.value);
			}
		)});
		</script>';
		$dd .= '<td align="right" ><strong>'.$this->build_friendly_names(substr($field, 0, -3)).'</strong></td><td>
		<input type="text" id="'.$field.'" name="'.$field.'" size="1" readonly="true"></input><input type="text" id="my'.$field.'" class=":required" size="31" title="Cantidad de registros: '.$totalrows.'"></input>'.'<select id="s'.$field.'" style="display: none">';

		do{
			$dd .= "<option title=\"".$foreign['detalle']."\"   value='".$foreign['id']."'";
			if ($foreign['id'] == $value){ $dd .= ' selected';}
			if (!empty($foreign['descripcion'])){
				$dd .= '>'.$foreign['descripcion'].'</option>';
			}else{
				$dd .= '>'.$foreign['id'].'</option>';
			}
		}while($foreign = mysql_fetch_assoc($select));
		$dd .= '</td>';
		return $dd;
		}else{  //Este else es del if para los select dinamicos
		$dd .= '<td align="right" ><strong>'.$this->build_friendly_names(substr($field, 0, -3)).'</strong></td><td>'
		. '<select name="'.$field.'">';
		do{
			$dd .= "<option title=\"".$foreign['detalle']."\"   value='".$foreign['id']."'";
			if ($foreign['id'] == $value){ $dd .= ' selected';}
			if (!empty($foreign['descripcion'])){
				$dd .= '>'.$foreign['descripcion'].'</option>';
			}else{
				$dd .= '>'.$foreign['id'].'</option>';
			}
		}while($foreign = mysql_fetch_assoc($select));
		$dd .= '</td>';
		return $dd;


		}
	}




	/**
	* **IMPORTANTE:**
	* Los nombres de las tablas deben terminar en s, las fk deben terminar en
	* _id y las tablas de las fk deben tener un campo 'descripcion'
	*
	* string $field				// campo fk
	* string $value				// valor
	*/
	function build_foreign_key_title($field, $value) {
		// revisa las relaciones
		$match = FALSE;
		$dd = '';
		for($i=0; $i<count($this->singular); $i++){
			$match = preg_match('/^'.$this->singular[$i].'$/', substr($field, 0, -3));
			if($match){break;}
		}
		if($match){
			$foreignTable = str_replace($this->singular, $this->plural, substr($field, 0, -3));
		}else{
			// corta _id y pluraliza el nombre
			$foreignTable = substr($field, 0, -3);
			(substr($foreignTable, -1) != 'y') ? $foreignTable .= 's' : $foreignTable = substr($foreignTable, 0, -1).'ies';
		}
		$select = mysql_query("SELECT id, descripcion FROM $foreignTable WHERE id=$value") or die(mysql_error());
		$foreign = mysql_fetch_assoc($select);
		if (!empty($foreign['descripcion'])){
				$dd .= $foreign['descripcion'].' - '.$foreign['id'];
		}else{
				$dd .= $foreign['id'];
		}
		while($foreign = mysql_fetch_assoc($select));
		return $dd;
	}




	/**
	* Paginacion
	*
	* int $total 	// Numero total de filas de la tabla
	*
	*/
	function paginate($total = 1) {
		// paginacion
		if($total>$this->max_records){
		// Construye los links del recordset
		$num_pages = ceil($total / $this->max_records);
		$nav = '';

		// Link a la pagina previa si es necesario
		if($this->page > 1)
		$nav .= '<a href="'.$_SERVER['PHP_SELF'].'?page=' . ($this->page-1) . '">&lt;&lt; Anterior</a> |';

		for($i = 1; $i < $num_pages+1; $i++)
		{
		if($this->page == $i)
		{
		  //
		  $nav .= ' <strong>'.$i.'</strong> |';
		}
		else
		{
		  // Link a la pagina
		  $nav .= ' <a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> |';
		}
		}

		// Link a la pagina siguiente si es necesario
		if($this->page < $num_pages)
		$nav .= ' <a href="'.$_SERVER['PHP_SELF'].'?page=' . ($this->page+1) . '">Siguiente &gt;&gt;</a>';

		// Dibuja un pipe entre los numeros de pagina
		$nav = preg_replace('@|$@', "", $nav);
		echo $nav;
		}
	}

	/**
	* Barra de busqueda
	*
	*/
	function build_search_bar() {
		// Campos del menu
		$fielddropdown = '<select name="field">';
		$fieldselect = mysql_query('SHOW FIELDS FROM '.$this->table);
		while($fields = mysql_fetch_assoc($fieldselect)){
			$fielddropdown .= '<option value="'.$fields['Field'].'">'.$this->build_friendly_names($fields['Field']).'</option>';
		}
		$fielddropdown .= '</select>';
		$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : '' ;
		$search = '';
		$search .=  '<form name="searchbar" id="searchbar" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline;"><input type="hidden" name="variablecontrolposnavegacion" value="search">'
				. $fielddropdown
				. '<select name="compare">'
				. '<option value="=">Es igual a</option>'
				. '<option value="LIKE">Contiene</option>'
				. '<option value="<">Es menor que</option>'
				. '<option value=">">Es mayor que</option>'
				. '</select>'
				. '<input type="text" name="searchterm" value ="'.$searchterm.'">'
				. '<input type="submit" name="Search" value="Buscar" />'
				. '</form><br /><br />';

		echo $search;

	}


	/**
	* Transforma los nombres de los campos en amistosos
	* Esto lo hace reemplazando el guion bajo por espacio y poniendo la primer
	* letra de cada palabra en mayusculas
	* string $field 	// pass the field name
	*
	*/
	function build_friendly_names($field) {
		return ucwords(str_replace('_', ' ', $field));
	}


	/**
	* Transforma una imagen en un dato blob para subirlo a la db
	*
	*/

	function image_transform_blob ($image) {

  		$mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
  		$name = $_FILES["$image"]["name"];
  		$type = $_FILES["$image"]["type"];
  		$tmp_name = $_FILES["$image"]["tmp_name"];
  		$size = $_FILES["$image"]["size"];

  		//Verifico si la imagen es valida
  		if(!in_array($type, $mimetypes))
    		die("El archivo no es una imagen válida");

		//Tomo la foto
		$fp = fopen($tmp_name, "rb");
  		$tfoto = fread($fp, filesize($tmp_name));
  		$tfoto = addslashes($tfoto);
  		fclose($fp);

		  // Borra archivos temporales si es que existen
		@unlink($tmp_name);

		return($tfoto);
	}


}
