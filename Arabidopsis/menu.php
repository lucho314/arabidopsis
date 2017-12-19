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
                <?= build_friendly_names('GESTION') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li role="presentation" class="dropdown-header"><?= build_friendly_names('Movimientos') ?></li>
                <li><a href="movimientos.php"><?= build_friendly_names('ABM') ?></a></li>
				<li><a href="movimientos_viejos.php"><?= build_friendly_names('Recibos atrasados') ?></a></li>
                <li><a href="recibos_emitidos.php"><?= build_friendly_names('Recibos_Emitidos') ?></a></li>
                <li class="divider"></li>
                <li role="presentation" class="dropdown-header"><?= build_friendly_names('Stock') ?></li>
                <li><a href="rubros.php"><?= build_friendly_names('Rubros') ?></a></li>
                <li><a href="productos.php"><?= build_friendly_names('Productos') ?></a></li>
                <li><a href="stocks.php"><?= build_friendly_names('Stock') ?></a></li>
                <li role="presentation" class="dropdown-header"><?= build_friendly_names('Proveedores') ?></li>
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=proveedors"><?= build_friendly_names('Alta_Proveedores') ?></a></li>
                <li><a href="proveedors.php"><?= build_friendly_names('Listar_Proveedores') ?></a></li>
                <li role="presentation" class="dropdown-header"><?= build_friendly_names('Colaboradores') ?></li>
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=colaboradors"><?= build_friendly_names('Alta_Colaborador') ?></a></li>
                <li><a href="colaboradors.php"><?= build_friendly_names('Listar_Colaboradores') ?></a></li>
  
            </ul>    
        </div>
    <?php endif; ?>
    <?php if (in_array('EVENTOS', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('EVENTOS') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=salons"> <?= build_friendly_names('Nuevo_salón') ?></a></li>
                <li><a href="salons.php"><?= build_friendly_names('Listar_salones') ?></a></li>
                <li class="divider"></li>
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=alojamientos"><?= build_friendly_names('Nuevo_alojamiento') ?></a></li>
                <li><a href="alojamientos.php"><?= build_friendly_names('Listar_alojamientos') ?></a></li>
                <li class="divider"></li>
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=eventos"><?= build_friendly_names('Nuevo_evento') ?></a></li>
                <li><a href="eventos.php"><?= build_friendly_names('Listar_Eventos') ?></a></li>
            </ul>    
        </div>
    <?php endif; ?>
    <?php if (in_array('MEDIOS', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('MEDIOS') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=medios"><?= build_friendly_names('Nuevo_medio') ?></a></li>
                <li><a href="medios.php"><?= build_friendly_names('Listar_medios') ?></a></li>
                <li class="divider"></li>
                <li><a href="publicidad_maestros.php"><?= build_friendly_names('Publicidad') ?></a></li>    
            </ul>    
        </div>
    <?php endif; ?>

    <?php if (in_array('VIAJES', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('VIAJES') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=viajes"><?= build_friendly_names('Nuevo_viaje') ?></a></li>
                <li><a href="viajes.php"><?= build_friendly_names('Listar_viajes') ?></a></li>
                <li class="divider"></li>
                <li><a href="viaticos_y_movilidad.php"><?= build_friendly_names('Viaticos_y_movimienos') ?></a></li>
                <li><a href="gastos_de_viaje.php"><?= build_friendly_names('Gastos') ?></a></li>
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
    <?php if (in_array('CONFIGURACIONES', $modulos)): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle"
                    data-toggle="dropdown">
                <?= build_friendly_names('CONFIGURACIONES') ?> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <li><a href="empleados.php"><?= build_friendly_names('Empleados') ?></a></li>
                <li><a href="tipo_de_alojamientos.php"><?= build_friendly_names('Tipo_de_alojamiento') ?></a></li>
                <li><a href="tipo_de_medios.php"><?= build_friendly_names('Tipo_de_medio') ?></a></li>
                <li><a href="tipo_de_difusions.php"><?= build_friendly_names('Tipo_de_difusión') ?></a></li>
                <li><a href="tipo_de_publicacions.php"><?= build_friendly_names('Tipo_de_publicación') ?></a></li>       
                <li><a href="usuarios.php"><?= build_friendly_names('Usuarios') ?></a></li>
                <li><a href="cambios.php"><?= build_friendly_names('Cambios') ?></a></li>
                 <li><a href="mensajes.php"><?= build_friendly_names('Mensaje') ?></a></li>
                 <li><a href="upload.php"><?= build_friendly_names('Mensaje') ?></a></li>
               <!-- <li><a href="modulos.php"><?= build_friendly_names('Modulos') ?></a></li> 
                <li><a href="usuario_x_modulos.php"><?= build_friendly_names('Usuarios x módulo') ?></a></li> -->
            </ul>    
        </div>    

    <?php endif ?>
</div>
