-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-07-2011 a las 10:14:20
-- Versión del servidor: 5.1.54
-- Versión de PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pregesto`
--

--
-- Volcar la base de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `descripcion`, `provincia_id`, `nombre`, `apellido`, `dni`, `domicilio`, `email`, `telefono`, `celular`, `localidad`, `razon_social`, `cuit`, `condicion_iva_id`) VALUES
(1, 'ELIAS, WALTER RICARDO 23368818', 7, 'WALTER RICARDO', 'ELIAS', 23368818, 'LOS JILGUEROS 160', 'WELIAS@OROVERDEDIGITAL.COM.AR', 4975442, 154067888, 'ORO VERDE', NULL, NULL, NULL);

--
-- Volcar la base de datos para la tabla `comisions`
--


--
-- Volcar la base de datos para la tabla `empleados`
--


--
-- Volcar la base de datos para la tabla `factura_detalles`
--


--
-- Volcar la base de datos para la tabla `factura_maestros`
--

INSERT INTO `factura_maestros` (`id`, `descripcion`, `cliente_id`, `fecha`, `total_venta`, `iva`, `neto_de_iva`) VALUES
(6, '1', 1, '2011-07-14', '0.00', '0.00', '0.00');

--
-- Volcar la base de datos para la tabla `pedido_detalles`
--


--
-- Volcar la base de datos para la tabla `pedido_maestros`
--


--
-- Volcar la base de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `descripcion`, `proveedor_id`, `codigo`, `nombre`, `costo`, `margen`, `iva`, `disponibles`, `rubro_id`) VALUES
(1, '1 - ANANá RODAJA X 565 GRS.', 2, 1, 'ANANá RODAJA X 565 GRS.', 7, '30.00', '21.00', '5', 7);

--
-- Volcar la base de datos para la tabla `proveedors`
--

INSERT INTO `proveedors` (`id`, `descripcion`, `provincia_id`, `razon_social`, `cuit`, `ing_brutos`, `direccion`, `contacto`, `localidad`, `telefono`, `celular`, `hora_de_trabajo`, `condicion_iva_id`) VALUES
(2, 'ORO VERDE DIGITAL SRL - 30710060114', 7, 'ORO VERDE DIGITAL SRL', 2147483647, 2147483647, 'LOS JILGUEROS 160', 'WALTER ELIAS', 'ORO VERDE', 343, 343, 'COMERCIAL', 3);

--
-- Volcar la base de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `descripcion`) VALUES
(1, 'BUENOS AIRES'),
(2, 'CATAMARCA'),
(3, 'CHACO'),
(4, 'CHUBUT'),
(5, 'CÓRDOBA'),
(6, 'CORRIENTES'),
(7, 'ENTRE RÍOS'),
(8, 'FORMOSA'),
(9, 'JUJUY'),
(10, 'LA PAMPA'),
(11, 'LA RIOJA'),
(12, 'MENDOZA'),
(13, 'MISIONES'),
(14, 'NEUQUÉN'),
(15, 'RÍO NEGRO'),
(16, 'SALTA'),
(17, 'SAN JUAN'),
(18, 'SAN LUIS'),
(19, 'SANTA CRUZ'),
(20, 'SANTA FE'),
(21, 'SANTIAGO DEL ESTERO'),
(22, 'TIERRA DEL FUEGO, ANTÁRTIDA E ISLAS DEL ATLÁN'),
(23, 'TUCUMÁN');

--
-- Volcar la base de datos para la tabla `remito_detalles`
--


--
-- Volcar la base de datos para la tabla `remito_maestros`
--


--
-- Volcar la base de datos para la tabla `repartos`
--


--
-- Volcar la base de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`id`, `descripcion`) VALUES
(1, 'ACEITUNAS & ENCURTIDOS'),
(2, 'CEREALES DESAYUNO'),
(3, 'CEREALES INFLADOS'),
(4, 'COMESTIBLES'),
(5, 'CONDIMENTOS'),
(6, 'COPETÍN'),
(7, 'ENLATA'),
(8, 'FRESCOS'),
(9, 'FRUTAS SECAS'),
(10, 'GALLETITAS'),
(11, 'LEGUMBRES'),
(12, 'LIMPIEZA'),
(13, 'PANIFICACIÓN'),
(14, 'VARIOS');

--
-- Volcar la base de datos para la tabla `tipo`
--

