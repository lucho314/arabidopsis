<?php
$tip = '';
$msg = $_GET['mensaje'];
include_once('html_sup_min.php');
include_once('../lib/connect_mysql.php');
include_once('lib/funciones.php');
?>
<div class="container-fluid"> 
<table class="table" width="80" height="50" align="center" cellpadding="8" cellspacing="0" border="0" style="background-color: #cccccc;">

    <tr>
        <td colspan="2">

            <table class="table table-bordered" align="center" width="1100" bgcolor="#ffffff">
                <tr>
                    <td align="left" width="125">
                        <a href="menu_principal.php">
                            <img src="images/logo.png" width="400">
                        </a>
                    </td>
                    <td width="600" align="right">
                        <div align="center"><strong><h3>SISTEMA DE CONSULTA COLABORADOR</h3></strong>
                             <a href="movimientos_colaborador.php">Donaciones personales</a>&nbsp;|
                             <a href="flujo_caja_colaborador.php">Flujo de caja</a>&nbsp;|
                            
                             <a href="javascript:abrir_pop()">Cambiar Contrase&ntilde;a</a>&nbsp;|

                             <a href="aut_logout.php">SALIR</a>
                        </div>
                    </td>
                    <td width="300" align="left">
                        <p style="text-decoration: blink;">
                            <img src="images/tips.jpg" align="right">
                            <?php
                            include_once('tips.php');
                            ?>
                        </p>
                    </td>
                </tr>
            </table>



        </td></tr>



    <tr>

        <td align="center" valign="top">
            <br>

            <!-- Trigger the modal with a button -->
            <button type="button" id="abrir" style="display: none" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cambio de Contrase&ntilde;a</h4>
                            
                        </div>
                        <form action="#" id="cambiar_contrasenia">
                            <div class="modal-body">
                                <table id="scaffold" class="table table-bordered table-striped" cellpadding="2" cellspacing="0" border="0" width="80%">
                                    <tr>
                                        <td align="right"  width="200"> <b>Contrase&ntilde;a actual:</b></td><td id='tabla_actual'><input id='actual' type="password" class='contra'></td>
                                    </tr>
                                    <tr>
                                        <td align="right"  width="200"><b>Nueva contrase&ntilde;a:</b></td><td id='tabla_nueva'> <input id="nueva" type="password" class='contra'><br></td>
                                    </tr>
                                    <tr>
                                        <td align="right"  width="200"><b>Repetir nueva contrase&ntilde;a:</b></td><td id='tabla_repetir'> <input id="repetir" type="password" class='contra'><br></td>
                                    <tr>
                                    <tr>
                                        <td></td><td> <input type="submit" value="Aceptar"><br></td>
                                    <tr>
                                </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cerrar"  id='close' data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
            </div>
            <p><b>En esta seccion podra ver los archivos cargados por la fundacion.</b></p>
<?php include_once 'archivos_lista.php' ?>
            </tr>
</tr>
</tr>
</tr>
</table>
</div>
</form>
</div>
</div>
</div>
</td>
</tr>
</table>
</div>