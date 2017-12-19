create   view reporte_contable as
	SELECT 
		M.id,
		Pr.razon_social as proveedor,
        C.descripcion concepto,
		M.nro_factura,
        M.nro_comprobante_o_transaccion,
		case P.forma_de_pago_id 
			when 5 then concat("Tarjeta de credito (cuota",concat(PT.numero_cuota,'/',P.cantidad_cuotas),")") 
			else f.descripcion end 
			as 'forma_de_pago', 
		M.monto_en_pesos as total,
		case P.forma_de_pago_id 
			WHEN 5 THEN concat(PT.monto,' saldo ', P.monto-(SELECT TotalPagadoConTarjeta(P.id,PT.fecha_imputacion)) ) else 
			P.monto end 
			as 'Pagado',
		case P.forma_de_pago_id 
			when 5 then PT.fecha_imputacion
            else M.fecha end 
            as fecha
            , 
			 case P.forma_de_pago_id
				WHEN '5' then T.descripcion 
				else TT.descripcion end 
			 as tipo_pago,
			
			 M.descripcion as detalle,
             P.monto
	FROM pagos_realizados P 
		LEFT JOIN forma_de_pagos F on F.id=P.forma_de_pago_id 
		LEFT JOIN movimientos M on M.id=P.movimiento_id 
		LEFT JOIN tipo_de_transaccions TT on TT.id=P.tipo_de_transaccion_id and P.forma_de_pago_id<>5 
		LEFT JOIN pago_con_tarjeta PT on PT.pago_realizado_id=P.id and P.forma_de_pago_id=5 and PT.fecha_imputacion<= curdate()
		LEFT JOIN tarjeta_de_creditos T on t.id=PT.tarjeta_id and P.forma_de_pago_id=5
		inner JOIN concepto_movimientos C on c.id=m.concepto_movimiento_id 
        inner join proveedors Pr on Pr.id=M.proveedor_id
	


	
    