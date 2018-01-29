<?php
include "html_sup.php";
?>
<div class="container" id="general">
    <div class="row">
    	<div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                	Reporte  contable
                </div>
                <div class="panel-body">
                	<table class="table" id="reporte" width="100%">
                        <thead>
                            <tr>
                                 <th>Fecha</th>
                                 <th>Movimiento</th>
                                <th>nro_factura/Comptobante</th>
                                <th>Proveedor</th>
                                <th>Concepto</th>
                                <th>Forma pago</th>
                                <th>Tipo pago</th>
                                <th>Pagado</th>
                               
                                
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
            url: "ReporteContableServiseSide.php",
            type: 'POST',
            data:function(data){
                return data;
            }
        },
        serverSide: true,
        processing: true,
          "order": [[ 0, "desc" ]],
        columns: [
                { data: "reporte_contable_full.fecha", render:function(data){
                 date= new Date(data);
                 date.setDate(date.getDate()+1);
                    return date.toLocaleDateString("arg");
                } },
                 {data: "reporte_contable_full.tipo_movimiento"},
              
            {data: "reporte_contable_full.nro_factura"},
            { data: "reporte_contable_full.persona" },
            { data: "reporte_contable_full.concepto" },
           
            
            { data: "reporte_contable_full.forma_de_pago" },
            { data: "reporte_contable_full.tipo_pago" },
           // { data: "reporte_contable.monto" },
            { data: "reporte_contable_full.pagado" }
            
            
        ]
} );

</script>

<?php include 'html_inf.php';