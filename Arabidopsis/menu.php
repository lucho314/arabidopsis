<?php 
$ultimo_dia=  cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
$inicio=  "01-". date("m")."-".date("Y");
$fin=  $ultimo_dia."-". date("m")."-".date("Y");


?>

<div align="center">
    <?php if (in_array('GESTION', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('MOVIMIENTOS') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
               <!-- <li role="presentation" class="dropdown-header"></li>-->
                <li><a href="movimientos.php"><?= build_friendly_names('Entrada') ?></a></li>
                <li><a href="movimientos.php"><?= build_friendly_names('Salida') ?></a></li>
				<li><a href="movimientos_viejos.php"><?= build_friendly_names('Recibos atrasados') ?></a></li>
                <li><a href="recibos_emitidos.php"><?= build_friendly_names('Recibos_Emitidos') ?></a></li>
                <li class="divider"></li>
                <li role="presentation" class="dropdown-header"><?= build_friendly_names('Reportes') ?></li>
                <li><a href="reporteFiscal.php"><?= build_friendly_names('Reporte fiscal') ?></a></li>
                 <li><a href="reporteContable.php"><?= build_friendly_names('Reporte contable') ?></a></li>
               <!-- <li><a href="rubros.php">Rubros></a></li>
                <li><a href="productos.php">Productos'</a></li>
                <li><a href="stocks.php">Stock'</a></li>
                <li role="presentation" class="dropdown-header">Proveedores</li>
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=proveedors">Alta_Proveedores></a></li>
                <li><a href="proveedors.php">Listar_Proveedores</a></li>
                <li role="presentation" class="dropdown-header">Colaboradores></li>
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=colaboradors">Alta_Colaborador></a></li>
                <li><a href="colaboradors.php">Listar_Colaboradores</a></li>-->
  
            </ul>    
        </div>
    <?php endif; ?>
    

    <?php if (in_array('REPORTES', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('REPORTES') ?>  <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li><a href="reportes_paso_1.php?tipo_de_reporte=movimientos"><?= build_friendly_names('Movimientos') ?></a></a>
                <li><a href="reporte_movimiento.php"><?= build_friendly_names('Movimientos2') ?></a></a>
                <li><a href="reportes_paso_1.php?tipo_de_reporte=medios"><?= build_friendly_names('Medios_por_localidad') ?></a></li>
                 <li><a href="reportes_paso_1.php?tipo_de_reporte=gastos_de_viajes"><?= build_friendly_names('Gastos_por_viajes') ?></a></li>
                 <li><a href="libro_diario.php?forma_pago=2&fecha_inicio=<?= $inicio?>&fecha_fin=<?= $fin?>"><?= build_friendly_names('Flujo') ?></a></li>
                <!-- <li><a href="libro_diario.php?fecha_inicio=<?= $inicio?>&fecha_fin=<?= $fin?>"><?= build_friendly_names('Libro diario') ?></a></li>-->
                  <li><a href="libro_diario2.php?fecha_inicio=<?= $inicio?>&fecha_fin=<?= $fin?>"><?= build_friendly_names('Libro diario') ?></a></li>
            </ul>    
        </div>       

    <?php endif; ?>

    <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('PERSONAS') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
             <li role="presentation" class="dropdown-header">Colaboradores</li>
                <li><a href="empleados.php"><?= build_friendly_names('Nuevo colaborador') ?></a></li>
                <li><a href="tipo_de_alojamientos.php"><?= build_friendly_names('Listado colaboradores') ?></a></li>
                 <li class="divider"></li>
                  <li role="presentation" class="dropdown-header">Proveedores</li>
                <li><a href="tipo_de_medios.php"><?= build_friendly_names('Nuevo proveedor') ?></a></li>
                <li><a href="tipo_de_difusions.php"><?= build_friendly_names('Lista proveedores') ?></a></li>
                
            </ul>    
        </div> 




    <?php if (in_array('CONFIGURACIONES', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('CONFIGURACIONES') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li><a href="usuarios.php"><?= build_friendly_names('Usuarios') ?></a></li>
                <li><a href="cambios.php"><?= build_friendly_names('Cambios') ?></a></li>
                 <li><a href="mensajes.php"><?= build_friendly_names('Mensaje') ?></a></li>
                 <li><a href="upload.php"><?= build_friendly_names('Archivos') ?></a></li>
            </ul>    
        </div>    

    <?php endif ?>
</div>
