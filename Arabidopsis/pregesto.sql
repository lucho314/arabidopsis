-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-07-2011 a las 09:27:03
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `dni` int(11) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clientes_1` (`provincia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `clientes`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comisions`
--

CREATE TABLE IF NOT EXISTS `comisions` (
  ` id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `mes` date DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (` id`),
  KEY `fk_comisiones_1` (`empleado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `comisions`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `dni` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleados_2` (`tipo_id`),
  KEY `fk_empleados_1` (`provincia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `empleados`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalles`
--

CREATE TABLE IF NOT EXISTS `factura_detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `factura_maestra_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_venta_detalles_1` (`factura_maestra_id`),
  KEY `fk_venta_detalles_2` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `factura_detalles`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_maestras`
--

CREATE TABLE IF NOT EXISTS `factura_maestras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total_venta` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `neto_de_iva` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_venta_maestras_1` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `factura_maestras`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalles`
--

CREATE TABLE IF NOT EXISTS `pedido_detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `pedido_maestro_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_detalles_1` (`pedido_maestro_id`),
  KEY `fk_pedido_detalles_2` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `pedido_detalles`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_maestros`
--

CREATE TABLE IF NOT EXISTS `pedido_maestros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `preventista_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `cant_producto` int(11) DEFAULT NULL,
  `cant_unidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_maestros_2` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `pedido_maestros`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  `margen` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_productos_1` (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `productos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedors`
--

CREATE TABLE IF NOT EXISTS `proveedors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `cuil` int(11) DEFAULT NULL,
  `ing_brutos` int(11) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `hora_de_trabajo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proveedores_2` (`provincia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `proveedors`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito_detalles`
--

CREATE TABLE IF NOT EXISTS `remito_detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `remito_maestro_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_remito_detalles_2` (`producto_id`),
  KEY `fk_remito_detalles_3` (`remito_maestro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `remito_detalles`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remito_maestros`
--

CREATE TABLE IF NOT EXISTS `remito_maestros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `factura_maestra_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total_venta` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `neto_de_iva` decimal(10,2) DEFAULT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_remito_maestros_1` (`cliente_id`),
  KEY `fk_remito_maestros_2` (`factura_maestra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `remito_maestros`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartos`
--

CREATE TABLE IF NOT EXISTS `repartos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `pedido_maestro_id` int(11) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `vuelto_esperado` decimal(10,2) DEFAULT NULL,
  `dinero_ingresado` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reparto_1` (`pedido_maestro_id`),
  KEY `fk_reparto_2` (`empleado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `repartos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `descripcion`) VALUES
(1, 'REPARTIDOR'),
(2, 'REPARTIDOR / PREVENTISTA'),
(3, 'PREVENTISTA'),
(4, 'COBRADOR'),
(5, 'REPARTIDOR / COBRADOR'),
(6, 'PREVENTISTA / COBRADOR'),
(7, 'ADMINSTRATIVO');

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_1` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comisions`
--
ALTER TABLE `comisions`
  ADD CONSTRAINT `fk_comisiones_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleados_1` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleados_2` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_detalles`
--
ALTER TABLE `factura_detalles`
  ADD CONSTRAINT `fk_venta_detalles_1` FOREIGN KEY (`factura_maestra_id`) REFERENCES `factura_maestras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_detalles_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_maestras`
--
ALTER TABLE `factura_maestras`
  ADD CONSTRAINT `fk_venta_maestras_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD CONSTRAINT `fk_pedido_detalles_1` FOREIGN KEY (`pedido_maestro_id`) REFERENCES `pedido_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_detalles_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_maestros`
--
ALTER TABLE `pedido_maestros`
  ADD CONSTRAINT `fk_pedido_maestros_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedors`
--
ALTER TABLE `proveedors`
  ADD CONSTRAINT `fk_proveedores_2` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `remito_detalles`
--
ALTER TABLE `remito_detalles`
  ADD CONSTRAINT `fk_remito_detalles_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_remito_detalles_3` FOREIGN KEY (`remito_maestro_id`) REFERENCES `remito_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `remito_maestros`
--
ALTER TABLE `remito_maestros`
  ADD CONSTRAINT `fk_remito_maestros_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_remito_maestros_2` FOREIGN KEY (`factura_maestra_id`) REFERENCES `factura_maestras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `repartos`
--
ALTER TABLE `repartos`
  ADD CONSTRAINT `fk_reparto_1` FOREIGN KEY (`pedido_maestro_id`) REFERENCES `pedido_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reparto_2` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
