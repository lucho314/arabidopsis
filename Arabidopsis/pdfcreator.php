<?php
 
require('fpdf.php');
include 'lib/connect_mysql.php';
include 'lib/funciones.php';

class PDF extends FPDF
{         
    //Pie de página
  /* function Footer()
   {
      //Posición: a 1,5 cm del final
      $this->SetY(-15);
      //Arial italic 8
      $this->SetFont('Arial','I',8);
      //Número de página
      $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
   }
    */
    
    function date_transform_lat($fecha_usa){
            //Parseo el $value para ver si es una fecha.
            $value = str_replace("'",'',$fecha_usa);
            $guion1 = substr($value, 4,-5);
            $guion2 = substr($value, 7,-2);
            $largo  = strlen($value);

            $verificador = $guion1.$largo.$guion2;

            if (($verificador == '-10-')) {
                
                $dia = substr($value, 8, 2);
                $mes = substr($value, 5, 2);
                $ano = substr($value, 0, 4);
                $value = "'".$dia . '-' . $mes . '-' . $ano."'";

            }
            $value = str_replace("'",'',$value);
            return $value;                        
        }    
    
    
    
    // FACTURA ****************************************************************
    
    function desarrolla_factura($datos)
    {  $sql_factura_maestro = "SELECT *
                              FROM factura_maestros
                              WHERE id = $datos";
        
       $q_factura_maestro = mysql_query($sql_factura_maestro);
       
       
       $j=0;    
       for ($i=1; $i<=2; $i++){  //FOR PARA IMPRIMIR DOS COPIAS DE LA FACTURA 
           
            if ($i==2) {$j=150;}        
       
       //  ************** IMPRESIONES ***************** 
       $query = mysql_query("SELECT * 
                             FROM  coordenadas
                             WHERE id=1 ");
       
//IMPRIMO EL DETALLE DE LA FACTURA       
       
       while($line = mysql_fetch_array($query)){      
        
       while($r = mysql_fetch_array($q_factura_maestro)) {
            $id                     = $r['id'];
            $descripcion_maestro    = $r['descripcion'];
            $nro_factura            = $r['nro_factura'];
            $detalle                = $r['detalle'];            
            $control                = $r['control'];
            $cliente_id             = $r['cliente_id'];
            $fecha                  = $r['fecha'];
            $condicion_venta_id     = $r['condicion_venta_id'];
            $subtotal               = $r['subtotal'];
            $impuesto               = $r['impuesto'];
            $total                  = $r['total'];
            $iva_21                 = $r['iva_21'];
            $iva_105                = $r['iva_105'];
            $anulada                = $r['anulada'];
            $cliente                = DevuelveValor($cliente_id,'razon_social', 'clientes', 'id');
            $cliente_condicion_iva_id= DevuelveValor($cliente_id,'condicion_iva_id', 'clientes', 'id');
            $cliente_condicion_iva  = DevuelveValor($cliente_condicion_iva_id,'descripcion', 'condicion_ivas', 'id');
            $cliente_direccion      = DevuelveValor($cliente_id,'domicilio', 'clientes', 'id');
            $cliente_localidad      = DevuelveValor($cliente_id,'localidad_id', 'clientes', 'id');
            $localidad              = DevuelveValor($cliente_localidad,'descripcion', 'localidads', 'id');
            $cliente_cuit           = DevuelveValor($cliente_id,'cuit', 'clientes', 'id');
            $condicion_de_venta     = DevuelveValor($condicion_de_venta_id,'descripcion', 'condicion_ventas', 'id');
            
            /*$fechalat              = date_transform_lat($fecha);
            $fechalat_de_entrega    = date_transform_lat($fecha_de_entrega);*/
        }
        
        $this->SetFont('Arial','B',12);  //Selecciono la fuente
        
        
//IMPRIMO EL ENCABEZADO DE LA FACTURA
        
            //numero de factura
            $this->SetXY($line['c1x'],$line['c1y']+$j);
            $this->Cell(20,5,$nro_factura,0,2,'L');               
            //fecha
            $this->SetXY($line['c2x'],$line['c2y']+$j);
            $this->Cell(40,5,'Fecha: '.$fecha,0,2,'L');       
            //cliente    
            $this->SetXY($line['c3x'],$line['c3y']+$j);
            $this->Cell(140,5,utf8_decode($cliente),0,2,'L');            
            //direccion
            $this->SetXY($line['c4x'],$line['c4y']+$j);
            $this->Cell(140,5,$cliente_direccion,0,2,'L');            
            //localidad
            $this->SetXY($line['c5x'],$line['c5y']+$j);
            $this->Cell(50,5,utf8_decode($localidad),0,2,'L');
            //cuit
            $this->SetXY($line['c6x'],$line['c6y']+$j);
            $this->Cell(30,5,$cliente_cuit,0,2,'L');
            //condicion de iva
            $this->SetXY($line['c7x'],$line['c7y']+$j);
            $this->Cell(140,5,$cliente_condicion_iva,0,2,'L');        
        
        
        

       
       $sql_factura_detalle = "SELECT *
                               FROM factura_detalles
                               WHERE factura_maestro_id = $datos";
        
       $q_factura_detalle = mysql_query($sql_factura_detalle);
        
        while($r = mysql_fetch_array($q_factura_detalle)) {
            $id                     = $r['id'];
            $descripcion_detalle    = $r['descripcion'];
            $cantidad               = $r['cantidad'];
            $producto_id            = $r['producto_id'];            
            $detalle                = $r['detalle'];
            $precio_unitario        = $r['precio_unitario'];
            $iva                    = $r['iva'];
            
            /*$fechalat               = date_transform_lat($fecha);
            $fechalat_de_entrega    = date_transform_lat($fecha_de_entrega);*/
                
       
        
       $this->SetFont('Arial','B',10);
       

       

            
            //DETALLE FACTURA
            //
            If ($producto_id == 1) {
                //cantidad            
                $this->SetXY($line['c13x'],$line['c13y']+$j);
                $this->Cell(140,5,$cantidad,0,2,'L');
                //detalle
                $this->SetXY($line['c14x'],$line['c14y']+$j);
                $this->Cell(140,5,$detalle,0,2,'L');
                //precio_unitario
                $this->SetXY($line['c15x'],$line['c15y']+$j);
                $this->Cell(140,5,$precio_unitario,0,2,'L');
                //Total
                $this->SetXY($line['c16x'],$line['c16y']+$j);
                $this->Cell(140,5,$precio_unitario*$cantidad,0,2,'L');
            }
            else {
                $producto_descripcion  = DevuelveValor($producto_id,'descripcion', 'productos', 'id');
                $producto_nombre       = DevuelveValor($producto_id,'nombre', 'productos', 'id');
                $producto_costo        = DevuelveValor($producto_id,'costo', 'productos', 'id');
                $producto_margen       = DevuelveValor($producto_id,'margen', 'productos', 'id');
                $producto_iva          = DevuelveValor($producto_id,'iva', 'productos', 'id');
                //cantidad            
                $this->SetXY($line['c13x'],$line['c13y']+$j);
                $this->Cell(140,5,$cantidad,0,2,'L');
                //detalle
                $this->SetXY($line['c14x'],$line['c14y']+$j);
                $this->Cell(140,5,$producto_nombre,0,2,'L');
                //precio_unitario
                $this->SetXY($line['c15x'],$line['c15y']+$j);
                $this->Cell(140,5,$producto_costo*$producto_margen,0,2,'L');
                //Total
                $this->SetXY($line['c16x'],$line['c16y']+$j);
                $this->Cell(140,5,$producto_costo*$producto_margen*$cantidad,0,2,'L');
            }
                           
            if ($cliente_condicion_iva_id == 2) {            
                //subtotal
                $this->SetXY($line['c8x'],$line['c8y']+$j-10);
                $this->Cell(24,5,$subtotal,0,2,'L');
                //impuesto
                $this->SetXY($line['c9x'],$line['c9y']+$j-10);
                $this->Cell(24,5,$impuesto,0,2,'L');
                //iva 21
                $this->SetXY($line['c10x'],$line['c10y']+$j-10);
                $this->Cell(24,5,$iva_21 ,0,2,'L');
                //iva105
                $this->SetXY($line['c11x'],$line['c11y']+$j-10);
                $this->Cell(24,5,$iva_105,0,2,'L');
                //total
                $this->SetXY($line['c12x'],$line['c12y']+$j-10);
                $this->Cell(24,5,$total,0,2,'L'); 
            }
            else {
                
                //total
                $this->SetXY($line['c12x'],$line['c12y']+$j-10);
                $this->Cell(24,5,$total,0,2,'L'); 
                
            }
        
       
       } // fin del while de impresion       
       }
       }
    }
    
    
    
    
    
     function factura($datos)
    {   $this->desarrolla_factura ($datos);         
    }
     
 
} //fin clase PDF

class crea_pdf {      
     //($comprobante, $fields = array(),$ruta )
     function crea_pdf ($fields)
     {   
        $this->fields = $fields;	// aca tengo los datos a llenar en el pdf a crear
         
        $pdf = new PDF();         //Crea objeto PDF
        $pdf->AddPage('P', 'A4'); // L  Apaisado, A4         
        $pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
        $pdf->SetMargins(0, 0, 0);
        $pdf->Ln();
         
        $ruta=facturas.'/'.date("Y").'/'.date("m").'/';
        
        $pdf->factura($this->fields);        
        $nombre_file = $ruta."factura1".".pdf";            
                     
        $pdf->Output($nombre_file,I);  //Salida al navegador
        //$pdf->Output($nombre_file,I);  //guarda en archivo
         
     }
}
/*  
$datos = 2;
$ola = new crea_pdf($datos); */
?>