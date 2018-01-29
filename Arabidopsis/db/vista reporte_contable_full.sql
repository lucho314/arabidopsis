create view reporte_contable_full as
SELECT id,fecha,nro_comprobante_o_transaccion,proveedor persona,concepto,nro_factura,forma_de_pago,pagado,tipo_pago,'SALIDA' tipo_movimiento
from reporte_contable
union
select M.id, fecha,nro_recibo_manual nro_comprobante_o_transaccion,Cl.razon_social persona,C.descripcion concepto,nro_recibo_fundacion nro_factura,F.descripcion forma_de_pago,monto_en_pesos Pagado,TT.descripcion tipo_pago,'ENTRADA' tipo_movimiento
from movimientos M
inner JOIN concepto_movimientos C on c.id=m.concepto_movimiento_id 
LEFT JOIN forma_de_pagos F on F.id=M.forma_de_pago_id 
LEFT JOIN tipo_de_transaccions TT on TT.id=M.tipo_de_transaccion_id 
 inner join colaboradors Cl on Cl.id=M.colaborador_id
where M.tipo_movimiento_id=1