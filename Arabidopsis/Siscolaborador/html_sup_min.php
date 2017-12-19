<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <?php
    require("../aut_verifica.inc.php");
    include_once('../lib/connect_mysql.php');
    include_once('../lib/funciones.php');
    
    ?>
   <head>
        <title>ARABIDOPSIS</title>
        <meta name="author" content="Walter R. Elias">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <!--   <link type="text/css" rel="stylesheet" href="../estilos.css"> -->
        <!--<link rel="stylesheet" href="../menu.css">-->
        <!--<link rel="stylesheet" href="../viejos/style.css">-->


     
        <script src="../js/jquery-1.10.2.js"></script>
        <script src="../js/jquery-ui.js"></script>
        <link rel="stylesheet" href="../css/jquery-ui.css">




        <!--AUTOCOMPLETAR-->
        <link href="../css/select2.css" rel="stylesheet" />
        <script src="../js/select2.min.js"></script>
        <!--FIN AUTOCOMPLETAR-->



        <script type="text/javascript" src="../js/jquery.timepicker.js"></script>
        <script src="../js/vanadium.js" type="text/javascript"></script>

        <link href="../css/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
        <script src="../js/facebox.js" type="text/javascript"></script>
       

        <script language="javascript">
            function eltooltip(algo)
            {
                var ejecuta = window.event;
                var x = ejecuta.x;
                var y = ejecuta.srcElement.offsetTop + ejecuta.srcElement.offsetHeight + 10;
                var pos = tabla.style;
                tabla.innerHTML = '<table style="background-color:INFOBACKGROUND;font:8pt Arial;padding:3px 3px 3px 3px;border:1px solid INFOTEXT"><tr><td align=left>' + algo + '</td></tr></table>';
                pos.posTop = y
                pos.posLeft = x;
                pos.visibility = '';
            }
            
                   </script>




        <!--SCRIPTS PARA CALENDARIO-->

        <!-- Set the viewport width to deevvice width for mobile -->
        <meta name="viewport" content="width=device-width" />

        <!-- Core CSS File. The CSS code needed to make eventCalendar works -->
        <link rel="stylesheet" href="../css/eventCalendar.css">

        <!-- Theme CSS file: it makes eventCalendar nicer -->
        <link rel="stylesheet" href="../css/eventCalendar_theme_responsive.css">

        <!--FIN SCRIPTS CALENDARIO-->


        <script type="text/javascript">
            $('select').select2();

            $(document).ready(function () {
                $(".js-example-basic-single").select2();
            });



        </script>


        <!--LIBRERIAS SELECT HORA-->
        
        <script type="text/javascript" src="../js/jquery.timepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/jquery.timepicker.css" />

        <!--FIN LIBRERIAS SELECT HORA-->


        <script>
            $(function () {
                $(".datepicker").datepicker({
                    dateFormat: "dd-mm-yy"
                });
            });

            $(function () {
                $(".selecthora").timepicker({'timeFormat': 'H:i'});
            });


        </script>


        <!--FIN CALENDARIO SELECTOR DE FECHA-->

        <!--VENTANAS EMERGENTES-->


        <link rel="stylesheet" href="../css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
        <script src="../js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

        <!--FIN VENTANAS EMERGENTES-->

        <!-- Datatable y estilos Agregados estilos y libreria datatable    F.C. -->
        <script type="text/javascript" language="javascript" src="../DataTables-1.10.12/media/js/jquery.dataTables.js">
        </script>
        <link rel="stylesheet" href="../bootstrap-3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="../DataTables-1.10.12/media/css/jquery.dataTables.min.css">
         <link rel="stylesheet" href="../DataTables-1.10.12/media/css/buttons.dataTables.min.css">
         
         

    <script type="text/javascript" language="javascript" src="../DataTables-1.10.12/pluggin/dataTables.buttons.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="../DataTables-1.10.12/pluggin/jszip.min.js">
    </script>
         <script type="text/javascript" language="javascript" src="../DataTables-1.10.12/pluggin/pdfmake.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="../DataTables-1.10.12/pluggin/vfs_fonts.js">
    </script>
    <script type="text/javascript" language="javascript" src="../DataTables-1.10.12/pluggin/buttons.html5.min.js">
    </script>
         
         
         
       
        
        <script src="../bootstrap-3.3.6/js/bootstrap.min.js" ></script>
    </head>
    <body style="background-color: rgb(122, 161, 174);">
        <br>

        <div align="center">

            <table bgcolor="#e8e6e6" width="1100" height="50" align="center" cellpadding="5" cellspacing="0" border="0">

                <tr>
                    <td colspan="2">




                <tr>

                    <td align="center" valign="top">
                        <br>
                        </td>
</tr>
</TABLE>
</div>
</div>



<div class="container-fluid"> 
<table class="table" width="80" height="50" align="center" cellpadding="8" cellspacing="0" border="0" style="background-color: #cccccc;">

    <tr>
        <td colspan="2">

            <table class="table table-bordered" align="center" width="1100" bgcolor="#ffffff">
                <tr>
                    <td align="left" width="125">
                        <a href="menu_principal.php">
                            <img src="../images/logo.png" width="400">
                        </a>
                    </td>
                    <td width="600" align="right">
                        <div align="center"><strong><h3>SISTEMA DE CONSULTA COLABORADOR</h3></strong>
                              <a href="movimientos_colaborador.php">Movimientos</a>&nbsp;|
                             <a href="flujo_caja_colaborador.php">Flujo de caja</a>&nbsp;|
                            
                             <a href="javascript:abrir_pop()">Cambiar Contrase&ntilde;a</a>&nbsp;|

                             <a href="aut_logout.php">SALIR</a>
                        </div>
                    </td>
                    <td width="300" align="left">
                        <p style="text-decoration: blink;">
                            <img src="../images/tips.jpg" align="right">
                            <?php
                            include_once('../tips.php');
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
