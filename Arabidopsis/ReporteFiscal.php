<?php
include "html_sup.php";
?>
<style type="text/css">
    .not-active {
  pointer-events: none;
  cursor: default;
}

</style>
<div class="container" id="general">
    <div class="row">
    	<div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                	Reporte  fiscal
                </div>
                <div class="panel-body">
                	<table class="table" id="reporte" width="100%">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Monto</th>
                                <th>Nro factura</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                	
                </div>
             </div>
        </div>

     </div>
 </div>


 <script type="text/javascript">

var table=$('#reporte').DataTable( {
        //dom: "Bfrtip",
        ajax: {
            url: "ReporteFiscalServiceSide.php",
            type: 'POST',
            data:function(data){
                return data;
            }
        },
        serverSide: true,
        processing: true,
        "columnDefs": [
            { "orderable": false,"searchable": false, "targets": 5 },
          
            ],
        columns: [
            { data: "concepto_movimientos.descripcion" },
            { data: "movimientos.fecha",
                render:function(data){

                    date= new Date(data);
                    return date.toLocaleDateString("es");
                }},
            { data: "proveedors.razon_social" },
            { data: "movimientos.monto_en_pesos" },
            { data: "movimientos.nro_factura" },
            {data:function(data){
                var disabled=(data.archivos.nombre==null) ? "not-active" : "";
                
                return '<a href="uploads/'+data.archivos.nombre+'" download  class="glyphicon glyphicon-save '+disabled+'"> </a>&nbsp&nbsp\n'+'<a href="salidas.php?movimiento_id='+data.movimientos.id+'"><i class="fa fa-eye" style="font-size:21px"> </i></a>&nbsp&nbsp\n'
                     +'<a href="#"><i class="fa fa fa-trash" style="font-size:21px"></i></a>';

            }}
        ]
} );

</script>

<?php include 'html_inf.php';