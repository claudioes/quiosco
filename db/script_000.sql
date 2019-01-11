-- --------------------------------------------------------
-- Host:                         192.168.10.11
-- Server version:               10.1.34-MariaDB-0ubuntu0.18.04.1 - Ubuntu 18.04
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table quiosco.archivo
CREATE TABLE IF NOT EXISTS `archivo` (
  `id` char(13) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `objeto` varchar(100) NOT NULL,
  `objeto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_archivo_usuario` (`usuario_id`),
  CONSTRAINT `fk_archivo_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.articulo
CREATE TABLE IF NOT EXISTS `articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(10) NOT NULL,
  `descripcion` varchar(150) CHARACTER SET latin1 NOT NULL,
  `stock_minimo` int(11) NOT NULL DEFAULT '0',
  `familia_id` int(11) NOT NULL,
  `marca_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `costo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ganancia` float NOT NULL DEFAULT '0',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio_modificado` datetime NOT NULL,
  `notas` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `fk_articulo_familia` (`familia_id`),
  KEY `fk_articulo_marca` (`marca_id`),
  KEY `fk_articulo_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_articulo_familia` FOREIGN KEY (`familia_id`) REFERENCES `familia` (`id`),
  CONSTRAINT `fk_articulo_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`),
  CONSTRAINT `fk_articulo_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1055 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.banco
CREATE TABLE IF NOT EXISTS `banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.caja
CREATE TABLE IF NOT EXISTS `caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `concepto` enum('E','C','O','M') NOT NULL COMMENT 'E: Efectivo, C:Cheque, O:Deposito, M:Mercaderia',
  `detalle` varchar(100) NOT NULL,
  `tipo` enum('E','S') NOT NULL COMMENT 'E: Entrada, S:Salida',
  `importe` decimal(10,2) NOT NULL,
  `caja_cierre_id` int(11) DEFAULT NULL,
  `cobrador_id` int(11) DEFAULT NULL,
  `recibo_id` int(11) DEFAULT NULL,
  `pago_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_caja_cobrador` (`cobrador_id`),
  KEY `fk_caja_caja_cierre` (`caja_cierre_id`),
  KEY `fk_caja_recibo` (`recibo_id`),
  KEY `fk_caja_pago` (`pago_id`),
  CONSTRAINT `fk_caja_caja_cierre` FOREIGN KEY (`caja_cierre_id`) REFERENCES `caja_cierre` (`id`),
  CONSTRAINT `fk_caja_cobrador` FOREIGN KEY (`cobrador_id`) REFERENCES `cobrador` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_caja_pago` FOREIGN KEY (`pago_id`) REFERENCES `pago` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_caja_recibo` FOREIGN KEY (`recibo_id`) REFERENCES `recibo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17376 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.caja_cierre
CREATE TABLE IF NOT EXISTS `caja_cierre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_caja_cierre_usuario` (`usuario_id`),
  CONSTRAINT `fk_caja_cierre_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1371 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cheque
CREATE TABLE IF NOT EXISTS `cheque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `banco_id` int(11) NOT NULL,
  `cuit` varchar(13) DEFAULT NULL,
  `fecha` date NOT NULL,
  `importe` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('C','D','E','R') NOT NULL DEFAULT 'C',
  `recibo_id` int(11) DEFAULT NULL,
  `pago_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cheque_banco` (`banco_id`),
  KEY `fk_cheque_recibo` (`recibo_id`),
  KEY `fk_cheque_pago` (`pago_id`),
  CONSTRAINT `fk_cheque_banco` FOREIGN KEY (`banco_id`) REFERENCES `banco` (`id`),
  CONSTRAINT `fk_cheque_pago` FOREIGN KEY (`pago_id`) REFERENCES `pago` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cheque_recibo` FOREIGN KEY (`recibo_id`) REFERENCES `recibo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=619 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon` varchar(100) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `cp` varchar(20) DEFAULT NULL,
  `domicilio_entrega` varchar(100) DEFAULT NULL,
  `localidad_entrega` varchar(100) DEFAULT NULL,
  `cp_entrega` varchar(20) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cuit` varchar(13) DEFAULT NULL,
  `forma_pago_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `notas` text,
  `adv` text,
  `dias_visita` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `fk_cliente_grupo` (`grupo_id`),
  KEY `fk_cliente_forma_pago` (`forma_pago_id`),
  CONSTRAINT `fk_cliente_forma_pago` FOREIGN KEY (`forma_pago_id`) REFERENCES `forma_pago` (`id`),
  CONSTRAINT `fk_cliente_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=842 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cliente_bunker
CREATE TABLE IF NOT EXISTS `cliente_bunker` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `razon` varchar(80) DEFAULT NULL,
  `contacto` varchar(200) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `localidad` varchar(80) DEFAULT NULL,
  `cp` varchar(20) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `fax` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `condicion_iva_id` int(11) NOT NULL,
  `cuit` varchar(11) DEFAULT NULL,
  `condicion_venta_id` int(11) NOT NULL,
  `bonificacion` float NOT NULL DEFAULT '0',
  `notas` text,
  `producto_lista_id` int(11) NOT NULL,
  `provincia_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `controla_cc` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cliente_categoria
CREATE TABLE IF NOT EXISTS `cliente_categoria` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cliente_cc
CREATE TABLE IF NOT EXISTS `cliente_cc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `debe` decimal(10,2) NOT NULL DEFAULT '0.00',
  `haber` decimal(10,2) NOT NULL DEFAULT '0.00',
  `presupuesto_id` int(11) DEFAULT NULL,
  `recibo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_cc_cliente` (`cliente_id`),
  KEY `fk_cliente_cc_presupuesto` (`presupuesto_id`),
  KEY `fk_cliente_cc_recibo` (`recibo_id`),
  CONSTRAINT `fk_cliente_cc_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cliente_cc_presupuesto` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuesto` (`id`),
  CONSTRAINT `fk_cliente_cc_recibo` FOREIGN KEY (`recibo_id`) REFERENCES `recibo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19143 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cliente_descuento
CREATE TABLE IF NOT EXISTS `cliente_descuento` (
  `cliente_id` int(11) NOT NULL,
  `descuento_id` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`,`descuento_id`),
  KEY `fk_cliente_descuento_descuento` (`descuento_id`),
  CONSTRAINT `fk_cliente_descuento_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cliente_descuento_descuento` FOREIGN KEY (`descuento_id`) REFERENCES `descuento` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.cobrador
CREATE TABLE IF NOT EXISTS `cobrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.compra
CREATE TABLE IF NOT EXISTS `compra` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(8) NOT NULL,
  `fecha` date NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `pagado` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notas` text,
  PRIMARY KEY (`id`),
  KEY `fk_compra_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_compra_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=832 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.corredor
CREATE TABLE IF NOT EXISTS `corredor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `porcentaje` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.deposito
CREATE TABLE IF NOT EXISTS `deposito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.descuento
CREATE TABLE IF NOT EXISTS `descuento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `descripcion` varchar(200) NOT NULL,
  `porcentaje_unidad` float NOT NULL DEFAULT '0',
  `porcentaje_multiplo` float NOT NULL DEFAULT '0',
  `multiplo` int(11) NOT NULL DEFAULT '0',
  `porcentaje_cantidad` float NOT NULL DEFAULT '0',
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `familia_id` int(11) DEFAULT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `articulo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_descuento_familia` (`familia_id`),
  KEY `fk_descuento_marca` (`marca_id`),
  KEY `fk_descuento_articulo` (`articulo_id`),
  CONSTRAINT `fk_descuento_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_descuento_familia` FOREIGN KEY (`familia_id`) REFERENCES `familia` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_descuento_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.familia
CREATE TABLE IF NOT EXISTS `familia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.forma_pago
CREATE TABLE IF NOT EXISTS `forma_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descuento` float NOT NULL DEFAULT '0',
  `recargo` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.lp
CREATE TABLE IF NOT EXISTS `lp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `lp_modelo_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion` (`descripcion`),
  KEY `fk_lp_grupo` (`grupo_id`),
  KEY `fk_lp_lp_modelo` (`lp_modelo_id`),
  CONSTRAINT `fk_lp_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
  CONSTRAINT `fk_lp_lp_modelo` FOREIGN KEY (`lp_modelo_id`) REFERENCES `lp_modelo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.lp_articulo
CREATE TABLE IF NOT EXISTS `lp_articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lp_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lp_articulo_articulo` (`articulo_id`),
  KEY `fk_lp_detalle_lp` (`lp_id`),
  CONSTRAINT `fk_lp_articulo_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lp_detalle_lp` FOREIGN KEY (`lp_id`) REFERENCES `lp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=110361 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.lp_generado
CREATE TABLE IF NOT EXISTS `lp_generado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lp_id` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `fecha` date NOT NULL,
  `numero` int(11) NOT NULL,
  `archivo` varchar(100) NOT NULL,
  `cambios` text,
  PRIMARY KEY (`id`),
  KEY `fk_lp_generado_lp` (`lp_id`),
  CONSTRAINT `fk_lp_generado_lp` FOREIGN KEY (`lp_id`) REFERENCES `lp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=986 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.lp_modelo
CREATE TABLE IF NOT EXISTS `lp_modelo` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.pago
CREATE TABLE IF NOT EXISTS `pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `proveedor_id` int(11) NOT NULL,
  `efectivo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mercaderia` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cheques` decimal(10,2) NOT NULL DEFAULT '0.00',
  `anticipo_anterior` decimal(10,2) NOT NULL DEFAULT '0.00',
  `anticipo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notas` text,
  PRIMARY KEY (`id`),
  KEY `fk_pago_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_pago_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=758 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.pago_compra
CREATE TABLE IF NOT EXISTS `pago_compra` (
  `pago_id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  PRIMARY KEY (`pago_id`,`compra_id`),
  KEY `fk_pago_compra_compra` (`compra_id`),
  CONSTRAINT `fk_pago_compra_compra` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`),
  CONSTRAINT `fk_pago_compra_pago` FOREIGN KEY (`pago_id`) REFERENCES `pago` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `facturado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pedido_cliente` (`cliente_id`),
  CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6660 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.pedido_detalle
CREATE TABLE IF NOT EXISTS `pedido_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_detalle_pedido` (`pedido_id`),
  KEY `fk_pedido_detalle_articulo` (`articulo_id`),
  CONSTRAINT `fk_pedido_detalle_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`),
  CONSTRAINT `fk_pedido_detalle_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52794 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.permiso
CREATE TABLE IF NOT EXISTS `permiso` (
  `id` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.presupuesto
CREATE TABLE IF NOT EXISTS `presupuesto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `cliente_saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `iva_descripcion` varchar(100) DEFAULT NULL,
  `iva_porcentaje` float NOT NULL DEFAULT '0',
  `iva` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cobrado` decimal(10,2) NOT NULL DEFAULT '0.00',
  `anulado` tinyint(1) NOT NULL DEFAULT '0',
  `pedido_id` int(11) DEFAULT NULL,
  `notas` text,
  PRIMARY KEY (`id`),
  KEY `fk_presupuesto_cliente` (`cliente_id`),
  KEY `fk_presupuesto_pedido` (`pedido_id`),
  CONSTRAINT `fk_presupuesto_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_presupuesto_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16220 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.presupuesto_detalle
CREATE TABLE IF NOT EXISTS `presupuesto_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presupuesto_id` int(11) NOT NULL,
  `articulo_id` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `descripcion` varchar(150) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `costo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `descuento1` float NOT NULL DEFAULT '0',
  `descuento2` float NOT NULL DEFAULT '0',
  `recargo` float NOT NULL DEFAULT '0',
  `tipo` enum('N','D','C') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `fk_presupuesto_detalle_presupuesto` (`presupuesto_id`),
  KEY `fk_presupuesto_detalle_articulo` (`articulo_id`),
  CONSTRAINT `fk_presupuesto_detalle_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_presupuesto_detalle_presupuesto` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuesto` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124632 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `razon` varchar(100) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `cp` varchar(50) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cuit` varchar(13) DEFAULT NULL,
  `notas` text,
  `anticipo` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.proveedor_cc
CREATE TABLE IF NOT EXISTS `proveedor_cc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `proveedor_id` int(11) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `debe` decimal(10,2) NOT NULL DEFAULT '0.00',
  `haber` decimal(10,2) NOT NULL DEFAULT '0.00',
  `compra_id` int(11) DEFAULT NULL,
  `pago_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proveedor_cc_compra` (`compra_id`),
  KEY `fk_proveedor_cc_pago` (`pago_id`),
  KEY `fk_proveedor_cc_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_proveedor_cc_compra` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_proveedor_cc_pago` FOREIGN KEY (`pago_id`) REFERENCES `pago` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_proveedor_cc_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1589 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.proveedor_documento
CREATE TABLE IF NOT EXISTS `proveedor_documento` (
  `id` char(40) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `aumento` float NOT NULL,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proveedor_lista_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_proveedor_lista_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.recepcion
CREATE TABLE IF NOT EXISTS `recepcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `comprobante_tipo` varchar(50) NOT NULL,
  `comprobante_fecha` date NOT NULL,
  `comprobante_numero` varchar(50) NOT NULL,
  `deposito_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `anulado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_recepcion_deposito` (`deposito_id`),
  KEY `fk_recepcion_proveedor` (`proveedor_id`),
  KEY `fk_recepcion_usuario` (`usuario_id`),
  CONSTRAINT `fk_recepcion_deposito` FOREIGN KEY (`deposito_id`) REFERENCES `deposito` (`id`),
  CONSTRAINT `fk_recepcion_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`),
  CONSTRAINT `fk_recepcion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.recepcion_detalle
CREATE TABLE IF NOT EXISTS `recepcion_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recepcion_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recepcion_detalle_recepcion` (`recepcion_id`),
  KEY `fk_recepcion_detalle_articulo` (`articulo_id`),
  CONSTRAINT `fk_recepcion_detalle_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`),
  CONSTRAINT `fk_recepcion_detalle_recepcion` FOREIGN KEY (`recepcion_id`) REFERENCES `recepcion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2341 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.recibo
CREATE TABLE IF NOT EXISTS `recibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `cobrador_id` int(11) NOT NULL,
  `efectivo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cheques` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deposito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mercaderia` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notas` text,
  PRIMARY KEY (`id`),
  KEY `fk_recibo_cliente` (`cliente_id`),
  KEY `fk_recibo_cobrador` (`cobrador_id`),
  CONSTRAINT `fk_recibo_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  CONSTRAINT `fk_recibo_cobrador` FOREIGN KEY (`cobrador_id`) REFERENCES `cobrador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8611 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.recibo_presupuesto
CREATE TABLE IF NOT EXISTS `recibo_presupuesto` (
  `recibo_id` int(11) NOT NULL,
  `presupuesto_id` int(11) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  PRIMARY KEY (`recibo_id`,`presupuesto_id`),
  KEY `fk_recibo_presupuesto_factura` (`presupuesto_id`),
  CONSTRAINT `fk_recibo_presupuesto_factura` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuesto` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_recibo_presupuesto_recibo` FOREIGN KEY (`recibo_id`) REFERENCES `recibo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.stock_inventario
CREATE TABLE IF NOT EXISTS `stock_inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `deposito_id` int(11) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_inventario_usuario` (`usuario_id`),
  KEY `fk_stock_inventario_deposito` (`deposito_id`),
  CONSTRAINT `fk_stock_inventario_deposito` FOREIGN KEY (`deposito_id`) REFERENCES `deposito` (`id`),
  CONSTRAINT `fk_stock_inventario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=477 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.stock_inventario_detalle
CREATE TABLE IF NOT EXISTS `stock_inventario_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_inventario_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_inventario_detalle_stock_inventario` (`stock_inventario_id`),
  KEY `fk_stock_inventario_detalle_articulo` (`articulo_id`),
  CONSTRAINT `fk_stock_inventario_detalle_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`),
  CONSTRAINT `fk_stock_inventario_detalle_stock_inventario` FOREIGN KEY (`stock_inventario_id`) REFERENCES `stock_inventario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1054 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.stock_movimiento
CREATE TABLE IF NOT EXISTS `stock_movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articulo_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `tipo` enum('E','S') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `deposito_id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movimiento_stock_articulo` (`articulo_id`),
  KEY `fk_movimiento_stock_deposito` (`deposito_id`),
  KEY `fk_movimiento_stock_usuario` (`usuario_id`),
  CONSTRAINT `fk_movimiento_stock_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_movimiento_stock_deposito` FOREIGN KEY (`deposito_id`) REFERENCES `deposito` (`id`),
  CONSTRAINT `fk_movimiento_stock_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79338 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.stock_transferencia
CREATE TABLE IF NOT EXISTS `stock_transferencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `deposito_origen_id` int(11) NOT NULL,
  `deposito_destino_id` int(11) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_transferencia_usuario` (`usuario_id`),
  KEY `fk_stock_transferencia_deposito_origen` (`deposito_origen_id`),
  KEY `fk_stock_transferencia_deposito_destino` (`deposito_destino_id`),
  CONSTRAINT `fk_stock_transferencia_deposito_destino` FOREIGN KEY (`deposito_destino_id`) REFERENCES `deposito` (`id`),
  CONSTRAINT `fk_stock_transferencia_deposito_origen` FOREIGN KEY (`deposito_origen_id`) REFERENCES `deposito` (`id`),
  CONSTRAINT `fk_stock_transferencia_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=794 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.stock_transferencia_detalle
CREATE TABLE IF NOT EXISTS `stock_transferencia_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_transferencia_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_transferencia_detalle_stock_transferencia` (`stock_transferencia_id`),
  KEY `fk_stock_transferencia_detalle_articulo` (`articulo_id`),
  CONSTRAINT `fk_stock_transferencia_detalle_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`),
  CONSTRAINT `fk_stock_transferencia_detalle_stock_transferencia` FOREIGN KEY (`stock_transferencia_id`) REFERENCES `stock_transferencia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1712 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(150) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `administrador` tinyint(4) NOT NULL DEFAULT '0',
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  `dias` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `horario_desde` time DEFAULT NULL,
  `horario_hasta` time DEFAULT NULL,
  `cobrador_id` int(11) NOT NULL,
  `cliente_categoria_id` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_cobrador` (`cobrador_id`),
  KEY `fk_usuario_cliente_categoria` (`cliente_categoria_id`),
  CONSTRAINT `fk_usuario_cliente_categoria` FOREIGN KEY (`cliente_categoria_id`) REFERENCES `cliente_categoria` (`id`),
  CONSTRAINT `fk_usuario_cobrador` FOREIGN KEY (`cobrador_id`) REFERENCES `cobrador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco.usuario_permiso
CREATE TABLE IF NOT EXISTS `usuario_permiso` (
  `usuario_id` int(11) NOT NULL,
  `permiso_id` varchar(50) NOT NULL,
  PRIMARY KEY (`usuario_id`,`permiso_id`),
  KEY `fk_usuario_permiso_permiso` (`permiso_id`),
  CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table quiosco._version
CREATE TABLE IF NOT EXISTS `_version` (
  `version` int(11) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for view quiosco.v_articulo
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_articulo` (
	`id` INT(11) NOT NULL,
	`codigo` INT(10) NOT NULL,
	`descripcion` VARCHAR(150) NOT NULL COLLATE 'latin1_swedish_ci',
	`familia_id` INT(11) NOT NULL,
	`familia` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`marca_id` INT(11) NOT NULL,
	`marca` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`proveedor_id` INT(11) NOT NULL,
	`proveedor` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`costo` DECIMAL(10,2) NOT NULL,
	`ganancia` FLOAT NOT NULL,
	`precio` DECIMAL(10,2) NOT NULL,
	`stock_minimo` INT(11) NOT NULL,
	`stock` DECIMAL(32,0) NOT NULL,
	`stock_distribuidora` DECIMAL(32,0) NOT NULL,
	`stock_deposito` DECIMAL(32,0) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_caja
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_caja` (
	`id` INT(11) NOT NULL,
	`fecha` DATETIME NULL,
	`tipo` ENUM('E','S') NOT NULL COMMENT 'E: Entrada, S:Salida' COLLATE 'utf8_general_ci',
	`tipo_descripcion` VARCHAR(7) NOT NULL COLLATE 'utf8_general_ci',
	`detalle` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`concepto` ENUM('E','C','O','M') NOT NULL COMMENT 'E: Efectivo, C:Cheque, O:Deposito, M:Mercaderia' COLLATE 'utf8_general_ci',
	`concepto_descripcion` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`importe` DECIMAL(10,2) NOT NULL,
	`entrada` DECIMAL(10,2) NOT NULL,
	`salida` DECIMAL(10,2) NOT NULL,
	`cobrador_id` INT(11) NULL,
	`cobrador_nombre` VARCHAR(80) NULL COLLATE 'utf8_general_ci',
	`recibo_id` INT(11) NULL,
	`cliente_id` INT(11) NULL,
	`cliente_codigo` INT(11) NULL,
	`cliente_nombre` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`pago_id` INT(11) NULL,
	`proveedor_id` INT(11) NULL,
	`proveedor_codigo` INT(11) NULL,
	`proveedor_nombre` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`caja_cierre_id` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_caja_cierre
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_caja_cierre` (
	`id` INT(11) NOT NULL,
	`fecha` DATETIME NOT NULL,
	`usuario_id` INT(11) NOT NULL,
	`usuario_nombre_completo` VARCHAR(102) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_cheque
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_cheque` (
	`id` INT(11) NOT NULL,
	`numero` INT(11) NOT NULL,
	`banco_id` INT(11) NOT NULL,
	`banco_nombre` VARCHAR(30) NOT NULL COLLATE 'utf8_general_ci',
	`cuit` VARCHAR(13) NULL COLLATE 'utf8_general_ci',
	`fecha` DATE NOT NULL,
	`importe` DECIMAL(10,2) NOT NULL,
	`estado` ENUM('C','D','E','R') NOT NULL COLLATE 'utf8_general_ci',
	`recibo_id` INT(11) NULL,
	`cliente_id` INT(11) NULL,
	`cliente_codigo` INT(11) NULL,
	`cliente_nombre` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`pago_id` INT(11) NULL,
	`proveedor_id` INT(11) NULL,
	`proveedor_nombre` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`vencimiento` DATE NULL,
	`vencimiento_dias` INT(7) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_cliente
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_cliente` (
	`id` INT(11) NOT NULL,
	`codigo` INT(11) NOT NULL,
	`nombre` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`razon` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`domicilio` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`localidad` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`cp` VARCHAR(20) NULL COLLATE 'utf8_general_ci',
	`telefono` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`email` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`forma_pago_id` INT(11) NOT NULL,
	`forma_pago` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`grupo_id` INT(11) NOT NULL,
	`grupo` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`grupo_descuento` FLOAT NOT NULL,
	`notas` TEXT NULL COLLATE 'utf8_general_ci',
	`saldo` DECIMAL(33,2) NULL,
	`dias_visita` TINYINT(3) UNSIGNED NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_cliente_cc
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_cliente_cc` (
	`id` INT(11) NOT NULL,
	`fecha` DATE NULL,
	`cliente_id` INT(11) NOT NULL,
	`concepto` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`debe` DECIMAL(10,2) NOT NULL,
	`haber` DECIMAL(10,2) NOT NULL,
	`saldo` DECIMAL(11,2) NOT NULL,
	`presupuesto_id` INT(11) NULL,
	`presupuesto_cliente_id` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_cliente_saldo
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_cliente_saldo` (
	`cliente_id` INT(11) NOT NULL,
	`saldo` DECIMAL(33,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_compra
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_compra` (
	`id` INT(10) NOT NULL,
	`tipo` VARCHAR(8) NOT NULL COLLATE 'utf8_general_ci',
	`fecha` DATE NOT NULL,
	`proveedor_id` INT(11) NOT NULL,
	`proveedor_nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`total` DECIMAL(10,2) NOT NULL,
	`pagado` DECIMAL(10,2) NOT NULL,
	`notas` TEXT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_descuento
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_descuento` (
	`id` INT(11) NOT NULL,
	`desde` DATE NULL,
	`hasta` DATE NULL,
	`porcentaje_unidad` FLOAT NOT NULL,
	`porcentaje_multiplo` FLOAT NOT NULL,
	`multiplo` INT(11) NOT NULL,
	`familia_id` INT(11) NULL,
	`familia` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`marca_id` INT(11) NULL,
	`marca` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`articulo_id` INT(11) NULL,
	`articulo_codigo` INT(10) NULL,
	`articulo_descripcion` VARCHAR(150) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_lp
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_lp` (
	`id` INT(11) NOT NULL,
	`descripcion` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`grupo_id` INT(11) NOT NULL,
	`grupo_nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`ultimo_numero` BIGINT(11) NULL,
	`generados` BIGINT(21) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_pago
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_pago` (
	`id` INT(11) NOT NULL,
	`fecha` DATETIME NOT NULL,
	`proveedor_id` INT(11) NOT NULL,
	`proveedor_nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`anticipo_anterior` DECIMAL(10,2) NOT NULL,
	`efectivo` DECIMAL(10,2) NOT NULL,
	`mercaderia` DECIMAL(10,2) NOT NULL,
	`cheques` DECIMAL(10,2) NOT NULL,
	`total` DECIMAL(10,2) NOT NULL,
	`anticipo` DECIMAL(10,2) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_pedido
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_pedido` (
	`id` INT(11) NOT NULL,
	`fecha` DATE NOT NULL,
	`cliente_id` INT(11) NOT NULL,
	`cliente_codigo` INT(11) NOT NULL,
	`cliente_nombre` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`facturado` TINYINT(4) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_presupuesto
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_presupuesto` 
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_presupuesto_detalle
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_presupuesto_detalle` (
	`id` INT(11) NOT NULL,
	`presupuesto_id` INT(11) NOT NULL,
	`articulo_id` INT(11) NULL,
	`codigo` INT(11) NULL,
	`descripcion` VARCHAR(150) NOT NULL COLLATE 'utf8_general_ci',
	`cantidad` INT(11) NOT NULL,
	`costo` DECIMAL(10,2) NOT NULL,
	`precio` DECIMAL(10,2) NOT NULL,
	`precio_recargo` DOUBLE(19,2) NULL,
	`descuento1` FLOAT NOT NULL,
	`descuento2` FLOAT NOT NULL,
	`recargo` FLOAT NOT NULL,
	`precio_neto` DOUBLE(19,2) NULL,
	`tipo` ENUM('N','D','C') NOT NULL COLLATE 'utf8_general_ci',
	`importe` DOUBLE(19,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_proveedor
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_proveedor` (
	`id` INT(11) NOT NULL,
	`codigo` INT(11) NOT NULL,
	`nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`razon` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`domicilio` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`localidad` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`cp` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`telefono` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`email` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`notas` TEXT NULL COLLATE 'utf8_general_ci',
	`saldo` DECIMAL(33,2) NULL,
	`anticipo` DECIMAL(10,2) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_proveedor_saldo
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_proveedor_saldo` (
	`proveedor_id` INT(11) NOT NULL,
	`saldo` DECIMAL(33,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_recepcion
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_recepcion` (
	`id` INT(11) NOT NULL,
	`fecha` DATETIME NOT NULL,
	`proveedor_id` INT(11) NOT NULL,
	`proveedor_nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`comprobante_tipo` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`comprobante_fecha` DATE NOT NULL,
	`comprobante_numero` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`usuario_id` INT(11) NOT NULL,
	`usuario_nombre` VARCHAR(102) NOT NULL COLLATE 'utf8_general_ci',
	`deposito_id` INT(11) NOT NULL,
	`deposito_nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`anulado` TINYINT(4) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_stock
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_stock` (
	`articulo_id` INT(11) NOT NULL,
	`cantidad` DECIMAL(32,0) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_stock_deposito
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_stock_deposito` (
	`articulo_id` INT(11) NOT NULL,
	`deposito_id` INT(11) NOT NULL,
	`cantidad` DECIMAL(32,0) NULL
) ENGINE=MyISAM;

-- Dumping structure for view quiosco.v_articulo
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_articulo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_articulo` AS select `a`.`id` AS `id`,`a`.`codigo` AS `codigo`,`a`.`descripcion` AS `descripcion`,`a`.`familia_id` AS `familia_id`,`f`.`nombre` AS `familia`,`a`.`marca_id` AS `marca_id`,`m`.`nombre` AS `marca`,`a`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `proveedor`,`a`.`costo` AS `costo`,`a`.`ganancia` AS `ganancia`,`a`.`precio` AS `precio`,`a`.`stock_minimo` AS `stock_minimo`,ifnull(`s`.`cantidad`,0) AS `stock`,ifnull(`d1`.`cantidad`,0) AS `stock_distribuidora`,ifnull(`d2`.`cantidad`,0) AS `stock_deposito` from ((((((`articulo` `a` join `familia` `f` on((`a`.`familia_id` = `f`.`id`))) join `marca` `m` on((`a`.`marca_id` = `m`.`id`))) join `proveedor` `p` on((`a`.`proveedor_id` = `p`.`id`))) left join `v_stock` `s` on((`s`.`articulo_id` = `a`.`id`))) left join `v_stock_deposito` `d1` on(((`d1`.`articulo_id` = `a`.`id`) and (`d1`.`deposito_id` = 1)))) left join `v_stock_deposito` `d2` on(((`d2`.`articulo_id` = `a`.`id`) and (`d2`.`deposito_id` = 2))));

-- Dumping structure for view quiosco.v_caja
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_caja`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_caja` AS select `c`.`id` AS `id`,`c`.`fecha` AS `fecha`,`c`.`tipo` AS `tipo`,(case `c`.`tipo` when 'E' then 'Entrada' else 'Salida' end) AS `tipo_descripcion`,`c`.`detalle` AS `detalle`,`c`.`concepto` AS `concepto`,(case `c`.`concepto` when 'E' then 'Efectivo' when 'C' then 'Cheque' when 'O' then 'Deposito' when 'M' then 'Mercadería' else 'Otro' end) AS `concepto_descripcion`,`c`.`importe` AS `importe`,(case `c`.`tipo` when 'E' then `c`.`importe` else 0 end) AS `entrada`,(case `c`.`tipo` when 'S' then `c`.`importe` else 0 end) AS `salida`,`c`.`cobrador_id` AS `cobrador_id`,`b`.`nombre` AS `cobrador_nombre`,`c`.`recibo_id` AS `recibo_id`,`r`.`cliente_id` AS `cliente_id`,`l`.`codigo` AS `cliente_codigo`,`l`.`nombre` AS `cliente_nombre`,`c`.`pago_id` AS `pago_id`,`p`.`proveedor_id` AS `proveedor_id`,`v`.`codigo` AS `proveedor_codigo`,`v`.`nombre` AS `proveedor_nombre`,`c`.`caja_cierre_id` AS `caja_cierre_id` from (((((`caja` `c` left join `cobrador` `b` on((`c`.`cobrador_id` = `b`.`id`))) left join `recibo` `r` on((`c`.`recibo_id` = `r`.`id`))) left join `cliente` `l` on((`r`.`cliente_id` = `l`.`id`))) left join `pago` `p` on((`c`.`pago_id` = `p`.`id`))) left join `proveedor` `v` on((`p`.`proveedor_id` = `v`.`id`)));

-- Dumping structure for view quiosco.v_caja_cierre
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_caja_cierre`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_caja_cierre` AS select `c`.`id` AS `id`,`c`.`fecha` AS `fecha`,`c`.`usuario_id` AS `usuario_id`,concat(`u`.`apellido`,', ',`u`.`nombre`) AS `usuario_nombre_completo` from (`caja_cierre` `c` join `usuario` `u` on((`c`.`usuario_id` = `u`.`id`)));

-- Dumping structure for view quiosco.v_cheque
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_cheque`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_cheque` AS select `c`.`id` AS `id`,`c`.`numero` AS `numero`,`c`.`banco_id` AS `banco_id`,`b`.`nombre` AS `banco_nombre`,`c`.`cuit` AS `cuit`,`c`.`fecha` AS `fecha`,`c`.`importe` AS `importe`,`c`.`estado` AS `estado`,`c`.`recibo_id` AS `recibo_id`,`r`.`cliente_id` AS `cliente_id`,`l`.`codigo` AS `cliente_codigo`,`l`.`nombre` AS `cliente_nombre`,`c`.`pago_id` AS `pago_id`,`p`.`proveedor_id` AS `proveedor_id`,`v`.`nombre` AS `proveedor_nombre`,(`c`.`fecha` + interval 30 day) AS `vencimiento`,(to_days((`c`.`fecha` + interval 30 day)) - to_days(curdate())) AS `vencimiento_dias` from (((((`cheque` `c` join `banco` `b` on((`c`.`banco_id` = `b`.`id`))) left join `recibo` `r` on((`c`.`recibo_id` = `r`.`id`))) left join `cliente` `l` on((`r`.`cliente_id` = `l`.`id`))) left join `pago` `p` on((`c`.`pago_id` = `p`.`id`))) left join `proveedor` `v` on((`p`.`proveedor_id` = `v`.`id`)));

-- Dumping structure for view quiosco.v_cliente
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_cliente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_cliente` AS select `c`.`id` AS `id`,`c`.`codigo` AS `codigo`,`c`.`nombre` AS `nombre`,`c`.`razon` AS `razon`,`c`.`domicilio` AS `domicilio`,`c`.`localidad` AS `localidad`,`c`.`cp` AS `cp`,`c`.`telefono` AS `telefono`,`c`.`email` AS `email`,`c`.`forma_pago_id` AS `forma_pago_id`,`p`.`descripcion` AS `forma_pago`,`c`.`grupo_id` AS `grupo_id`,`g`.`nombre` AS `grupo`,`g`.`descuento` AS `grupo_descuento`,`c`.`notas` AS `notas`,(case when isnull(`s`.`saldo`) then 0 else `s`.`saldo` end) AS `saldo`,`c`.`dias_visita` AS `dias_visita` from (((`cliente` `c` join `grupo` `g` on((`g`.`id` = `c`.`grupo_id`))) join `forma_pago` `p` on((`p`.`id` = `c`.`forma_pago_id`))) left join `v_cliente_saldo` `s` on((`c`.`id` = `s`.`cliente_id`)));

-- Dumping structure for view quiosco.v_cliente_cc
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_cliente_cc`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_cliente_cc` AS select `c`.`id` AS `id`,`c`.`fecha` AS `fecha`,`c`.`cliente_id` AS `cliente_id`,`c`.`concepto` AS `concepto`,`c`.`debe` AS `debe`,`c`.`haber` AS `haber`,(`c`.`debe` - `c`.`haber`) AS `saldo`,`c`.`presupuesto_id` AS `presupuesto_id`,`p`.`cliente_id` AS `presupuesto_cliente_id` from (`cliente_cc` `c` left join `presupuesto` `p` on((`c`.`presupuesto_id` = `p`.`id`)));

-- Dumping structure for view quiosco.v_cliente_saldo
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_cliente_saldo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_cliente_saldo` AS select `c`.`cliente_id` AS `cliente_id`,sum((`c`.`debe` - `c`.`haber`)) AS `saldo` from `cliente_cc` `c` group by `c`.`cliente_id`;

-- Dumping structure for view quiosco.v_compra
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_compra`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_compra` AS select `c`.`id` AS `id`,`c`.`tipo` AS `tipo`,`c`.`fecha` AS `fecha`,`c`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `proveedor_nombre`,`c`.`total` AS `total`,`c`.`pagado` AS `pagado`,`c`.`notas` AS `notas` from (`compra` `c` join `proveedor` `p` on((`c`.`proveedor_id` = `p`.`id`)));

-- Dumping structure for view quiosco.v_descuento
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_descuento`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_descuento` AS select `d`.`id` AS `id`,`d`.`desde` AS `desde`,`d`.`hasta` AS `hasta`,`d`.`porcentaje_unidad` AS `porcentaje_unidad`,`d`.`porcentaje_multiplo` AS `porcentaje_multiplo`,`d`.`multiplo` AS `multiplo`,`d`.`familia_id` AS `familia_id`,`f`.`nombre` AS `familia`,`d`.`marca_id` AS `marca_id`,`m`.`nombre` AS `marca`,`d`.`articulo_id` AS `articulo_id`,`a`.`codigo` AS `articulo_codigo`,`a`.`descripcion` AS `articulo_descripcion` from (((`descuento` `d` left join `marca` `m` on((`d`.`marca_id` = `m`.`id`))) left join `familia` `f` on((`d`.`familia_id` = `f`.`id`))) left join `articulo` `a` on((`d`.`articulo_id` = `a`.`id`)));

-- Dumping structure for view quiosco.v_lp
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_lp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_lp` AS select `lp`.`id` AS `id`,`lp`.`descripcion` AS `descripcion`,`lp`.`grupo_id` AS `grupo_id`,`g`.`nombre` AS `grupo_nombre`,(select max(`g1`.`numero`) from `lp_generado` `g1` where (`g1`.`lp_id` = `lp`.`id`)) AS `ultimo_numero`,(select count(0) from `lp_generado` `g2` where (`g2`.`lp_id` = `lp`.`id`)) AS `generados` from (`lp` join `grupo` `g` on((`lp`.`grupo_id` = `g`.`id`)));

-- Dumping structure for view quiosco.v_pago
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_pago`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_pago` AS select `p`.`id` AS `id`,`p`.`fecha` AS `fecha`,`p`.`proveedor_id` AS `proveedor_id`,`v`.`nombre` AS `proveedor_nombre`,`p`.`anticipo_anterior` AS `anticipo_anterior`,`p`.`efectivo` AS `efectivo`,`p`.`mercaderia` AS `mercaderia`,`p`.`cheques` AS `cheques`,`p`.`total` AS `total`,`p`.`anticipo` AS `anticipo` from (`pago` `p` join `proveedor` `v` on((`p`.`proveedor_id` = `v`.`id`)));

-- Dumping structure for view quiosco.v_pedido
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_pedido`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_pedido` AS select `p`.`id` AS `id`,`p`.`fecha` AS `fecha`,`p`.`cliente_id` AS `cliente_id`,`c`.`codigo` AS `cliente_codigo`,`c`.`nombre` AS `cliente_nombre`,`p`.`facturado` AS `facturado` from (`pedido` `p` join `cliente` `c` on((`p`.`cliente_id` = `c`.`id`)));

-- Dumping structure for view quiosco.v_presupuesto
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_presupuesto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_presupuesto` AS select `p`.`id` AS `id`,`p`.`fecha` AS `fecha`,`p`.`cliente_id` AS `cliente_id`,`c`.`codigo` AS `cliente_codigo`,`c`.`nombre` AS `cliente_nombre`,`c`.`cliente_categoria_id` AS `cliente_categoria_id`,`p`.`subtotal` AS `subtotal`,`p`.`iva_descripcion` AS `iva_descripcion`,`p`.`iva_porcentaje` AS `iva_porcentaje`,`p`.`iva` AS `iva`,`p`.`total` AS `total`,`p`.`cliente_saldo` AS `cliente_saldo`,`p`.`anulado` AS `anulado`,`p`.`pedido_id` AS `pedido_id`,`p`.`notas` AS `notas` from (`presupuesto` `p` join `cliente` `c` on((`p`.`cliente_id` = `c`.`id`)));

-- Dumping structure for view quiosco.v_presupuesto_detalle
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_presupuesto_detalle`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_presupuesto_detalle` AS select `d`.`id` AS `id`,`d`.`presupuesto_id` AS `presupuesto_id`,`d`.`articulo_id` AS `articulo_id`,`d`.`codigo` AS `codigo`,`d`.`descripcion` AS `descripcion`,`d`.`cantidad` AS `cantidad`,`d`.`costo` AS `costo`,`d`.`precio` AS `precio`,round((`d`.`precio` * (1 + (`d`.`recargo` / 100))),2) AS `precio_recargo`,`d`.`descuento1` AS `descuento1`,`d`.`descuento2` AS `descuento2`,`d`.`recargo` AS `recargo`,round(((round((`d`.`precio` * (1 + (`d`.`recargo` / 100))),2) * (1 - (`d`.`descuento1` / 100))) * (1 - (`d`.`descuento2` / 100))),2) AS `precio_neto`,`d`.`tipo` AS `tipo`,(`d`.`cantidad` * round(((round((`d`.`precio` * (1 + (`d`.`recargo` / 100))),2) * (1 - (`d`.`descuento1` / 100))) * (1 - (`d`.`descuento2` / 100))),2)) AS `importe` from `presupuesto_detalle` `d`;

-- Dumping structure for view quiosco.v_proveedor
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_proveedor`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_proveedor` AS select `p`.`id` AS `id`,`p`.`codigo` AS `codigo`,`p`.`nombre` AS `nombre`,`p`.`razon` AS `razon`,`p`.`domicilio` AS `domicilio`,`p`.`localidad` AS `localidad`,`p`.`cp` AS `cp`,`p`.`telefono` AS `telefono`,`p`.`email` AS `email`,`p`.`notas` AS `notas`,(case when isnull(`s`.`saldo`) then 0 else `s`.`saldo` end) AS `saldo`,`p`.`anticipo` AS `anticipo` from (`proveedor` `p` left join `v_proveedor_saldo` `s` on((`p`.`id` = `s`.`proveedor_id`)));

-- Dumping structure for view quiosco.v_proveedor_saldo
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_proveedor_saldo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_proveedor_saldo` AS select `p`.`proveedor_id` AS `proveedor_id`,sum((`p`.`debe` - `p`.`haber`)) AS `saldo` from `proveedor_cc` `p` group by `p`.`proveedor_id`;

-- Dumping structure for view quiosco.v_recepcion
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_recepcion`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_recepcion` AS select `r`.`id` AS `id`,`r`.`fecha` AS `fecha`,`r`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `proveedor_nombre`,`r`.`comprobante_tipo` AS `comprobante_tipo`,`r`.`comprobante_fecha` AS `comprobante_fecha`,`r`.`comprobante_numero` AS `comprobante_numero`,`r`.`usuario_id` AS `usuario_id`,concat(`u`.`apellido`,', ',`u`.`nombre`) AS `usuario_nombre`,`r`.`deposito_id` AS `deposito_id`,`d`.`nombre` AS `deposito_nombre`,`r`.`anulado` AS `anulado` from (((`recepcion` `r` join `proveedor` `p` on((`r`.`proveedor_id` = `p`.`id`))) join `usuario` `u` on((`r`.`usuario_id` = `u`.`id`))) join `deposito` `d` on((`r`.`deposito_id` = `d`.`id`)));

-- Dumping structure for view quiosco.v_stock
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_stock`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_stock` AS select `m`.`articulo_id` AS `articulo_id`,sum((case when (`m`.`tipo` = 'E') then `m`.`cantidad` else -(`m`.`cantidad`) end)) AS `cantidad` from `stock_movimiento` `m` group by `m`.`articulo_id`;

-- Dumping structure for view quiosco.v_stock_deposito
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_stock_deposito`;
CREATE ALGORITHM=UNDEFINED DEFINER=`minim`@`%` SQL SECURITY DEFINER VIEW `v_stock_deposito` AS select `m`.`articulo_id` AS `articulo_id`,`m`.`deposito_id` AS `deposito_id`,sum((case when (`m`.`tipo` = 'E') then `m`.`cantidad` else -(`m`.`cantidad`) end)) AS `cantidad` from `stock_movimiento` `m` group by `m`.`deposito_id`,`m`.`articulo_id`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
