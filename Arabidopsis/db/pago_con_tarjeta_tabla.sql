-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2017 a las 15:34:45
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pymeser_arabidop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_con_tarjeta`
--

CREATE TABLE `pago_con_tarjeta` (
  `id` int(11) NOT NULL,
  `pago_realizado_id` int(11) NOT NULL,
  `tarjeta_id` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `numero_cuota` int(11) NOT NULL,
  `fecha_imputacion` date DEFAULT NULL,
  `movimiento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `pago_con_tarjeta`
--
DELIMITER $$
CREATE TRIGGER `IMPUTAR_PAGOS2` BEFORE INSERT ON `pago_con_tarjeta` FOR EACH ROW BEGIN
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
    
    END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pago_con_tarjeta`
--
ALTER TABLE `pago_con_tarjeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarjeta_id` (`tarjeta_id`),
  ADD KEY `pago_realizado_id` (`pago_realizado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pago_con_tarjeta`
--
ALTER TABLE `pago_con_tarjeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pago_con_tarjeta`
--
ALTER TABLE `pago_con_tarjeta`
  ADD CONSTRAINT `pago_con_tarjeta_ibfk_1` FOREIGN KEY (`tarjeta_id`) REFERENCES `tarjeta_de_creditos` (`id`),
  ADD CONSTRAINT `pago_con_tarjeta_ibfk_2` FOREIGN KEY (`pago_realizado_id`) REFERENCES `pagos_realizados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
