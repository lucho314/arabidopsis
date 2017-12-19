delimiter %%
CREATE  FUNCTION TotalPagadoConTarjeta(P_pago_realizado_id int,P_fecha varchar(20)) RETURNS DOUBLE
BEGIN
 
 DECLARE TOTAL_PAGADO DOUBLE;
 
  SELECT SUM(MONTO) INTO  TOTAL_PAGADO from pago_con_tarjeta  WHERE pago_realizado_id=P_pago_realizado_id AND fecha_imputacion <= P_fecha;
 RETURN TOTAL_PAGADO;
END;

%%
