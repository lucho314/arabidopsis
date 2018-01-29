-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2017 a las 15:34:10
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
-- Estructura de tabla para la tabla `pagos_realizados`
--

CREATE TABLE `pagos_realizados` (
  `movimiento_id` int(11) NOT NULL,
  `forma_de_pago_id` int(11) NOT NULL,
  `tipo_de_transaccion_id` int(11) NOT NULL,
  `banco_id` int(11) DEFAULT NULL,
  `monto` double NOT NULL,
  `cantidad_cuotas` int(11) DEFAULT NULL,
  `monto_cuota_uno` double DEFAULT NULL,
  `monto_demas_cuotas` double DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pagos_realizados`
--
ALTER TABLE `pagos_realizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forma_de_pago_id` (`forma_de_pago_id`),
  ADD KEY `movimiento_id` (`movimiento_id`),
  ADD KEY `tipo_de_transaccion_id` (`tipo_de_transaccion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pagos_realizados`
--
ALTER TABLE `pagos_realizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos_realizados`
--
ALTER TABLE `pagos_realizados`
  ADD CONSTRAINT `pagos_realizados_ibfk_1` FOREIGN KEY (`forma_de_pago_id`) REFERENCES `forma_de_pagos` (`id`),
  ADD CONSTRAINT `pagos_realizados_ibfk_2` FOREIGN KEY (`movimiento_id`) REFERENCES `movimientos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
