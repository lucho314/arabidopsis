insert into items (cantidad,descripcion,movimiento_id,precio) select 1,C.descripcion,M.id,m.monto_en_pesos from movimientos M INNER JOIN concepto_movimientos C on C.id=M.concepto_movimiento_id where M.`tipo_movimiento_id`=2 and M.`forma_de_pago_id`<>5 and M.colaborador_id is not null