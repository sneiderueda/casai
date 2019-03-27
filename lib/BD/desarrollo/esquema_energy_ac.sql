CREATE DATABASE  IF NOT EXISTS `energy_ac` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `energy_ac`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: energy_ac
-- ------------------------------------------------------
-- Server version	5.1.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cf_actividad`
--

DROP TABLE IF EXISTS `cf_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_actividad` (
  `actividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `actividad_descripcion` varchar(200) NOT NULL,
  `actividad_estado` int(5) DEFAULT '1',
  `actividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `actividad_fechmodifico` timestamp NULL DEFAULT NULL,
  `actividad_GOM` varchar(45) DEFAULT NULL,
  `actividad_unidadservicio` varchar(45) DEFAULT NULL,
  `actividad_usuariocreo` int(11) DEFAULT NULL,
  `actividad_usuariomodifico` int(11) DEFAULT NULL,
  `actividad_valorservicio` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`actividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_alcance`
--

DROP TABLE IF EXISTS `cf_alcance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_alcance` (
  `alcance_id` int(11) NOT NULL AUTO_INCREMENT,
  `alcance_descripcion` longtext,
  `alcance_estado` int(5) NOT NULL DEFAULT '1',
  `alcance_fechacreo` datetime DEFAULT NULL,
  `alcance_fechamodifico` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `alcance_usuariocreo` int(11) DEFAULT NULL,
  `alcance_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`alcance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1262 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_area`
--

DROP TABLE IF EXISTS `cf_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_estado` int(5) DEFAULT '1',
  `area_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `area_fechamodifico` timestamp NULL DEFAULT NULL,
  `area_nombre` varchar(45) NOT NULL,
  `area_usuariocreo` int(11) DEFAULT NULL,
  `area_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_cumplimentacion`
--

DROP TABLE IF EXISTS `cf_cumplimentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cumplimentacion` (
  `cumplimentacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `cumplimentacion_aperturarp` datetime DEFAULT NULL,
  `cumplimentacion_cierreapertura` datetime DEFAULT NULL,
  `cumplimentacion_descargo` varchar(45) DEFAULT NULL,
  `cumplimentacion_estado` int(11) DEFAULT '1',
  `cumplimentacion_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cumplimentacion_fechafincod` datetime DEFAULT NULL,
  `cumplimentacion_fechainicod` datetime DEFAULT NULL,
  `cumplimentacion_fechamodifico` datetime DEFAULT NULL,
  `cumplimentacion_gestor` int(11) DEFAULT NULL COMMENT 'id de la tabla perfil_usuario',
  `cumplimentacion_jornada` varchar(45) DEFAULT NULL,
  `cumplimentacion_obs` varchar(5000) DEFAULT NULL,
  `cumplimentacion_operadorapertura` varchar(200) DEFAULT NULL,
  `cumplimentacion_operariocierre` varchar(200) DEFAULT NULL,
  `cumplimentacion_usuariocreo` int(11) NOT NULL,
  `cumplimentacion_usuariomodifico` int(11) DEFAULT NULL,
  `ingenieros` varchar(45) DEFAULT NULL COMMENT 'en este campo van a ir los id\\''s  de la tabla perfil usuario que se asignan al descargo',
  `tipodescargo_id` int(11) DEFAULT NULL,
  `subestacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cumplimentacion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_entregable`
--

DROP TABLE IF EXISTS `cf_entregable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_entregable` (
  `entregable_id` int(11) NOT NULL AUTO_INCREMENT,
  `entregable_descripcion` longtext,
  `entregable_estado` int(11) NOT NULL DEFAULT '1',
  `entregable_fechacreo` timestamp NULL DEFAULT NULL,
  `entregable_fechamodifico` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `entregable_usuariocreo` int(11) DEFAULT NULL,
  `entregable_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`entregable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1431 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_labor`
--

DROP TABLE IF EXISTS `cf_labor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_labor` (
  `labor_id` int(11) NOT NULL AUTO_INCREMENT,
  `labor_descripcion` varchar(500) NOT NULL,
  `labor_estado` int(5) DEFAULT '1',
  `labor_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `labor_fechamodifico` timestamp NULL DEFAULT NULL,
  `labor_unidmedida` varchar(500) DEFAULT NULL,
  `labor_usuariocreo` int(11) DEFAULT NULL,
  `labor_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`labor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_menu`
--

DROP TABLE IF EXISTS `cf_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_estado` int(11) NOT NULL DEFAULT '1',
  `menu_fechacreo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `menu_fechamodifico` timestamp NULL DEFAULT NULL,
  `menu_icono` varchar(45) DEFAULT NULL,
  `menu_idpadre` varchar(45) NOT NULL,
  `menu_nombre` varchar(100) NOT NULL,
  `menu_orderurl` int(11) DEFAULT NULL,
  `menu_tipo` varchar(45) NOT NULL,
  `menu_URL` varchar(100) DEFAULT NULL,
  `menu_usuariocreo` int(11) NOT NULL,
  `menu_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_modulo`
--

DROP TABLE IF EXISTS `cf_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_modulo` (
  `modulo_id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_descripcion` varchar(100) NOT NULL,
  `modulo_estado` int(11) NOT NULL DEFAULT '1',
  `modulo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modulo_fechamodifico` datetime DEFAULT NULL,
  `modulo_usuariocreo` int(11) NOT NULL,
  `modulo_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`modulo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2451 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_perfil`
--

DROP TABLE IF EXISTS `cf_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_perfil` (
  `perfil_id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil_estado` int(11) DEFAULT '1',
  `perfil_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `perfil_fechamodifico` timestamp NULL DEFAULT NULL,
  `perfil_nombre` varchar(100) NOT NULL,
  `perfil_usuariocreo` int(11) DEFAULT NULL,
  `perfil_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_subactividad`
--

DROP TABLE IF EXISTS `cf_subactividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_subactividad` (
  `subactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `subactividad_descripcion` varchar(300) DEFAULT NULL,
  `subactividad_estado` int(5) DEFAULT '1',
  `subactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `subactividad_usuariocreo` int(5) DEFAULT NULL,
  `subactividad_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`subactividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cf_tipobaremo`
--

DROP TABLE IF EXISTS `cf_tipobaremo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_tipobaremo` (
  `tipobaremo_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipobaremo_descripcion` varchar(45) DEFAULT NULL,
  `tipobaremo_estado` int(5) DEFAULT '1',
  `tipobaremo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tipobaremo_fechamodifico` timestamp NULL DEFAULT NULL,
  `tipobaremo_sigla` varchar(45) DEFAULT NULL,
  `tipobaremo_usuariocreo` int(11) DEFAULT NULL,
  `tipobaremo_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`tipobaremo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_cliente`
--

DROP TABLE IF EXISTS `dt_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_cliente` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_descripcion` varchar(100) NOT NULL,
  `cliente_estado` int(5) DEFAULT '1',
  `cliente_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cliente_fechamodifico` timestamp NULL DEFAULT NULL,
  `cliente_PID` varchar(45) DEFAULT NULL,
  `cliente_usuariocreo` int(11) DEFAULT NULL,
  `cliente_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_contrato`
--

DROP TABLE IF EXISTS `dt_contrato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_contrato` (
  `contrato_id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_estado` int(5) NOT NULL DEFAULT '1',
  `contrato_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `contrato_fechainicio` varchar(45) DEFAULT NULL,
  `contrato_fechafin` varchar(45) DEFAULT NULL,
  `contrato_fechamodifico` timestamp NULL DEFAULT NULL,
  `contrato_numero` varchar(45) NOT NULL,
  `contrato_usuariocreo` int(11) DEFAULT NULL,
  `contrato_usuariomodifico` int(11) DEFAULT NULL,
  `contrato_valor` varchar(45) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`contrato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_detalle_presupuesto`
--

DROP TABLE IF EXISTS `dt_detalle_presupuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_detalle_presupuesto` (
  `detallepresupuesto_id` int(11) NOT NULL AUTO_INCREMENT,
  `detallepresupuesto_alcance` varchar(20000) DEFAULT NULL,
  `detallepresupuesto_estado` int(5) DEFAULT '1',
  `detallepresupuesto_fechaini` date DEFAULT NULL,
  `detallepresupuesto_fechafin` date DEFAULT NULL,
  `detallepresupuesto_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detallepresupuesto_fechamodifico` datetime DEFAULT NULL,
  `detallepresupuesto_gestor` int(11) DEFAULT NULL,
  `detallepresupuesto_nombre` varchar(200) DEFAULT NULL,
  `detallepresupuesto_objeto` varchar(2000) DEFAULT NULL,
  `detallepresupuesto_total` varchar(45) DEFAULT NULL,
  `detallepresupuesto_usuariocreo` int(11) DEFAULT NULL,
  `detallepresupuesto_usuariomodifico` int(11) DEFAULT NULL,
  `subestacion_id` int(11) NOT NULL,
  `contrato_id` int(11) NOT NULL,
  PRIMARY KEY (`detallepresupuesto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_factura`
--

DROP TABLE IF EXISTS `dt_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_factura` (
  `factura_id` int(11) NOT NULL AUTO_INCREMENT,
  `factura_estado` varchar(45) NOT NULL,
  `factura_fechainicio` date NOT NULL,
  `factura_fechafin` date NOT NULL,
  `factura_fechacreo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `factura_fechamodifico` datetime DEFAULT NULL,
  `factura_numero` varchar(45) DEFAULT NULL,
  `factura_porcentajeactual` varchar(45) DEFAULT NULL,
  `factura_porcentajeinicial` varchar(45) DEFAULT NULL,
  `factura_porcentajependiente` varchar(45) DEFAULT NULL,
  `factura_usuariocreo` int(11) NOT NULL,
  `factura_usuariomodifico` int(11) DEFAULT NULL,
  `factura_valorfacturado` varchar(45) DEFAULT NULL,
  `factura_valorpendiente` varchar(45) DEFAULT NULL,
  `factura_valortotal` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`factura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_soporte`
--

DROP TABLE IF EXISTS `dt_soporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_soporte` (
  `soporte_id` int(11) NOT NULL AUTO_INCREMENT,
  `soporte_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `soporte_fechamodifico` datetime DEFAULT NULL,
  `soporte_nombre` varchar(2000) DEFAULT NULL,
  `soporte_tamano` varchar(45) DEFAULT NULL,
  `soporte_tipo` varchar(45) DEFAULT NULL,
  `soporte_url` varchar(1000) DEFAULT NULL,
  `soporte_usuariocreo` int(11) DEFAULT NULL,
  `soporte_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`soporte_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_subestacion`
--

DROP TABLE IF EXISTS `dt_subestacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_subestacion` (
  `subestacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `subestacion_aplicaiva` varchar(10) DEFAULT NULL,
  `subestacion_codigo` varchar(45) DEFAULT NULL,
  `subestacion_estado` int(11) DEFAULT '1',
  `subestacion_fax` varchar(45) DEFAULT NULL,
  `subestacion_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subestacion_fechamodifico` datetime DEFAULT NULL,
  `subestacion_hicom` varchar(45) DEFAULT NULL,
  `subestacion_nombre` varchar(100) NOT NULL,
  `subestacion_telefono` varchar(45) DEFAULT NULL,
  `subestacion_usuariocreo` int(11) DEFAULT NULL,
  `subestacion_usuariomodifico` int(11) DEFAULT NULL,
  `subestacion_ubicacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`subestacion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_tipo_descargo`
--

DROP TABLE IF EXISTS `dt_tipo_descargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_tipo_descargo` (
  `tipodescargo_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipodescargo_descripcion` varchar(45) DEFAULT NULL,
  `tipodescargo_estado` int(11) DEFAULT '1',
  `tipodescargo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tipodescargo_fechamodifico` datetime DEFAULT NULL,
  `tipodescargo_usuariocreo` int(11) NOT NULL,
  `tipodescargo_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`tipodescargo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dt_usuario`
--

DROP TABLE IF EXISTS `dt_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dt_usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_afp` varchar(45) DEFAULT NULL,
  `usuario_apellidos` varchar(70) DEFAULT NULL,
  `usuario_arp` varchar(45) DEFAULT NULL,
  `usuario_cajacomp` varchar(100) DEFAULT NULL,
  `usuario_cargo` varchar(45) DEFAULT NULL,
  `usuario_cedula` int(11) DEFAULT NULL,
  `usuario_celular` int(11) DEFAULT NULL,
  `usuario_condicionmedica` varchar(100) DEFAULT NULL,
  `usuario_contrato` varchar(45) DEFAULT NULL,
  `usuario_conyuge` varchar(45) DEFAULT NULL,
  `usuario_correo` varchar(60) DEFAULT NULL,
  `usuario_clasesalario` varchar(45) DEFAULT NULL,
  `usuario_ctconduccion` varchar(30) DEFAULT NULL,
  `usuario_direccion` varchar(45) DEFAULT NULL,
  `usuario_eps` varchar(70) DEFAULT NULL,
  `usuario_estado` varchar(45) DEFAULT '1',
  `usuario_expedicion` varchar(70) DEFAULT NULL,
  `usuario_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_fechamodifico` timestamp NULL DEFAULT NULL,
  `usuario_fenacimiento` varchar(45) DEFAULT NULL,
  `usuario_fentregacarp` date DEFAULT NULL,
  `usuario_fentregaceps` date DEFAULT NULL,
  `usuario_fentregacempresa` date DEFAULT NULL,
  `usuario_fentregaccodensa` date DEFAULT NULL,
  `usuario_fincontrato` date DEFAULT NULL,
  `usuario_horario` varchar(45) DEFAULT NULL,
  `usuario_jornada` varchar(45) DEFAULT NULL,
  `usuario_iniarp` varchar(50) DEFAULT NULL,
  `usuario_iniafp` varchar(45) DEFAULT NULL,
  `usuario_inicajacomp` varchar(45) DEFAULT NULL,
  `usuario_inieps` varchar(45) DEFAULT NULL,
  `usuario_inicontrato` date DEFAULT NULL,
  `usuario_inilaboral` date DEFAULT NULL,
  `usuario_lugnacimiento` varchar(45) DEFAULT NULL,
  `usuario_matricula` varchar(45) DEFAULT NULL,
  `usuario_nombre` varchar(70) DEFAULT NULL,
  `usuario_nombrehijos` varchar(200) DEFAULT NULL,
  `usuario_numcuenta` varchar(45) DEFAULT NULL,
  `usuario_numhijos` int(11) DEFAULT NULL,
  `usuario_numcontrato` varchar(45) DEFAULT NULL,
  `usuario_observaciones` varchar(100) DEFAULT NULL,
  `usuario_password` varchar(2000) NOT NULL,
  `usuario_prompactado` varchar(45) DEFAULT NULL,
  `usuario_porcentajearp` varchar(20) DEFAULT NULL,
  `usuario_profesion` varchar(45) DEFAULT NULL,
  `usuario_riesgoarp` int(11) DEFAULT NULL,
  `usuario_RH` varchar(10) DEFAULT NULL,
  `usuario_rol` varchar(45) DEFAULT NULL,
  `usuario_salario` varchar(45) DEFAULT NULL,
  `usuario_Tchaqueta` varchar(10) DEFAULT NULL,
  `usuario_Tchaleco` varchar(10) DEFAULT NULL,
  `usuario_Tcamisa` varchar(10) DEFAULT NULL,
  `usuario_Tcamiseta` varchar(10) DEFAULT NULL,
  `usuario_Tpantalon` varchar(10) DEFAULT NULL,
  `usuario_Tcalzado` varchar(10) DEFAULT NULL,
  `usuario_telefono` int(11) DEFAULT NULL,
  `usuario_tipocontrato` varchar(45) DEFAULT NULL,
  `usuario_tp` varchar(45) DEFAULT NULL,
  `usuario_universidad` varchar(100) DEFAULT NULL,
  `usuario_usuariocreo` int(11) DEFAULT NULL,
  `usuario_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_alcance_subactividad`
--

DROP TABLE IF EXISTS `pt_alcance_subactividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_alcance_subactividad` (
  `alcancesubactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `alcancesubactividad_estado` int(11) DEFAULT '1',
  `alcancesubactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `alcancesubactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `alcancesubactividad_usuariocreo` int(11) DEFAULT NULL,
  `alcancesubactividad_usuariomodifico` int(11) DEFAULT NULL,
  `alcance_id` int(11) NOT NULL,
  `detalleactividad_id` int(11) NOT NULL,
  PRIMARY KEY (`alcancesubactividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1262 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_baremo`
--

DROP TABLE IF EXISTS `pt_baremo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_baremo` (
  `baremo_id` int(11) NOT NULL AUTO_INCREMENT,
  `baremo_estado` int(5) DEFAULT '1',
  `baremo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `baremo_fechamodifico` timestamp NULL DEFAULT NULL,
  `baremo_item` varchar(45) DEFAULT NULL,
  `baremo_totalsinIva` varchar(10) DEFAULT NULL COMMENT 'si aplica el iva ''si'' de lo contrario ''no''',
  `baremo_unidadservicio` varchar(45) DEFAULT NULL,
  `baremo_usuariocreo` int(11) DEFAULT NULL,
  `baremo_usuariomodifico` int(11) DEFAULT NULL,
  `baremo_valorservicio` varchar(45) DEFAULT NULL,
  `baremo_valortotalAct` varchar(45) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `labor_id` int(11) NOT NULL,
  `tipobaremo_id` int(11) NOT NULL,
  PRIMARY KEY (`baremo_id`),
  KEY `fk_pt_baremo_cf_labor1_idx` (`labor_id`),
  KEY `fk_pt_baremo_cf_tipobaremo1_idx` (`tipobaremo_id`),
  KEY `fk_pt_baremo_dt_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_pt_baremo_cf_labor1` FOREIGN KEY (`labor_id`) REFERENCES `cf_labor` (`labor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pt_baremo_cf_tipobaremo1` FOREIGN KEY (`tipobaremo_id`) REFERENCES `cf_tipobaremo` (`tipobaremo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pt_baremo_dt_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `dt_cliente` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_baremo_actividad`
--

DROP TABLE IF EXISTS `pt_baremo_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_baremo_actividad` (
  `baremoactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `baremoactividad_estado` int(5) DEFAULT '1',
  `baremoactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `baremoactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `baremoactividad_usuariocreo` int(11) DEFAULT NULL,
  `baremoactividad_usuariomodifico` int(11) DEFAULT NULL,
  `actividad_id` int(11) NOT NULL,
  `baremo_id` int(11) NOT NULL,
  PRIMARY KEY (`baremoactividad_id`),
  KEY `fk_pt_baremo_actividad_pt_baremo1_idx` (`baremo_id`),
  KEY `fk_pt_baremo_actividad_cf_actividad1_idx` (`actividad_id`),
  CONSTRAINT `fk_pt_baremo_actividad_cf_actividad1` FOREIGN KEY (`actividad_id`) REFERENCES `cf_actividad` (`actividad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pt_baremo_actividad_pt_baremo1` FOREIGN KEY (`baremo_id`) REFERENCES `pt_baremo` (`baremo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_descargo`
--

DROP TABLE IF EXISTS `pt_descargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_descargo` (
  `descargo_id` int(11) NOT NULL AUTO_INCREMENT,
  `descargo_actividad` varchar(5000) DEFAULT NULL,
  `descargo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `descargo_fechamodifico` datetime DEFAULT NULL,
  `descargo_num` varchar(45) DEFAULT NULL,
  `descargo_riesgo` varchar(2000) DEFAULT NULL,
  `descargo_usuariocreo` varchar(45) DEFAULT NULL,
  `descargo_usuariomodifico` varchar(45) DEFAULT NULL,
  `ordentrabajo_id` int(11) DEFAULT NULL,
  `presupuesto_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`descargo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_detalle_actividad`
--

DROP TABLE IF EXISTS `pt_detalle_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_detalle_actividad` (
  `detalleactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `detallesubactividad_costosinIva` varchar(45) DEFAULT NULL,
  `detalleactividad_estado` int(5) DEFAULT '1',
  `detalleactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detalleactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `detalleactividad_iva` varchar(10) DEFAULT NULL COMMENT 'valor del iva',
  `detallesubactividad_porc` varchar(11) NOT NULL,
  `detalleactividad_usuariocreo` int(11) DEFAULT NULL,
  `detalleactividad_usuariomodifico` int(11) DEFAULT NULL,
  `actividad_id` int(11) NOT NULL,
  `baremoactividad_id` int(11) NOT NULL,
  `subactividad_id` int(11) NOT NULL,
  PRIMARY KEY (`detalleactividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=424 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_detalle_factura`
--

DROP TABLE IF EXISTS `pt_detalle_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_detalle_factura` (
  `detallefactura_id` int(11) NOT NULL AUTO_INCREMENT,
  `detallefactura_avance` varchar(45) DEFAULT NULL COMMENT 'porcentaje trabajado de cada actividad del presupuesto',
  `detallefactura_estado` varchar(45) DEFAULT NULL,
  `detallefactura_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detallefactura_fechamodifico` datetime DEFAULT NULL,
  `detallefactura_obs` varchar(200) DEFAULT NULL,
  `detallefactura_usuariocreo` int(11) DEFAULT NULL,
  `detallefactura_usuariomodifico` int(11) DEFAULT NULL,
  `detallefactura_valoravance` varchar(45) DEFAULT NULL,
  `factura_id` int(11) DEFAULT NULL,
  `presupuesto_id` int(11) NOT NULL,
  PRIMARY KEY (`detallefactura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_detalle_subactividad`
--

DROP TABLE IF EXISTS `pt_detalle_subactividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_detalle_subactividad` (
  `detallesubactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `detallesubactividad_estado` int(11) DEFAULT '1',
  `detallesubactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detallesubactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `detallesubactividad_usuariocreo` int(11) DEFAULT NULL,
  `detallesubactividad_usuariomodifico` int(11) DEFAULT NULL,
  `detallesubactividad_valor` varchar(45) DEFAULT NULL,
  `alcance_id` int(11) DEFAULT NULL,
  `entregable_id` varchar(45) DEFAULT NULL,
  `subactividad_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`detallesubactividad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_entregable_subactividad`
--

DROP TABLE IF EXISTS `pt_entregable_subactividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_entregable_subactividad` (
  `entregablesubactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `entregablesubactividad_estado` int(11) NOT NULL DEFAULT '1',
  `entregablesubactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `entregablesubactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `entregablesubactividad_usuariocreo` int(11) DEFAULT NULL,
  `entregablesubactividad_usuariomodifico` int(11) DEFAULT NULL,
  `entregable_id` int(11) NOT NULL,
  `detalleactividad_id` int(11) NOT NULL,
  PRIMARY KEY (`entregablesubactividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1431 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_menu_perfil`
--

DROP TABLE IF EXISTS `pt_menu_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_menu_perfil` (
  `menuperfil_id` int(11) NOT NULL AUTO_INCREMENT,
  `menuperfil_estado` int(5) DEFAULT '1',
  `menuperfil_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `menuperfil_fechamodifico` timestamp NULL DEFAULT NULL,
  `menuperfil_usuariocreo` int(11) DEFAULT NULL,
  `menuperfil_usuariomodifico` int(11) DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `perfil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`menuperfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_orden_trabajo`
--

DROP TABLE IF EXISTS `pt_orden_trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_orden_trabajo` (
  `ordentrabajo_id` int(11) NOT NULL AUTO_INCREMENT,
  `ordentrabajo_contratista` varchar(200) DEFAULT NULL,
  `ordentrabajo_estado` varchar(45) DEFAULT '1',
  `ordentrabajo_fechacreo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ordentrabajo_fechaemision` date DEFAULT NULL,
  `ordentrabajo_fechaini` date NOT NULL,
  `ordentrabajo_fechamodifico` timestamp NULL DEFAULT NULL,
  `ordentrabajo_GOM` varchar(45) DEFAULT NULL,
  `ordentrabajo_num` varchar(45) DEFAULT NULL,
  `ordentrabajo_obs` varchar(1000) DEFAULT NULL COMMENT 'En este campo va el nombre del proyecto de la OT',
  `ordentrabajo_usuariocreo` int(11) DEFAULT NULL,
  `ordentrabajo_usuariomodifico` int(11) DEFAULT NULL,
  `detallepresupuesto_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ordentrabajo_id`,`ordentrabajo_fechaini`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_perfil_usuario`
--

DROP TABLE IF EXISTS `pt_perfil_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_perfil_usuario` (
  `perfilusuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `perfilusuario_estado` int(5) DEFAULT '1',
  `perfilusuario_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `perfilusuario_fechamodifico` timestamp NULL DEFAULT NULL,
  `perfilusuario_usuariocreo` int(11) DEFAULT NULL,
  `perfilusuario_usuariomodifico` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `perfil_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`perfilusuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=520 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_presupuesto`
--

DROP TABLE IF EXISTS `pt_presupuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_presupuesto` (
  `presupuesto_id` int(11) NOT NULL AUTO_INCREMENT,
  `presupuesto_alcances` varchar(500) DEFAULT NULL,
  `presupuesto_encargado` int(11) DEFAULT NULL,
  `presupuesto_entregables` varchar(500) DEFAULT NULL,
  `presupuesto_asignadopor` int(11) DEFAULT NULL,
  `presupuesto_estado` int(5) DEFAULT '1',
  `presupuesto_fechaini` date DEFAULT NULL,
  `presupuesto_fechafin` date DEFAULT NULL,
  `presupuesto_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `presupuesto_fechamodifico` datetime DEFAULT NULL,
  `presupuesto_horaini` varchar(45) DEFAULT NULL,
  `presupuesto_horafin` varchar(45) DEFAULT NULL,
  `presupuesto_obs` varchar(5000) DEFAULT NULL,
  `presupuesto_porcentaje` varchar(45) DEFAULT NULL,
  `presupuesto_progestado` varchar(100) DEFAULT NULL,
  `presupuesto_usuariocreo` int(11) DEFAULT NULL,
  `presupuesto_usuariomodifico` int(11) DEFAULT NULL,
  `presupuesto_valorporcentaje` varchar(45) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `detallepresupuesto_id` int(11) NOT NULL,
  `baremoactividad_id` int(11) DEFAULT NULL,
  `baremo_id` int(11) NOT NULL,
  `detalleactividad_id` int(11) DEFAULT NULL,
  `modulo_id` int(11) DEFAULT NULL,
  `tipobaremo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`presupuesto_id`),
  KEY `fk_pt_presupuesto_pt_baremo1_idx` (`baremo_id`),
  CONSTRAINT `fk_pt_presupuesto_pt_baremo1` FOREIGN KEY (`baremo_id`) REFERENCES `pt_baremo` (`baremo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_seguimiento`
--

DROP TABLE IF EXISTS `pt_seguimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_seguimiento` (
  `seguimiento_id` int(11) NOT NULL AUTO_INCREMENT,
  `seguimiento_avance` varchar(45) DEFAULT NULL COMMENT 'porcentaje de avance en la actividad',
  `seguimiento_ejecutor` int(11) DEFAULT NULL COMMENT 'id del usuario que ejecuto la actividad',
  `seguimiento_estado` varchar(45) NOT NULL DEFAULT '1',
  `seguimiento_fechaini` date DEFAULT NULL,
  `seguimiento_fechafin` date DEFAULT NULL,
  `seguimiento_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seguimiento_fechamodifico` datetime DEFAULT NULL,
  `seguimiento_horaini` varchar(45) DEFAULT NULL,
  `seguimiento_horafin` varchar(45) DEFAULT NULL,
  `seguimiento_num` varchar(45) DEFAULT NULL,
  `seguimiento_obs` varchar(5000) DEFAULT NULL,
  `seguimiento_usuariocreo` int(11) DEFAULT NULL,
  `seguimiento_usuariomodifico` int(11) DEFAULT NULL,
  `baremo_id` int(11) NOT NULL,
  `ordentrabajo_id` int(11) DEFAULT NULL,
  `presupuesto_id` int(11) DEFAULT NULL,
  `tipobaremo_id` int(11) NOT NULL,
  PRIMARY KEY (`seguimiento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt_soporte_seguimiento`
--

DROP TABLE IF EXISTS `pt_soporte_seguimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt_soporte_seguimiento` (
  `soporteseguimiento_id` int(11) NOT NULL AUTO_INCREMENT,
  `soporteseguimiento_estado` int(5) DEFAULT '1',
  `soporteseguimiento_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `soporteseguimiento_fechamodifico` datetime DEFAULT NULL,
  `soporteseguimiento_usuariocreo` int(11) DEFAULT NULL,
  `soporteseguimiento_usuariomodifico` int(11) DEFAULT NULL,
  `soporteseguimiento_tipo` varchar(45) DEFAULT NULL COMMENT 'si es de cumplimentacion o de seguimiento del presupuesto',
  `seguimiento_id` int(11) NOT NULL COMMENT 'va el id de la tabla seguimiento o de cumplimentacion ',
  `soporte_id` int(11) NOT NULL,
  PRIMARY KEY (`soporteseguimiento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'energy_ac'
--
/*!50003 DROP PROCEDURE IF EXISTS `PS_ptBaremoactividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `PS_ptBaremoactividad`(
IN _tipoControl varchar(11),
IN _baremoactividad_id varchar(11),
IN _baremoactividad_estado varchar(45),
IN _baremoactividad_fechacreo varchar(45),
IN _baremoactividad_fechamodifico varchar(45),
IN _baremoactividad_usuariocreo varchar(45),
IN _baremoactividad_usuariomodifico varchar(45),
IN _actividad_id varchar(45),
IN _baremo_id varchar(11)
)
BEGIN
DECLARE baremoactividad_id_insert INT;
 
if _tipoControl='1' THEN -- Consultar actividades por id_baremo del baremo
select *
   from pt_baremo_actividad
  where actividad_id=_actividad_id
    and baremo_id=_baremo_id;
elseif _tipoControl='2' THEN -- Insertar la actividades del baremo
			  INSERT INTO pt_baremo_actividad(baremoactividad_usuariocreo,
											 actividad_id,
											 baremo_id)
									  VALUES(_baremoactividad_usuariocreo,
  											 _actividad_id,
											 _baremo_id);
SET baremoactividad_id_insert= LAST_INSERT_ID();
select baremoactividad_id_insert;
elseif _tipoControl='3' THEN -- consultar actividades por baremo
	 SELECT ac.actividad_id,
			ac.actividad_descripcion,
			ac.actividad_valorservicio,
			ba.baremoactividad_id
	   FROM pt_baremo_actividad ba
	   JOIN cf_actividad ac ON ba.actividad_id=ac.actividad_id
	    AND ba.baremo_id=_baremo_id
	    AND ba.baremoactividad_estado=1;
elseif _tipoControl='4' THEN -- ACTUALIZAR ESTADO
	UPDATE pt_baremo_actividad 
	   SET baremoactividad_estado = 0,
           baremoactividad_usuariomodifico=NOW(),
           baremoactividad_usuariomodifico=_baremoactividad_usuariomodifico
	 WHERE baremoactividad_id = _baremoactividad_id;
	 
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfactividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfactividad`(
IN _tipoControl varchar(11),
IN _actividad_id varchar(11),
IN _actividad_descripcion varchar(500),
IN _actividad_estado varchar(11),
IN _actividad_fechacreo varchar(11),
IN _actividad_fechmodifico varchar(11),
IN _actividad_GOM varchar(45),
IN _actividad_unidadservicio varchar(11),
IN _actividad_usuariocreo varchar(11),
IN _actividad_usuariomodifico varchar(11),
IN _actividad_valorservicio varchar(11)
)
BEGIN
 DECLARE insert_actividad_id INT;
if _tipoControl='1' THEN -- Consultar actividad
SELECT * 
  FROM cf_actividad 
 where actividad_descripcion=_actividad_descripcion
   and actividad_unidadservicio=_actividad_unidadservicio
   and actividad_valorservicio=_actividad_valorservicio
   and actividad_estado=1;
elseif _tipoControl='2' THEN -- Insertar la actividad
			  INSERT INTO cf_actividad(actividad_descripcion,
									   actividad_GOM,
									   actividad_unidadservicio,
									   actividad_usuariocreo,
									   actividad_valorservicio)
								VALUES(_actividad_descripcion,	
									   _actividad_GOM,
									   _actividad_unidadservicio,
									   _actividad_usuariocreo,
									   _actividad_valorservicio);
SET insert_actividad_id= LAST_INSERT_ID();
select insert_actividad_id;
 
elseif _tipoControl='3' THEN -- Consultar actividad por descripcion
	SELECT * 
	  FROM cf_actividad 
     WHERE actividad_descripcion=_actividad_descripcion;
elseif _tipoControl='4' THEN -- Consultar actividad por descripcion
	SELECT * 
	  FROM cf_actividad 
     WHERE actividad_id=_actividad_id;
elseif _tipoControl='5' THEN -- Actualizar
 UPDATE cf_actividad
	SET actividad_descripcion = _actividad_descripcion,
		actividad_fechmodifico = NOW(),
		actividad_GOM =_actividad_GOM,
		actividad_unidadservicio =_actividad_unidadservicio,
		actividad_usuariomodifico =_actividad_usuariomodifico,
		actividad_valorservicio = _actividad_valorservicio
  WHERE actividad_id = _actividad_id;
     
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfalcance` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfalcance`(
IN _tipoControl varchar(11),
IN _alcance_id varchar(11),
IN _alcance_descripcion varchar(500),
IN _alcance_estado varchar(11),
IN _alcance_fechacreo varchar(45),
IN _alcance_fechamodifico varchar(45),
IN _alcance_usuariocreo varchar(45),
IN _alcance_usuariomodifico varchar(45)
)
BEGIN
DECLARE alcance_id_insert INT;
DECLARE _existe_alcance INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar alcances
select *
   from cf_alcance
  where alcance_estado=1
  ORDER BY alcance_descripcion ASC;
elseif _tipoControl='2' THEN -- Insertar la alcances
select alcance_id from cf_alcance 
where alcance_descripcion=_alcance_descripcion
INTO _existe_alcance;
IF _existe_alcance >0 then
	UPDATE cf_alcance 
	   SET alcance_estado = 1,
           alcance_fechamodifico=NOW(),
           alcance_usuariomodifico=_alcance_usuariocreo
	 WHERE alcance_id = _existe_alcance;
	 SET alcance_id_insert= _existe_alcance;
ELSE
	 INSERT INTO cf_alcance(alcance_descripcion,alcance_usuariocreo)
                VALUES(_alcance_descripcion,_alcance_usuariocreo);
	 SET alcance_id_insert= LAST_INSERT_ID();
END IF;
select alcance_id_insert;
elseif _tipoControl='3' THEN -- Eliminar alcance
	UPDATE cf_alcance 
	   SET alcance_estado = _alcance_estado,
           alcance_fechamodifico=NOW(),
           alcance_usuariomodifico=_alcance_usuariomodifico
	 WHERE alcance_id = _alcance_id;
elseif _tipoControl='4' THEN -- Consultar alcance_id
select *
   from cf_alcance
  where alcance_id=_alcance_id;
elseif _tipoControl='5' THEN -- Actualizar descripcion alcance
	UPDATE cf_alcance 
	   SET alcance_descripcion = _alcance_descripcion,
           alcance_fechamodifico=NOW(),
           alcance_usuariomodifico=_alcance_usuariomodifico
	 WHERE alcance_id = _alcance_id;
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfentregable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfentregable`(
IN _tipoControl varchar(11),
IN _entregable_id varchar(11),
IN _entregable_descripcion varchar(500),
IN _entregable_estado varchar(11),
IN _entregable_fechacreo varchar(45),
IN _entregable_fechamodifico varchar(45),
IN _entregable_usuariocreo varchar(45),
IN _entregable_usuariomodifico varchar(45)
)
BEGIN
DECLARE entregable_id_insert INT;
DECLARE _existe_entregable INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar entregable
select *
   from cf_entregable
  where entregable_estado=1
ORDER BY entregable_descripcion ASC;
elseif _tipoControl='2' THEN -- Insertar la entregable
select entregable_id from cf_entregable 
where entregable_descripcion=_entregable_descripcion
INTO _existe_entregable;
IF _existe_entregable >0 then
	UPDATE cf_entregable 
	   SET entregable_estado = 1,
           entregable_fechamodifico=NOW(),
           entregable_usuariomodifico=_entregable_usuariocreo
	 WHERE entregable_id = _existe_entregable;
	 SET entregable_id_insert= _existe_entregable;
ELSE
	 INSERT INTO cf_entregable(entregable_descripcion,entregable_usuariocreo)
                VALUES(_entregable_descripcion,_entregable_usuariocreo);
	 SET entregable_id_insert= LAST_INSERT_ID();
END IF;
select entregable_id_insert;
elseif _tipoControl='3' THEN -- Eliminar entregable
	UPDATE cf_entregable 
	   SET entregable_estado = _entregable_estado,
           entregable_fechamodifico=NOW(),
           entregable_usuariomodifico=_entregable_usuariomodifico
	 WHERE entregable_id = _entregable_id;
elseif _tipoControl='4' THEN -- Consultar entregable_id
select *
   from cf_entregable
  where entregable_id=_entregable_id;
elseif _tipoControl='5' THEN -- actualizar entregable
	UPDATE cf_entregable 
	   SET entregable_descripcion = _entregable_descripcion,
           entregable_fechamodifico=NOW(),
           entregable_usuariomodifico=_entregable_usuariomodifico
	 WHERE entregable_id = _entregable_id;
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cflabor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cflabor`(
IN _tipoControl varchar(11),
IN _labor_id varchar(100),
IN _labor_descripcion varchar(500),
IN _labor_estado varchar(11),
IN _labor_fechacreo varchar(11),
IN _labor_fechamodifico varchar(11),
IN _labor_unidmedida varchar(45),
IN _labor_usuariocreo varchar(11),
IN _labor_usuariomodifico varchar(11)
)
BEGIN
 DECLARE insert_labor_id INT;
if _tipoControl='1' THEN -- Consultar labor
SELECT * 
  FROM cf_labor 
 where labor_descripcion=_labor_descripcion
   and labor_unidmedida=_labor_unidmedida
   and labor_estado=1;
elseif _tipoControl='2' THEN -- Insertar la labor
			  INSERT INTO cf_labor(labor_descripcion,								   
								   labor_unidmedida
								   )
				             VALUES(_labor_descripcion,									
									_labor_unidmedida);
SET insert_labor_id= LAST_INSERT_ID();
select insert_labor_id;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfmodulo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfmodulo`(
IN _tipoControl varchar(11),	
IN _modulo_id varchar(11),
IN _modulo_descripcion varchar(100),
IN _modulo_estado varchar(11),
IN _modulo_fechacreo varchar(45),
IN _modulo_fechamodifico varchar(45),
IN _modulo_usuariocreo varchar(45),
IN _modulo_usuariomodifico varchar(45)
)
BEGIN
DECLARE modulo_id_insert INT;
DECLARE _existe_modulo INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar
	SELECT * FROM cf_modulo WHERE modulo_estado=1 ORDER BY modulo_descripcion ASC;
elseif _tipoControl='2' THEN -- Insertar 
	SELECT modulo_id 
      FROM cf_modulo 
	 WHERE modulo_descripcion=_modulo_descripcion
	  INTO _existe_modulo;
IF _existe_modulo >0 then
	UPDATE cf_modulo 
	   SET modulo_estado = 1,
           modulo_fechamodifico=NOW(),
           modulo_usuariomodifico=_modulo_usuariocreo
	 WHERE modulo_id = _existe_modulo;
	 SET modulo_id_insert= _existe_modulo;
ELSE
	 INSERT INTO cf_modulo(modulo_descripcion,
						   modulo_usuariocreo)
					VALUES(_modulo_descripcion,
						   _modulo_usuariocreo
							);
	 SET modulo_id_insert= LAST_INSERT_ID();
END IF;
select modulo_id_insert;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfperfil` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfperfil`(
IN _tipoControl varchar(50),
IN _usuario_correo varchar(100),
IN _perfil_id varchar(11),
IN _perfil_estato varchar(11),
IN _perfil_fechamodifico varchar(11),
IN _perfil_nombre varchar(100),
IN _perfil_usuariocreo varchar(11),
IN _perfil_usuariomodifico varchar(11)
)
    COMMENT '1=CONSULTAR PERFILES'
BEGIN
if _tipoControl='1' THEN
	SELECT * FROM cf_perfil WHERE perfil_id=_perfil_id;
END if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfsubactividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfsubactividad`(
IN _tipoControl varchar(11),
IN _subactividad_id varchar(11),
IN _subactividad_descripcion varchar(300),
IN _subactividad_estado varchar(11),
IN _subactividad_fechacreo varchar(45),
IN _subactividad_fechamodifico varchar(45),
IN _subactividad_usuariocreo varchar(45),
IN _subactividad_usuariomodifico varchar(45)
)
BEGIN
DECLARE subactividad_id_insert INT;
DECLARE _existe_subactividad INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar subactividades
select *
   from cf_subactividad
  where subactividad_estado=1;
elseif _tipoControl='2' THEN -- Insertar la subactividades
select subactividad_id from cf_subactividad 
where subactividad_descripcion=_subactividad_descripcion
INTO _existe_subactividad;
IF _existe_subactividad >0 then
	UPDATE cf_subactividad 
	   SET subactividad_estado = 1,
           subactividad_fechamodifico=NOW(),
           subactividad_usuariomodifico=_subactividad_usuariocreo
	 WHERE subactividad_id = _existe_subactividad;
	 SET subactividad_id_insert= _existe_subactividad;
ELSE
	 INSERT INTO cf_subactividad(subactividad_descripcion,subactividad_usuariocreo)
                VALUES(_subactividad_descripcion,_subactividad_usuariocreo);
	 SET subactividad_id_insert= LAST_INSERT_ID();
END IF;
select subactividad_id_insert;
elseif _tipoControl='3' THEN -- Actualizar descripcion de la subactividad
	UPDATE cf_subactividad 
	   SET subactividad_descripcion = _subactividad_descripcion,
           subactividad_fechamodifico=NOW(),
           subactividad_usuariomodifico=_subactividad_usuariomodifico
	 WHERE subactividad_id = _subactividad_id;
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_cfTipobaremo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_cfTipobaremo`(
IN _tipoControl varchar(5),
IN _tipobaremo_id varchar(11),
IN _tipobaremo_descripcion varchar(11),
IN _tipobaremo_estado varchar(45),
IN _tipobaremo_fechacreo varchar(45),
IN _tipobaremo_fechamodifico varchar(45),
IN _tipobaremo_sigla varchar(45),
IN _tipobaremo_usuariocreo varchar(45),
IN _tipobaremo_usuariomodifico varchar(45)
)
BEGIN
if _tipoControl='1' THEN -- Consultar tipo Baremos
 select *
   from cf_tipobaremo
  where tipobaremo_estado=1
order by tipobaremo_descripcion DESC;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_dtCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_dtCliente`(
IN _tipoControl varchar(11),
IN _cliente_descripcion varchar(100),
IN _cliente_PID varchar(45),
IN _cliente_usuariocreo varchar(11),
IN _cliente_usuariomodifico varchar(11),
IN _cliente_id varchar(11),
IN _cliente_estado varchar(11)
)
    COMMENT '1=CONSULTA DE CLIENTES CONTRATO'
BEGIN
 DECLARE _client_id INT;
IF _tipoControl='1' THEN -- Consultar clientes
				SELECT *
			      FROM dt_cliente
			  ORDER BY cliente_descripcion DESC;
              
elseif _tipoControl='2' THEN -- Insertar cliente
			  INSERT INTO dt_cliente(cliente_descripcion,
									 cliente_PID,
									 cliente_usuariocreo
								    )
				             VALUES(_cliente_descripcion,
									_cliente_PID,
									_cliente_usuariocreo);
SET _client_id= LAST_INSERT_ID();
select _client_id as clien_id;
elseif _tipoControl='3' THEN -- Consultar datos de un cliente
				SELECT *
			      FROM dt_cliente
				 WHERE cliente_id=_cliente_id;
elseif _tipoControl='4' THEN -- Actualizar el estado del cliente
	UPDATE dt_cliente 
	   SET cliente_estado = _cliente_estado,
           cliente_fechamodifico=NOW(),
           cliente_usuariomodifico=_cliente_usuariomodifico
	 WHERE cliente_id = _cliente_id;
				
elseif _tipoControl='5' THEN -- Actualizar datos del cliente
	UPDATE dt_cliente 
	   SET cliente_descripcion = _cliente_descripcion,
		   cliente_PID=_cliente_PID,
           cliente_fechamodifico=NOW(),
           cliente_usuariomodifico=_cliente_usuariomodifico
	 WHERE cliente_id = _cliente_id;
     
elseif _tipoControl='6' THEN -- Cliente Contrato
		 SELECT ct.contrato_id,
				cl.cliente_descripcion,
				ct.contrato_numero
		   FROM dt_contrato ct
		   JOIN dt_cliente cl ON ct.cliente_id=cl.cliente_id
		    AND ct.contrato_estado=1
	   GROUP BY cl.cliente_descripcion,ct.contrato_numero;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_dtcontrato` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_dtcontrato`(
IN _tipoControl varchar(11),
IN _contrato_fechainicio varchar(45),
IN _contrato_fechafin varchar(45),
IN _contrato_numero varchar(45),
IN _contrato_usuariocreo varchar(11),
IN _contrato_usuariomodifico varchar(11),
IN _contrato_valor varchar(45),
IN _cliente_id varchar(11),
IN _contrato_estado varchar(11),
IN _contrato_id varchar(11)
)
    COMMENT 'parametrizacion de la data de contratos'
BEGIN
 DECLARE _contrato_id_in INT;
IF _tipoControl='1' THEN -- Consultar contratos
				SELECT *
			      FROM dt_contrato
				 WHERE cliente_id=_cliente_id
                   AND contrato_estado=_contrato_estado;
elseif _tipoControl='2' THEN -- Insertar contratos
			  INSERT INTO dt_contrato(contrato_fechainicio,
									 contrato_fechafin,
									 contrato_numero,
									 contrato_usuariocreo,
									 contrato_valor,
									 cliente_id
								    )
				             VALUES(_contrato_fechainicio,
									_contrato_fechafin,
									_contrato_numero,
									_contrato_usuariocreo,
									_contrato_valor,
									_cliente_id);
SET _contrato_id_in= LAST_INSERT_ID();
select _contrato_id_in as contrato_id;
elseif _tipoControl='3' THEN -- Consultar por numero de contrato
				SELECT *
			      FROM dt_contrato
				 WHERE cliente_id=_cliente_id
                   AND contrato_estado=_contrato_estado
                   AND contrato_numero=_contrato_numero;
elseif _tipoControl='4' THEN -- Actualizar datos del cliente
	UPDATE dt_contrato 
	   SET contrato_fechainicio = _contrato_fechainicio,
		   contrato_fechafin=_contrato_fechafin,           
           contrato_valor=_contrato_valor,
           contrato_fechamodifico=NOW(),
           contrato_usuariomodifico=_contrato_usuariomodifico
	 WHERE contrato_id = _contrato_id;
     
     
elseif _tipoControl='5' THEN -- Actualizar el estado del contrato
	UPDATE dt_contrato 
	   SET contrato_estado = _contrato_estado,
           contrato_fechamodifico=NOW(),
           contrato_usuariomodifico=_contrato_usuariomodifico
	 WHERE contrato_id = _contrato_id;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_dtdetallepresupuesto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_dtdetallepresupuesto`(
IN _tipoControl varchar(11),
IN _detallepresupuesto_id varchar(11),
IN _detallepresupuesto_alcance varchar(20000),
IN _detallepresupuesto_estado varchar(11),
IN _detallepresupuesto_fechaini varchar(45),
IN _detallepresupuesto_fechafin varchar(45),
IN _detallepresupuesto_fechacreo varchar(45),
IN _detallepresupuesto_fechamodifico varchar(45),
IN _detallepresupuesto_gestor varchar(45),
IN _detallepresupuesto_nombre varchar(200),
IN _detallepresupuesto_objeto varchar(2000),
IN _detallepresupuesto_total varchar(45),
IN _detallepresupuesto_usuariocreo varchar(45),
IN _detallepresupuesto_usuariomodifico varchar(45),
IN _subestacion_id varchar(45),
IN _contrato_id varchar(45)
)
BEGIN
DECLARE detallepresupuesto_id_insert INT;
DECLARE _existe_detallepresupuesto INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar
			 SELECT dp.detallepresupuesto_id,
					dp.detallepresupuesto_estado,
					cl.cliente_descripcion,
					sb.subestacion_nombre,
					dp.detallepresupuesto_fechaini,
					dp.detallepresupuesto_nombre,
					dp.detallepresupuesto_total
			   FROM dt_detalle_presupuesto dp
			   JOIN dt_contrato ct ON dp.contrato_id=ct.contrato_id
			   JOIN dt_cliente cl ON ct.cliente_id=cl.cliente_id
			   JOIN dt_subestacion sb ON dp.subestacion_id=sb.subestacion_id
			    AND dp.detallepresupuesto_estado <> 0;
elseif _tipoControl='2' THEN -- Insertar 
	SELECT detallepresupuesto_id 
      FROM dt_detalle_presupuesto 
	 WHERE detallepresupuesto_nombre=_detallepresupuesto_nombre
       AND contrato_id=_contrato_id
       AND subestacion_id=_subestacion_id
	  INTO _existe_detallepresupuesto;
IF _existe_detallepresupuesto >0 then
	UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_estado = 1,
           detallepresupuesto_alcance=_detallepresupuesto_alcance,
		   detallepresupuesto_fechaini=_detallepresupuesto_fechaini,
		   detallepresupuesto_fechafin=_detallepresupuesto_fechafin, 
		   detallepresupuesto_gestor=_detallepresupuesto_gestor,
		   detallepresupuesto_objeto=_detallepresupuesto_objeto,
		   -- detallepresupuesto_total=_detallepresupuesto_total,
           detallepresupuesto_fechamodifico=NOW(),
           detallepresupuesto_usuariomodifico=_detallepresupuesto_usuariocreo
	 WHERE detallepresupuesto_id = _existe_detallepresupuesto;
	 SET detallepresupuesto_id_insert= _existe_detallepresupuesto;
ELSE
	 INSERT INTO dt_detalle_presupuesto(detallepresupuesto_alcance,
									    detallepresupuesto_fechaini,
										detallepresupuesto_fechafin,
										detallepresupuesto_gestor,
										detallepresupuesto_nombre,
										detallepresupuesto_objeto,
										detallepresupuesto_total,
										detallepresupuesto_usuariocreo,
										subestacion_id,
										contrato_id)
								VALUES(_detallepresupuesto_alcance,
									   _detallepresupuesto_fechaini,
									   _detallepresupuesto_fechafin,
									   _detallepresupuesto_gestor,
									   _detallepresupuesto_nombre,
									   _detallepresupuesto_objeto,
									   _detallepresupuesto_total,
									   _detallepresupuesto_usuariocreo,
									   _subestacion_id,
									   _contrato_id);
	 SET detallepresupuesto_id_insert= LAST_INSERT_ID();
END IF;
select detallepresupuesto_id_insert;
elseif _tipoControl='3' THEN -- ACTUALIZAR ESTADO
	UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_estado = _detallepresupuesto_estado,
           detallepresupuesto_fechamodifico=NOW(),
           detallepresupuesto_usuariomodifico=_detallepresupuesto_usuariomodifico
	 WHERE detallepresupuesto_id = _detallepresupuesto_id;
	 
elseif _tipoControl='4' THEN -- CONSULTAR POR ID
		SELECT * 
		  FROM dt_detalle_presupuesto 
		 WHERE detallepresupuesto_id=_detallepresupuesto_id;
elseif _tipoControl='5' THEN -- CONSULTAR PRESUPUESTOS APROBADOS Y FINALIZADOS
			 SELECT ot.ordentrabajo_num,
				    dp.detallepresupuesto_id,
					dp.detallepresupuesto_estado,
					cl.cliente_descripcion,
					sb.subestacion_nombre,
					dp.detallepresupuesto_fechaini,
					dp.detallepresupuesto_nombre,
					dp.detallepresupuesto_total
			   FROM dt_detalle_presupuesto dp
			   JOIN dt_contrato ct ON dp.contrato_id=ct.contrato_id
			   JOIN dt_cliente cl ON ct.cliente_id=cl.cliente_id
			   JOIN dt_subestacion sb ON dp.subestacion_id=sb.subestacion_id
		  LEFT JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
		      WHERE dp.detallepresupuesto_estado IN (3,4);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_dtsoporte` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_dtsoporte`(
IN _tipoControl varchar(11),
IN _soporte_id varchar(11),
IN _soporte_fechacreo varchar(11),
IN _soporte_fechamodifico varchar(45),
IN _soporte_nombre varchar(2000),
IN _soporte_tamano varchar(45),
IN _soporte_tipo varchar(45),
IN _soporte_url varchar(1000),
IN _soporte_usuariocreo varchar(45),
IN _soporte_usuariomodifico varchar(45)
)
BEGIN
DECLARE soporte_id_insert INT;
 
if _tipoControl='1' THEN -- Consultar 
		 SELECT *
		   FROM dt_soporte;
elseif _tipoControl='2' THEN -- Insertar
			     INSERT INTO dt_soporte(																															
										soporte_nombre,
										soporte_tamano,
										soporte_tipo,
										soporte_url,
										soporte_usuariocreo)
								 VALUES(																			
										_soporte_nombre,
										_soporte_tamano,
										_soporte_tipo,
										_soporte_url,
										_soporte_usuariocreo
										);
SET soporte_id_insert= LAST_INSERT_ID();
select soporte_id_insert;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_dtsubestacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_dtsubestacion`(
IN _tipoControl varchar(11),	
IN _subestacion_id varchar(11),
IN _subestacion_aplicaiva varchar(10),
IN _subestacion_codigo varchar(11),
IN _subestacion_estado varchar(45),
IN _subestacion_fax varchar(45),
IN _subestacion_fechacreo varchar(45),
IN _subestacion_fechamodifico varchar(45),
IN _subestacion_hicom varchar(45),
IN _subestacion_nombre varchar(200),
IN _subestacion_telefono varchar(45),
IN _subestacion_usuariocreo varchar(45),
IN _subestacion_usuariomodifico varchar(45),
IN _subestacion_ubicacion varchar(45)
)
BEGIN
DECLARE subestacion_id_insert INT;
DECLARE _existe_subestacion INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar
	SELECT * FROM dt_subestacion WHERE subestacion_estado=1
   ORDER BY subestacion_nombre ASC;
elseif _tipoControl='2' THEN -- Insertar 
	SELECT subestacion_id 
      FROM dt_subestacion 
	 WHERE subestacion_codigo=_subestacion_codigo
	  INTO _existe_subestacion;
IF _existe_subestacion >0 then
	UPDATE dt_subestacion 
	   SET subestacion_estado = 1,
	       subestacion_aplicaiva=_subestacion_aplicaiva,
		   subestacion_fax=_subestacion_fax,
		   subestacion_hicom=_subestacion_hicom,
		   subestacion_nombre=_subestacion_nombre,
		   subestacion_telefono=_subestacion_telefono,
		   subestacion_ubicacion=_subestacion_ubicacion,
           subestacion_fechamodifico=NOW(),
           subestacion_usuariomodifico=_subestacion_usuariocreo
	 WHERE subestacion_id = _existe_subestacion;
	 SET subestacion_id_insert= _existe_subestacion;
ELSE
	 INSERT INTO dt_subestacion(subestacion_aplicaiva,
							    subestacion_codigo,
								subestacion_fax,
								subestacion_hicom,
								subestacion_nombre,
								subestacion_telefono,
								subestacion_usuariocreo,
								subestacion_ubicacion)
						VALUES(_subestacion_aplicaiva,
								_subestacion_codigo,
								_subestacion_fax,
								_subestacion_hicom,
								_subestacion_nombre,
								_subestacion_telefono,
								_subestacion_usuariocreo,
								_subestacion_ubicacion
								);
	 SET subestacion_id_insert= LAST_INSERT_ID();
END IF;
select subestacion_id_insert;
elseif _tipoControl='3' THEN -- Consultar cod_subestacion
 SELECT *
   FROM dt_subestacion
  WHERE subestacion_codigo=_subestacion_codigo;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_dtusuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_dtusuario`(
IN _tipoControl varchar(5),
IN _usuario_id varchar(11),
IN _usuario_afp varchar(100),
IN _usuario_apellidos varchar(100),
IN _usuario_arp varchar(100),
IN _usuario_cajacomp varchar(100),
IN _usuario_cargo varchar(100),
IN _usuario_cedula varchar(100),
IN _usuario_celular varchar(100),
IN _usuario_condicionmedica varchar(100),
IN _usuario_contrato varchar(100),
IN _usuario_conyuge varchar(100),
IN _usuario_correo varchar(100),
IN _usuario_clasesalario varchar(100),
IN _usuario_ctconduccion varchar(100),
IN _usuario_direccion varchar(100),
IN _usuario_eps varchar(100),
IN _usuario_estado varchar(100),
IN _usuario_expedicion varchar(100),
IN _usuario_fenacimiento varchar(100),
IN _usuario_fentregacarp varchar(100),
IN _usuario_fentregaceps varchar(100),
IN _usuario_fentregacempresa varchar(100),
IN _usuario_fentregaccodensa varchar(100),
IN _usuario_fincontrato varchar(100),
IN _usuario_horario varchar(100),
IN _usuario_jornada varchar(100),
IN _usuario_iniarp varchar(100),
IN _usuario_iniafp varchar(100),
IN _usuario_inicajacomp varchar(100),
IN _usuario_inieps varchar(100),
IN _usuario_inicontrato varchar(100),
IN _usuario_inilaboral varchar(100),
IN _usuario_lugnacimiento varchar(100),
IN _usuario_matricula varchar(100),
IN _usuario_nombre varchar(100),
IN _usuario_nombrehijos varchar(200),
IN _usuario_numcuenta varchar(100),
IN _usuario_numhijos varchar(100),
IN _usuario_numcontrato varchar(100),
IN _usuario_observaciones varchar(100),
IN _usuario_password varchar(2000),
IN _usuario_prompactado varchar(100),
IN _usuario_porcentajearp varchar(100),
IN _usuario_profesion varchar(100),
IN _usuario_riesgoarp varchar(100),
IN _usuario_RH varchar(100),
IN _usuario_rol varchar(100),
IN _usuario_salario varchar(100),
IN _usuario_Tchaqueta varchar(100),
IN _usuario_Tchaleco varchar(100),
IN _usuario_Tcamisa varchar(100),
IN _usuario_Tcamiseta varchar(100),
IN _usuario_Tpantalon varchar(100),
IN _usuario_Tcalzado varchar(100),
IN _usuario_telefono varchar(100),
IN _usuario_tipocontrato varchar(100),
IN _usuario_tp varchar(100),
IN _usuario_universidad varchar(100),
IN _usuario_usuariocreo varchar(11),
IN _usuario_usuariomodifico varchar(11)
)
    COMMENT '1=ACTUALIZAR ESTADO  2=INSERTAR USUARIO 3=ACTUALIZAR USUARIO'
BEGIN
 DECLARE _usuario_id_create INT;
if _tipoControl='1' THEN
	UPDATE dt_usuario 
	   SET usuario_estado = _usuario_estado,
           usuario_fechamodifico=NOW(),
           usuario_usuariomodifico=_usuario_usuariomodifico
	 WHERE usuario_id = _usuario_id;
ELSEif _tipoControl='2' THEN
INSERT INTO dt_usuario(usuario_apellidos,usuario_cargo,usuario_cedula,usuario_celular,usuario_correo,usuario_direccion,usuario_nombre,usuario_password,usuario_profesion,usuario_telefono,usuario_tp,usuario_usuariocreo)
				VALUES(_usuario_apellidos,_usuario_cargo,_usuario_cedula,_usuario_celular,_usuario_correo,_usuario_direccion,_usuario_nombre,_usuario_password,_usuario_profesion,_usuario_telefono,_usuario_tp,_usuario_usuariocreo);
SET _usuario_id_create= LAST_INSERT_ID();
select _usuario_id_create as id_user_create;
elseif _tipoControl='3' THEN
	UPDATE dt_usuario 
	   SET usuario_apellidos = _usuario_apellidos,
			usuario_cargo = _usuario_cargo,
			usuario_cedula = _usuario_cedula,
			usuario_celular = _usuario_celular,
			usuario_correo = _usuario_correo,
			usuario_direccion = _usuario_direccion,
			usuario_nombre = _usuario_nombre,
			usuario_password = _usuario_password,
			usuario_profesion = _usuario_profesion,
			usuario_telefono = _usuario_telefono,
			usuario_tp = _usuario_tp,
           usuario_fechamodifico=NOW(),
           usuario_usuariomodifico=_usuario_usuariomodifico
	 WHERE usuario_id = _usuario_id;
elseif _tipoControl='4' THEN -- gestores
 		 SELECT us.usuario_id,
                us.usuario_apellidos,
				us.usuario_nombre,
				pr.perfil_nombre
		   FROM pt_perfil_usuario pu
		   JOIN dt_usuario us ON pu.usuario_id=us.usuario_id
		   JOIN cf_perfil pr ON pu.perfil_id=pr.perfil_id
		    AND pr.perfil_id=2
	   GROUP BY pr.perfil_nombre,us.usuario_apellidos,us.usuario_nombre;
elseif _tipoControl='5' THEN -- cambiar clave
	UPDATE dt_usuario 
	   SET usuario_password = _usuario_password,
           usuario_fechamodifico=NOW(),
           usuario_usuariomodifico=_usuario_usuariomodifico
	 WHERE usuario_id = _usuario_id;
END if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptalcancesubactividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptalcancesubactividad`(
IN _tipoControl varchar(11),
IN _alcancesubactividad_id varchar(11),
IN _alcancesubactividad_estado varchar(11),
IN _alcancesubactividad_fechacreo varchar(11),
IN _alcancesubactividad_fechamodifico varchar(45),
IN _alcancesubactividad_usuariocreo varchar(45),
IN _alcancesubactividad_usuariomodifico varchar(45),
IN _alcance_id varchar(45),
IN _detalleactividad_id varchar(45)
)
BEGIN
DECLARE alcancesubactividad_id_insert INT;
DECLARE existe_alcancesubactividad INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar los alcances de las subactividades
		 SELECT al.alcance_id,
				al.alcance_descripcion,
				alsub.alcancesubactividad_id
		   FROM pt_alcance_subactividad alsub
		   JOIN cf_alcance al ON alsub.alcance_id=al.alcance_id
		    AND alsub.detalleactividad_id=_detalleactividad_id
		    AND alsub.alcancesubactividad_estado=1;
    
elseif _tipoControl='2' THEN -- Insertar
		SELECT alcancesubactividad_id
		  FROM pt_alcance_subactividad
		 WHERE alcance_id=_alcance_id
		   AND detalleactividad_id=_detalleactividad_id		   
          INTO existe_alcancesubactividad;
IF existe_alcancesubactividad >0 then
	UPDATE pt_alcance_subactividad 
	   SET alcancesubactividad_estado = 1,
           alcancesubactividad_fechamodifico=NOW(),
           alcancesubactividad_usuariomodifico=_alcancesubactividad_usuariocreo
	 WHERE alcancesubactividad_id = existe_alcancesubactividad;
	 SET alcancesubactividad_id_insert= existe_alcancesubactividad;
ELSE
	 INSERT INTO pt_alcance_subactividad(alcancesubactividad_usuariocreo,
                                      alcance_id,
								      detalleactividad_id)
							   VALUES(_alcancesubactividad_usuariocreo,
                                      _alcance_id,
									  _detalleactividad_id);
	 SET alcancesubactividad_id_insert= LAST_INSERT_ID();
END IF;
select alcancesubactividad_id_insert;
elseif _tipoControl='3' THEN -- eliminar
	UPDATE pt_alcance_subactividad 
	   SET alcancesubactividad_estado = '0',
           alcancesubactividad_fechamodifico=NOW(),
           alcancesubactividad_usuariomodifico=_alcancesubactividad_usuariomodifico
	 WHERE alcancesubactividad_id = _alcancesubactividad_id;
 
elseif _tipoControl='4' THEN -- consultar alcances de las actividades
		SELECT al.alcance_descripcion, al.alcance_id
		  FROM pt_alcance_subactividad asub
		  JOIN cf_alcance al ON asub.alcance_id=al.alcance_id
		 WHERE asub.detalleactividad_id=_detalleactividad_id
		   AND asub.alcancesubactividad_estado=1;
      
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptBaremo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptBaremo`(
IN _tipoControl varchar(11),
IN _baremo_id varchar(11),
IN _baremo_estado varchar(11),
IN _baremo_fechacreo varchar(45),
IN _baremo_fechamodifico varchar(45),
IN _baremo_item varchar(45),
IN _baremo_totalsinIva varchar(45),
IN _baremo_unidadservicio varchar(45),
IN _baremo_usuariocreo varchar(45),
IN _baremo_usuariomodifico varchar(45),
IN _baremo_valorservicio varchar(45),
IN _baremo_valortotalAct varchar(45),
IN _cliente_id varchar(45),
IN _labor_id varchar(45),
IN _tipobaremo_id varchar(45)
)
BEGIN
DECLARE baremo_id_insert INT;
DECLARE _existe_baremo INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar Baremos
		 SELECT bm.baremo_id,
				bm.baremo_item,
				bm.baremo_totalsinIva,
				cl.cliente_descripcion,
				tb.tipobaremo_descripcion
		   FROM pt_baremo bm
		   JOIN dt_cliente cl ON bm.cliente_id=cl.cliente_id
		   JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		    AND bm.baremo_estado=1;
elseif _tipoControl='2' THEN -- Insertar la baremo
 SELECT baremo_id
   FROM pt_baremo
  WHERE baremo_item=_baremo_item
    -- AND baremo_estado=1
    AND cliente_id=_cliente_id
   INTO _existe_baremo;
IF _existe_baremo >0 then
	UPDATE pt_baremo 
	   SET baremo_estado = 1,
           baremo_totalsinIva=_baremo_totalsinIva,
           baremo_unidadservicio=_baremo_unidadservicio,
   		   baremo_valorservicio=_baremo_valorservicio,
		   baremo_valortotalAct=_baremo_valortotalAct,           
           baremo_fechamodifico=NOW(),
           baremo_usuariomodifico=_baremo_usuariocreo,
           labor_id=_labor_id
	 WHERE baremo_id = _existe_baremo;
	 SET baremo_id_insert= _existe_baremo;
ELSE
			  INSERT INTO pt_baremo(baremo_item,
								   baremo_totalsinIva,
                                   baremo_unidadservicio,
								   baremo_valorservicio,
                                   baremo_valortotalAct,
								   baremo_usuariocreo,
                                   cliente_id,
                                   labor_id,
                                   tipobaremo_id
								   )
				             VALUES(_baremo_item,
									_baremo_totalsinIva,
                                    _baremo_unidadservicio,
									_baremo_valorservicio,
                                    _baremo_valortotalAct,
							        _baremo_usuariocreo,
                                    _cliente_id,
                                    _labor_id,
                                    _tipobaremo_id);
SET baremo_id_insert= LAST_INSERT_ID();
END IF;
select baremo_id_insert;
elseif _tipoControl='3' THEN -- Consultar Baremo por cliente y ITEM
 SELECT lb.labor_id,
        lb.labor_descripcion,
		bm.baremo_id,
		bm.baremo_item,
		bm.baremo_totalsinIva,
		bm.baremo_unidadservicio,
		bm.baremo_valorservicio,
		bm.baremo_valortotalAct
   FROM pt_baremo bm
   JOIN cf_labor lb ON bm.labor_id=lb.labor_id
    AND bm.cliente_id=_cliente_id
    AND bm.baremo_estado=1
    AND bm.tipobaremo_id=_tipobaremo_id
    AND bm.baremo_item=_baremo_item;
elseif _tipoControl='4' THEN -- ACTUALIZAR ESTADO
	UPDATE pt_baremo 
	   SET baremo_estado = 0,
           baremo_fechamodifico=NOW(),
           baremo_usuariomodifico=_baremo_usuariomodifico
	 WHERE baremo_id = _baremo_id;
	 
elseif _tipoControl='5' THEN -- CONSULTAR BAREMO_ID
 SELECT lb.labor_id,
        lb.labor_descripcion,
		bm.baremo_id,
		bm.baremo_item,
		bm.baremo_totalsinIva,
		bm.baremo_unidadservicio,
		bm.baremo_valorservicio,
		bm.baremo_valortotalAct,
		bm.cliente_id,
        bm.tipobaremo_id
   FROM pt_baremo bm
   JOIN cf_labor lb ON bm.labor_id=lb.labor_id    
    AND bm.baremo_estado=1    
    AND bm.baremo_id=_baremo_id;
    
elseif _tipoControl='6' THEN -- CONSULTAR BAREMO_ITEM
	 SELECT ba.baremoactividad_id,
			bm.baremo_item,
            bm.baremo_id,
			ac.actividad_id,
			ac.actividad_descripcion,
			ac.actividad_GOM,
			ac.actividad_valorservicio
	   FROM pt_baremo_actividad ba
	   JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
	   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
	    AND bm.baremo_item=_baremo_item
        AND tipobaremo_id=_tipobaremo_id
        AND baremo_estado=1;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptdescargo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptdescargo`(
IN _tipoControl varchar(11),
IN _descargo_id varchar(11),
IN _descargo_actividad varchar(5000),
IN _descargo_riesgo varchar(2000),
IN _descargo_usuariocreo varchar(45),
IN _descargo_usuariomodifico varchar(45),
IN _ordentrabajo_id varchar(45),
IN _presupuesto_id varchar(45)
)
BEGIN
DECLARE descargo_id_insert INT;
DECLARE _existe_descargo INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar 
		 SELECT *
		   FROM pt_descargo
           WHERE ordentrabajo_id=_ordentrabajo_id
			 AND presupuesto_id=_presupuesto_id;
elseif _tipoControl='2' THEN -- Insertar
		 SELECT descargo_id
		   FROM pt_descargo
		  WHERE ordentrabajo_id=_ordentrabajo_id
			AND presupuesto_id=_presupuesto_id
		   INTO _existe_descargo;
IF _existe_descargo >0 then
	UPDATE pt_descargo 
	   SET descargo_actividad = _descargo_actividad,
           descargo_fechamodifico=NOW(),
   		   descargo_riesgo=_descargo_riesgo,
		   descargo_usuariomodifico=_descargo_usuariocreo
	 WHERE descargo_id = _existe_descargo;
	 SET descargo_id_insert= _existe_descargo;
ELSE
	 INSERT INTO pt_descargo(descargo_actividad,
								descargo_riesgo,
								descargo_usuariocreo,	
								ordentrabajo_id,																		
								presupuesto_id)
						 VALUES(_descargo_actividad,
								_descargo_riesgo,
								_descargo_usuariocreo,
								_ordentrabajo_id,
								_presupuesto_id);
		SET descargo_id_insert= LAST_INSERT_ID();
END IF;
		SELECT descargo_id_insert;
          
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptdetalleactividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptdetalleactividad`(
IN _tipoControl varchar(11),
IN _detalleactividad_id varchar(11),
IN _detallesubactividad_costosinIva varchar(100),
IN _detalleactividad_estado varchar(11),
IN _detalleactividad_fechacreo varchar(45),
IN _detalleactividad_fechamodifico varchar(45),
IN _detalleactividad_iva varchar(45),
IN _detallesubactividad_porc varchar(45),
IN _detalleactividad_usuariocreo varchar(45),
IN _detalleactividad_usuariomodifico varchar(45),
IN _actividad_id varchar(45),
IN _baremoactividad_id varchar(45),
IN _subactividad_id varchar(45)
)
BEGIN
DECLARE detalleactividad_id_insert INT;
DECLARE _existe_detalleactividad INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar detalleactividad
 /*select ac.actividad_id,
		ac.actividad_descripcion,
		sub.subactividad_id,
		sub.subactividad_descripcion,
		det.detallesubactividad_porc,
		det.detallesubactividad_costosinIva
   from pt_detalle_actividad det
   join cf_actividad ac on det.actividad_id=ac.actividad_id
   join cf_subactividad sub on det.subactividad_id=sub.subactividad_id
    and det.detalleactividad_estado=1
    and det.actividad_id=_actividad_id
    and baremoactividad_id=_baremoactividad_id;*/
    
    SELECT  sb.subactividad_descripcion,
			da.detalleactividad_id,
			da.detallesubactividad_costosinIva,
			da.detallesubactividad_porc,
			da.actividad_id,
			da.baremoactividad_id,
			da.subactividad_id
	   FROM pt_detalle_actividad da
       JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
		AND da.detalleactividad_estado=1
		AND da.baremoactividad_id=_baremoactividad_id
		AND da.actividad_id=_actividad_id;
elseif _tipoControl='2' THEN -- Insertar la subactividades
 SELECT detalleactividad_id
   FROM pt_detalle_actividad
  WHERE actividad_id=_actividad_id
    AND subactividad_id=_subactividad_id
    AND baremoactividad_id=_baremoactividad_id
   INTO _existe_detalleactividad;
IF _existe_detalleactividad >0 then
	UPDATE pt_detalle_actividad 
	   SET detalleactividad_estado = 1,
           detalleactividad_fechamodifico=NOW(),
           detalleactividad_usuariomodifico=_detalleactividad_usuariocreo
	 WHERE detalleactividad_id = _existe_detalleactividad;
	 SET detalleactividad_id_insert= _existe_detalleactividad;
ELSE
	 INSERT INTO pt_detalle_actividad(detallesubactividad_costosinIva,
                                      detallesubactividad_porc,
								      detalleactividad_usuariocreo,
                                      actividad_id,
								      baremoactividad_id,
								      subactividad_id)
							   VALUES(_detallesubactividad_costosinIva,
                                      _detallesubactividad_porc,
									  _detalleactividad_usuariocreo,
									  _actividad_id,
									  _baremoactividad_id,
									  _subactividad_id);
	 SET detalleactividad_id_insert= LAST_INSERT_ID();
END IF;
select detalleactividad_id_insert;
elseif _tipoControl='3' THEN -- CONSULTAR EL PORCENTAJE DE LA ACTIVIDAD DEL BAREMO
SELECT SUM(detallesubactividad_porc) AS porcentaje
  FROM pt_detalle_actividad
 WHERE actividad_id=_actividad_id
   AND baremoactividad_id=_baremoactividad_id
   AND detalleactividad_estado=1;
elseif _tipoControl='4' THEN -- ACTUALIZARESTADO
	UPDATE pt_detalle_actividad 
	   SET detalleactividad_estado = 0,
           detalleactividad_fechamodifico=NOW(),
           detalleactividad_usuariomodifico=_detalleactividad_usuariomodifico
	 WHERE detalleactividad_id = _detalleactividad_id;
	
    
elseif _tipoControl='5' THEN -- CONSULTAR SUBACTIVIDADES baremoactividad_id
		 SELECT da.detalleactividad_id,
				ba.baremoactividad_id,
				ac.actividad_id,
				sb.subactividad_descripcion,
				da.detallesubactividad_porc,
				da.detallesubactividad_costosinIva
		   FROM pt_baremo_actividad ba
		   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
		   JOIN pt_detalle_actividad da ON ba.baremoactividad_id=da.baremoactividad_id
		   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
		    AND da.actividad_id=ac.actividad_id
		    AND da.detalleactividad_estado=1
		    AND da.baremoactividad_id=_baremoactividad_id;
elseif _tipoControl='6' THEN -- CONSULTAR DETALLE DE ACTIVIDAD
	 SELECT da.detalleactividad_id,
				ba.baremoactividad_id,
				ac.actividad_id,				
				da.detallesubactividad_porc,
				da.detallesubactividad_costosinIva
		   FROM pt_baremo_actividad ba
		   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
		   JOIN pt_detalle_actividad da ON ba.baremoactividad_id=da.baremoactividad_id		   
		    AND da.actividad_id=ac.actividad_id
		    AND da.detalleactividad_estado=1
		    AND da.baremoactividad_id=_baremoactividad_id;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptentregablesubactividad` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptentregablesubactividad`(
IN _tipoControl varchar(11),
IN _entregablesubactividad_id varchar(11),
IN _entregablesubactividad_estado varchar(11),
IN _entregablesubactividad_fechacreo varchar(11),
IN _entregablesubactividad_fechamodifico varchar(45),
IN _entregablesubactividad_usuariocreo varchar(45),
IN _entregablesubactividad_usuariomodifico varchar(45),
IN _entregable_id varchar(45),
IN _detalleactividad_id varchar(45)
)
BEGIN
DECLARE entregablesubactividad_id_insert INT;
DECLARE existe_entregablesubactividad INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar los entregables de las subactividades
	 SELECT en.entregable_id,
				en.entregable_descripcion,
				ensub.entregablesubactividad_id
		   FROM pt_entregable_subactividad ensub
		   JOIN cf_entregable en ON ensub.entregable_id=en.entregable_id
		    AND ensub.detalleactividad_id=_detalleactividad_id
		    AND ensub.entregablesubactividad_estado=1;
    
elseif _tipoControl='2' THEN -- Insertar
		SELECT entregablesubactividad_id
		  FROM pt_entregable_subactividad
		 WHERE entregable_id=_entregable_id
		   AND detalleactividad_id=_detalleactividad_id		   
          INTO existe_entregablesubactividad;
IF existe_entregablesubactividad >0 then
	UPDATE pt_entregable_subactividad 
	   SET entregablesubactividad_estado = 1,
           entregablesubactividad_fechamodifico=NOW(),
           entregablesubactividad_usuariomodifico=_entregablesubactividad_usuariocreo
	 WHERE entregablesubactividad_id = existe_entregablesubactividad;
	 SET entregablesubactividad_id_insert= existe_entregablesubactividad;
ELSE
	 INSERT INTO pt_entregable_subactividad(entregablesubactividad_usuariocreo,
                                      entregable_id,
								      detalleactividad_id)
							   VALUES(_entregablesubactividad_usuariocreo,
                                      _entregable_id,
									  _detalleactividad_id);
	 SET entregablesubactividad_id_insert= LAST_INSERT_ID();
END IF;
select entregablesubactividad_id_insert;
elseif _tipoControl='3' THEN -- eliminar
	UPDATE pt_entregable_subactividad 
	   SET entregablesubactividad_estado = '0',
           entregablesubactividad_fechamodifico=NOW(),
           entregablesubactividad_usuariomodifico=_entregablesubactividad_usuariomodifico
	 WHERE entregablesubactividad_id = _entregablesubactividad_id;
     
 
elseif _tipoControl='4' THEN -- consulta entregables actividad
		SELECT en.entregable_descripcion,
               en.entregable_id
		  FROM pt_entregable_subactividad es
		  JOIN cf_entregable en ON es.entregable_id=en.entregable_id
		 WHERE es.detalleactividad_id=_detalleactividad_id
		   AND es.entregablesubactividad_estado=1;
      
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptordentrabajo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptordentrabajo`(
IN _tipoControl varchar(11),
IN _ordentrabajo_id varchar(11),
IN _ordentrabajo_contratista varchar(11),
IN _ordentrabajo_fechacreo varchar(11),
IN _ordentrabajo_fechaemision varchar(45),
IN _ordentrabajo_fechaini varchar(45),
IN _ordentrabajo_fechamodifico varchar(45),
IN _ordentrabajo_GOM varchar(5000),
IN _ordentrabajo_num varchar(45),
IN _ordentrabajo_obs varchar(5000),
IN _ordentrabajo_usuariocreo varchar(11),
IN _ordentrabajo_usuariomodifico varchar(45),
IN _detallepresupuesto_id varchar(45)
)
BEGIN
DECLARE ordentrabajo_id_insert INT;
DECLARE _existe_ordentrabajo INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar 
		 SELECT *
		   FROM pt_orden_trabajo
           WHERE detallepresupuesto_id=_detallepresupuesto_id;
elseif _tipoControl='2' THEN -- Insertar
 SELECT ordentrabajo_id 
   FROM pt_orden_trabajo
  WHERE detallepresupuesto_id=_detallepresupuesto_id
   INTO _existe_ordentrabajo;
IF _existe_ordentrabajo >0 then
	UPDATE pt_orden_trabajo 
	   SET ordentrabajo_contratista = _ordentrabajo_contratista,
           ordentrabajo_fechaemision=_ordentrabajo_fechaemision,
           ordentrabajo_fechaini=_ordentrabajo_fechaini,
           ordentrabajo_fechamodifico=NOW(),
   		   ordentrabajo_GOM=_ordentrabajo_GOM,
		   ordentrabajo_num=_ordentrabajo_num,          
           ordentrabajo_obs=_ordentrabajo_obs,
           ordentrabajo_usuariomodifico=_ordentrabajo_usuariocreo	
	 WHERE ordentrabajo_id = _existe_ordentrabajo;
	 SET ordentrabajo_id_insert= _existe_ordentrabajo;
ELSE
	 INSERT INTO pt_orden_trabajo(ordentrabajo_contratista,
								ordentrabajo_fechaemision,
								ordentrabajo_fechaini,	
								ordentrabajo_GOM,																		
								ordentrabajo_num,
								ordentrabajo_obs,
								ordentrabajo_usuariocreo,
								detallepresupuesto_id)
						 VALUES(_ordentrabajo_contratista,
								_ordentrabajo_fechaemision,
								_ordentrabajo_fechaini,
								_ordentrabajo_GOM,
								_ordentrabajo_num,
								_ordentrabajo_obs,
								_ordentrabajo_usuariocreo,
								_detallepresupuesto_id);
		SET ordentrabajo_id_insert= LAST_INSERT_ID();
END IF;
		SELECT ordentrabajo_id_insert;
          
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptperfil_usuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptperfil_usuario`(
IN _tipoControl varchar(5),
IN _usuario_id varchar(11),
IN _area_id varchar(11),
IN _perfil_id varchar(11),
IN _usuario_creo_mod varchar(11)
)
    COMMENT '1=PERFILES POR USUARIO'
BEGIN
if _tipoControl='1' THEN
		select per.perfil_id,per.perfil_nombre,perUsu.perfilusuario_id,ar.area_nombre
		  from pt_perfil_usuario perUsu
		  join dt_usuario usu on perUsu.usuario_id=usu.usuario_id
          JOIN cf_area ar ON perUsu.area_id=ar.area_id
		   and perUsu.usuario_id=_usuario_id
	       and perUsu.perfilusuario_estado=1
		  join cf_perfil per on perUsu.perfil_id=per.perfil_id
	  GROUP BY per.perfil_nombre;
elseif _tipoControl='2' THEN -- MOSTRAR LAS AREAS DEL USUARIO
		      SELECT ar.area_id,ar.area_nombre
                FROM pt_perfil_usuario perUsu
                JOIN dt_usuario usu on perUsu.usuario_id=usu.usuario_id
                JOIN cf_area ar on perUsu.area_id=ar.area_id
               WHERE usu.usuario_id=_usuario_id
            GROUP BY ar.area_nombre;
elseif _tipoControl='3' THEN -- MOSTRAR LOS PERFILES POR AREAS
	    select per.perfil_id,per.perfil_nombre
		  from pt_perfil_usuario perUsu
		  join dt_usuario usu on perUsu.usuario_id=usu.usuario_id
		   and perUsu.usuario_id=_usuario_id
           and perUsu.area_id=_area_id
		   and perUsu.perfilusuario_estado=1
		  join cf_perfil per on perUsu.perfil_id=per.perfil_id
	  GROUP BY per.perfil_nombre;
            
elseif _tipoControl='4' THEN -- MOSTRAR LOS PERFILES
	    select *
		  from cf_perfil
          where perfil_estado=1
		ORDER BY perfil_nombre ASC;
        
        
elseif _tipoControl='5' THEN -- MOSTRAR AREAS
	    select *
		  from cf_area
          where area_estado=1
		ORDER BY area_nombre ASC;
       
       
elseif _tipoControl='6' THEN -- ELIMINAR LAS AREAS POR USUARIO
	   DELETE FROM pt_perfil_usuario
             WHERE usuario_id = _usuario_id
               AND area_id = _area_id;     
        
        
elseif _tipoControl='7' THEN -- ELIMINAR PERFIL SEGUN USUARIO Y AREA
	   DELETE FROM pt_perfil_usuario
             WHERE usuario_id = _usuario_id
               AND area_id = _area_id
               AND perfil_id=_perfil_id;   
               
elseif _tipoControl='8' THEN -- consultar usuarios por area
               
		SELECT pu.perfilusuario_id,
                us.usuario_id,
                us.usuario_apellidos,
				us.usuario_nombre,
				pr.perfil_nombre,
                ar.area_id,
                ar.area_nombre
		   FROM pt_perfil_usuario pu
		   JOIN dt_usuario us ON pu.usuario_id=us.usuario_id
           JOIN cf_area ar ON pu.area_id=ar.area_id
		   JOIN cf_perfil pr ON pu.perfil_id=pr.perfil_id
		    AND ar.area_id=_area_id
	   GROUP BY pr.perfil_nombre,us.usuario_apellidos,us.usuario_nombre;
       
       
elseif _tipoControl='9' THEN -- consultar actividades asignadas por usuario y perfil
               
      		 SELECT pt.presupuesto_id,
					pt.baremo_id,
                    pt.tipobaremo_id,
					ot.ordentrabajo_id,
                    ot.ordentrabajo_num, 
                    pt.presupuesto_progestado,
                    pt.presupuesto_porcentaje,
                    md.modulo_descripcion,
                    ar.area_nombre,
                    ac.actividad_descripcion,					
					sb.subactividad_descripcion,
                    pt.presupuesto_fechaini,
                    pt.presupuesto_fechafin,
                    pt.presupuesto_horaini,
                    pt.presupuesto_horafin,
                    CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS asigno
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
           JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
           JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
           JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
           JOIN dt_usuario usu ON pt.presupuesto_asignadopor=usu.usuario_id
		   JOIN cf_area ar ON pt.area_id=ar.area_id
           JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
           AND pt.presupuesto_encargado IN (SELECT perUsu.perfilusuario_id
											  FROM pt_perfil_usuario perUsu
											  JOIN dt_usuario usu on perUsu.usuario_id=usu.usuario_id          
											   AND perUsu.usuario_id=_usuario_id											   
											   AND perUsu.perfil_id=_perfil_id
                                               AND perUsu.perfilusuario_estado=1)            
			AND pt.presupuesto_estado=1;
            
elseif _tipoControl='10' THEN
      		 SELECT pt.presupuesto_id,
					pt.baremo_id,
                    pt.tipobaremo_id,
					ot.ordentrabajo_id,
                    ot.ordentrabajo_num, 
                    pt.presupuesto_progestado,
                    pt.presupuesto_porcentaje,
                    md.modulo_descripcion,
                    ar.area_nombre,
                    ac.actividad_descripcion,					
					sb.subactividad_descripcion,
                    pt.presupuesto_fechaini,
                    pt.presupuesto_fechafin,
                    pt.presupuesto_horaini,
                    pt.presupuesto_horafin,
                   CONCAT(usu_enc.usuario_nombre, ' ', usu_enc.usuario_apellidos ) AS responsable,
                   CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS asigno
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
           JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
           JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
           JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
           JOIN dt_usuario usu ON pt.presupuesto_asignadopor=usu.usuario_id
		   JOIN pt_perfil_usuario per_enc ON pt.presupuesto_encargado=per_enc.perfilusuario_id
		   JOIN dt_usuario usu_enc ON per_enc.usuario_id=usu_enc.usuario_id
		   JOIN cf_area ar ON pt.area_id=ar.area_id
           JOIN cf_modulo md ON pt.modulo_id=md.modulo_id           
			AND pt.presupuesto_estado=1;               
END if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptpresupuesto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptpresupuesto`(
IN _tipoControl varchar(11),
IN _presupuesto_id varchar(11),
IN _presupuesto_alcances varchar(11),
IN _presupuesto_encargado varchar(11),
IN _presupuesto_entregables varchar(45),
IN _presupuesto_estado varchar(45),
IN _presupuesto_fechaini varchar(45),
IN _presupuesto_fechafin varchar(45),
IN _presupuesto_fechacreo varchar(45),
IN _presupuesto_fechamodifico varchar(45),
IN _presupuesto_obs varchar(5000),
IN _presupuesto_porcentaje varchar(45),
IN _presupuesto_usuariocreo varchar(45),
IN _presupuesto_usuariomodifico varchar(45),
IN _presupuesto_valorporcentaje varchar(45),
IN _area_id varchar(45),
IN _detallepresupuesto_id varchar(45),
IN _baremoactividad_id varchar(45),
IN _baremo_id varchar(45),
IN _detalleactividad_id varchar(45),
IN _modulo_id varchar(45),
IN _tipobaremo_id varchar(45)
)
BEGIN
DECLARE presupuesto_id_insert INT;
DECLARE presupuesto_id_update INT;
DECLARE presupuesto_total varchar(45);
DECLARE _existe_presupuesto INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar 
		 SELECT bm.baremo_id,
				bm.baremo_item,
				bm.baremo_totalsinIva,
				cl.cliente_descripcion,
				tb.tipobaremo_descripcion
		   FROM pt_baremo bm
		   JOIN dt_cliente cl ON bm.cliente_id=cl.cliente_id
		   JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		    AND bm.baremo_estado=1;
elseif _tipoControl='2' THEN -- Insertar
 SELECT presupuesto_id
   FROM pt_presupuesto
  WHERE detallepresupuesto_id=_detallepresupuesto_id
	AND baremoactividad_id=_baremoactividad_id
    AND baremo_id=_baremo_id
    AND detalleactividad_id=_detalleactividad_id
    AND modulo_id=_modulo_id
    AND tipobaremo_id=_tipobaremo_id
   INTO _existe_presupuesto;
IF _existe_presupuesto >0 then
	UPDATE pt_presupuesto 
	   SET presupuesto_alcances = _presupuesto_alcances,           
           presupuesto_entregables=_presupuesto_entregables,
           presupuesto_estado=1,      
           presupuesto_fechamodifico=NOW(),
           presupuesto_obs=_presupuesto_obs,
           presupuesto_porcentaje=_presupuesto_porcentaje,
           presupuesto_usuariomodifico=_presupuesto_usuariocreo,
           presupuesto_valorporcentaje=_presupuesto_valorporcentaje		
	 WHERE presupuesto_id = _existe_presupuesto;
	 SET presupuesto_id_insert= _existe_presupuesto;
	 -- ACTUALIZAR TOTAL PRESUPPUESTO
		SELECT sum(presupuesto_valorporcentaje) AS total 
		 FROM pt_presupuesto 
		WHERE detallepresupuesto_id=_detallepresupuesto_id
		  AND presupuesto_estado=1
         INTO presupuesto_total;
		
	UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_total=presupuesto_total           
	 WHERE detallepresupuesto_id = _detallepresupuesto_id;
ELSE
  			     INSERT INTO pt_presupuesto(presupuesto_alcances,
                                            presupuesto_entregables,
											presupuesto_obs,
											presupuesto_porcentaje,
											presupuesto_usuariocreo,											
											presupuesto_valorporcentaje,											
											detallepresupuesto_id,
											baremoactividad_id,
											baremo_id,
											detalleactividad_id,
											modulo_id,
											tipobaremo_id)
									 VALUES(_presupuesto_alcances,
                                            _presupuesto_entregables,
											_presupuesto_obs,
											_presupuesto_porcentaje,
											_presupuesto_usuariocreo,
											_presupuesto_valorporcentaje,
											_detallepresupuesto_id,
											_baremoactividad_id,
											_baremo_id,
											_detalleactividad_id,
											_modulo_id,
											_tipobaremo_id);
			SET presupuesto_id_insert= LAST_INSERT_ID();
		 -- ACTUALIZAR TOTAL PRESUPPUESTO
			SELECT sum(presupuesto_valorporcentaje) AS total 
			 FROM pt_presupuesto 
			WHERE detallepresupuesto_id=_detallepresupuesto_id
			  AND presupuesto_estado=1
             INTO presupuesto_total;		
		UPDATE dt_detalle_presupuesto 
		   SET detallepresupuesto_total=presupuesto_total           
		 WHERE detallepresupuesto_id = _detallepresupuesto_id;
END IF;
select presupuesto_id_insert;
elseif _tipoControl='3' THEN -- CONSULTAR ITEMS DE PRESUPUESTO
		SELECT pt.baremo_id,
			   pt.tipobaremo_id,
			   pt.detallepresupuesto_id,
			   bm.baremo_item,
			   tb.tipobaremo_descripcion,
			   md.modulo_descripcion,
               md.modulo_id,
			   sum(presupuesto_valorporcentaje) as total_actividad
		  FROM pt_presupuesto pt
		  JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		  JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
		  JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
		   AND pt.presupuesto_estado=1
		   AND pt.detallepresupuesto_id=_detallepresupuesto_id
	  GROUP BY pt.baremo_id,
			   pt.tipobaremo_id,
			   pt.detallepresupuesto_id,
			   bm.baremo_item,
			   tb.tipobaremo_descripcion,
			   md.modulo_descripcion;
elseif _tipoControl='4' THEN -- ACTUALIZAR ESTADO
	UPDATE pt_presupuesto 
	   SET presupuesto_estado = 0,
           presupuesto_fechamodifico=NOW(),
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico
	 WHERE baremo_id = _baremo_id
	   AND detallepresupuesto_id=_detallepresupuesto_id
       AND modulo_id=_modulo_id;
	 -- ACTUALIZAR TOTAL PRESUPPUESTO
		SELECT sum(presupuesto_valorporcentaje) AS total 
		 FROM pt_presupuesto 
		WHERE detallepresupuesto_id=_detallepresupuesto_id
		  AND presupuesto_estado=1
         INTO presupuesto_total;	
	UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_total=presupuesto_total           
	 WHERE detallepresupuesto_id = _detallepresupuesto_id;
elseif _tipoControl='5' THEN -- CONSULTAR ACTIVIDADES DEL PRESUPUESTO	 
	 SELECT pt.presupuesto_id,
			pt.baremoactividad_id,
			pt.presupuesto_porcentaje,
            pt.presupuesto_valorporcentaje,
			bm.baremo_item,
            bm.baremo_id,
			ac.actividad_id,
			ac.actividad_descripcion,
			ac.actividad_GOM,
			ac.actividad_valorservicio
       FROM pt_presupuesto pt
	   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
	   JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
	   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
	    AND pt.baremo_id=_baremo_id
        AND pt.tipobaremo_id=_tipobaremo_id
	    AND pt.modulo_id=_modulo_id
        AND bm.baremo_estado=1
        AND pt.detallepresupuesto_id=_detallepresupuesto_id
        AND pt.presupuesto_estado=1
   group by actividad_id;
elseif _tipoControl='6' THEN -- CONSULTAR SUBACTIVIDADES DEL PRESUPUESTO
		 SELECT pt.presupuesto_id,
				pt.baremoactividad_id,
                pt.detalleactividad_id,								
				sb.subactividad_descripcion,
                pt.presupuesto_porcentaje,
                pt.presupuesto_valorporcentaje				
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
		    AND da.detalleactividad_estado=1
		    AND pt.baremoactividad_id=_baremoactividad_id
			AND pt.detallepresupuesto_id=_detallepresupuesto_id
			AND pt.modulo_id=_modulo_id
			AND pt.presupuesto_estado=1;
elseif _tipoControl='7' THEN -- CONSULTAR DETALLE DE LA ACTIVIDAD DEL PRESUPUESTO
		 SELECT pt.presupuesto_id,
				pt.tipobaremo_id,
				bm.baremo_item,
				pt.modulo_id,
				pt.presupuesto_obs,
				dp.detallepresupuesto_total
		   FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
		   JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
		   JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
			AND pt.baremo_id=_baremo_id
			AND pt.tipobaremo_id=_tipobaremo_id
            AND pt.modulo_id=_modulo_id
			AND bm.baremo_estado=1
			AND pt.detallepresupuesto_id=_detallepresupuesto_id
			AND pt.presupuesto_estado=1
	   GROUP BY bm.baremo_item;
elseif _tipoControl='8' THEN -- ACTUALIZAR BAREMO
	UPDATE pt_presupuesto 
	   SET presupuesto_alcances = _presupuesto_alcances,           
           presupuesto_entregables=_presupuesto_entregables,
           presupuesto_estado=1,     
           presupuesto_fechamodifico=NOW(),
           presupuesto_obs=_presupuesto_obs,
           presupuesto_porcentaje=_presupuesto_porcentaje,
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico,
           presupuesto_valorporcentaje=_presupuesto_valorporcentaje,
           modulo_id=_modulo_id,
           tipobaremo_id=_tipobaremo_id
	 WHERE presupuesto_id = _presupuesto_id;
     
	 -- ACTUALIZAR TOTAL PRESUPPUESTO
		SELECT sum(presupuesto_valorporcentaje) AS total 
		 FROM pt_presupuesto 
		WHERE detallepresupuesto_id=_detallepresupuesto_id
		  AND presupuesto_estado=1
         INTO presupuesto_total;
		-- SET presupuesto_total=total;
    UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_total=presupuesto_total           
	 WHERE detallepresupuesto_id = _detallepresupuesto_id;
     
elseif _tipoControl='9' THEN -- ACTUALIZAR PROGRAMACION OT
	UPDATE pt_presupuesto 
	   SET presupuesto_encargado=_presupuesto_encargado,                      
   		   presupuesto_fechaini=_presupuesto_fechaini,
		   presupuesto_fechafin=_presupuesto_fechafin,          
           presupuesto_horaini=_presupuesto_entregables, 
           presupuesto_horafin=_presupuesto_estado, 
           presupuesto_asignadopor=_presupuesto_fechacreo, 
           presupuesto_progestado=_presupuesto_fechamodifico,
           presupuesto_fechamodifico=NOW(),                      
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico,
           area_id=_area_id
	 WHERE presupuesto_id = _presupuesto_id;
elseif _tipoControl='10' THEN -- CONSULTAR PRESUPUESTO
	SELECT * FROM  pt_presupuesto  WHERE presupuesto_id = _presupuesto_id;
elseif _tipoControl='11' THEN -- CAMBIAR ESTADO DE PROGRAMACION
	UPDATE pt_presupuesto 
	   SET presupuesto_progestado=_presupuesto_fechamodifico,
           presupuesto_fechamodifico=NOW(),                      
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico           
	 WHERE presupuesto_id = _presupuesto_id;
     
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptseguimiento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptseguimiento`(
IN _tipoControl varchar(11),
IN _seguimiento_id varchar(11),
IN _seguimiento_avance varchar(11),
IN _seguimiento_ejecutor varchar(45),
IN _seguimiento_estado varchar(45),
IN _seguimiento_fechaini varchar(45),
IN _seguimiento_fechafin varchar(45),
IN _seguimiento_fechacreo varchar(45),
IN _seguimiento_fechamodifico varchar(45),
IN _seguimiento_horaini varchar(45),
IN _seguimiento_horafin varchar(45),
IN _seguimiento_num varchar(45),
IN _seguimiento_obs varchar(5000),
IN _seguimiento_riesgoVYP varchar(45),
IN _seguimiento_usuariocreo varchar(45),
IN _seguimiento_usuariomodifico varchar(45),
IN _baremo_id varchar(45),
IN _ordentrabajo_id varchar(45),
IN _presupuesto_id varchar(45),
IN _tipobaremo_id varchar(45)
)
BEGIN
DECLARE seguimiento_id_insert INT;
DECLARE _existe_seguimiento INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar 
		 SELECT *
		   FROM pt_seguimiento
           WHERE presupuesto_id=_presupuesto_id
             AND seguimiento_estado=1;
elseif _tipoControl='2' THEN -- Insertar
			     INSERT INTO pt_seguimiento(
											seguimiento_avance,
											seguimiento_ejecutor,											
											seguimiento_fechaini,
											seguimiento_fechafin,																						
											seguimiento_horaini,
											seguimiento_horafin,
											seguimiento_num,
											seguimiento_obs,											
											seguimiento_usuariocreo,											
											baremo_id,
											ordentrabajo_id,
											presupuesto_id,
											tipobaremo_id )
									 VALUES(
											_seguimiento_avance,
											_seguimiento_ejecutor,											
											_seguimiento_fechaini,
											_seguimiento_fechafin,																						
											_seguimiento_horaini,
											_seguimiento_horafin,
											_seguimiento_num,
											_seguimiento_obs,											
											_seguimiento_usuariocreo,											
											_baremo_id,
											_ordentrabajo_id,
											_presupuesto_id,
											_tipobaremo_id);
SET seguimiento_id_insert= LAST_INSERT_ID();
select seguimiento_id_insert;
elseif _tipoControl='3' THEN -- Actualizar el estado 
	UPDATE pt_seguimiento 
	   SET seguimiento_estado = _seguimiento_estado,
           seguimiento_fechamodifico=NOW(),
           seguimiento_usuariomodifico=_seguimiento_usuariomodifico
	 WHERE seguimiento_id = _seguimiento_id;
elseif _tipoControl='4' THEN 
	SELECT *
	  FROM pt_seguimiento
	 WHERE seguimiento_id = _seguimiento_id;
     
     
elseif _tipoControl='5' THEN -- Actualizar  obs 
	UPDATE pt_seguimiento 
	   SET seguimiento_obs = _seguimiento_obs,
           seguimiento_fechamodifico=NOW(),
           seguimiento_usuariomodifico=_seguimiento_usuariomodifico
	 WHERE seguimiento_id = _seguimiento_id;
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_ptsoporteseguimiento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_ptsoporteseguimiento`(
IN _tipoControl varchar(11),
IN _soporteseguimiento_id varchar(11),
IN _soporteseguimiento_estado varchar(45),
IN _soporteseguimiento_fechacreo varchar(45),
IN _soporteseguimiento_fechamodifico varchar(45),
IN _soporteseguimiento_usuariocreo varchar(45),
IN _soporteseguimiento_usuariomodifico varchar(45),
IN _seguimiento_id varchar(45),
IN _soporte_id varchar(45)
)
BEGIN
DECLARE soporteseguimiento_id_insert INT;
 
if _tipoControl='1' THEN -- Consultar 
		SELECT seg.soporteseguimiento_id,
			   sp.soporte_id,
			   sp.soporte_nombre,
			   sp.soporte_tipo
		  FROM pt_soporte_seguimiento seg
		  JOIN dt_soporte sp ON seg.soporte_id=sp.soporte_id
		 WHERE seg.seguimiento_id=_seguimiento_id
		   AND seg.soporteseguimiento_estado=1;
elseif _tipoControl='2' THEN -- Insertar
			     INSERT INTO pt_soporte_seguimiento(																																																						
													soporteseguimiento_usuariocreo,											
													seguimiento_id,
													soporte_id)
											 VALUES(											
													_soporteseguimiento_usuariocreo,											
													_seguimiento_id,
													_soporte_id
													);
SET soporteseguimiento_id_insert= LAST_INSERT_ID();
select soporteseguimiento_id_insert;
elseif _tipoControl='3' THEN -- Actualizar el estado 
	UPDATE pt_soporte_seguimiento 
	   SET soporteseguimiento_estado = _soporteseguimiento_estado,
           soporteseguimiento_fechamodifico=NOW(),
           soporteseguimiento_usuariomodifico=_soporteseguimiento_usuariomodifico
	 WHERE soporteseguimiento_id = _soporteseguimiento_id;
     
end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_validaUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `SP_validaUsuario`(
IN _usuariocorreo varchar(100),
IN _tipoValidacion varchar(5),
IN _pass varchar(200),
IN _usuario_id varchar(11)
)
    COMMENT 'validaciones de usuario'
BEGIN
IF _tipoValidacion='1' THEN -- Para recuperar la clave
			   
	           SELECT * 
                 FROM dt_usuario 
                WHERE usuario_correo=_usuariocorreo 
                  AND usuario_estado=1;
elseif _tipoValidacion='2' THEN -- Validar la autenticacion del usuario
		       SELECT * 
                 FROM dt_usuario 
                WHERE usuario_correo=_usuariocorreo 
                  AND usuario_password=_pass;
elseif _tipoValidacion='3' THEN -- listar todos los usuario
			   SELECT * 
                 FROM dt_usuario
             ORDER BY usuario_id DESC;
elseif _tipoValidacion='4' THEN -- Buscar por id del usuario
			   SELECT * 
                 FROM dt_usuario
				WHERE usuario_id=_usuario_id;
END if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-22 11:28:42
