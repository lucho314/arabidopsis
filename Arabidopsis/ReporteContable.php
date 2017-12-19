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
        columns: [
                { data: "reporte_contable.fecha", render:function(data){
                 date= new Date(data);
                 date.setDate(date.getDate()+1);
                    return date.toLocaleDateString("arg");
                } },
            {data: "reporte_contable.nro_factura"},
            { data: "reporte_contable.proveedor" },
            { data: "reporte_contable.concepto" },
           
            
            { data: "reporte_contable.forma_de_pago" },
            { data: "reporte_contable.tipo_pago" },
           // { data: "reporte_contable.monto" },
            { data: "reporte_contable.pagado" }
            
            
        ]
} );

</script>

<?php include 'html_inf.php';