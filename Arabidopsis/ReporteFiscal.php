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
                                <th>Movimiento</th>
                                <th>Proveedor</th>
                                <th>Colaborador</th>
                                <th>Monto</th>
                                <th>Nro factura</th>
                               
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
            { "orderable": false,"searchable": false, "targets": 6 }
          
            ],
            "order": [[ 1, "desc" ]],
        columns: [
            { data: "concepto_movimientos.descripcion" },
            { data: "movimientos.fecha",
                render:function(data){

                    date= new Date(data);
                    date.setDate(date.getDate()+1);
                    return date.toLocaleDateString("es");
                }},
             { data: "tipo_movimientos.descripcion" },
            { data: "proveedors.razon_social" },
            { data: "colaboradors.razon_social" },
            { data: "movimientos.monto_en_pesos" },
            { data: "movimientos.nro_factura" }
        
        ]
} );

</script>

<?php include 'html_inf.php';