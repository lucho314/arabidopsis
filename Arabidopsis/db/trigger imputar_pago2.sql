DELIMITER $$
CREATE   TRIGGER  IMPUTAR_PAGOS2 
 BEFORE INSERT  ON pago_con_tarjeta
 FOR EACH ROW 
	BEGIN
	DECLARE FECHA DATE;	
    DECLARE FECHA_SALIDA DATE;
    DECLARE CANT integer;

   IF(NEW.numero_cuota = 1) THEN
		SET @FECHA_SALIDA:=(SELECT M.fecha from movimientos M inner join pagos_realizados P on P.movimiento_id=M.id where P.id=NEW.pago_realizado_id);
		SET @FECHA:= (SELECT fecha_vencimiento from tarjeta_de_creditos where id=NEW.tarjeta_id and (date_format(`fecha_vencimiento`, '%Y-%m') = date_format(curdate(), '%Y-%m')) and date_format(`fecha_vencimiento`, '%d') >= date_format(curdate(), '%d'));
		
		IF(@FECHA IS NOT NULL) THEN
			SET NEW.fecha_imputacion = @FECHA;
		END IF;
   END IF;
    
    END$$
DELIMITER ;

 

