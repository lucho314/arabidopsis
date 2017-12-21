<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup.php');
include("scaffold.php");

echo $msg;
$bandera = 0;
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  

<!--Una tabla por menú con restricción de acceso según el nivel de usuario.-->
<?php if (in_array('GESTION', $modulos)): $bandera++; ?>

    <div class="panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><strong><?= build_friendly_names('Movimientos') ?></strong></h3>
        </div>
        <div class="panel-body">
            <table align="center" class="table table-responsive">
                <tr>
                    <td align="center"> 
                        <div class="btn-group">
                        <form id="movimientos" style="display:inline" method="post" action="movimientos.php" name="newrecord_">
                                    <input type="hidden" value="new" name="variablecontrolposnavegacion"></form>
                            <button type="button" onclick="javascript:$('#movimientos').submit()" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff">        
                                <span style="font-size: 40px;" class="fa fa-plus" aria-hidden="true"></span>
                                <?= build_friendly_names('Entrada') ?>  &nbsp</span>
                                </font>
                            </button>
                           
                        </div>
                    </td>
                      <td align="center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary btn-lg dropdown-toggle" href="salidas.php" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff">        
                                <span style="font-size: 40px;"  class="fa fa-minus" aria-hidden="true"></span>
                                <?= build_friendly_names('Salida') ?> &nbsp<span></span>
                                </font>
                            </a>
                            
                        </div>
                    </td>
                    <td align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff"> 
                                <span class="fa-stack fa-lg" tyle="font-size: 40px;"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-list-ul fa-stack-1x"></i></span>       
                                <?= build_friendly_names('Reportes') ?> &nbsp<span class="caret"></span>
                                </font>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="reporteFiscal.php"><?= build_friendly_names('Reporte fiscal') ?></a></li>
                                <li><a href="reporteContable.php"><?= build_friendly_names('Reporte contable') ?></a></li>
                            </ul>
                        </div>
                    </td>
                    </tr>
                    </table>
                    </div>
                    </div>
    <div class="panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><strong><?= build_friendly_names('Personas') ?></strong></h3>
        </div>
        <div class="panel-body">
            <table align="center" class="table table-responsive">
                <tr>
                   
                    <td align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff">        
                                <span style="font-size: 40px;" class="glyphicon glyphicon-user"></span>
                                <?= build_friendly_names('Colaboradores') ?>  &nbsp<span class="caret"></span>
                                </font>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=colaboradors"><?= build_friendly_names('Alta') ?></a></li>
                                <li><a href="colaboradors.php"><?= build_friendly_names('Listado') ?></a></li>
                            </ul>
                        </div>
                    </td>
                     <td align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff">        
                                <span style="font-size: 40px;" class="fa fa-5x fa-shopping-cart"></span>
                                <?= build_friendly_names('Proveedores') ?>  &nbsp<span class="caret"></span>
                                </font>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="formulario_ciudad_paso_1.php?tabla_scaffold=proveedors"><?= build_friendly_names('Alta') ?></a></li>
                                <li><a href="proveedors.php"><?= build_friendly_names('Listado') ?></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>     
        </div>
    </div>
     <div class="panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><strong><?= build_friendly_names('Configuraciones') ?></strong></h3>
        </div>
        <div class="panel-body">
            <table align="center" class="table table-responsive">
                <tr>
                   
                    <td align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff">        
                                <span style="font-size: 40px;" class="fa fa-5x fa-user"></span>
                                <?= build_friendly_names('Usuarios') ?>  &nbsp<span class="caret"></span>
                                </font>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="usuarios.php?ban=nuevo"><?= build_friendly_names('Alta') ?></a></li>
                                <li><a href="usuarios.php"><?= build_friendly_names('Listado') ?></a></li>
                            </ul>
                        </div>
                    </td>
                     <td align="center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary btn-lg " href="upload.php" style="text-shadow: black 5px 3px 3px;"> 
                                <font color="#ffffff">   
                                <span style="font-size: 40px;" class="fa fa-5x fa-files-o"></span>
                                <?= build_friendly_names('Archivos') ?>  &nbsp
                                </font>
                            </a>
                           
                        </div>
                    </td>
                </tr>
            </table>     
        </div>
    </div>

    <?php
endif;
if ($bandera === 0) {
    echo "No posee ningun m&oacute;dulo activo para su usuario, contacte al administrador.";
}
?>


<?php
include_once('html_inf.php');
?>
&
