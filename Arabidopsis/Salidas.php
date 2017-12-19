<?php 

include "html_sup.php";
$sql="SELECT * FROM `forma_de_pagos` where id<>1";
$query=mysql_query($sql);
$sql="SELECT * FROM `tarjeta_de_creditos` where id<>1";
$query2=mysql_query($sql);

$sql="SELECT * FROM `concepto_movimientos` WHERE `tipo_movimiento_id`=2";
$query3=mysql_query($sql);

$sql="SELECT * FROM `proveedors` order by descripcion";
$query4=mysql_query($sql);


if(isset($_GET["movimiento_id"]))
{

    $movimiento_id=$_GET["movimiento_id"];
   $sql="select
              `concepto_movimiento_id` as concepto_id,
              `fecha`,
              `proveedor_id`,
              `monto_en_pesos` as monto,
              `nro_comprobante_o_transaccion` as nro_comprobante,
              `nro_factura`
         from movimientos
         where id=$movimiento_id";
    $query=mysql_query($sql);
    while ($fila = mysql_fetch_assoc($query)) {
      $movimiento=$fila;
    }
    $movimiento= json_encode($movimiento);
}




?>
 <link rel="stylesheet" href="css/tabs.css">
 <script src="js/vue.js"></script>
<div class="container" id="general">
    <div class="row">
    	<div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Default 1</a></li>
                            <li class="items"><a href="#tab2default" data-toggle="tab">Default 2</a></li>
                            <li class="pagos"><a href="#tab3default" data-toggle="tab">Default 3</a></li>
                             <li class="pagos"><a href="#tab4default" data-toggle="tab">Default 3</a></li>
                            <div style="float: right">
                            	<a class="btn btn-danger" href="ddjj_principal.aspx" style="color: white">CANCELAR</a> &nbsp;
                            	<button class="btn btn-success" id="grabar" v-on:click="grabarDatos($event)">GRABAR</button>
                			</div>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active text-left" id="tab1default">
                        	 <div class="form-group">
							    
                            <div class="form-group">
                              <label for="monto" class="control-label">Fecha:</label>
                              <input type="text" class="form-control  salida datepicker" id="fecha" required>
                              <span class="help-block"></span>
                           </div>

                           <div class="form-group">
                            <label for="proveedor" class="control-label">Proveedor:</label>
                           <select class="form-control salida js-example-basic-single" required name="proveedor_id" id="proveedor_select" onchange="general.proveedor_id=$(this).val()" >
                              <option value="">Seleccione proveedor</option>
                              <?php while ($fila = mysql_fetch_assoc($query4)): ?>
                                                  <option value="<?= $fila["id"] ?>"> <?= $fila["descripcion"] ?> </option>
                                                <?php endwhile; ?>
                            </select>
                            <input type="hidden" v-model="proveedor_id" id="proveedorhidden">
                            <span class="help-block"></span>
                          </div>
                  
 							 </div>
 							
  							
  							
  							<div class="form-group">
							    <label for="monto" class="control-label">Nro comprobante/transaccion:</label>
							    <input type="number" class="form-control salida" id="monto" v-model="nro_comprobante" placeholder="Numero de comprobante">
                  <span class="help-block"></span>
  							</div>
  							<div class="form-group">
							    <label for="monto" class="control-label">Nro factura:</label>
							    <input type="text" class="form-control salida" id="monto" v-model="nro_factura" placeholder="Numero de factura">
                  <span class="help-block"></span>
  							</div>
  							 <div class="form-group">
							    <label for="detalle" class="control-label">Observaciones:</label>
							    <textarea class="form-control salida" id="detalle" v-model="observaciones" placeholder="Observaciones"></textarea>
							    <span class="help-block"></span>
  							</div>

              </div>
              <div class="tab-pane fade text-left" id="tab2default">
                  <div class="form-group">
                  <label for="concepto">Concepto:</label>
                  <select class="form-control salida" required name="concepto_id" v-model="concepto_id">
                    <option value="">Seleccione concepto</option>
                    <?php while ($fila = mysql_fetch_assoc($query3)): ?>
                                        <option value="<?= $fila["id"] ?>"> <?= $fila["descripcion"] ?> </option>
                                      <?php endwhile; ?>
                  </select>
                  <span class="help-block"></span>
                </div>
                  <br>
        
              <button class="btn btn-primary" style="float: left;"  v-on:click="nuevoItem($event)"> Nuevo items</button>
               <p style="float: right;"><b>Monto Total $ {{$data.monto}}</b></p>
                  <table id="items" class="display" cellspacing="0" width="100%">
                    
                        <thead>
                          <tr>
                            <th>Descripcion</th>
                            <th>Precio U.</th>
                            <th>Cantidad</th>  
                             <th>Total</th>
                          </tr> 
                        </thead>
                       
                 
                      

            </table>


              </div>
                <div class="tab-pane fade" id="tab3default">
                   <div class="col-lg-12 well">
        						<h4 class="text-primary"><span class="glyphicon glyphicon-info-sign"></span> Forma de pagos</h4>
        						<p align="justify" class="text-info">
        							Es posible saldar el monto total con mas de un medio de pago. Haga click sobre "nuevo pago" para agregar el o los pagos correspondientes
        						</p>
						    </div>
						  <a class="btn btn-primary" style="float: left;"  data-toggle="modal" id="btn-nuevo-pago">
          Nuevo pago
        </a>
        <div style="width: 27%; margin-left: 68%;">
        <p style="float: left;"><b>Monto a saldar {{$data.monto}}</b></p>
        <p style="float: right;"><b>Monto saldado {{$data.monto_saldado}}</b></p>
    </div>
						<table class="table" id="pagos">
							<tr>
								<thead>
										<th>Modo de pago</th>
										<th>Monto saldado</th>
										<th>Acciones</th>
								</thead>
							</tr>

						</table>
					</div>

                        
                        <div class="tab-pane fade" id="tab4default">
                        <div class="col-lg-12 well">
                        	<h4 class="text-primary"><span class="glyphicon glyphicon-info-sign"></span> Justificacion</h4>
						<p align="justify" class="text-info">
							Si lo cree necesario puede adjuntar el comprobante para justificar el movimiento.
						</p>
					</div>
                        	<input type="file" id="fileInput"/>

                        </div>
                        <div class="tab-pane fade" id="tab4default">Default 4</div>
                        <div class="tab-pane fade" id="tab5default">Default 5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade"  id="Items" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-labelledby="contactLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="panel-title" id="contactLabel">Nuevo item</h4>
                    </div>
                    <form action="#" method="post" accept-charset="utf-8">
                    <div class="modal-body text-left">
                          
                              <div class="form-group">
                                  <label for="cuotas" class="control-label">Descripcion</label>
                                    <input class="form-control item" name="descripcion" v-model="descripcion"   placeholder="Descripcion" type="text" required />
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                  <label for="precio">Precio U</label>
                                    <input class="form-control item" name="precio" v-model="precio"   placeholder="precio unitario"   type="number" min="1" step="any" required />
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                  <label for="precio">Cantidad</label>
                                    <input class="form-control item" name="cantidad" v-model="cantidad"  placeholder="cantidad" min="1" type="number" required />
                                    <span class="help-block"></span>
                                </div>
                           
                        </div>  
                         <div class="modal-footer">
                           <button  class="btn btn-success" id="guardar-item"  v-on:click="guardarItem($event)"  data-dismiss="modal" disabled>Aceptar</button>
                         
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- ###############modal pagos##############################-->
<div class="modal fade"  id="contact" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-labelledby="contactLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="panel-title" id="contactLabel">Nuevo pago.</h4>
                    </div>
                    <form action="#" method="post" accept-charset="utf-8">
                    <div class="modal-body text-left">
                          
                                <div class="form-group">
                                     <label for="forma_pago" class="control-label">Forma de pago:</label>
                                    <select class="form-control pago" required name="forma_de_pago_id" v-model="forma_pago" @change="handleChangeFpago" id="f_pago">
                                    	<option value="">Seleccione forma de pago</option>
                                    	<?php while ($fila = mysql_fetch_assoc($query)): ?>
                                    		<option value="<?= $fila["id"] ?>"> <?= $fila["descripcion"] ?> </option>
                                    	<?php endwhile; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group" v-if="forma_pago!=5 && forma_pago!=3">
                                	<label for="tipo_transaccion" class="control-label">Tipo transaccion:</label>
                                     <select class="form-control pago" required  v-model="tipo_de_transaccion_id" @change="handleChangeTtransaccion">
                                    	<option value="">Seleccione tipo de transaccion</option>
                                    	<option v-for="option in optionTransaccion" v-bind:value="option.value">{{ option.text }}</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                           
                            	 <div class="form-group" v-if="forma_pago==5">
                                	<label for="tipo_transaccion" class="control-label">Tarjeta de credito:</label>
                                     <select class="form-control pago" required v-model="tarjeta_id" @change="handleChangeTtarjeta">
                                    	<option value="">Seleccione la tarjeta</option>
                                    	<?php while ($fila = mysql_fetch_assoc($query2)): ?>
                                    		<option value="<?= $fila["id"] ?>"> <?= $fila["descripcion"] ?> </option>
                                    	<?php endwhile; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>

                                <div class="form-group">
                                	<label for="monto" class="control-label">Monto total:</label>
                                    <input class="form-control pago" required name="monto" v-model="monto" placeholder="Monto total" type="number" step="any"  min="1" max="5" id="monto_total"/>
                                    <span class="help-block"></span>
                                </div>
                           
                           
                                <div class="form-group" v-if="forma_pago==5">
                                	<label for="cuotas" class="control-label">Cuotas:</label>
                                    <input class="form-control pago" required name="cuotas" v-model="cuotas" placeholder="Cantidad de cuotas"  type="number"  min="1" required />
                                    <span class="help-block"></span>
                                </div>
                      
                           		<div class="form-group" v-if="forma_pago==5 && cuotas>1">
                                	<label for="cuotas" class="control-label">1° cuota:</label>
                                    <input class="form-control pago" required name="cuota_uno" v-model="cuota_uno"  placeholder="Valor de la primera cuota" min="1" step="any" type="number" required />
                                    <span class="help-block"></span>
                                </div>
                           
                        </div>  
                         <div class="modal-footer">
                           <button  class="btn btn-success"  id="guardar-pagos" v-on:click="guardarPago($event)">Aceptar</button>
                           <button  class="btn btn-success" style="display: none" id="guardar-pago"   data-dismiss="modal">Aceptar</button>
                           
                         
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    





<script type="text/javascript">
 
var pagos=[];
var items=[];

var general = new Vue({
	 el: '#general',
	 data:{
	 	concepto_id:"",
	 	detalle:"",
	 	proveedor_id:"",
	 	monto:0,
	 	monto_saldado:0,
	 	nro_comprobante:"",
	 	nro_factura:"",
	 	observaciones:"",
	 	fecha:''
	 },
	 	 methods: {
      nuevoItem(event){
        event.preventDefault();
        if(this.concepto_id=="")
        {
          alert("Debe seleccionar un concepto");
          return;
        }
        $("#Items").modal("toggle");

      },


	 	grabarDatos(event){
	 		event.preventDefault();
	 		salida=Object.assign({}, this.$data);
	 		salida['pagos']=pagos;
      salida['items']=items;
	 		$.ajax({
	 			type: "POST",
            url: "guardarSalidas.php",
            data: JSON.stringify(salida),
            contentType: "application/json",
            dataType: "json",
            success: function (e)
            {
              guardarFile().success(function(){
                   swal({
                    title: "Gravado",
                    text: "Los datos se gravaron correctamente",
                    type: "success"
                }, function () {
                    location.href = "Salidas.php";
                });

              })
            	

            }
	 		}).fail(function(data){
                var str=data.responseText;
                swal({
                    title: "Error al guardar los datos",
                    text: "Ocurrio un error al guardar los datos, intente mas tarde o contacte al administrador\n \n "+str.substring(0, str.indexOf("{")),
                    type: "error"
                })
               
            
            });
	 	},
	 	processFile(e){
	 		 this.fileUploadFormData = event.target.files[0];
	 	},
    setDataFromDb(json){
           for (var i in json) {
              this[i]=json[i];

           }
           console.log(this.proveedor_id);
           $("#proveedor_select").val(this.proveedor_id).change();
           $("#fecha").val(this.fecha);
        }
		   
	 },


	});


var Items = new Vue({

  el: '#Items',
    data: {
  
          descripcion:"",
          precio:"",
          cantidad:'',
          total:''
        },
     watch: {
            precio: function (val) {
               var cant=(this.cantidad!='')?this.cantidad:0;
               this.total=this.precio*this.cantidad;
            },
            cantidad: function (val) {
            var precio=(this.precio!='')?this.precio:0;
               this.total=this.precio*this.cantidad;
            }
        },
    methods:{

       guardarItem(event){

          event.preventDefault()
          aux= Object.assign({}, this.$data);
          aux["index"]=items.length;
          items.push(aux);
          general.monto=parseFloat(general.monto)+this.total;
          actualizarItems();
          this.resetDefault();
       },
       resetDefault(){

           this.descripcion="";
          this.precio="";
          this.cantidad='';
          this.total='';
       }

    }

});



var vm = new Vue({
    el: '#contact',
    data: {
  
        	forma_pago:"",
        	monto:"",
        	cuotas:1,
        	cuota_uno:0,
        	otras_cuotas:0,
        	optionTransaccion:[],
        	formaPagoDescripcion:"",
        	transaccionDescripcion:"",
        	tipo_de_transaccion_id:"",
        	tarjeta_id:""
    	},
        watch: {
        	monto: function (val) {
		      var aux = (this.cuotas==0) ? val : val/this.cuotas;
		        this.otras_cuotas=this.cuota_uno=Math.round(aux * 100) / 100
		    },
		    cuotas: function (val) {
		    	var aux =this.cuota_uno = (val==0) ? this.monto : this.monto/val;
		    	 this.otras_cuotas=this.cuota_uno=Math.round(aux * 100) / 100;

		    },
		    cuota_uno: function(val)
		    {
		    	var cuotas=Math.round((this.monto-val)/(this.cuotas-1) * 100) / 100;
		    	this.otras_cuotas=cuotas;
		    }
		},
		methods: {
		    handleChangeFpago(e) {
		    	if(this.forma_pago!=5) 
		    		{
		    			this.tarjeta_id="";
		    			this.tipo_de_transaccion_id="";
		    		}
		    	if(this.forma_pago==3)
		    		this.transaccionDescripcion="";
		            this.formaPagoDescripcion=e.target.options[e.target.options.selectedIndex].label;
		        $.post("movimientos_get_tramsaccion.php",{id:this.forma_pago,salida:1},function(d){
						vm.optionTransaccion=d;

				},"json")
		    },
		    handleChangeTtransaccion(e){
		    	this.transaccionDescripcion=e.target.options[e.target.options.selectedIndex].label;
		    	 $.post("movimientos_get_tramsaccion.php",{id:this.forma_pago,salida:1},function(d){
						vm.optionTransaccion=d;

				},"json")
		    },
		    handleChangeTtarjeta(e){
		    	this.transaccionDescripcion=e.target.options[e.target.options.selectedIndex].label;
		    },

		    guardarPago(event){
		    	event.preventDefault()
		    	aux= Object.assign({}, this.$data);
		    	aux["index"]=pagos.length;
          if(validarHtml($(document).find(".pago")))
          {
            pagos.push(aux);
            general.monto_saldado=parseFloat(general.monto_saldado)+parseFloat(this.monto);
            actualizarPagos();
            $("#guardar-pago").click();
            this.resetDefault();
          }

		    	

		    },
		    editarPago(i){
		    	Object.assign(this.$data,pagos[i])
		    },
		    eliminarPago(i)
		    {
		    	pagos.pop(i);
		    	actualizarPagos();
		    },

        resetDefault(){
          this.forma_pago="";
          this.monto="";
          this.cuotas=1;
          this.cuota_uno=0;
          this.otras_cuotas=0;
          this.optionTransaccion=[];
          this.formaPagoDescripcion="";
          this.transaccionDescripcion="";
          this.tipo_de_transaccion_id="";
          this.tarjeta_id=""
        }
        
		}

});


function actualizarItems(){
$("#items").DataTable({
  "dom": 'rtip',
  "bDestroy": true,
   "data": items,
        
        "columns": [
          {"data": "descripcion","defaultContent": ""},
          {"data": "precio","defaultContent": ""},
          {"data": "cantidad","defaultContent": ""},
          {"data": "total","defaultContent": ""}
        ]
       

});
}


 $('.items').click(function(){
                    setTimeout(function(){
                        actualizarItems();
                    }, 200);
                })
 $('.pagos').click(function(){
                    setTimeout(function(){
                        actualizarPagos();
                    }, 200);
                })

function actualizarPagos(){
	$("#pagos").DataTable({
		"dom": 'rtip',
        "bDestroy": true,
        "data": pagos,
        
        "columns": [
                    
                     {"data": function(data){
                     		var a="";
                     		if(data.forma_pago==5 && data.cuotas>1)
                     		{
                     			if(data.cuota_uno!=data.otras_cuotas)
                     				a="(pago inicial de "+data.cuota_uno+" y "+ (parseInt(data.cuotas)-1) +" cuotas de "+data.otras_cuotas+")";
                     			else
                     				 a="("+data.cuotas+" Cuotas)";
                     		}
                     		return data.formaPagoDescripcion+" "+data.transaccionDescripcion+" "+a;

                     }},
                     {"data": "monto","defaultContent": ""},
                     {"data": function(data){
                     		return '<a href="javascript:vm.editarPago('+data.index+')"><i class="glyphicon glyphicon-pencil"></i></a> '+
                                    '<a href="javascript:vm.eliminarPago('+data.index+')"><i class="glyphicon glyphicon-trash"></i></a>';

                     }},
             		]
             	})
}


$("#btn-nuevo-pago").click(function(){

  var monto_a_saldar=general.monto-general.monto_saldado;
  $("#monto_total").attr("max",monto_a_saldar);
  $("#contact").modal("toggle");


})

$("input").change(function(){

  validate(this);
});

$("select").change(function(){

  validate(this);
});

function validate($obj)
    {
        var v=true;
 
        var $div=$($obj).closest('.form-group');
        var $help=$div.children('.help-block');
        $help.text('');
        $div.removeClass('has-warning');
        if ($($obj)[0].checkValidity() == false) {
            console.log($($obj)[0].validationMessage+' '+$($obj)[0].title);
            $help.text($($obj)[0].validationMessage+' '+$($obj)[0].title);
            $div.addClass('has-warning');
            v=false;
            return false;
        }
    
        return v;
   }
   function  validarHtml($obj){
        var v=true;
        $obj.each(function () {
            if(!validate(this))
            {
                v=false;
            }
        })
        return v;
    };


 function  disableOrEnabledBtn(clase,$btn){
   $(document).find("."+clase).change(function(){
    var b=true;
    $("."+clase).each(function(){
      if($(this).val()==""){
        console.log("aca",$(this).attr("name"));
        b=false;
        $btn.attr("disabled", true);
        return false;

      }

    });

      if(b)
      {
          $btn.attr("disabled", !validate($("."+clase)));

      }
    })


};

$("#fecha").change(function(){

  var fecha=$(this).val();
  general.fecha=fecha;
})
disableOrEnabledBtn("item",$("#guardar-item"));
//disableOrEnabledBtn("pago",$("#guardar-pagos"));




function guardarFile(){

               var fileInputElement = $('#fileInput');   //Ya que utilizas jquery aprovechalo...
                
               var formData = new FormData();
               
            formData.append("archivo", $('#fileInput')[0].files[0]);
       return         $.ajax({
                    url: 'guardarSalidas.php',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST'
                    
                });

}



var data=<?= $movimiento ?>;


</script>

<?php

include 'html_inf.php';
?>