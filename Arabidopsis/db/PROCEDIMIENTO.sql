SET SQL_SAFE_UPDATES = 0;

DELIMITER //

CREATE  PROCEDURE p1()
BEGIN
 DECLARE TARJETA_ID INT;
 DECLARE FECHA DATETIME;
DECLARE cur1 CURSOR FOR  select 
			fecha_vencimiento, 
			id 
	from tarjeta_de_creditos
		where
			date_format(`fecha_vencimiento`, '%m-%Y')=date_format(curdate(), '%m-%Y') 
            and recargable=0;
            
	OPEN cur1;
    read_loop: LOOP
		FETCH cur1  into TARJETA_ID,FECHA;

        UPDATE pago_con_tarjeta SET fecha_imputacion=FECHA WHERE ID IN(
			select id 
			from (
					select * from pago_con_tarjeta where fecha_imputacion is null 
					and tarjeta_id=TARJETA_ID group by pago_realizado_id
				) as c
        
        );
        
	 END LOOP;

  CLOSE cur1;
  
END; //

 CALL p1()


select 
			fecha_vencimiento, 
			id 
	from tarjeta_de_creditos
		where
			date_format(`fecha_vencimiento`, '%m-%Y')=date_format(curdate(), '%m-%Y') 
            and recargable=0;

/*

DECLARE  cursor1 CURSOR FOR select 
			fecha_vencimiento, 
			id 
	from tarjeta_de_creditos
		where
			date_format(`fecha_vencimiento`, '%m-%Y')=date_format(curdate(), '%m-%Y') 
            and recargable=0;

*/