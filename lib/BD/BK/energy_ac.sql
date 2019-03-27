/*
SQLyog Community Edition- MySQL GUI v8.05 
MySQL - 5.1.41 : Database - energy_ac
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`energy_ac` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `energy_ac`;

/*Table structure for table `cf_actividad` */

DROP TABLE IF EXISTS `cf_actividad`;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `cf_actividad` */

insert  into `cf_actividad`(`actividad_id`,`actividad_descripcion`,`actividad_estado`,`actividad_fechacreo`,`actividad_fechmodifico`,`actividad_GOM`,`actividad_unidadservicio`,`actividad_usuariocreo`,`actividad_usuariomodifico`,`actividad_valorservicio`) values (1,'Ingenieria civil (Levantamiento e ingenieria de detalle)',1,'2017-03-15 22:11:43','2017-05-23 17:38:03','SPTFLFF','219',1,1,'7164766'),(2,'Diseno civil (Levantamiento e ingenieria de detalle)',1,'2017-03-19 06:03:02','2017-03-23 19:15:31','SL01CIV','227',1,1,'7426492'),(3,'Ingenieria mecanica (Levantamiento e ingenieria de detalle)',1,'2017-03-19 06:21:45',NULL,'SL01MEC','144',1,NULL,'4711079'),(4,'Ingenieria mecanica (Levantamiento e ingenieria de detalle)',1,'2017-03-20 22:15:22',NULL,'','214',0,NULL,'7001187'),(5,'Ingenieria civil (Levantamiento e ingenieria de detalle)',1,'2017-03-20 22:23:03','2017-05-23 17:39:03','RRFRFDS','138',1,1,'4514784'),(7,'prueba',1,'2017-03-27 19:02:05',NULL,'WW','137',1,NULL,'10000000'),(8,'ESTO ES UNA PRUEBA',1,'2017-03-31 03:01:03',NULL,'DGETR','123',1,NULL,'50000000');

/*Table structure for table `cf_alcance` */

DROP TABLE IF EXISTS `cf_alcance`;

CREATE TABLE `cf_alcance` (
  `alcance_id` int(11) NOT NULL AUTO_INCREMENT,
  `alcance_descripcion` varchar(500) DEFAULT NULL,
  `alcance_estado` int(5) NOT NULL DEFAULT '1',
  `alcance_fechacreo` datetime DEFAULT NULL,
  `alcance_fechamodifico` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `alcance_usuariocreo` int(11) DEFAULT NULL,
  `alcance_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`alcance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=528 DEFAULT CHARSET=latin1;

/*Data for the table `cf_alcance` */

insert  into `cf_alcance`(`alcance_id`,`alcance_descripcion`,`alcance_estado`,`alcance_fechacreo`,`alcance_fechamodifico`,`alcance_usuariocreo`,`alcance_usuariomodifico`) values (1,'Verificación de las cimentaciones existentes para determinar si son adecuadas para el interruptor a instalar (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.). En caso de no existir bases, levantar el espacio disponible para la construcción de las mismas, así como posibles interferencias con bases de pórticos, tuberías, etc.',1,NULL,'2017-03-25 07:05:23',1,NULL),(2,'Verificación de existencia y disponibilidad de cárcamos y/o tuberías para cableado de control entre los polos y desde el interruptor hacia los equipos asociados (tablero de control y protección, seccionadores).',1,NULL,'2017-03-25 07:06:05',1,NULL),(3,'Ingeniería para construcción y/o modificación de la cimentación para el interruptor a instalar, soportando cada opción con sus respectivos cálculos.',1,NULL,'2017-03-25 07:06:05',1,NULL),(4,'Ingeniería para construcción y/o ampliación de los cárcamos y/o bancos de ductos para el cableado de control entre los polos y desde el interruptor a los equipos asociados (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:05',1,NULL),(5,'Verificar las distancias de seguridad, eléctricas y de mantenimiento al piso, estructuras de pórtico y equipos adyacentes, con las normas vigentes (en especial el RETIE).',1,NULL,'2017-03-25 07:06:05',1,NULL),(6,'Validar la conexión a los equipos adyacentes (seccionadores, CTs) especificando calibre de cable y/o tubería y los conectores.',1,NULL,'2017-03-25 07:06:05',1,NULL),(7,'Revisar los planos de fabricante del interruptor a instalar.',1,NULL,'2017-03-25 07:06:05',1,NULL),(8,'Presentar planos de planta y perfil mostrando la integración entre el interruptor nuevo y el modulo existente (equipos de potencia, caja de mando del interruptor y cárcamos de control en patio).',1,NULL,'2017-03-25 07:06:05',1,NULL),(9,'Ingeniería mecánica completa para instalación de nuevo interruptor incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia con los equipos adyacentes (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:05',1,NULL),(10,'Determinar los aspectos a tener en cuenta para la instalación del nuevo equipo (acceso de maquinaria pesada, distancia a equipos energizados, delimitación de la zona de trabajo, etc.).',1,NULL,'2017-03-25 07:06:05',1,NULL),(11,'Realizar el levantamiento de las interfaces a nivel de control, protección y servicios auxiliares AC y DC del interruptor existente, plasmando esta información en sus respectivos planos.',1,NULL,'2017-03-25 07:06:05',1,NULL),(12,'Realizar la ingeniería eléctrica completa para reemplazo y/o instalación del interruptor, con sus interfaces a nivel de control, protección y auxiliares AC y DC, bajo los criterios de ingeniería de CODENSA, NO047.',1,NULL,'2017-03-25 07:06:05',1,NULL),(13,'Ingeniería para la conexión del relé de mando sincronizado (cuando aplique)',1,NULL,'2017-03-25 07:06:05',1,NULL),(14,'Elaborar las listas de desconexión del esquema de control, protección y auxiliares del interruptor existente.',1,NULL,'2017-03-25 07:06:05',1,NULL),(15,'Elaborar la lista de conexionado para el interruptor a instalar (tipo de cable, marquillas, terminales, código de colores, etc.).',1,NULL,'2017-03-25 07:06:05',1,NULL),(16,'Adecuar el cableado hacia los relés de protección y/o unidades de control, según la plantilla de protecciones normalizada de CODENSA.',1,NULL,'2017-03-25 07:06:05',1,NULL),(17,'Verificar si el diseño de la cimentación existente es adecuado para el interruptor a instalar (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.). En caso de no existir base, levantar el espacio disponible para la construcción de la misma, así como posibles interferencias con bases de pórticos, tuberías, etc.',1,NULL,'2017-03-25 07:06:05',1,NULL),(18,'Verificar la existencia y disponibilidad de cárcamos y/o tuberías para cableado de control desde el interruptor hacia los equipos asociados y alimentaciones de AC y DC.',1,NULL,'2017-03-25 07:06:05',1,NULL),(19,'Adaptar la ingeniería civil de cimentación de interruptor normalizada y/o modificar la existente, de acuerdo a las condiciones del lugar de instalación del equipo.',1,NULL,'2017-03-25 07:06:05',1,NULL),(20,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de control desde el interruptor a los equipos asociados.',1,NULL,'2017-03-25 07:06:05',1,NULL),(21,'Verificar distancias de seguridad, eléctricas y de mantenimiento al piso, estructuras de pórtico y equipos adyacentes, con las normas vigentes (en especial el RETIE).',1,NULL,'2017-03-25 07:06:05',1,NULL),(22,'Validar la conexión en potencia a los equipos adyacentes (seccionadores, CTs) especificando calibre de cable y/o tubería, conectores.',1,NULL,'2017-03-25 07:06:05',1,NULL),(23,'Ingeniería mecánica completa para instalación de nuevo interruptor incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia por AT con los equipos adyacentes. (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:05',1,NULL),(24,'Verificar si la cimentación existente es adecuada para los nuevos CTs a instalar (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.). Incluye las actividades necesarias para esta verificación',1,NULL,'2017-03-25 07:06:05',1,NULL),(25,'Verificar la disponibilidad de cárcamos y/o tuberías para cableado de circuitos de corriente.',1,NULL,'2017-03-25 07:06:05',1,NULL),(26,'Adaptar la ingeniería civil de la cimentación de los CTs normalizada y/o modificar la existente para los nuevos equipos a instalar.',1,NULL,'2017-03-25 07:06:05',1,NULL),(27,'Verificar la estructura metálica de soporte actual para determinar si se adapta a los nuevos equipos. En caso contrario, realizar la ingeniería mecánica completa de la nueva estructura o de las partes que requieran modificarse, incluyendo planos detallados para fabricación.',1,NULL,'2017-03-25 07:06:05',1,NULL),(28,'Revisión de la actual caja de agrupamiento y tubería para determinar la necesidad de cambio.',1,NULL,'2017-03-25 07:06:05',1,NULL),(29,'Presentar planos de planta y perfil mostrando la integración entre los nuevos CTs y los equipos adyacentes, la barra y/o la llegada de las líneas (en el caso de módulos de línea)',1,NULL,'2017-03-25 07:06:05',1,NULL),(30,'Ingeniería mecánica completa para instalación de los nuevos CTs incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia con los equipos adyacentes (incluyendo calibres de cables y conectores) y disposición de la caja de agrupamiento.',1,NULL,'2017-03-25 07:06:05',1,NULL),(31,'Realizar el levantamiento de las características de los CT’s existentes (marca, tipo, relación de transformación, precisión, BIL, etc.).',1,NULL,'2017-03-25 07:06:05',1,NULL),(32,'Realizar diagramas unifilares y trifilares donde se muestre la conexión de cada núcleo del CT con los equipos de medida y relés de protección asociados.',1,NULL,'2017-03-25 07:06:05',1,NULL),(33,'Incluir planos producto de este levantamiento',1,NULL,'2017-03-25 07:06:05',1,NULL),(34,'Verificar que el CT a instalar cumpla con los requerimientos del esquema de protección y medida existente en la subestación.',1,NULL,'2017-03-25 07:06:05',1,NULL),(35,'Contemplar modernización de borneras de corriente tanto en caja de agrupamiento como en los tableros de control y protección asociados a los CTs a reemplazar.',1,NULL,'2017-03-25 07:06:05',1,NULL),(36,'Realizar la ingeniería eléctrica completa para el reemplazo de los CTs teniendo en cuenta las listas de desconexión de los circuitos de corriente existentes y las listas de conexionado para el CT a instalar (tipo de cable, marquillas, terminales, etc.).',1,NULL,'2017-03-25 07:06:05',1,NULL),(37,'Realizar los cálculos de cargabilidad de los CTs con el cableado propuesto y validar el cumplimiento de la reglamentación vigente (Código de Medida CREG 038).',1,NULL,'2017-03-25 07:06:05',1,NULL),(38,'Verificar si la cimentación existente es adecuada para los nuevos CTs a instalar (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.). Incluye las actividades necesarias para esta verificación (apiques, extracción de núcleos de concreto, etc)',1,NULL,'2017-03-25 07:06:06',1,NULL),(39,'Verificación de la estructura metálica de soporte actual para determinar si se adapta a los nuevos equipos. En caso contrario, realizar el calculo de la nueva estructura o de las partes que requieran modificarse, incluyendo planos detallados para fabricación.',1,NULL,'2017-03-25 07:06:06',1,NULL),(40,'Presentar planos de planta y perfil mostrando la integración entre los nuevos CTs y los equipos adyacentes y la barra.',1,NULL,'2017-03-25 07:06:06',1,NULL),(41,'Ingeniería mecánica completa para instalación de los nuevos CTs incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia con los equipos adyacentes (incluyendo calibres de cables y conectores), disposición de la caja de agrupamiento.',1,NULL,'2017-03-25 07:06:06',1,NULL),(42,'Realizar la ingeniería eléctrica completo para el reemplazo de los CTs teniendo en cuenta las listas de desconexión de los circuitos de corriente existentes y las listas de conexionado para el CT a instalar (tipo de cable, marquillas, terminales, etc.).',1,NULL,'2017-03-25 07:06:06',1,NULL),(43,'Verificar si la cimentación existente es adecuada para los nuevos PTs a instalar (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.). Incluye las actividades necesarias para esta verificación (apiques, extracción de núcleos de concreto, etc)',1,NULL,'2017-03-25 07:06:06',1,NULL),(44,'Verificar la disponibilidad de cárcamos y/o tuberías para cableado de circuitos de tensión.',1,NULL,'2017-03-25 07:06:06',1,NULL),(45,'Adaptar la ingeniería civil de la cimentación de los PTs normalizada y/o modificar la existente para los nuevos equipos a instalar.',1,NULL,'2017-03-25 07:06:06',1,NULL),(46,'Verificación de la estructura metálica de soporte actual para determinar si se adapta a los nuevos equipos. En caso contrario, Ingeniería mecánica completo de la nueva estructura o de las partes que requieran modificarse, incluyendo planos detallados para fabricación.',1,NULL,'2017-03-25 07:06:06',1,NULL),(47,'Presentar planos de planta y perfil mostrando la integración entre los nuevos PTs y los equipos adyacentes y/o la barra.',1,NULL,'2017-03-25 07:06:06',1,NULL),(48,'Ingeniería mecánica completa para instalación de los nuevos PTs incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia con los equipos adyacentes (incluyendo calibres de cables y conectores), disposición de la caja de agrupamiento.',1,NULL,'2017-03-25 07:06:06',1,NULL),(49,'Realizar el levantamiento de las características de los PT’s existentes (marca, tipo, relación de transformación, precisión, BIL, etc.).',1,NULL,'2017-03-25 07:06:06',1,NULL),(50,'Realizar diagramas unifilares y trifilares donde se muestre la conexión de cada núcleo del PT con los equipos de medida, control y/o protección asociados.',1,NULL,'2017-03-25 07:06:06',1,NULL),(51,'Verificar que el PT a instalar cumpla con los requerimientos del esquema de protección y medida existente en la subestación.',1,NULL,'2017-03-25 07:06:06',1,NULL),(52,'Contemplar modernización de borneras de tensión y MCBs tanto en caja de agrupamiento como en los tableros de control y protección asociados a los equipos a reemplazar.',1,NULL,'2017-03-25 07:06:06',1,NULL),(53,'Realizar la ingeniería eléctrica completa para el reemplazo de los PTs teniendo en cuenta las listas de desconexión de los circuitos de corriente existentes y las listas de conexionado para el PT a instalar (tipo de cable, marquillas, terminales, etc.).',1,NULL,'2017-03-25 07:06:06',1,NULL),(54,'Realizar los cálculos de cargabilidad de los PTs con el cableado propuesto y validar el cumplimiento de la reglamentación vigente (Código de Medida CREG 038).',1,NULL,'2017-03-25 07:06:06',1,NULL),(55,'Verificar si la cimentación existente es adecuada para los nuevos PTs a instalar (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.).',1,NULL,'2017-03-25 07:06:06',1,NULL),(56,'Verificación disponibilidad de cárcamos y/o tuberías para cableado de circuitos de tensión hacia sala de control. En caso de requerirse, realizar la ingeniería para la ampliación o extensión de los cárcamos y/o banco de ductos existentes',1,NULL,'2017-03-25 07:06:06',1,NULL),(57,'Adaptar el diseño de la cimentación de los PTs normalizada y/o modificar la existente para los nuevos equipos a instalar.',1,NULL,'2017-03-25 07:06:06',1,NULL),(58,'Realizar un levantamiento detallado de las vigas y columnas para determinar esfuerzos sobre el pórtico y necesidad de refuerzos sobre las vigas y/o columnas.',1,NULL,'2017-03-25 07:06:06',1,NULL),(59,'Verificación de la estructura metálica de soporte actual para determinar si se adapta a los nuevos equipos. En caso contrario, Ingeniería mecánica completo de la nueva estructura incluyendo planos de taller para fabricación.',1,NULL,'2017-03-25 07:06:06',1,NULL),(60,'Presentar planos de planta y perfil mostrando la conexión de los PTs a la barra.',1,NULL,'2017-03-25 07:06:06',1,NULL),(61,'Ingeniería mecánica completa para instalación de nuevos PTs incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:06',1,NULL),(62,'Realizar diagramas unifilares y trifilares donde se muestre la conexión de cada núcleo del PT con los equipos de medida y relés de protección asociados.',1,NULL,'2017-03-25 07:06:06',1,NULL),(63,'Actualizar los planos del levantamiento con la información del nuevo PT a instalar.',1,NULL,'2017-03-25 07:06:06',1,NULL),(64,'Contemplar modernización de borneras de tensión tanto en caja de agrupamiento como en los tableros de control y protección.',1,NULL,'2017-03-25 07:06:06',1,NULL),(65,'Realizar la ingeniería eléctrica para el reemplazo de los PTs teniendo en cuenta las listas de desconexión de los circuitos de corriente existentes y las listas de conexionado para el PT a instalar (tipo de cable, marquillas, terminales, etc.).',1,NULL,'2017-03-25 07:06:06',1,NULL),(66,'Realizar los cálculos de cargabilidad de los PTs con el cableado propuesto.',1,NULL,'2017-03-25 07:06:06',1,NULL),(67,'Verificar si la cimentación existente es adecuada para la instalación de los nuevos seccionadores de barra y/o de línea (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.) para el caso de los seccionadores montados sobre piso.',1,NULL,'2017-03-25 07:06:06',1,NULL),(68,'Verificación disponibilidad de cárcamos y/o tuberías para cableado de circuitos de control hacia sala y con los equipos adyacentes.',1,NULL,'2017-03-25 07:06:06',1,NULL),(69,'Adaptar la ingeniería civil de la cimentación de los seccionadores normalizada y/o modificar la existente para los nuevos equipos a instalar.',1,NULL,'2017-03-25 07:06:06',1,NULL),(70,'En caso de requerirse, diseñar ampliación o extensión de los cárcamos y/o banco de ductos existentes.',1,NULL,'2017-03-25 07:06:06',1,NULL),(71,'Determinar si la estructura de soporte existente se ajusta a las características del nuevo equipo, mediante los estudios correspondientes.',1,NULL,'2017-03-25 07:06:06',1,NULL),(72,'Validación de los planos de fabricación suministrados por el proveedor de los equipos.',1,NULL,'2017-03-25 07:06:06',1,NULL),(73,'Para el caso de seccionadores instalados sobre pórtico, hacer un levantamiento de las vigas y columnas para determinar esfuerzos sobre el pórtico y necesidad de refuerzos sobre las vigas y/o columnas.',1,NULL,'2017-03-25 07:06:06',1,NULL),(74,'Verificar distancias de seguridad, eléctricas y de mantenimiento al piso, estructuras de pórtico y equipos adyacentes, con las normas vigentes (en especial el RETIE), en posición del seccionador abierto y cerrado.',1,NULL,'2017-03-25 07:06:06',1,NULL),(75,'Calcular la estructura de soporte del seccionador teniendo en cuenta las dimensiones y peso del equipo a montar.',1,NULL,'2017-03-25 07:06:06',1,NULL),(76,'Realizar los planos de instalación del seccionador sobre la viga con el diseño de los elementos que se requieran para fijación tanto del equipo, como del tubo y la caja de mando.',1,NULL,'2017-03-25 07:06:06',1,NULL),(77,'Ingeniería mecánica completa para instalación de nuevo seccionador incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia (calibres y conectores).',1,NULL,'2017-03-25 07:06:06',1,NULL),(78,'Realizar el levantamiento de las interfaces a nivel de control, protección y servicios auxiliares AC y DC del seccionador existente, plasmando esta información en sus respectivos planos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(79,'Revisar los planos de fabricante del equipo a instalar.',1,NULL,'2017-03-25 07:06:07',1,NULL),(80,'Realizar la ingeniería eléctrica completa para reemplazo y/o instalación del seccionador, con sus interfaces a nivel de control, protección y auxiliares AC y DC, bajo los criterios de ingeniería de CODENSA, NO047.',1,NULL,'2017-03-25 07:06:07',1,NULL),(81,'Elaborar las listas de desconexión del esquema de control de los seccionadores existentes.',1,NULL,'2017-03-25 07:06:07',1,NULL),(82,'Elaborar la lista de conexionado para los seccionadores a instalar (tipo de cable, marquillas, terminales, etc.).',1,NULL,'2017-03-25 07:06:07',1,NULL),(83,'En caso de requerirse, realizar la ingeniería para la ampliación o extensión de los cárcamos y/o banco de ductos existentes.',1,NULL,'2017-03-25 07:06:07',1,NULL),(84,'Levantamiento de la base actual de los pararrayos para determinar si es apta para los nuevos equipos a instalar. En caso de requerirse, adaptar la ingeniería civil de la cimentación de los PYs normalizada y/o modificar la existente para los nuevos equipos a instalar.',1,NULL,'2017-03-25 07:06:07',1,NULL),(85,'Para el caso de pararrayos instalados sobre pórtico, hacer un levantamiento de las vigas y realizar los planos de instalación de los equipos sobre la viga con la definición de los elementos adicionales que se requieran para fijación del equipo.',1,NULL,'2017-03-25 07:06:07',1,NULL),(86,'Determinar si la estructura de soporte existente se ajusta a las características del nuevo equipo, mediante los estudios correspondientes. En caso de requerirse, calcular la estructura de soporte necesaria para el montaje de los pararrayos teniendo en cuenta las dimensiones y peso del equipo a montar.',1,NULL,'2017-03-25 07:06:07',1,NULL),(87,'Ingeniería mecánica completa para instalación de los nuevos pararrayos incluyendo: conexiones de PAT y conexiones en potencia (calibres y tipo de cables y conectores).',1,NULL,'2017-03-25 07:06:07',1,NULL),(88,'Realizar el levantamiento del lugar de ubicación del banco de compensación.',1,NULL,'2017-03-25 07:06:07',1,NULL),(89,'Verificar la cimentación existente para los equipos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(90,'En caso de ser necesario realizar la ingeniería de la nueva cimentación',1,NULL,'2017-03-25 07:06:07',1,NULL),(91,'Determinar si la estructura de soporte existente se ajusta a las características de los equipos, mediante los estudios correspondientes.',1,NULL,'2017-03-25 07:06:07',1,NULL),(92,'En caso de requerirse, calcular la estructura de soporte necesaria para el montaje de los equipos teniendo en cuenta las dimensiones y pesos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(93,'Ingeniería mecánica completa para instalación del banco incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia (calibres y conectores).',1,NULL,'2017-03-25 07:06:07',1,NULL),(94,'Realizar el levantamiento correspondiente a los esquemas de control y enclavamientos del banco, plasmando esta información en sus respectivos planos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(95,'Determinar los aspectos mas relevantes a tener en cuenta para la instalación del banco (acceso de maquinaria pesada, distancia a equipos energizados, etc.).',1,NULL,'2017-03-25 07:06:07',1,NULL),(96,'Actualizar los planos de control y protección producto del levantamiento.',1,NULL,'2017-03-25 07:06:07',1,NULL),(97,'Elaborar las listas de desconexionado y conexionado',1,NULL,'2017-03-25 07:06:07',1,NULL),(98,'Verificar si la cimentación existente es adecuada para el reconectador a instalar para los que están ubicados en estructura soporte en piso. (tipo de cimentación, distancia entre pernos de anclaje, esfuerzos estáticos y dinámicos, etc.).',1,NULL,'2017-03-25 07:06:07',1,NULL),(99,'Verificación disponibilidad de cárcamos y/o tuberías para cableado de control hacia módulos asociados.',1,NULL,'2017-03-25 07:06:07',1,NULL),(100,'Adaptar la ingeniería civil de la cimentación de los reconectadores normalizada y/o modificar la existente para el nuevo equipo a instalar.',1,NULL,'2017-03-25 07:06:07',1,NULL),(101,'Presentar planos de planta y perfil mostrando la integración entre el nuevo equipo y el modulo existente (equipos de potencia, caja de mando del reconectador y canaletas de control en patio).',1,NULL,'2017-03-25 07:06:07',1,NULL),(102,'Ingeniería mecánica completa para instalación de nuevo reconectador incluyendo: conexiones de PAT, disposición de tuberías, conexiones en potencia por AT con los equipos adyacentes. (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:07',1,NULL),(103,'Realizar el levantamiento de las interfaces a nivel de control y protección del equipo existente, plasmando esta información en sus respectivos planos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(104,'Revisar los planos de fabricante del reconectador a instalar.',1,NULL,'2017-03-25 07:06:07',1,NULL),(105,'Realizar la ingeniería eléctrica completa para reemplazo y/o instalación del reconectador, con sus interfaces a nivel de control, protección y auxiliares AC y DC, bajo los criterios de ingeniería de CODENSA, NO047.',1,NULL,'2017-03-25 07:06:07',1,NULL),(106,'Elaborar las listas de desconexión del esquema de control, protección y auxiliares del equipo existente.',1,NULL,'2017-03-25 07:06:07',1,NULL),(107,'Elaborar la lista de conexionado para el reconectador a instalar (tipo de cable, marquillas, terminales, código de colores, etc.).',1,NULL,'2017-03-25 07:06:07',1,NULL),(108,'Levantamiento civil de la base actual del transformador o de los espacios disponibles para la ubicación del nuevo equipo. Para bases existentes, realizar la verificación de la capacidad de la base para el nuevo equipo.',1,NULL,'2017-03-25 07:06:07',1,NULL),(109,'Levantamiento de la ubicación actual/propuesta del transformador de SSAUX y sus conexiones tanto por MT como por BT.',1,NULL,'2017-03-25 07:06:07',1,NULL),(110,'Ajustar la cimentación para transformadores tipo pedestal/poste según las normas de construcción de CODENSA, en el sitio de ubicación del nuevo equipo, con sus respectivos bancos de ductos y/o cárcamos para conexión de los cables de potencia tanto en MT como en BT.',1,NULL,'2017-03-25 07:06:07',1,NULL),(111,'Realizar el dimensionamiento de los cables de conexión en potencia y determinar la necesidad de reemplazo y/o reutilización de los mismos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(112,'Realizar la ingeniería mecánica completa indicando conexiones de puesta a tierra y elementos de conexión en potencia.',1,NULL,'2017-03-25 07:06:07',1,NULL),(113,'Levantamiento de la ubicación actual y propuesta del tablero dentro de la sala de control.',1,NULL,'2017-03-25 07:06:07',1,NULL),(114,'Verificación de disponibilidad de cárcamos y tuberías para conexión de los circuitos de auxiliares AC a los módulos tanto en patio como en sala de control.',1,NULL,'2017-03-25 07:06:07',1,NULL),(115,'Realizar la ingeniería para construcción de nuevos cárcamos o bancos de ductos para interconexión entre el tablero y los módulos.',1,NULL,'2017-03-25 07:06:07',1,NULL),(116,'Realizar el plano de dimensiones generales y disposición física de equipos en el tablero (breakers, borneras, equipos de medida y otros)',1,NULL,'2017-03-25 07:06:07',1,NULL),(117,'Diseñar el anclaje del tablero al piso.',1,NULL,'2017-03-25 07:06:07',1,NULL),(118,'Levantamiento de los circuitos actuales de alimentación de AC que salen del tablero a reemplazar.',1,NULL,'2017-03-25 07:06:08',1,NULL),(119,'Dimensionamiento del nuevo tablero, haciendo las independizaciones de circuitos a que haya lugar y el calculo de cargas para cada uno de ellos, teniendo en cuenta los criterios de ingeniería NO047. Determinar cantidad, tipo, curva y capacidad de Breakers.',1,NULL,'2017-03-25 07:06:08',1,NULL),(120,'Definir cantidad de contactos auxiliares requeridos y realizar el diseño de conexión de los mismos para señalización a anunciación local o hacia centro de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(121,'Indicar las conexiones de alimentación de auxiliares AC desde el nuevo tablero hacia los diferentes módulos de la S/E tanto en patio como en sala de control. (calibre, tipo de cable y ruta propuesta)',1,NULL,'2017-03-25 07:06:08',1,NULL),(122,'Realizar el estudio de coordinación de protecciones del nuevo tablero.',1,NULL,'2017-03-25 07:06:08',1,NULL),(123,'Realizar diagramas unifilares y trifilares del tablero.',1,NULL,'2017-03-25 07:06:08',1,NULL),(124,'Levantamiento de la ubicación actual y propuesta del equipo dentro de la sala de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(125,'Verificación de disponibilidad de cárcamos y tuberías para conexión de los circuitos de AC hacia/desde el equipo de transferencia',1,NULL,'2017-03-25 07:06:08',1,NULL),(126,'Realizar la ingeniería para construcción de nuevos cárcamos o bancos de ductos para interconexión entre el equipo y los módulos asociados (trafo auxiliares y tablero AC).',1,NULL,'2017-03-25 07:06:08',1,NULL),(127,'Indicar como se debe realizar el anclaje del equipo al piso.',1,NULL,'2017-03-25 07:06:08',1,NULL),(128,'Realizar la ingeniería eléctrica completa incluyendo la conexión de cables de fuerza y la señalización a centro de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(129,'Levantamiento de los circuitos actuales de alimentación de DC que salen del tablero a reemplazar.',1,NULL,'2017-03-25 07:06:08',1,NULL),(130,'Indicar las conexiones de alimentación de auxiliares DC desde el nuevo tablero hacia los diferentes módulos de la S/E tanto en patio como en sala de control. (calibre, tipo de cable y ruta propuesta)',1,NULL,'2017-03-25 07:06:08',1,NULL),(131,'Realizar el estudio de coordinación de protecciones del tablero.',1,NULL,'2017-03-25 07:06:08',1,NULL),(132,'Levantamiento de la ubicación actual y propuesta de los equipos dentro de la sala de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(133,'Verificación de disponibilidad de cárcamos y tuberías para conexión de la acometida entre los cargadores y el banco de baterías y los tableros de AC y DC.',1,NULL,'2017-03-25 07:06:08',1,NULL),(134,'En caso de requerirse, realizar la ingeniería para construcción nuevos cárcamos o bancos de ductos para interconexión',1,NULL,'2017-03-25 07:06:08',1,NULL),(135,'Levantamiento de las conexiones actuales de los cargadores incluyendo conexiones a tableros de AC, DC, banco de baterías y señalización a centro de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(136,'Revisión de los planos del fabricante.',1,NULL,'2017-03-25 07:06:08',1,NULL),(137,'Realizar la ingeniería eléctrica completa para la instalación de los nuevos equipos, incluyendo: interconexiones entre el cargador, los tableros de AC y DC y los bancos de baterías, señales a centro de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(138,'Levantamiento completo del tablero de control y protección (equipos, borneras, MCBs, etc)',1,NULL,'2017-03-25 07:06:08',1,NULL),(139,'Realizar las modificaciones requeridas en el tablero incluyendo detalles de laminas a adecuar y vista final del tablero, de acuerdo a los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:08',1,NULL),(140,'Levantamiento de conexiones eléctricas del esquema de control y protección del modulo existente para su normalización de acuerdo con los criterios de ingeniería NO047',1,NULL,'2017-03-25 07:06:08',1,NULL),(141,'Ingeniería eléctrica completa para adecuación del esquema de control y protección según criterios de ingeniería NO047',1,NULL,'2017-03-25 07:06:08',1,NULL),(142,'Actualización de planos de control y protección del modulo.',1,NULL,'2017-03-25 07:06:08',1,NULL),(143,'Elaboración de listas de conexionado y desconexionado.',1,NULL,'2017-03-25 07:06:08',1,NULL),(144,'Indicar características y cantidad de borneras (seccionables y cortocircuitables) a reemplazar, en caso que las existentes estén deterioradas o no cumplan con las características requeridas por la EEC',1,NULL,'2017-03-25 07:06:08',1,NULL),(145,'Levantamiento del tablero de control donde se instalara la UCB. Determinar elementos a retirar como lámparas de indicación, anunciadores, unidades de medida análogas, etc.',1,NULL,'2017-03-25 07:06:08',1,NULL),(146,'Levantamiento de conexiones eléctricas del esquema de control, medida y anunciación existente.',1,NULL,'2017-03-25 07:06:08',1,NULL),(147,'Verificar si se requiere tendido o reemplazo de multiconductores desde patio hacia sala.',1,NULL,'2017-03-25 07:06:08',1,NULL),(148,'Ingeniería para adecuación del esquema de control del modulo según criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:08',1,NULL),(149,'Actualización de planos de control del modulo.',1,NULL,'2017-03-25 07:06:08',1,NULL),(150,'Indicar características y cantidad de borneras (seccionables y cortocircuitables) a reemplazar, en caso que las existentes estén deterioradas o no cumplan con las características requeridas por la EEC.',1,NULL,'2017-03-25 07:06:08',1,NULL),(151,'Definición de conectividad a nivel de comunicaciones para los servicios de telecontrol y gestión de protecciones.',1,NULL,'2017-03-25 07:06:08',1,NULL),(152,'Realizar el levantamiento en sala de control para determinar la ubicación optima del nuevo tablero.',1,NULL,'2017-03-25 07:06:08',1,NULL),(153,'Realizar la ingeniería del tablero de control y protección requerido (tipo rack o tipo túnel) incluyendo detalles de disposición de borneras, MCBs y demás equipos.',1,NULL,'2017-03-25 07:06:08',1,NULL),(154,'Indicar la disposición de relés, mímico y controlador de bahía en los casos que aplique',1,NULL,'2017-03-25 07:06:08',1,NULL),(155,'Levantamiento de conexiones eléctricas del esquema de control, medida, anunciación y protección existente.',1,NULL,'2017-03-25 07:06:08',1,NULL),(156,'Verificación de multiconductores desde patio hacia sala para determinar necesidad de cambio o instalación de nuevos cables.',1,NULL,'2017-03-25 07:06:08',1,NULL),(157,'Verificar la conexión de señales hacia centro de control.',1,NULL,'2017-03-25 07:06:08',1,NULL),(158,'Ingeniería eléctrica completa del esquema de control y protección según criterios de ingeniería NO047, incluyendo todos los IEDs que requiera el modulo.',1,NULL,'2017-03-25 07:06:09',1,NULL),(159,'Indicar las interconexiones con los módulos asociados y el sistema de auxiliares AC y DC.',1,NULL,'2017-03-25 07:06:09',1,NULL),(160,'Indicar interconexiones con los módulos asociados y el sistema de auxiliares AC y DC.',1,NULL,'2017-03-25 07:06:09',1,NULL),(161,'Verificación del estado de las cajas de agrupamiento de todos los módulos intervenidos',1,NULL,'2017-03-25 07:06:09',1,NULL),(162,'Levantamiento mecánico del tablero donde se instalara la protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(163,'Elaborar plano mostrando la adecuación de(los) tablero(s) o diseño del nuevo tablero(s) donde se realizara el cambio o instalación de la nueva protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(164,'Ingeniería mecánica para el cambio de las cajas de agrupamiento y borneras en los módulos que sean requeridos.',1,NULL,'2017-03-25 07:06:09',1,NULL),(165,'Realizar el levantamiento de las características de la protección actual (marca, tipo, etc.)',1,NULL,'2017-03-25 07:06:09',1,NULL),(166,'Realizar los diagramas unifilares y trifilares donde se muestre el estado actual de la instalación.',1,NULL,'2017-03-25 07:06:09',1,NULL),(167,'Verificación del estado y conexión de las corrientes en todos los módulos a integrar bajo la protección 87B. En caso que no cuenten con borneras cortocircuitables se debe sugerir el reemplazo de borneras en los módulos que así lo requieran.',1,NULL,'2017-03-25 07:06:09',1,NULL),(168,'Verificar la compatibilidad de los CTs existentes con la nueva protección (núcleos, relación de transformación, saturación, etc) y determinar si es requerido el cambio en alguno de los módulos.',1,NULL,'2017-03-25 07:06:09',1,NULL),(169,'Levantamientos e ingeniería para el reemplazo de la protección 86B, con sus conexiones en cada uno de los módulos asociados.',1,NULL,'2017-03-25 07:06:09',1,NULL),(170,'Hacer la nueva implementación bajo los criterios de ingeniería NO047 (contemplando esquemas de disparo y bloqueo, función 50 BF, enclavamientos, señales a centro de control, etc.).',1,NULL,'2017-03-25 07:06:09',1,NULL),(171,'Verificar la funcionalidad de la protección a instalar con los CTs existentes en todos los módulos a integrar en la nueva protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(172,'Presentar diagramas unifilares, trifilares, de principio, de control y protección, que contemplen la implementación final.',1,NULL,'2017-03-25 07:06:09',1,NULL),(173,'Determinar los aspectos a tener en cuenta para la instalación del relé.',1,NULL,'2017-03-25 07:06:09',1,NULL),(174,'Elaborar las listas de desconexionado y conexionado para la implementación de la nueva protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(175,'Diseñar la adecuación del tablero donde se realizara el cambio o instalación de la nueva protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(176,'Realizar los diagramas unifilares y trifilares donde se muestre el estado actual de la instalación. Se debe reflejar el estado y conexión de las corrientes de cada uno de los devanados del transformador de potencia que intervienen en el esquema.',1,NULL,'2017-03-25 07:06:09',1,NULL),(177,'Verificar la funcionalidad de la protección a instalar con los CTs existentes.',1,NULL,'2017-03-25 07:06:09',1,NULL),(178,'Realizar los levantamientos y diseños para el reemplazo de la protección 86T.',1,NULL,'2017-03-25 07:06:09',1,NULL),(179,'Hacer la nueva implementación de acuerdo a los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:09',1,NULL),(180,'Presentar diagramas unifilares, trifilares, de principio, de control y protección, que contemplen la implementación final, incluyendo los caminos de cierre y disparo al interruptor con sus respectivos enclavamientos.',1,NULL,'2017-03-25 07:06:09',1,NULL),(181,'Indicar como se debe hacer la adecuación del tablero donde se realizara el cambio o instalación de la nueva protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(182,'Verificar la existencia de esquemas maestroseguidor.',1,NULL,'2017-03-25 07:06:09',1,NULL),(183,'Verificar la funcionalidad de la protección a instalar con los CTs y demás equipos de potencia instalados en el modulo a intervenir.',1,NULL,'2017-03-25 07:06:09',1,NULL),(184,'Realizar los levantamientos y diseños para el reemplazo/instalación de la protección 86L.',1,NULL,'2017-03-25 07:06:09',1,NULL),(185,'Verificar la implementación del esquema de comunicación entre los relés de ambos extremos con los equipos a instalar.',1,NULL,'2017-03-25 07:06:09',1,NULL),(186,'Verificar las conexiones con el equipo de teleproteccion en caso que sea existente y en caso contrario, dejar la ingeniería adaptada para cuando se instale dicho equipo según los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:09',1,NULL),(187,'Hacer la nueva implementación de acuerdo a los criterios de ingeniería NO047',1,NULL,'2017-03-25 07:06:09',1,NULL),(188,'En los módulos de línea, implementación de la lógica de teleproteccion (si el equipo es existente). Si no, dejar la plantilla definida para la futura implementación.',1,NULL,'2017-03-25 07:06:09',1,NULL),(189,'Levantamiento mecánico del tablero y/o celda donde se instalara la unidad de control y protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(190,'Indicar como se debe hacer la adecuación del tablero donde se realizara el cambio o instalación de la nueva unidad de control y protección.',1,NULL,'2017-03-25 07:06:09',1,NULL),(191,'Realizar el levantamiento de las características de la protección actual (marca, tipo, etc.) y del esquema de control del modulo o celda.',1,NULL,'2017-03-25 07:06:09',1,NULL),(192,'Verificar la funcionalidad de la unidad de control y protección a instalar con los CTs y demás equipos de potencia instalados en el modulo a intervenir.',1,NULL,'2017-03-25 07:06:09',1,NULL),(193,'Presentar diagramas unifilares, trifilares, de principio, de control y protección del modulo intervenido, que contemplen la implementación final.',1,NULL,'2017-03-25 07:06:09',1,NULL),(194,'Determinar los aspectos a tener en cuenta para la instalación del equipo.',1,NULL,'2017-03-25 07:06:09',1,NULL),(195,'Indicar características y cantidad de borneras a reemplazar, en caso que las existentes estén deterioradas o no cumplan con las características requeridas por la EEC.',1,NULL,'2017-03-25 07:06:09',1,NULL),(196,'Elaborar las listas de desconexionado y conexionado para la implementación del nuevo equipo.',1,NULL,'2017-03-25 07:06:09',1,NULL),(197,'Levantamiento del tablero/celda donde se ubicaran los equipos de medida.',1,NULL,'2017-03-25 07:06:09',1,NULL),(198,'Indicar como se debe hacer la adecuación del tablero donde se realizara el cambio o instalación de los nuevos equipos.',1,NULL,'2017-03-25 07:06:09',1,NULL),(199,'Levantamiento de los circuitos de medida (corrientes y tensiones).',1,NULL,'2017-03-25 07:06:10',1,NULL),(200,'Verificar las características de placa de los CTs y PTs para validar compatibilidad con el equipo de medida a instalar.',1,NULL,'2017-03-25 07:06:10',1,NULL),(201,'Elaboración de planos para reemplazo de los equipos de medida',1,NULL,'2017-03-25 07:06:10',1,NULL),(202,'Levantamiento de esquema de transferencia actual incluyendo: disparos, polaridades, enclavamientos, etc, en todos los módulos conectados a la barra de transferencia.',1,NULL,'2017-03-25 07:06:10',1,NULL),(203,'Validar los contactos disponibles en el seccionador de transferencia, para determinar necesidad de cambio o uso de relés repetidores.',1,NULL,'2017-03-25 07:06:10',1,NULL),(204,'Ingeniería para la implementación de esquema de transferencia teniendo en cuenta los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:10',1,NULL),(205,'Indicar las adecuaciones que se deben realizar en el tablero del modulo acoplador.',1,NULL,'2017-03-25 07:06:10',1,NULL),(206,'Levantamiento del tablero de control donde se ubicara el panel anunciador de alarmas.',1,NULL,'2017-03-25 07:06:10',1,NULL),(207,'Ingeniería mecánica para instalación del nuevo equipo',1,NULL,'2017-03-25 07:06:10',1,NULL),(208,'Levantamiento de circuitos de alarma que se cablearan al anunciador según criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:10',1,NULL),(209,'Ingeniería para montaje y puesta en servicio del nuevo equipo, incluyendo listas de conexionado y desconexionado e implementación de relés repetidores en caso de ser requerido.',1,NULL,'2017-03-25 07:06:10',1,NULL),(210,'Verificación de disponibilidad de espacio, cárcamos y tuberías para conexión de los circuitos al nuevo tablero en casa de control o patio conexiones.',1,NULL,'2017-03-25 07:06:10',1,NULL),(211,'Realizar la ingeniería de las bases de anclaje, nuevos cárcamos, bancos de ductos para interconexión en caso de requerirse.',1,NULL,'2017-03-25 07:06:10',1,NULL),(212,'Realizar la ingeniería del tablero de medida requerido (tipo rack u otro tipo) incluyendo detalles de disposición de borneras y demás equipos (hasta 6 equipos de medida).',1,NULL,'2017-03-25 07:06:10',1,NULL),(213,'Verificación de disponibilidad de cárcamos y tuberías para conexión de los circuitos al nuevo tablero.',1,NULL,'2017-03-25 07:06:10',1,NULL),(214,'En caso de requerirse realizar la ingeniería para construcción de nuevos cárcamos o bancos de ductos para interconexión.',1,NULL,'2017-03-25 07:06:10',1,NULL),(215,'Realizar la ingeniería mecánica completa del nuevo tablero, incluyendo disposición de equipos, borneras, selectores, unidad de control y relé de regulación.',1,NULL,'2017-03-25 07:06:10',1,NULL),(216,'Levantamiento de conexiones eléctricas del esquema de control, medida, fuerza, anunciación y protección existente del transformador.',1,NULL,'2017-03-25 07:06:10',1,NULL),(217,'Ingeniería completo del nuevo tablero de regulación (incluyendo el relé 90 y la unidad de control donde aplique), según los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:10',1,NULL),(218,'Actualización de planos de control del modulo de transformación.',1,NULL,'2017-03-25 07:06:10',1,NULL),(219,'Verificación de multiconductores desde el transformador hacia el nuevo tablero para determinar necesidad de cambio o instalación de nuevos cables.',1,NULL,'2017-03-25 07:06:10',1,NULL),(220,'Indicar las interconexiones con el tablero de control y protección del modulo de transformador y el sistema de auxiliares AC y DC.',1,NULL,'2017-03-25 07:06:10',1,NULL),(221,'Definir la conexión de señales hacia centro de control.',1,NULL,'2017-03-25 07:06:10',1,NULL),(222,'Levantamiento mecánico del tablero donde se instalara el registrador de fallas.',1,NULL,'2017-03-25 07:06:10',1,NULL),(223,'Elaborar plano mostrando la adecuación del tablero o el nuevo tablero donde se realizara el cambio/instalación del nuevo equipo.',1,NULL,'2017-03-25 07:06:10',1,NULL),(224,'Realizar el levantamiento de las características del equipo actual (marca, tipo, etc.)',1,NULL,'2017-03-25 07:06:10',1,NULL),(225,'Levantamiento de todas las señales provenientes de las protecciones del modulo destinadas al registrador de fallas, las protecciones mecánicas del transformador (donde aplique), posiciones de interruptor(es) y las señales de tensión de barra y corrientes del(los) modulo(s) asociados.',1,NULL,'2017-03-25 07:06:10',1,NULL),(226,'Realizar los diagramas unifilares y trifilares donde se muestre el estado actual de la instalación. Se debe reflejar el estado y conexión de las corrientes y tensiones al registrador.',1,NULL,'2017-03-25 07:06:10',1,NULL),(227,'Hacer la implementación del equipo teniendo en cuenta la plantilla normalizada .',1,NULL,'2017-03-25 07:06:10',1,NULL),(228,'Elaborar las listas de desconexionado y conexionado para la implementación del equipo.',1,NULL,'2017-03-25 07:06:10',1,NULL),(229,'Levantamiento mecánico del tablero donde se instalaran las protecciones.',1,NULL,'2017-03-25 07:06:10',1,NULL),(230,'Elaborar plano mostrando la adecuación del tablero donde se realizara el cambio o instalación de las nuevas protecciones.',1,NULL,'2017-03-25 07:06:10',1,NULL),(231,'Realizar el levantamiento de las características de las protecciones actuales (marca, tipo, etc.)',1,NULL,'2017-03-25 07:06:10',1,NULL),(232,'Verificar la funcionalidad de las protecciones a instalar con los CTs y demás equipos de potencia instalados en el modulo a intervenir.',1,NULL,'2017-03-25 07:06:10',1,NULL),(233,'Determinar los aspectos a tener en cuenta para la instalación de las protecciones.',1,NULL,'2017-03-25 07:06:11',1,NULL),(234,'Verificar las conexiones con el equipo de teleproteccion en caso que sea existente y en caso contrario, dejar la ingeniería adaptada para cuando se instale dicho equipo.',1,NULL,'2017-03-25 07:06:11',1,NULL),(235,'Realizar los levantamientos para el reemplazo/instalación de la protección 86L.',1,NULL,'2017-03-25 07:06:11',1,NULL),(236,'Determinar los aspectos a tener en cuenta para la instalación de los relés.',1,NULL,'2017-03-25 07:06:11',1,NULL),(237,'Elaborar las listas de desconexionado y conexionado para la implementación de las nuevas protecciones.',1,NULL,'2017-03-25 07:06:11',1,NULL),(238,'Levantamiento mecánico de las celdas donde se instalaran las unidades de control y protección.',1,NULL,'2017-03-25 07:06:11',1,NULL),(239,'Diseñar la adecuación del modulo de control de las celdas donde se realizara el cambio o instalación de la nueva unidad de control y protección.',1,NULL,'2017-03-25 07:06:11',1,NULL),(240,'Realizar el levantamiento de las características de la protección actual (marca, tipo, etc.) y del esquema de control de cada celda.',1,NULL,'2017-03-25 07:06:11',1,NULL),(241,'Verificar la funcionalidad de la protección a instalar con los CTs de las celdas.',1,NULL,'2017-03-25 07:06:11',1,NULL),(242,'Presentar diagramas unifilares, trifilares, de principio, de control y protección del tren de celdas que contemplen la implementación final.',1,NULL,'2017-03-25 07:06:11',1,NULL),(243,'Determinar los aspectos a tener en cuenta para la instalación de los equipos.',1,NULL,'2017-03-25 07:06:11',1,NULL),(244,'Elaborar las listas de desconexionado y conexionado para la implementación de los nuevos equipos.',1,NULL,'2017-03-25 07:06:11',1,NULL),(245,'Levantamiento del estado actual del cuarto de baterías',1,NULL,'2017-03-25 07:06:11',1,NULL),(246,'Ingeniería para adecuación del cuarto para cumplir con normatividad vigente: ducha lavaojos, lámparas antiexplosivas, adecuación del piso, instalación extractores, puerta antipanico y demás adecuaciones que se requieran.',1,NULL,'2017-03-25 07:06:11',1,NULL),(247,'Recomendaciones del proceso constructivo.',1,NULL,'2017-03-25 07:06:11',1,NULL),(248,'Levantamiento topográfico del patio de la S/E incluyendo el sistema de drenaje de aguas lluvias, para determinar la ubicación optima del tanque de aceite.',1,NULL,'2017-03-25 07:06:11',1,NULL),(249,'Dimensionamiento del tanque de almacenamiento de aceite de acuerdo a los criterios de ingeniería NO048 y verificación de las conexiones entre este y los fosos colectores de los transformadores.',1,NULL,'2017-03-25 07:06:11',1,NULL),(250,'Ingeniería para construcción del tanque y conexión de la salida de agua a sumidero de aguas lluvias.',1,NULL,'2017-03-25 07:06:11',1,NULL),(251,'Levantamiento de la base actual del transformador.',1,NULL,'2017-03-25 07:06:11',1,NULL),(252,'Identificación de alternativas de conexión entre el nuevo foso y el tanque/trampa de aceite.',1,NULL,'2017-03-25 07:06:11',1,NULL),(253,'Dimensionamiento del foso colector de aceite de acuerdo a los criterios de ingeniería NO048.',1,NULL,'2017-03-25 07:06:11',1,NULL),(254,'Indicación de la conexión entre el foso y el tanque y/o trampa de aceite.',1,NULL,'2017-03-25 07:06:11',1,NULL),(255,'Refuerzo de la base del transformador de manera que permita la instalación futura de un transformador de 40 MVA.',1,NULL,'2017-03-25 07:06:11',1,NULL),(256,'Levantamiento del espacio disponible entre los transformadores de potencia para la construcción del muro cortafuegos.',1,NULL,'2017-03-25 07:06:11',1,NULL),(257,'Identificación de variables tales como la ubicación de cajas de inspección, postes y/o columnas de pórtico que deban ser tenidas en cuenta dentro de la construcción del muro',1,NULL,'2017-03-25 07:06:11',1,NULL),(258,'Levantamiento de la base de los transformadores actuales para verificar interferencias con la cimentación del muro cortafuego.',1,NULL,'2017-03-25 07:06:11',1,NULL),(259,'Ingeniería para construcción del muro cortafuego atendiendo la normatividad relacionada con el tema y los criterios de ingeniería NO048.',1,NULL,'2017-03-25 07:06:11',1,NULL),(260,'Indicación de proceso constructivo recomendado bajo la premisa de mantener los transformadores indisponibles el menor tiempo posible.',1,NULL,'2017-03-25 07:06:11',1,NULL),(261,'Dimensionamiento de los fosos colectores de aceite de acuerdo a los criterios de ingeniería NO048.',1,NULL,'2017-03-25 07:06:11',1,NULL),(262,'Indicar como se realizara la conexión entre los fosos y el tanque y/o trampa de aceite.',1,NULL,'2017-03-25 07:06:11',1,NULL),(263,'Definición de proceso constructivo teniendo en cuenta que se debe construir con el equipo en servicio.',1,NULL,'2017-03-25 07:06:11',1,NULL),(264,'Ingeniería mecánica de las rejillas.',1,NULL,'2017-03-25 07:06:11',1,NULL),(265,'Levantamiento topográfico del patio de la S/E incluyendo el sistema de drenaje de aguas lluvias, para determinar la ubicación optima de la trampa de aceite.',1,NULL,'2017-03-25 07:06:11',1,NULL),(266,'Ingeniería para construcción de la trampa de aceite de acuerdo a los criterios de ingeniería NO048.',1,NULL,'2017-03-25 07:06:11',1,NULL),(267,'Indicar como se realizara la conexión de la salida de agua a sumidero de aguas lluvias.',1,NULL,'2017-03-25 07:06:11',1,NULL),(268,'Levantamiento de la subestación para determinar la posible ubicación de las celdas provisionales, teniendo en cuenta la conectividad de los circuitos de media tensión a la instalación provisional.',1,NULL,'2017-03-25 07:06:11',1,NULL),(269,'Levantamiento de cárcamos y bancos de ductos existentes y disponibles, o rutas sobre piso para el tendido de cableado de control y potencia hacia las celdas provisionales.',1,NULL,'2017-03-25 07:06:11',1,NULL),(270,'Definición de ubicación de las celdas provisionales y diseño de elementos requeridos para la ubicación de las mismas dentro de la S/E.',1,NULL,'2017-03-25 07:06:11',1,NULL),(271,'Ingeniería para la conexión provisional entre el transformador y las celdas provisionales. Determinación de cantidad y calibre de cables para dicha conexión, determinar necesidad de utilizar estructura de cables y realizar el diseño de la misma (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:11',1,NULL),(272,'Definir la conexión a la malla de puesta a tierra de la instalación provisional.',1,NULL,'2017-03-25 07:06:11',1,NULL),(273,'Revisión de planos de fabrica de las celdas provisionales.',1,NULL,'2017-03-25 07:06:11',1,NULL),(274,'Levantamiento eléctrico de interconexiones con el modulo de AT del transformador.',1,NULL,'2017-03-25 07:06:11',1,NULL),(275,'Ingeniería eléctrica, elaboración de planos y listas de conexionado y desconexionado para la instalación de las celdas provisionales.',1,NULL,'2017-03-25 07:06:11',1,NULL),(276,'Levantamiento de la subestación para determinar la posible ubicación del transformador provisional, teniendo en cuenta la conectividad del equipo en potencia y control.',1,NULL,'2017-03-25 07:06:12',1,NULL),(277,'Levantamiento mecánico del transformador a utilizar.',1,NULL,'2017-03-25 07:06:12',1,NULL),(278,'Verificación de la estructura de salida de cables (donde aplique).',1,NULL,'2017-03-25 07:06:12',1,NULL),(279,'Definición de ubicación del transformador provisional, verificando distancias de seguridad a pórticos y equipos adyacentes.',1,NULL,'2017-03-25 07:06:12',1,NULL),(280,'Definición de ubicación del tablero regulador y GCP en caso de requerirse para conexiones provisionales.',1,NULL,'2017-03-25 07:06:12',1,NULL),(281,'Calculo de nueva estructura de salida de cables en caso de requerirse.',1,NULL,'2017-03-25 07:06:12',1,NULL),(282,'Ingeniería para la conexión provisional del transformador incluyendo: conexiones en potencia (calibre de conductores y conectores), conexiones de PaT, tuberías.',1,NULL,'2017-03-25 07:06:12',1,NULL),(283,'Levantamiento eléctrico de transformador provisional y tablero de regulación actual, así como las interfaces con los módulos asociados y los servicios auxiliares.',1,NULL,'2017-03-25 07:06:12',1,NULL),(284,'Ingeniería eléctrica, elaboración de planos y listas de conexionado y desconexionado para la instalación provisional.',1,NULL,'2017-03-25 07:06:12',1,NULL),(285,'Levantamiento eléctrico del modulo de línea tanto en patio como en sala de control',1,NULL,'2017-03-25 07:06:12',1,NULL),(286,'Elaboración de los planos eléctricos actualizados.',1,NULL,'2017-03-25 07:06:12',1,NULL),(287,'Levantamiento eléctrico del modulo de transformador tanto en patio como en sala de control',1,NULL,'2017-03-25 07:06:12',1,NULL),(288,'Levantamiento eléctrico del modulo de circuito tanto en patio como en sala de control',1,NULL,'2017-03-25 07:06:12',1,NULL),(289,'Elaboración de ingenierías básicas para nuevas subestaciones o remodelación de subestaciones existentes de hasta 8 bahías de línea/transformador.',1,NULL,'2017-03-25 07:06:12',1,NULL),(290,'Elaboración de ingenierías básicas para nuevos módulos de línea o transformador en subestaciones existentes o para el reemplazo de transformadores de potencia.',1,NULL,'2017-03-25 07:06:12',1,NULL),(291,'Ingeniería básica para ampliación o construcción de nuevas subestaciones',1,NULL,'2017-03-25 07:06:12',1,NULL),(292,'Ingeniería básica para cambio en el esquema de control y protección de una subestación existente',1,NULL,'2017-03-25 07:06:12',1,NULL),(293,'Ingeniería básica para relocalización de una subestación existente',1,NULL,'2017-03-25 07:06:12',1,NULL),(294,'Levantamientos para corrección de anomalías en control, protección o servicios auxiliares.',1,NULL,'2017-03-25 07:06:12',1,NULL),(295,'Elaboración de especificaciones técnicas',1,NULL,'2017-03-25 07:06:12',1,NULL),(296,'Calculo de cimentaciones especiales.',1,NULL,'2017-03-25 07:06:12',1,NULL),(297,'Estudios geotécnicos especializados.',1,NULL,'2017-03-25 07:06:12',1,NULL),(298,'Ejecutar los tramites requeridos frente a Curaduría o la entidad competente (en el caso de municipios) para obtener la licencia de construcción, demolición y/o modificación de una nueva subestación o subestación existente. No se incluye el costo del impuesto de delineación urbana el cual será cancelado directamente por la EEC.',1,NULL,'2017-03-25 07:06:12',1,NULL),(299,'Ejecución del estudio de suelos en el terreno indicado. Si se requieren ejecutar mas de los 3 sondeos se reconocerá un 20% del valor del baremo por sondeo adicional, previa autorización de la EEC.',1,NULL,'2017-03-25 07:06:12',1,NULL),(300,'Inspección de las obras civiles que ejecuta la EEC. Comprende todas las actividades necesarias para verificar que la ingeniería civil y demás documentación asociada aprobada por la EEC sea aplicada correctamente en obra.',1,NULL,'2017-03-25 07:06:12',1,NULL),(301,'Inspección de las obras eléctricas y mecánicas que ejecuta la EEC. Comprende todas las actividades necesarias para verificar que la ingeniería eléctrica, mecánica y demás documentación asociada aprobada por la EEC sea aplicada correctamente en obra.',1,NULL,'2017-03-25 07:06:12',1,NULL),(302,'Realizar el calculo de la malla de puesta a tierra teniendo en cuenta la norma IEEE 80.',1,NULL,'2017-03-25 07:06:12',1,NULL),(303,'Medida de la resistividad del terreno en el área indicada.',1,NULL,'2017-03-25 07:06:12',1,NULL),(304,'Levantamiento topográfico de lote o subestación incluyendo todos los elementos incluidos en la misma.',1,NULL,'2017-03-25 07:06:12',1,NULL),(305,'Georreferenciacion del lote.',1,NULL,'2017-03-25 07:06:12',1,NULL),(306,'Realizar el levantamiento de la zona a apantallar.',1,NULL,'2017-03-25 07:06:12',1,NULL),(307,'Realizar el estudio del sistema de apantallamiento de la subestación incluyendo tanto el patio de la subestación como las edificaciones en el interior de la misma.',1,NULL,'2017-03-25 07:06:12',1,NULL),(308,'Realizar el levantamiento de la zona a intervenir.',1,NULL,'2017-03-25 07:06:12',1,NULL),(309,'Realizar el estudio de iluminación para definir la ubicación, cantidad y tipo de luminarias a instalar en el patio de la subestación y demás zonas exteriores.',1,NULL,'2017-03-25 07:06:12',1,NULL),(310,'Ingeniería para construcción de banco de ductos o cárcamos para el tendido del cableado de fuerza desde el tablero de AC hasta las luminarias.',1,NULL,'2017-03-25 07:06:12',1,NULL),(311,'Definir el punto de alimentación del alumbrado y recorrido de cables de fuerza.',1,NULL,'2017-03-25 07:06:12',1,NULL),(312,'Realizar el levantamiento topográfico del lote al cual se le realizara el cerramiento.',1,NULL,'2017-03-25 07:06:12',1,NULL),(313,'En caso de existir un cerramiento hacer el levantamiento del mismo.',1,NULL,'2017-03-25 07:06:12',1,NULL),(314,'Realizar la ingeniería completa del muro de cerramiento, teniendo en cuenta lineamientos como ubicación del predio, requerimientos especiales (para predios en zonas de conservación), altura requerida, etc.',1,NULL,'2017-03-25 07:06:12',1,NULL),(315,'Indicar la ubicación de las puertas de acceso a la subestación (vehiculares y peatonales).',1,NULL,'2017-03-25 07:06:12',1,NULL),(316,'Indicar puntos de conexión a malla de puesta a tierra.',1,NULL,'2017-03-25 07:06:12',1,NULL),(317,'Realizar el levantamiento topográfico para determinar la ubicación de la casa de control.',1,NULL,'2017-03-25 07:06:12',1,NULL),(318,'Ingeniería civil y arquitectónico de la casa.',1,NULL,'2017-03-25 07:06:13',1,NULL),(319,'Cálculos estructurales.',1,NULL,'2017-03-25 07:06:13',1,NULL),(320,'Iluminación interior (ventanerias e iluminación artificial)',1,NULL,'2017-03-25 07:06:13',1,NULL),(321,'Ventilación natural y artificial (en caso de ser requerido, diseño para instalación de aire acondicionado)',1,NULL,'2017-03-25 07:06:13',1,NULL),(322,'Disposición de equipos en el interior de la casa.',1,NULL,'2017-03-25 07:06:13',1,NULL),(323,'Cárcamos interiores y comunicación con los cárcamos existentes en el patio de la S/E.',1,NULL,'2017-03-25 07:06:13',1,NULL),(324,'Sistema de drenaje de aguas lluvias.',1,NULL,'2017-03-25 07:06:13',1,NULL),(325,'Instalaciones eléctricas internas.',1,NULL,'2017-03-25 07:06:13',1,NULL),(326,'Anden perimetral',1,NULL,'2017-03-25 07:06:13',1,NULL),(327,'Sistema de apantallamiento para la casa de control.',1,NULL,'2017-03-25 07:06:13',1,NULL),(328,'Realizar el levantamiento topográfico para determinar la ubicación de la caseta de vigilancia.',1,NULL,'2017-03-25 07:06:13',1,NULL),(329,'Ventilación natural y artificial',1,NULL,'2017-03-25 07:06:13',1,NULL),(330,'Baterías sanitarias',1,NULL,'2017-03-25 07:06:13',1,NULL),(331,'Sistema de apantallamiento.',1,NULL,'2017-03-25 07:06:13',1,NULL),(332,'Realizar la ingeniería completo de la casa de control de acuerdo con los criterios de ingeniería NO047 y NO048 incluyendo:',1,NULL,'2017-03-25 07:06:13',1,NULL),(333,'Disposición de equipos en el interior de la casa: celdas de media tensión, equipos de control y protección, etc)',1,NULL,'2017-03-25 07:06:13',1,NULL),(334,'Cárcamos interiores y comunicación con los cárcamos existentes en la S/E.',1,NULL,'2017-03-25 07:06:13',1,NULL),(335,'Semisótano',1,NULL,'2017-03-25 07:06:13',1,NULL),(336,'Cuarto de baterías (cumpliendo con los requerimientos de normalización)',1,NULL,'2017-03-25 07:06:13',1,NULL),(337,'Realizar el levantamiento topográfico para determinar la ubicación de las vías en el interior de la S/E.',1,NULL,'2017-03-25 07:06:13',1,NULL),(338,'Realizar la ingeniería completa de las vías de circulación vehicular teniendo en cuenta que permitan el acceso de vehículos pesados para labores de mantenimiento y obras en el patio de la S/E.',1,NULL,'2017-03-25 07:06:13',1,NULL),(339,'Contemplar los espacios para estacionamiento de vehículos y descarga de equipos pesados.',1,NULL,'2017-03-25 07:06:13',1,NULL),(340,'Realizar el levantamiento topográfico para determinar la ubicación del sistema de carrileras.',1,NULL,'2017-03-25 07:06:13',1,NULL),(341,'Realizar el diseño completo del sistema de carrilera que permita el descargue y desplazamiento de los mismos desde la plataforma de descarga hasta la ubicación final de los mismos.',1,NULL,'2017-03-25 07:06:13',1,NULL),(342,'Diseñar la plataforma de descarga que permita la ubicación temporal de un transformador.',1,NULL,'2017-03-25 07:06:13',1,NULL),(343,'Realizar el levantamiento topográfico para determinar la ubicación de los drenajes y cajas de inspección.',1,NULL,'2017-03-25 07:06:13',1,NULL),(344,'Determinar los puntos de conexión con el sistema de alcantarillado en el exterior de la S/E.',1,NULL,'2017-03-25 07:06:13',1,NULL),(345,'Definir si se requiere la construcción de pozo séptico.',1,NULL,'2017-03-25 07:06:13',1,NULL),(346,'Realizar la ingeniería completa del sistema de suministro y distribución de agua, drenajes y alcantarillado en el interior de la S/E, incluyendo detalles de ruta de tuberías, filtros (si aplica), cajas de inspección, sumideros y demás ítems que apliquen.',1,NULL,'2017-03-25 07:06:13',1,NULL),(347,'Si es requerido, incluir la motobomba para drenaje de aguas lluvias.',1,NULL,'2017-03-25 07:06:13',1,NULL),(348,'Realizar la revisión de planos del fabricante donde indiquen esfuerzos en condición normal y de cortocircuito.',1,NULL,'2017-03-25 07:06:13',1,NULL),(349,'Realizar el calculo normalizado de la cimentación para el equipo indicado.',1,NULL,'2017-03-25 07:06:13',1,NULL),(350,'Levantamiento topográfico del sitio de ubicación del nuevo modulo dentro de la S/E.',1,NULL,'2017-03-25 07:06:13',1,NULL),(351,'Verificación de disponibilidad de cárcamos de control y potencia en patio y sala de control.',1,NULL,'2017-03-25 07:06:13',1,NULL),(352,'Verificación de espacio en casa de control para instalación de los tableros de control y protección del nuevo modulo.',1,NULL,'2017-03-25 07:06:13',1,NULL),(353,'Adaptar las cimentaciones normalizadas de los nuevos equipos de potencia.',1,NULL,'2017-03-25 07:06:13',1,NULL),(354,'Ampliación y/o construcción de la malla de puesta a tierra (en caso de ser requerido)',1,NULL,'2017-03-25 07:06:13',1,NULL),(355,'Ingeniería para construcción de los nuevos cárcamos de control y/o potencia en patio y sala de control (en caso de ser requerido)',1,NULL,'2017-03-25 07:06:13',1,NULL),(356,'Ingeniería para construcción de las obras civiles requeridas para instalación de tablero de control y protección (en caso de ser requerido)',1,NULL,'2017-03-25 07:06:13',1,NULL),(357,'Verificación de cumplimiento de distancias de seguridad, eléctricas y de mantenimiento al piso, estructuras de pórtico y equipos adyacentes, con las normas vigentes (en especial el RETIE).',1,NULL,'2017-03-25 07:06:13',1,NULL),(358,'Verificación del espacio disponible en sala de control para ubicación del tablero de control y protección.',1,NULL,'2017-03-25 07:06:13',1,NULL),(359,'Verificación de disponibilidad de barraje para conexión del nuevo modulo.',1,NULL,'2017-03-25 07:06:14',1,NULL),(360,'Determinación del calibre actual del barraje.',1,NULL,'2017-03-25 07:06:14',1,NULL),(361,'Disposición de los equipos con sus conexiones en potencia (especificando calibre, tipo de cable y conectores requeridos).',1,NULL,'2017-03-25 07:06:14',1,NULL),(362,'Disposición de tuberías desde los equipos hacia los cárcamos.',1,NULL,'2017-03-25 07:06:14',1,NULL),(363,'Conexiones de puesta a tierra.',1,NULL,'2017-03-25 07:06:14',1,NULL),(364,'Calculo e ingeniería de apantallamiento para el nuevo modulo, especificando distancia, cables y herrajes y conexión al sistema existente (en caso que aplique).',1,NULL,'2017-03-25 07:06:14',1,NULL),(365,'Disposición de tableros en la casa de control y de los equipos dentro del tablero',1,NULL,'2017-03-25 07:06:14',1,NULL),(366,'Elaboración de planos detallados de la estructura metálica requerida',1,NULL,'2017-03-25 07:06:14',1,NULL),(367,'Determinar los aspectos a tener en cuenta para la instalación de los nuevos equipos (acceso de maquinaria pesada, distancia a equipos energizados, delimitación de la zona de trabajo, etc.).',1,NULL,'2017-03-25 07:06:14',1,NULL),(368,'Ingeniería del esquema de control y protección del modulo y del banco de compensación, contemplando las interfaces con los módulos de la S/E y con los esquemas de protección existentes (protección diferencial de barra, esquema 50 BF, esquema de seccionamiento, equipo registrador de fallas, relé de mando sincronizado), bajo los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:14',1,NULL),(369,'Ingeniería eléctrica completa para construcción del modulo de acuerdo con los criterios de ingeniería NO047 vigentes.',1,NULL,'2017-03-25 07:06:14',1,NULL),(370,'Calculo de conductores de acuerdo con la capacidad amperimetrica y cargabilidad de transformadores de instrumentación.',1,NULL,'2017-03-25 07:06:14',1,NULL),(371,'Calculo y selección de conductores de potencia.',1,NULL,'2017-03-25 07:06:14',1,NULL),(372,'Elaboración de manual de operación de la nueva instalación.',1,NULL,'2017-03-25 07:06:14',1,NULL),(373,'Integración al sistema de detección de incendios existente',1,NULL,'2017-03-25 07:06:14',1,NULL),(374,'Definición de rutas de cable de comunicaciones para los servicios de telecontrol y gestión de protecciones.',1,NULL,'2017-03-25 07:06:14',1,NULL),(375,'Recomendaciones sobre el proceso constructivo.',1,NULL,'2017-03-25 07:06:14',1,NULL),(376,'Calculo y estudio de apantallamiento para el nuevo modulo, especificando distancia, cables y herrajes y conexión al sistema existente (en caso que aplique).',1,NULL,'2017-03-25 07:06:14',1,NULL),(377,'Elaboración de planos detallados de la estructura metálica requerida.',1,NULL,'2017-03-25 07:06:14',1,NULL),(378,'Verificación de las características eléctricas de los equipos a instalar en el modulo.',1,NULL,'2017-03-25 07:06:14',1,NULL),(379,'Validación de disponibilidad de MCBs en los tableros de AC y DC existentes.',1,NULL,'2017-03-25 07:06:14',1,NULL),(380,'Verificación de interfaces requeridas con otros módulos o con la protección 87B.',1,NULL,'2017-03-25 07:06:14',1,NULL),(381,'Validación del esquema de telecontrol existente en la S/E.',1,NULL,'2017-03-25 07:06:14',1,NULL),(382,'Verificación del sistema de detección de incendios existente en la S/E.',1,NULL,'2017-03-25 07:06:14',1,NULL),(383,'Verificación de disponibilidad de barraje para conexión del nuevo modulo. Determinación del calibre actual del barraje.',1,NULL,'2017-03-25 07:06:14',1,NULL),(384,'Ingeniería civil de las bases de equipos de potencia en patio.',1,NULL,'2017-03-25 07:06:14',1,NULL),(385,'Ingeniería del esquema de control y protección del modulo contemplando las interfaces con los módulos existentes en la S/E y con los esquemas de protección existentes (protección diferencial de barra, esquema 50 BF, esquema de seccionamiento, tele protección), bajo los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:14',1,NULL),(386,'Integración al sistema de detección de incendios existente.',1,NULL,'2017-03-25 07:06:14',1,NULL),(387,'Calculo y diseño de apantallamiento para el nuevo modulo, especificando distancia, cables y herrajes y conexión al sistema existente (en caso que aplique).',1,NULL,'2017-03-25 07:06:14',1,NULL),(388,'Verificación de disponibilidad de cárcamos de control en patio y sala de control.',1,NULL,'2017-03-25 07:06:14',1,NULL),(389,'Ingeniería para construcción de los nuevos cárcamos de control en patio y sala de control (en caso de ser requerido)',1,NULL,'2017-03-25 07:06:14',1,NULL),(390,'Ingeniería eléctrica completo para construcción del modulo de acuerdo con los criterios de ingeniería NO047 vigentes.',1,NULL,'2017-03-25 07:06:14',1,NULL),(391,'Levantamiento topográfico de la S/E, detallando el/los barraje(s) y pórticos existente(s) y el espacio disponible para la ampliación.',1,NULL,'2017-03-25 07:06:14',1,NULL),(392,'Ingeniería civil de las bases de pórticos requeridas para la ampliación de la barra.',1,NULL,'2017-03-25 07:06:14',1,NULL),(393,'Adecuación del terreno en caso de ser necesario para que sea apto para las fundaciones de los nuevos pórticos.',1,NULL,'2017-03-25 07:06:14',1,NULL),(394,'Levantamiento mecánico detallado de la estructura metálica de pórticos existentes.',1,NULL,'2017-03-25 07:06:14',1,NULL),(395,'Validación de alternativas de conexión a la barra existente.',1,NULL,'2017-03-25 07:06:14',1,NULL),(396,'Verificación de las características actuales de la barra (cable, tubo), con detalles de calibres y/o diámetro y cantidad de cables y/o tubos por fase.',1,NULL,'2017-03-25 07:06:14',1,NULL),(397,'Ingeniería mecánica detallado que incluya: vista en planta y perfil de la barra con la ampliación propuesta (especificando calibre, tipo de cable y herrajes).',1,NULL,'2017-03-25 07:06:15',1,NULL),(398,'Conexiones de puesta a tierra de la nueva estructura.',1,NULL,'2017-03-25 07:06:15',1,NULL),(399,'Calculo y estudio de apantallamiento para la ampliación del barraje, especificando distancia, cables y herrajes y conexión al sistema existente (en caso que aplique).',1,NULL,'2017-03-25 07:06:15',1,NULL),(400,'Ingeniería mecánica de las columnas y vigas que se requieran para la ampliación del pórtico y la barra (con las respectivas memorias de calculo).',1,NULL,'2017-03-25 07:06:15',1,NULL),(401,'Proceso constructivo recomendado',1,NULL,'2017-03-25 07:06:15',1,NULL),(402,'Levantamiento topográfico del lugar de ubicación del nuevo transformador de potencia.',1,NULL,'2017-03-25 07:06:15',1,NULL),(403,'Levantamiento de cárcamos de control y potencia existentes para comunicación con la casa de control para verificar necesidades de ampliación.',1,NULL,'2017-03-25 07:06:15',1,NULL),(404,'Ingeniería para construcción de las carrileras y cimentación del transformador incluyendo foso de aceite y conexión a tanque de aceite.',1,NULL,'2017-03-25 07:06:15',1,NULL),(405,'Ingeniería para construcción de cimentaciones para columnas del barraje auxiliar (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:15',1,NULL),(406,'Ingeniería para construcción de obras civiles requeridas para instalación del nuevo tablero de regulación en sala de control y/o patio.',1,NULL,'2017-03-25 07:06:15',1,NULL),(407,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de control desde el patio hacia la sala de control.',1,NULL,'2017-03-25 07:06:15',1,NULL),(408,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de potencia desde el transformador hacia las celdas de MT (en caso que sea necesario).',1,NULL,'2017-03-25 07:06:15',1,NULL),(409,'Verificación de distancias de seguridad a pórticos y muros.',1,NULL,'2017-03-25 07:06:15',1,NULL),(410,'Validación de la conexión en potencia por el lado de AT del transformador. Verificar si es necesaria la construcción de un barraje auxiliar.',1,NULL,'2017-03-25 07:06:15',1,NULL),(411,'Ingeniería mecánica completa para instalación de nuevo transformador incluyendo: conexiones de PAT, conexiones de neutro, conexiones en potencia por AT y MT (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:15',1,NULL),(412,'Disposición de tuberías para el cableado de control.',1,NULL,'2017-03-25 07:06:15',1,NULL),(413,'Ingeniería para construcción de barraje auxiliar para conexión por AT en caso de ser necesario.',1,NULL,'2017-03-25 07:06:15',1,NULL),(414,'Calculo y estudio de apantallamiento para el nuevo transformador y barraje auxiliar (cuando aplique), especificando distancia, cables y herrajes y conexión al sistema existente.',1,NULL,'2017-03-25 07:06:15',1,NULL),(415,'Ubicación del tablero de regulación del nuevo transformador a instalar.',1,NULL,'2017-03-25 07:06:15',1,NULL),(416,'Ingeniería mecánica de las rejillas para el foso de aceite.',1,NULL,'2017-03-25 07:06:15',1,NULL),(417,'Determinar los aspectos a tener en cuenta para la instalación del nuevo equipo (acceso de maquinaria pesada, distancia a equipos energizados, delimitación de la zona de trabajo, etc.).',1,NULL,'2017-03-25 07:06:15',1,NULL),(418,'Verificación de MCBs disponibles en tableros de AC y DC para alimentación del gabinete de control local del transformador, gabinete del cambiador de tomas y el tablero de regulación.',1,NULL,'2017-03-25 07:06:15',1,NULL),(419,'Verificación de interfaces con el tablero de control y protección del modulo de transformador.',1,NULL,'2017-03-25 07:06:15',1,NULL),(420,'Ingeniería del tablero de regulación y control de ventiladores.',1,NULL,'2017-03-25 07:06:15',1,NULL),(421,'Indicar las conexiones entre el tablero de regulación y el transformador.',1,NULL,'2017-03-25 07:06:15',1,NULL),(422,'Ingeniería eléctrica para conexión del nuevo transformador y su integración al tablero de control y protección del modulo incluyendo las señales a centro de control.',1,NULL,'2017-03-25 07:06:15',1,NULL),(423,'Levantamiento topográfico del lugar de ubicación del nuevo banco de transformación.',1,NULL,'2017-03-25 07:06:15',1,NULL),(424,'Levantamiento de cárcamos de control existentes para comunicación entre las unidades y la casa de control para verificar necesidades de ampliación.',1,NULL,'2017-03-25 07:06:15',1,NULL),(425,'Ingeniería para construcción de las carrileras y cimentación de las unidades de transformación incluyendo fosos de aceite y conexión a tanque de aceite.',1,NULL,'2017-03-25 07:06:15',1,NULL),(426,'Ingeniería para construcción de los muros cortafuegos requeridos entre las unidades de transformación.',1,NULL,'2017-03-25 07:06:15',1,NULL),(427,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de potencia para la conformación de la delta del terciario (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:15',1,NULL),(428,'Validación de la conexión en potencia del banco de transformadores. Verificar si es necesaria la construcción de un barraje auxiliar.',1,NULL,'2017-03-25 07:06:15',1,NULL),(429,'Ingeniería mecánica completa para instalación del nuevo banco de transformación incluyendo: conexiones de PAT, conexiones de neutro, conexiones en potencia (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:15',1,NULL),(430,'Ingeniería para construcción de barraje auxiliar para conexión en potencia en caso de ser necesario.',1,NULL,'2017-03-25 07:06:15',1,NULL),(431,'Calculo y estudio de apantallamiento para el nuevo banco de transformación y barraje auxiliar (cuando aplique), especificando distancia, cables y herrajes y conexión al sistema existente.',1,NULL,'2017-03-25 07:06:15',1,NULL),(432,'Ubicación del tablero de regulación del nuevo banco de transformación a instalar.',1,NULL,'2017-03-25 07:06:15',1,NULL),(433,'Ingeniería mecánica de las rejillas para los fosos de aceite.',1,NULL,'2017-03-25 07:06:15',1,NULL),(434,'Verificación de MCBs disponibles en tableros de AC y DC para alimentación del gabinete de control local de las unidades de transformación, gabinetes del cambiador de tomas y el tablero de regulación.',1,NULL,'2017-03-25 07:06:16',1,NULL),(435,'Ingeniería de conexiones entre el tablero de regulación y las unidades de transformación.',1,NULL,'2017-03-25 07:06:16',1,NULL),(436,'Ingeniería eléctrica para conexión del nuevo banco de transformación y su integración al tablero de control y protección del modulo incluyendo las señales a centro de control.',1,NULL,'2017-03-25 07:06:16',1,NULL),(437,'Levantamiento topográfico del lugar de ubicación del nuevo transformador.',1,NULL,'2017-03-25 07:06:16',1,NULL),(438,'Levantamiento de cárcamos de control existentes para comunicación entre el transformador y la casa de control para verificar necesidades de ampliación.',1,NULL,'2017-03-25 07:06:16',1,NULL),(439,'Validación de la conexión en potencia del transformador. Verificar si es necesaria la construcción de un barraje auxiliar.',1,NULL,'2017-03-25 07:06:16',1,NULL),(440,'Ingeniería mecánica completo para instalación del nuevo transformador incluyendo: conexiones de PAT, conexiones de neutro, conexiones en potencia (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:06:16',1,NULL),(441,'Verificación de MCBs disponibles en tableros de AC y DC para alimentación del gabinete de control local del transformador, gabinetes del cambiador de tomas y el tablero de regulación.',1,NULL,'2017-03-25 07:06:16',1,NULL),(442,'Ingeniería para conexiones entre el tablero de regulación y el transformador',1,NULL,'2017-03-25 07:06:16',1,NULL),(443,'Ingeniería para construcción de las carrileras y cimentación de todas las unidades de transformación incluyendo fosos de aceite y conexión a tanque de aceite.',1,NULL,'2017-03-25 07:06:16',1,NULL),(444,'Ingeniería para construcción de las bases para las celdas y tablero asociados al cambio rápido,',1,NULL,'2017-03-25 07:06:16',1,NULL),(445,'Ingeniería de barraje auxiliar para conexión de cambio rápido en los tres devanados.',1,NULL,'2017-03-25 07:06:16',1,NULL),(446,'Indicar las conexiones entre el tablero de regulación y las unidades de transformación.',1,NULL,'2017-03-25 07:06:16',1,NULL),(447,'Diseño del tablero de control para cambio rápido',1,NULL,'2017-03-25 07:06:16',1,NULL),(448,'Levantamiento de cárcamos de control y potencia existentes para las interfaces con otros módulos.',1,NULL,'2017-03-25 07:06:16',1,NULL),(449,'Ingeniería para construcción de las carrileras y cimentación del transformador incluyendo foso de aceite y conexión a tanque de aceite y/o trampa de aceite.',1,NULL,'2017-03-25 07:06:16',1,NULL),(450,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de control desde el transformador hacia sus módulos asociados en AT y MT.',1,NULL,'2017-03-25 07:06:16',1,NULL),(451,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de potencia desde el transformador hacia el barraje de MT (en caso que sea necesario).',1,NULL,'2017-03-25 07:06:16',1,NULL),(452,'Ingeniería de barraje auxiliar para conexión por AT en caso de ser necesario.',1,NULL,'2017-03-25 07:06:16',1,NULL),(453,'Indicar como se realiza de la conexión al barraje de MT incluyendo calibres de cables y conectores.',1,NULL,'2017-03-25 07:06:16',1,NULL),(454,'Validación de la necesidad de MCBs de AC y DC para alimentación del control del transformador.',1,NULL,'2017-03-25 07:06:16',1,NULL),(455,'Verificación de interfaces con sus módulos asociados en AT y MT.',1,NULL,'2017-03-25 07:06:16',1,NULL),(456,'Ingeniería eléctrica para conexión del nuevo transformador y su integración a los módulos existentes.',1,NULL,'2017-03-25 07:06:16',1,NULL),(457,'Levantamiento topográfico del sitio de ubicación del nuevo banco de compensación capacitiva (Bobina, Condensadores, CTs de desbalance) y su modulo de conexión al barraje.',1,NULL,'2017-03-25 07:06:16',1,NULL),(458,'Verificación de disponibilidad de cárcamos de control.',1,NULL,'2017-03-25 07:06:16',1,NULL),(459,'Verificar necesidad de ejecutar obras civiles en casa de control para instalación de los tableros de control y protección.',1,NULL,'2017-03-25 07:06:16',1,NULL),(460,'Ingeniería civil de las bases de equipos de potencia del banco y su modulo de conexión.',1,NULL,'2017-03-25 07:06:16',1,NULL),(461,'Ampliación y/o construcción de la malla de puesta a tierra.',1,NULL,'2017-03-25 07:06:16',1,NULL),(462,'Indicar las obras requeridas para la ubicación del tablero en sala de control.',1,NULL,'2017-03-25 07:06:16',1,NULL),(463,'En caso de requerirse, realizar la ingeniería para construcción de los nuevos cárcamos.',1,NULL,'2017-03-25 07:06:16',1,NULL),(464,'Verificación de las características eléctricas de los equipos a instalar en el modulo incluyendo los elementos del banco de compensación.',1,NULL,'2017-03-25 07:06:16',1,NULL),(465,'Definición de rutas de cable de comunicaciones para los servicios de telecontrol y gestión de protecciones',1,NULL,'2017-03-25 07:06:16',1,NULL),(466,'Ingeniería para construcción de las obras requeridas para la ubicación del tablero en sala de control.',1,NULL,'2017-03-25 07:06:16',1,NULL),(467,'Verificación de disponibilidad de cárcamos de control y potencia.',1,NULL,'2017-03-25 07:06:16',1,NULL),(468,'Verificación de espacio disponible en casa de control para instalación del tablero de control y protección.',1,NULL,'2017-03-25 07:06:17',1,NULL),(469,'Verificación de ducteria existente para salida del circuito en caso de ser subterráneo',1,NULL,'2017-03-25 07:06:17',1,NULL),(470,'Adaptar los diseños de cimentaciones normalizadas de los nuevos equipos de potencia.',1,NULL,'2017-03-25 07:06:17',1,NULL),(471,'Ingeniería para construcción de los nuevos cárcamos de control en patio y sala de control (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:17',1,NULL),(472,'Ingeniería para construcción de nuevo banco de ductos para salida del circuito con sus cajas de inspección (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:17',1,NULL),(473,'Verificar distancias de seguridad, eléctricas y de mantenimiento al piso, estructuras de pórtico y equipos adyacentes, con las normas vigentes (en especial el RETIE).',1,NULL,'2017-03-25 07:06:17',1,NULL),(474,'Verificación de disponibilidad de pórticos y determinación del calibre de la barra actual.',1,NULL,'2017-03-25 07:06:17',1,NULL),(475,'Disposición de los equipos en patio, conexiones en potencia (especificando calibre, tipo de cable y conectores)',1,NULL,'2017-03-25 07:06:17',1,NULL),(476,'Disposición de tuberías desde equipos hacia cárcamos.',1,NULL,'2017-03-25 07:06:17',1,NULL),(477,'Disposición de tableros en casa de control.',1,NULL,'2017-03-25 07:06:17',1,NULL),(478,'Verificación de interfaces requeridas con otros módulos.',1,NULL,'2017-03-25 07:06:17',1,NULL),(479,'Ingeniería del esquema de control y protección del modulo contemplando las interfaces con los módulos existentes en la S/E y con los esquemas de protección existentes (esquema 50 BF), bajo los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:17',1,NULL),(480,'Ingeniería eléctrica completa para construcción del modulo bajo los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:06:17',1,NULL),(481,'Calculo de conductores de acuerdo a capacidad amperimetrica y cargabilidad de transformadores de instrumentación.',1,NULL,'2017-03-25 07:06:17',1,NULL),(482,'Verificación de disponibilidad de cárcamos de control y/o potencia.',1,NULL,'2017-03-25 07:06:17',1,NULL),(483,'Verificación de distancias de seguridad, eléctricas y de mantenimiento al piso, estructuras de pórtico y equipos adyacentes, con las normas vigentes (en especial el RETIE).',1,NULL,'2017-03-25 07:06:17',1,NULL),(484,'Verificación de disponibilidad de pórticos y vigas, verificación de esfuerzos mecánicos para determinar necesidad de refuerzos en la estructura existente y/o ampliaciones.',1,NULL,'2017-03-25 07:06:17',1,NULL),(485,'Verificación del calibre de la barra actual.',1,NULL,'2017-03-25 07:06:17',1,NULL),(486,'Dimensionamiento de nuevas vigas y soportes de instalación de equipos (en caso de ser necesario).',1,NULL,'2017-03-25 07:06:17',1,NULL),(487,'Ingeniería para construcción de nuevos cárcamos de control y/o potencia en caso de ser requerido.',1,NULL,'2017-03-25 07:06:18',1,NULL),(488,'Disposición de equipos en planta y perfil con las conexiones en potencia (especificando calibre, tipo de cable y conectores)',1,NULL,'2017-03-25 07:06:18',1,NULL),(489,'Disposición de tuberías para conexionado de control de los equipos.',1,NULL,'2017-03-25 07:06:18',1,NULL),(490,'Ingeniería mecánica detallada que incluya: vista en planta y perfil de la barra con la ampliación propuesta (especificando calibre, tipo de cable y herrajes).',1,NULL,'2017-03-25 07:06:18',1,NULL),(491,'Ingeniería mecánicas de las columnas y vigas que se requieran para la ampliación del pórtico y la barra (con las respectivas memorias de calculo).',1,NULL,'2017-03-25 07:06:18',1,NULL),(492,'Ingeniería para construcción de los nuevos cárcamos de control y/o potencia en patio y sala de control (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:18',1,NULL),(493,'Detalles de la conexión a las barras (cable desnudo o cable aislado), especificar calibres y estructuras adicionales en caso de ser requerido.',1,NULL,'2017-03-25 07:06:18',1,NULL),(494,'Levantamiento de la sala de control indicando la ubicación propuesta para el nuevo tren de celdas. En el caso de ser celdas tipo exterior, levantamiento del lugar de instalación propuesto para las nuevas celdas.',1,NULL,'2017-03-25 07:06:18',1,NULL),(495,'Verificación de disponibilidad de cárcamos de control y protección para interconexiones con el modulo de transformador en el lado de AT.',1,NULL,'2017-03-25 07:06:18',1,NULL),(496,'Verificación de disponibilidad de cárcamos de potencia y bancos de ductos para la conexión entre transformador y celda de entrada, salida de circuitos y acoples en cable entre trenes de celdas cuando sea requerido.',1,NULL,'2017-03-25 07:06:18',1,NULL),(497,'Validación de las opciones de conexión en potencia entre el transformador y la celda de entrada: electroductos o bajante de cables.',1,NULL,'2017-03-25 07:06:18',1,NULL),(498,'Ingeniería para construcción de obras civiles requeridas para la instalación del nuevo tren incluyendo: nivelación de piso, extensiones y /o construcción de cárcamo de potencia y cárcamo de control.',1,NULL,'2017-03-25 07:06:18',1,NULL),(499,'Indicar el uso de bandejas portacables para cableado de control y potencia en donde sea requerido.',1,NULL,'2017-03-25 07:06:18',1,NULL),(500,'Ingeniería civil para el anclaje de la estructura bajante de cables del transformador (en caso de ser requerido)',1,NULL,'2017-03-25 07:06:18',1,NULL),(501,'Disposición mecánica de las celdas incluyendo conexiones de puesta a tierra e interfaces con las celdas existentes (en donde aplique).',1,NULL,'2017-03-25 07:06:18',1,NULL),(502,'Disposición mecánica de los equipos adicionales de medida, control y protección que sean requeridos.',1,NULL,'2017-03-25 07:06:18',1,NULL),(503,'Ingeniería mecánica de la nueva estructura de salida de cables del transformador incluyendo planos para fabricación de la misma y elementos de conexión (conectores y cables), en los casos que aplique.',1,NULL,'2017-03-25 07:06:18',1,NULL),(504,'Ingeniería para construcción de bancos de ductos y cajas de inspección para salidas de circuitos de MT según normas construcción CODENSA.',1,NULL,'2017-03-25 07:06:18',1,NULL),(505,'Ingeniería para construcción de bancos de ductos y/o cárcamo de potencia para las conexiones en potencia requeridas (conexión entre el transformador y la(s) celda(s) de entrada, conexión entre celdas de acople, etc)',1,NULL,'2017-03-25 07:06:18',1,NULL),(506,'Verificación de las ingenierías básica y de detalle de las celdas suministradas por el fabricante.',1,NULL,'2017-03-25 07:06:18',1,NULL),(507,'Levantamiento de interfaces con el modulo de transformación por el lado de 115 kV y con trenes de celdas existentes en el caso que aplique.',1,NULL,'2017-03-25 07:06:18',1,NULL),(508,'Verificación de disponibilidad de MCBs de AC y DC para alimentación de las nuevas celdas.',1,NULL,'2017-03-25 07:06:18',1,NULL),(509,'Verificación del esquema de telecontrol existente en la S/E.',1,NULL,'2017-03-25 07:06:18',1,NULL),(510,'Calculo de la capacidad y cantidad de cables de potencia requeridos para la conexión desde el transformador a las celdas de entrada.',1,NULL,'2017-03-25 07:06:18',1,NULL),(511,'Ingeniería eléctrica de interconexiones entre celdas, conexiones con trenes existentes, señales a centro de control y conexiones con el modulo de transformador en el lado de AT.',1,NULL,'2017-03-25 07:06:18',1,NULL),(512,'Implementación de los equipos requeridos de función de medida, control y protección adicionales al relé propio de la celda.',1,NULL,'2017-03-25 07:06:18',1,NULL),(513,'Indicar las rutas de bandejas portacables para cableado de control y potencia en donde sea requerido.',1,NULL,'2017-03-25 07:06:18',1,NULL),(514,'Indicación de disposición de tuberías para conexionado de control de los equipos.',1,NULL,'2017-03-25 07:06:19',1,NULL),(515,'Diseño de nuevo banco de ductos para salida del circuito con sus cajas de inspección (en caso de ser requerido).',1,NULL,'2017-03-25 07:06:19',1,NULL),(516,'Verificación de las características eléctricas de los equipos a instalar en el modulo (reconectador, cuchillas monopolares, CTs y pararrayos).',1,NULL,'2017-03-25 07:06:19',1,NULL),(517,'Aplica cuando se requiere de una cimentación no convencional (pilotes o plateas) por las condiciones del terreno y el tipo de estructura a instalar. Comprende la entrega de un informe con la memoria detallada de los cálculos realizados y la metodología utilizada, las observaciones, las recomendaciones respectivas y los planos de detalle para construcción con cantidades de materiales y las dimensiones.',1,NULL,'2017-03-25 07:06:19',1,NULL),(518,'Comprende las actividades de amarre a coordenadas cartesianas del IGAC y toma de datos necesarios con distanciometro o GPS, con la presentación de las carteras topográficas del perfil terreno sobre el eje de la línea incluyendo los detalles de cruces con vías de todo tipo, puentes, construcciones, cauces fluviales, redes, luminarias, arboles, linderos, así como el inventario de propietarios, proyectos de desarrollo futuros. Esta actividad debe ser realizada tomando los datos sobre toda la zona d',1,NULL,'2017-03-25 07:06:19',1,NULL),(519,'Comprende la localización de los sitios de las estructuras, la marcación de las cotas y áreas de excavaciones. Incluye la verificación posterior de distancias eléctricas de seguridad en caso de requerirse y la presentación de informe con planos sobre los cambios realizados en cuanto a ubicación de estructuras y demás modificaciones.',1,NULL,'2017-03-25 07:06:19',1,NULL),(520,'Comprende todo el procedimiento para posicionar los cuatro Stubs (Bases) de la estructura reticulada de acuerdo con las coordenadas X,Y,Z utilizando los diferentes métodos, tensores, cadenas, gavaritos etc., verificando constantemente las cotas, pendientes, diagonales, laterales etc., en concordancia con los planos del fabricante de las Torres y los Diseños de Cimentaciones. Durante la fundición se debe continuar chequeando que las medidas de diseño no varíen y se debe entregar la planilla que c',1,NULL,'2017-03-25 07:06:19',1,NULL),(521,'Comprende la entrega de un informe con la memoria detallada de los cálculos realizados y la metodología utilizada, las observaciones, las recomendaciones respectivas y los planos de detalle para la construcción con cantidades de materiales y dimensiones.',1,NULL,'2017-03-25 07:06:19',1,NULL),(522,'Comprende la realización de recorridos a pie de las posibles rutas, Investigación y recolección de la información con el detalle descrito en la Especificación técnica, Incluye la entrega del estudio de selección optima de trazado basado en una matriz de ponderación que considere parámetros de valoración como son longitud de las líneas, análisis de riesgos, restricciones físicas y ambientales de la zona, grado de impacto ambiental y social, costos de construcción (obras civiles) y costos de servi',1,NULL,'2017-03-25 07:06:19',1,NULL),(523,'Comprende labores de reconocimiento detallado del corredor a utilizar para la línea de A.T, consecución de información cartográfica, de geometrías viales y de redes de servicios públicos proyectadas, análisis de aislamiento, estudio de puestas a tierra, verificación de distancias de seguridad, determinación de zona de servidumbre, calculo de flechas y tensiones, calculo de cargas mecánicas sobre las estructuras, elaboración de arboles de carga y curvas de utilización respectivas, verificación de',1,NULL,'2017-03-25 07:06:19',1,NULL),(524,'Comprende la verificación sobre planos de las afectaciones sobre las líneas de A.T. y la visita al lugar de la afectación para establecer las recomendaciones y acciones a realizar. Incluye la presentación del informe escrito con el análisis correspondiente y recomendaciones.',1,NULL,'2017-03-25 07:06:19',1,NULL),(525,'Comprende todas las investigaciones geotécnicas de campo y laboratorio con el fin de conocer y determinar la estratigrafia, características geomecanicas, variación del nivel freático y todos los demás parámetros necesarios para el diseño de la cimentación incluye presentación de informe con observaciones y recomendaciones (Aplica solo para sondeos manuales con profundidades promedio hasta 7 m).',1,NULL,'2017-03-25 07:06:19',1,NULL),(526,'Comprende todas las investigaciones geotécnicas de campo y laboratorio con el fin de conocer y determinar la estratigrafía, características geomecanicas, variación del nivel freático y todos los demás parámetros necesarios para el diseño de la cimentación incluye presentación de informe con observaciones y recomendaciones (Aplica para sondeos con equipo de perforación mecánica hasta una profundidad promedio de 20 m).. La SUBFAMILIA que es común a esta actividad se describe a continuación con la ',1,NULL,'2017-03-25 07:06:19',1,NULL),(527,'Mediante este baremo el oferente realizara su oferta en HH para la ejecución de trabajos requeridos por la EEC, que corresponde a estudios análisis evaluaciones y tareas especificas relacionadas con la ingeniería de proyectos eléctricos o civiles de instalaciones de AT en la EEC y que pueden ser entre otros:I ingeniería de líneas subterráneas, Ingeniería de subestaciones y circuitos especiales de distribución, levantamiento de subestaciones y líneas existentes, desarrollo de criterios de diseño,',1,NULL,'2017-03-25 07:06:19',1,NULL);

/*Table structure for table `cf_area` */

DROP TABLE IF EXISTS `cf_area`;

CREATE TABLE `cf_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_estado` int(5) DEFAULT '1',
  `area_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `area_fechamodifico` timestamp NULL DEFAULT NULL,
  `area_nombre` varchar(45) NOT NULL,
  `area_usuariocreo` int(11) DEFAULT NULL,
  `area_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cf_area` */

insert  into `cf_area`(`area_id`,`area_estado`,`area_fechacreo`,`area_fechamodifico`,`area_nombre`,`area_usuariocreo`,`area_usuariomodifico`) values (1,1,'2017-02-25 20:27:13',NULL,'ADMINISTRADOR',1,0),(2,1,'2017-02-25 20:27:49',NULL,'DISEÑO',1,NULL),(3,1,'2017-02-25 20:28:22',NULL,'MECANICA',1,NULL);

/*Table structure for table `cf_entregable` */

DROP TABLE IF EXISTS `cf_entregable`;

CREATE TABLE `cf_entregable` (
  `entregable_id` int(11) NOT NULL AUTO_INCREMENT,
  `entregable_descripcion` varchar(200) DEFAULT NULL,
  `entregable_estado` int(11) NOT NULL DEFAULT '1',
  `entregable_fechacreo` timestamp NULL DEFAULT NULL,
  `entregable_fechamodifico` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `entregable_usuariocreo` int(11) DEFAULT NULL,
  `entregable_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`entregable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=latin1;

/*Data for the table `cf_entregable` */

insert  into `cf_entregable`(`entregable_id`,`entregable_descripcion`,`entregable_estado`,`entregable_fechacreo`,`entregable_fechamodifico`,`entregable_usuariocreo`,`entregable_usuariomodifico`) values (1,'Planos de levantamiento civil de base existente',1,NULL,'2017-03-25 07:12:18',1,NULL),(2,'Informe de levantamiento',1,NULL,'2017-03-25 07:12:30',1,NULL),(3,'Memorias de calculo de diseño de la nueva base',1,NULL,'2017-03-25 07:12:30',1,NULL),(4,'Planos de construcción con desglose de cantidades de materiales y pesos.',1,NULL,'2017-03-25 07:12:30',1,NULL),(5,'Plano de disposición general de obras civiles',1,NULL,'2017-03-25 07:12:30',1,NULL),(6,'Informe de Ingeniería civil',1,NULL,'2017-03-25 07:12:30',1,NULL),(7,'Planos de levantamiento mecánico, con distancias de seguridad a estructuras y equipos adyacentes.',1,NULL,'2017-03-25 07:12:30',1,NULL),(8,'Informe de levantamiento.',1,NULL,'2017-03-25 07:12:30',1,NULL),(9,'Plano de ubicación en planta y perfil del equipo dentro del modulo.',1,NULL,'2017-03-25 07:12:30',1,NULL),(10,'Plano mecánico detallado que incluya: detalle de conexiones en potencia con equipos adyacentes especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición de tuber',1,NULL,'2017-03-25 07:12:30',1,NULL),(11,'Informe de Ingeniería mecánica',1,NULL,'2017-03-25 07:12:30',1,NULL),(12,'Planos y listas de levantamientos eléctricos',1,NULL,'2017-03-25 07:12:30',1,NULL),(13,'Planos esquemáticos',1,NULL,'2017-03-25 07:12:30',1,NULL),(14,'Listas de conexionado y desconexionado',1,NULL,'2017-03-25 07:12:30',1,NULL),(15,'Lógicas de control y protección',1,NULL,'2017-03-25 07:12:30',1,NULL),(16,'Lista de materiales',1,NULL,'2017-03-25 07:12:30',1,NULL),(17,'Cantidades de obra',1,NULL,'2017-03-25 07:12:30',1,NULL),(18,'Protocolo de energización del modulo',1,NULL,'2017-03-25 07:12:30',1,NULL),(19,'Plano Z de los equipos de control y protección.',1,NULL,'2017-03-25 07:12:30',1,NULL),(20,'Informe de Ingeniería eléctrica',1,NULL,'2017-03-25 07:12:30',1,NULL),(21,'Plano de disposición general de obras civiles.',1,NULL,'2017-03-25 07:12:30',1,NULL),(22,'Planos de levantamiento mecánico, con distancias de seguridad a estructuras y equipos adyacentes',1,NULL,'2017-03-25 07:12:30',1,NULL),(23,'Plano de ubicación en planta y perfil del equipo dentro del modulo.',1,NULL,'2017-03-25 07:12:30',1,NULL),(24,'Plano mecánico detallado que incluya: detalle de conexiones en potencia especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición de tuberías de control, entre o',1,NULL,'2017-03-25 07:12:30',1,NULL),(25,'Plano detallado de la estructura metálica requerida.',1,NULL,'2017-03-25 07:12:30',1,NULL),(26,'Planos de ubicación de la caja de agrupamiento',1,NULL,'2017-03-25 07:12:30',1,NULL),(27,'Memorias de calculo',1,NULL,'2017-03-25 07:12:30',1,NULL),(28,'Lista de materiales',1,NULL,'2017-03-25 07:12:30',1,NULL),(29,'Plano de disposición de borneras en tableros y caja de agrupamiento',1,NULL,'2017-03-25 07:12:30',1,NULL),(30,'Planos de levantamiento civil.',1,NULL,'2017-03-25 07:12:30',1,NULL),(31,'Planos de levantamiento mecánico, con distancias de seguridad a estructuras, barrajes y equipos adyacentes.',1,NULL,'2017-03-25 07:12:30',1,NULL),(32,'Informe de levantamiento mecánico.',1,NULL,'2017-03-25 07:12:30',1,NULL),(33,'Plano mecánico detallado que incluya: detalle de conexiones en potencia (AT y MT) especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición de tuberías de contro',1,NULL,'2017-03-25 07:12:30',1,NULL),(34,'Planos de taller de las estructuras (en donde aplique)',1,NULL,'2017-03-25 07:12:30',1,NULL),(35,'Planos de ubicación de la caja de mando.',1,NULL,'2017-03-25 07:12:30',1,NULL),(36,'Plano de disposición de borneras y MCBs en tableros',1,NULL,'2017-03-25 07:12:30',1,NULL),(37,'Planos de levantamiento civil',1,NULL,'2017-03-25 07:12:30',1,NULL),(38,'Planos de levantamiento mecánico, con distancias de seguridad a estructuras, barrajes y equipos adyacentes.',1,NULL,'2017-03-25 07:12:31',1,NULL),(39,'Informe de levantamiento',1,NULL,'2017-03-25 07:12:31',1,NULL),(40,'Memorias de calculo.',1,NULL,'2017-03-25 07:12:31',1,NULL),(41,'Planos de levantamiento',1,NULL,'2017-03-25 07:12:31',1,NULL),(42,'Plano de ubicación en planta y perfil del banco dentro de la S/E.',1,NULL,'2017-03-25 07:12:31',1,NULL),(43,'Protocolo de energización del banco',1,NULL,'2017-03-25 07:12:31',1,NULL),(44,'Planos de conexión en potencia del transformador',1,NULL,'2017-03-25 07:12:31',1,NULL),(45,'Plano de conexiones de puesta a tierra.',1,NULL,'2017-03-25 07:12:31',1,NULL),(46,'Planos de construcción con detalles de tuberías y cárcamos.',1,NULL,'2017-03-25 07:12:31',1,NULL),(47,'Listado de señales a centro de control asociadas a los tableros.',1,NULL,'2017-03-25 07:12:31',1,NULL),(48,'Protocolo de energización',1,NULL,'2017-03-25 07:12:31',1,NULL),(49,'Informe de diseño',1,NULL,'2017-03-25 07:12:31',1,NULL),(50,'Listado de señales a centro de control asociadas al equipo',1,NULL,'2017-03-25 07:12:31',1,NULL),(51,'Planos de levantamiento.',1,NULL,'2017-03-25 07:12:31',1,NULL),(52,'Informe de levantamiento.',1,NULL,'2017-03-25 07:12:31',1,NULL),(53,'Lista de señales a centro de control',1,NULL,'2017-03-25 07:12:31',1,NULL),(54,'Protocolo de energización del equipo',1,NULL,'2017-03-25 07:12:31',1,NULL),(55,'Planos mecánicos de adecuación del tablero',1,NULL,'2017-03-25 07:12:31',1,NULL),(56,'Arquitectura de telecontrol y comunicaciones y listas de conexionado.',1,NULL,'2017-03-25 07:12:31',1,NULL),(57,'Planos mecánicos detallados del tablero',1,NULL,'2017-03-25 07:12:31',1,NULL),(58,'Planos de cambio de cajas de agrupamiento (si se requiere)',1,NULL,'2017-03-25 07:12:31',1,NULL),(59,'Protocolo de energización de la protección',1,NULL,'2017-03-25 07:12:31',1,NULL),(60,'Verificación del estado de las cajas de agrupamiento de todos los módulos intervenidos',1,NULL,'2017-03-25 07:12:31',1,NULL),(61,'Levantamiento mecánico del tablero donde se instalara la protección.',1,NULL,'2017-03-25 07:12:31',1,NULL),(62,'Elaborar plano mostrando la adecuación de(los) tablero(s) o diseño del nuevo tablero(s) donde se realizara el cambio o instalación de la nueva protección.',1,NULL,'2017-03-25 07:12:31',1,NULL),(63,'Ingeniería mecánica para el cambio de las cajas de agrupamiento y borneras en los módulos que sean requeridos.',1,NULL,'2017-03-25 07:12:31',1,NULL),(64,'Realizar el levantamiento de las características de la protección actual (marca, tipo, etc.)',1,NULL,'2017-03-25 07:12:31',1,NULL),(65,'Realizar los diagramas unifilares y trifilares donde se muestre el estado actual de la instalación.',1,NULL,'2017-03-25 07:12:31',1,NULL),(66,'Verificación del estado y conexión de las corrientes en todos los módulos a integrar bajo la protección 87B. En caso que no cuenten con borneras cortocircuitables se debe sugerir el reemplazo de borne',1,NULL,'2017-03-25 07:12:31',1,NULL),(67,'Verificar la compatibilidad de los CTs existentes con la nueva protección (núcleos, relación de transformación, saturación, etc) y determinar si es requerido el cambio en alguno de los módulos.',1,NULL,'2017-03-25 07:12:31',1,NULL),(68,'Levantamientos e ingeniería para el reemplazo de la protección 86B, con sus conexiones en cada uno de los módulos asociados.',1,NULL,'2017-03-25 07:12:31',1,NULL),(69,'Hacer la nueva implementación bajo los criterios de ingeniería NO047 (contemplando esquemas de disparo y bloqueo, función 50 BF, enclavamientos, señales a centro de control, etc.).',1,NULL,'2017-03-25 07:12:31',1,NULL),(70,'Verificar la funcionalidad de la protección a instalar con los CTs existentes en todos los módulos a integrar en la nueva protección.',1,NULL,'2017-03-25 07:12:31',1,NULL),(71,'Presentar diagramas unifilares, trifilares, de principio, de control y protección, que contemplen la implementación final.',1,NULL,'2017-03-25 07:12:31',1,NULL),(72,'Determinar los aspectos a tener en cuenta para la instalación del relé.',1,NULL,'2017-03-25 07:12:31',1,NULL),(73,'Indicar características y cantidad de borneras (seccionables y cortocircuitables) a reemplazar, en caso que las existentes estén deterioradas o no cumplan con las características requeridas por la EEC',1,NULL,'2017-03-25 07:12:31',1,NULL),(74,'Elaborar las listas de desconexionado y conexionado para la implementación de la nueva protección.',1,NULL,'2017-03-25 07:12:31',1,NULL),(75,'Definición de conectividad a nivel de comunicaciones para los servicios de telecontrol y gestión de protecciones.',1,NULL,'2017-03-25 07:12:31',1,NULL),(76,'Planos esquemáticos',1,NULL,'2017-03-25 07:12:31',1,NULL),(77,'Listas de conexionado y desconexionado.',1,NULL,'2017-03-25 07:12:31',1,NULL),(78,'Listas de materiales',1,NULL,'2017-03-25 07:12:31',1,NULL),(79,'Diagramas esquemáticos',1,NULL,'2017-03-25 07:12:31',1,NULL),(80,'Protocolo de energización para cada modulo.',1,NULL,'2017-03-25 07:12:32',1,NULL),(81,'Diagramas trifilares y esquemáticos',1,NULL,'2017-03-25 07:12:32',1,NULL),(82,'Protocolo de energización del modulo.',1,NULL,'2017-03-25 07:12:32',1,NULL),(83,'Planos civiles detallados del tablero',1,NULL,'2017-03-25 07:12:32',1,NULL),(84,'Plano de disposición de borneras y equipos',1,NULL,'2017-03-25 07:12:32',1,NULL),(85,'Planos mecánicos del nuevo tablero',1,NULL,'2017-03-25 07:12:32',1,NULL),(86,'Planos de levantamiento.',1,NULL,'2017-03-25 07:12:32',1,NULL),(87,'Levantamiento mecánico del tablero donde se instalaran las protecciones.',1,NULL,'2017-03-25 07:12:32',1,NULL),(88,'Elaborar plano mostrando la adecuación del tablero donde se realizara el cambio o instalación de las nuevas protecciones.',1,NULL,'2017-03-25 07:12:32',1,NULL),(89,'Realizar el levantamiento de las características de las protecciones actuales (marca, tipo, etc.)',1,NULL,'2017-03-25 07:12:32',1,NULL),(90,'Verificar la funcionalidad de las protecciones a instalar con los CTs y demás equipos de potencia instalados en el modulo a intervenir.',1,NULL,'2017-03-25 07:12:32',1,NULL),(91,'Hacer la nueva implementación de acuerdo a los criterios de ingeniería NO047.',1,NULL,'2017-03-25 07:12:32',1,NULL),(92,'Determinar los aspectos a tener en cuenta para la instalación de las protecciones.',1,NULL,'2017-03-25 07:12:32',1,NULL),(93,'Indicar características y cantidad de borneras (seccionables y cortocircuitables) a reemplazar, en caso que las existentes estén deterioradas o no cumplan con las características requeridas por la EEC',1,NULL,'2017-03-25 07:12:32',1,NULL),(94,'Elaborar las listas de desconexionado y conexionado para la implementación de la nueva protección.',1,NULL,'2017-03-25 07:12:32',1,NULL),(95,'Verificar las conexiones con el equipo de teleproteccion en caso que sea existente y en caso contrario, dejar la ingeniería adaptada para cuando se instale dicho equipo.',1,NULL,'2017-03-25 07:12:32',1,NULL),(96,'Informe de diseño',1,NULL,'2017-03-25 07:12:32',1,NULL),(97,'Listado de materiales',1,NULL,'2017-03-25 07:12:32',1,NULL),(98,'Planos de taller de la estructura metálica requerida',1,NULL,'2017-03-25 07:12:32',1,NULL),(99,'Planos mecánicos de la instalación provisional: vista en planta, cortes, distribución de circuitos en las celdas provisionales, rutas de cable de control y potencia.',1,NULL,'2017-03-25 07:12:32',1,NULL),(100,'Planos y listas de levantamientos eléctricos.',1,NULL,'2017-03-25 07:12:32',1,NULL),(101,'Listado de materiales y cantidades de obra',1,NULL,'2017-03-25 07:12:32',1,NULL),(102,'Protocolo de energización de la instalación provisional.',1,NULL,'2017-03-25 07:12:32',1,NULL),(103,'Planos mecánicos de la instalación provisional: vista en planta, cortes, rutas de cable de control y potencia.',1,NULL,'2017-03-25 07:12:32',1,NULL),(104,'Informe de Ingeniería civil y mecánico',1,NULL,'2017-03-25 07:12:32',1,NULL),(105,'Planos eléctricos (2 copias en medio físico formato A3 con pasta dura y 2 copias en medio digital)',1,NULL,'2017-03-25 07:12:32',1,NULL),(106,'Disposición de equipos, disposición de áreas de construcción, unifilar, cortes típicos de las bahías, listado general de equipos, entre otros.',1,NULL,'2017-03-25 07:12:32',1,NULL),(107,'Informe',1,NULL,'2017-03-25 07:12:32',1,NULL),(108,'Planos civiles, mecánicos y/o eléctricos, según apliquen',1,NULL,'2017-03-25 07:12:32',1,NULL),(109,'Presupuestos y cantidades de equipos, materiales y obra',1,NULL,'2017-03-25 07:12:32',1,NULL),(110,'Estudio de suelos, con detalles de los sondeos ejecutados y recomendaciones del geotecnista.',1,NULL,'2017-03-25 07:12:32',1,NULL),(111,'Informes periódicos de avance y estado de la obra',1,NULL,'2017-03-25 07:12:32',1,NULL),(112,'Plano de construcción de la malla (planta y perfil)',1,NULL,'2017-03-25 07:12:32',1,NULL),(113,'Informe de medidas',1,NULL,'2017-03-25 07:12:32',1,NULL),(114,'Informe y planos de levantamiento.',1,NULL,'2017-03-25 07:12:32',1,NULL),(115,'Listas de conexionado.',1,NULL,'2017-03-25 07:12:32',1,NULL),(116,'Planos de disposición en planta',1,NULL,'2017-03-25 07:12:32',1,NULL),(117,'Planos de disposición en planta, rutas de cables, etc.',1,NULL,'2017-03-25 07:12:32',1,NULL),(118,'Planos de levantamiento',1,NULL,'2017-03-25 07:12:32',1,NULL),(119,'Planos arquitectónicos',1,NULL,'2017-03-25 07:12:32',1,NULL),(120,'Planos de cárcamos internos en casa de control',1,NULL,'2017-03-25 07:12:32',1,NULL),(121,'Planos estructurales',1,NULL,'2017-03-25 07:12:33',1,NULL),(122,'Planos de redes hidrosanitarias',1,NULL,'2017-03-25 07:12:33',1,NULL),(123,'Planos de construcción con desglose de cantidades de materiales y pesos',1,NULL,'2017-03-25 07:12:33',1,NULL),(124,'Planos de levantamiento topográfico.',1,NULL,'2017-03-25 07:12:33',1,NULL),(125,'Informe de levantamiento',1,NULL,'2017-03-25 07:12:33',1,NULL),(126,'Informe de Ingeniería civil',1,NULL,'2017-03-25 07:12:33',1,NULL),(127,'Memorias de calculo',1,NULL,'2017-03-25 07:12:33',1,NULL),(128,'Planos de construcción con desglose de materiales y pesos',1,NULL,'2017-03-25 07:12:33',1,NULL),(129,'Plano de disposición general de obras civiles',1,NULL,'2017-03-25 07:12:33',1,NULL),(130,'Planos de levantamiento mecánico, con distancias y dimensiones de los equipos.',1,NULL,'2017-03-25 07:12:33',1,NULL),(131,'Memorias de calculo y arboles de carga de las estructuras de soporte de equipos.',1,NULL,'2017-03-25 07:12:33',1,NULL),(132,'Plano de ubicación en planta y perfil de los equipos del nuevo modulo.',1,NULL,'2017-03-25 07:12:33',1,NULL),(133,'Plano mecánico detallado del modulo en patio que incluya: detalle de conexiones en potencia (AT y MT) especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición d',1,NULL,'2017-03-25 07:12:33',1,NULL),(134,'Plano mecánico detallado del tablero de control y protección que incluya disposición de equipos y de elementos auxiliares (borneras, MCBs, relés auxiliares, etc).',1,NULL,'2017-03-25 07:12:33',1,NULL),(135,'Planos de despiece de la estructura metálica requerida',1,NULL,'2017-03-25 07:12:33',1,NULL),(136,'Informe de Ingeniería mecánica',1,NULL,'2017-03-25 07:12:33',1,NULL),(137,'Lista de materiales',1,NULL,'2017-03-25 07:12:33',1,NULL),(138,'Informe de Ingeniería eléctrica',1,NULL,'2017-03-25 07:12:33',1,NULL),(139,'Lógicas de control y protección',1,NULL,'2017-03-25 07:12:33',1,NULL),(140,'Lista de cables, listas de conexionado y desconexionado',1,NULL,'2017-03-25 07:12:33',1,NULL),(141,'Lista de señales a centro de control',1,NULL,'2017-03-25 07:12:33',1,NULL),(142,'Diagramas unifilares y trifilares',1,NULL,'2017-03-25 07:12:33',1,NULL),(143,'Diagramas de principio',1,NULL,'2017-03-25 07:12:33',1,NULL),(144,'Planos esquemáticos.',1,NULL,'2017-03-25 07:12:33',1,NULL),(145,'Lista de materiales y equipos',1,NULL,'2017-03-25 07:12:33',1,NULL),(146,'Cantidades de obra.',1,NULL,'2017-03-25 07:12:33',1,NULL),(147,'Protocolo de energización del modulo',1,NULL,'2017-03-25 07:12:33',1,NULL),(148,'Arquitectura de telecontrol y comunicaciones y listas de conexionado.',1,NULL,'2017-03-25 07:12:33',1,NULL),(149,'Manual de operación',1,NULL,'2017-03-25 07:12:33',1,NULL),(150,'Memorias de calculo y arboles de carga de las estructuras de soporte de equipos.',1,NULL,'2017-03-25 07:12:33',1,NULL),(151,'Planos y listas de levantamientos eléctricos',1,NULL,'2017-03-25 07:12:33',1,NULL),(152,'Planos esquemáticos',1,NULL,'2017-03-25 07:12:33',1,NULL),(153,'Protocolo de energización del modulo',1,NULL,'2017-03-25 07:12:33',1,NULL),(154,'Informe de levantamiento.',1,NULL,'2017-03-25 07:12:33',1,NULL),(155,'Planos de la estructura actual.',1,NULL,'2017-03-25 07:12:33',1,NULL),(156,'Plano de ubicación en planta y perfil de la ampliación.',1,NULL,'2017-03-25 07:12:34',1,NULL),(157,'Plano mecánico detallado que incluya: detalle de conexiones en potencia especificando herrajes y calibres de cable, conexiones de puesta a tierra.',1,NULL,'2017-03-25 07:12:34',1,NULL),(158,'Lista de materiales',1,NULL,'2017-03-25 07:12:34',1,NULL),(159,'Levantamiento topográfico del lugar de ubicación del nuevo transformador de potencia.',1,NULL,'2017-03-25 07:12:34',1,NULL),(160,'Levantamiento de cárcamos de control y potencia existentes para comunicación con la casa de control para verificar necesidades de ampliación.',1,NULL,'2017-03-25 07:12:34',1,NULL),(161,'Ingeniería para construcción de las carrileras y cimentación del transformador incluyendo foso de aceite y conexión a tanque de aceite.',1,NULL,'2017-03-25 07:12:34',1,NULL),(162,'Ingeniería para construcción de cimentaciones para columnas del barraje auxiliar (en caso de ser requerido).',1,NULL,'2017-03-25 07:12:34',1,NULL),(163,'Ingeniería para construcción de obras civiles requeridas para instalación del nuevo tablero de regulación en sala de control y/o patio.',1,NULL,'2017-03-25 07:12:34',1,NULL),(164,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de control desde el patio hacia la sala de control.',1,NULL,'2017-03-25 07:12:34',1,NULL),(165,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de potencia desde el transformador hacia las celdas de MT (en caso que sea necesario).',1,NULL,'2017-03-25 07:12:34',1,NULL),(166,'Verificación de distancias de seguridad a pórticos y muros.',1,NULL,'2017-03-25 07:12:34',1,NULL),(167,'Validación de la conexión en potencia por el lado de AT del transformador. Verificar si es necesaria la construcción de un barraje auxiliar.',1,NULL,'2017-03-25 07:12:34',1,NULL),(168,'Ingeniería mecánica completa para instalación de nuevo transformador incluyendo: conexiones de PAT, conexiones de neutro, conexiones en potencia por AT y MT (incluyendo calibres de cables y conectores',1,NULL,'2017-03-25 07:12:34',1,NULL),(169,'Disposición de tuberías para el cableado de control.',1,NULL,'2017-03-25 07:12:34',1,NULL),(170,'Ingeniería para construcción de barraje auxiliar para conexión por AT en caso de ser necesario.',1,NULL,'2017-03-25 07:12:34',1,NULL),(171,'Calculo y estudio de apantallamiento para el nuevo transformador y barraje auxiliar (cuando aplique), especificando distancia, cables y herrajes y conexión al sistema existente.',1,NULL,'2017-03-25 07:12:34',1,NULL),(172,'Ubicación del tablero de regulación del nuevo transformador a instalar.',1,NULL,'2017-03-25 07:12:34',1,NULL),(173,'Ingeniería mecánica de las rejillas para el foso de aceite.',1,NULL,'2017-03-25 07:12:34',1,NULL),(174,'Determinar los aspectos a tener en cuenta para la instalación del nuevo equipo (acceso de maquinaria pesada, distancia a equipos energizados, delimitación de la zona de trabajo, etc.).',1,NULL,'2017-03-25 07:12:34',1,NULL),(175,'Verificación de MCBs disponibles en tableros de AC y DC para alimentación del gabinete de control local del transformador, gabinete del cambiador de tomas y el tablero de regulación.',1,NULL,'2017-03-25 07:12:34',1,NULL),(176,'Verificación de interfaces con el tablero de control y protección del modulo de transformador.',1,NULL,'2017-03-25 07:12:34',1,NULL),(177,'Ingeniería del tablero de regulación y control de ventiladores.',1,NULL,'2017-03-25 07:12:34',1,NULL),(178,'Indicar las conexiones entre el tablero de regulación y el transformador.',1,NULL,'2017-03-25 07:12:34',1,NULL),(179,'Ingeniería eléctrica para conexión del nuevo transformador y su integración al tablero de control y protección del modulo incluyendo las señales a centro de control.',1,NULL,'2017-03-25 07:12:34',1,NULL),(180,'Planos de levantamiento.',1,NULL,'2017-03-25 07:12:34',1,NULL),(181,'Plano de ubicación en planta y perfil del nuevo transformador',1,NULL,'2017-03-25 07:12:34',1,NULL),(182,'Plano mecánico detallado que incluya: detalle de conexiones en potencia especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición de tuberías de control, entre o',1,NULL,'2017-03-25 07:12:34',1,NULL),(183,'Planos de despiece de la estructura metálica requerida.',1,NULL,'2017-03-25 07:12:34',1,NULL),(184,'Listas de conexionado y des conexionado',1,NULL,'2017-03-25 07:12:34',1,NULL),(185,'Lista de señales a centro de control.',1,NULL,'2017-03-25 07:12:34',1,NULL),(186,'Cantidades de obra',1,NULL,'2017-03-25 07:12:34',1,NULL),(187,'Protocolo de energización del transformador',1,NULL,'2017-03-25 07:12:34',1,NULL),(188,'Proceso constructivo recomendado',1,NULL,'2017-03-25 07:12:34',1,NULL),(189,'Levantamiento topográfico del lugar de ubicación del nuevo transformador.',1,NULL,'2017-03-25 07:12:34',1,NULL),(190,'Levantamiento de cárcamos de control existentes para comunicación entre el transformador y la casa de control para verificar necesidades de ampliación.',1,NULL,'2017-03-25 07:12:34',1,NULL),(191,'Ingeniería para construcción de nuevos cárcamos y/o bancos de ductos para el cableado de potencia para la conformación de la delta del terciario (en caso de ser requerido).',1,NULL,'2017-03-25 07:12:34',1,NULL),(192,'Validación de la conexión en potencia del transformador. Verificar si es necesaria la construcción de un barraje auxiliar.',1,NULL,'2017-03-25 07:12:34',1,NULL),(193,'Ingeniería mecánica completo para instalación del nuevo transformador incluyendo: conexiones de PAT, conexiones de neutro, conexiones en potencia (incluyendo calibres de cables y conectores).',1,NULL,'2017-03-25 07:12:34',1,NULL),(194,'Ingeniería para construcción de barraje auxiliar para conexión en potencia en caso de ser necesario.',1,NULL,'2017-03-25 07:12:34',1,NULL),(195,'Calculo y estudio de apantallamiento para el nuevo banco de transformación y barraje auxiliar (cuando aplique), especificando distancia, cables y herrajes y conexión al sistema existente.',1,NULL,'2017-03-25 07:12:35',1,NULL),(196,'Ubicación del tablero de regulación del nuevo banco de transformación a instalar.',1,NULL,'2017-03-25 07:12:35',1,NULL),(197,'Ingeniería mecánica de las rejillas para los fosos de aceite.',1,NULL,'2017-03-25 07:12:35',1,NULL),(198,'Verificación de MCBs disponibles en tableros de AC y DC para alimentación del gabinete de control local del transformador, gabinetes del cambiador de tomas y el tablero de regulación.',1,NULL,'2017-03-25 07:12:35',1,NULL),(199,'Ingeniería para conexiones entre el tablero de regulación y el transformador',1,NULL,'2017-03-25 07:12:35',1,NULL),(200,'Plano de ubicación en planta y perfil del nuevo transformador.',1,NULL,'2017-03-25 07:12:35',1,NULL),(201,'Manual de operación del banco de auto transformación',1,NULL,'2017-03-25 07:12:35',1,NULL),(202,'Plano mecánico detallado que incluya: detalle de conexiones en potencia (AT y MT) especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición de tuberías de contro',1,NULL,'2017-03-25 07:12:35',1,NULL),(203,'Lista de señales a centro de control (en caso que aplique)',1,NULL,'2017-03-25 07:12:35',1,NULL),(204,'Plano de ubicación en planta y perfil de los equipos del nuevo modulo, incluyendo los de la bahía y del banco de compensación.',1,NULL,'2017-03-25 07:12:35',1,NULL),(205,'Plano mecánico detallado del tablero de control y protección que incluya disposición de equipos y de elementos auxiliares (borneras, MCBs, relés auxiliares, etc)',1,NULL,'2017-03-25 07:12:35',1,NULL),(206,'Plano mecánico detallado del modulo en patio que incluya: detalle de conexiones en potencia especificando tipo de conectores y calibres de cable, conexiones de puesta a tierra, disposición de tuberías',1,NULL,'2017-03-25 07:12:35',1,NULL),(207,'Plano de ubicación en planta y perfil del nuevo modulo.',1,NULL,'2017-03-25 07:12:35',1,NULL),(208,'Planos de levantamiento',1,NULL,'2017-03-25 07:12:35',1,NULL),(209,'Planos de disposición de las nuevas celdas',1,NULL,'2017-03-25 07:12:35',1,NULL),(210,'Planos de conexionado de puestas a tierra',1,NULL,'2017-03-25 07:12:35',1,NULL),(211,'Planos detallados de la estructura de salida de cables del transformador de potencia.',1,NULL,'2017-03-25 07:12:35',1,NULL),(212,'Informe de Ingeniería civil y mecánico',1,NULL,'2017-03-25 07:12:35',1,NULL),(213,'Planos de levantamiento',1,NULL,'2017-03-25 07:12:35',1,NULL),(214,'Planos de levantamiento topográfico.',1,NULL,'2017-03-25 07:12:35',1,NULL);

/*Table structure for table `cf_labor` */

DROP TABLE IF EXISTS `cf_labor`;

CREATE TABLE `cf_labor` (
  `labor_id` int(11) NOT NULL AUTO_INCREMENT,
  `labor_descripcion` varchar(500) NOT NULL,
  `labor_estado` int(5) DEFAULT '1',
  `labor_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `labor_fechamodifico` timestamp NULL DEFAULT NULL,
  `labor_unidmedida` varchar(45) DEFAULT NULL,
  `labor_usuariocreo` int(11) DEFAULT NULL,
  `labor_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`labor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `cf_labor` */

insert  into `cf_labor`(`labor_id`,`labor_descripcion`,`labor_estado`,`labor_fechacreo`,`labor_fechamodifico`,`labor_unidmedida`,`labor_usuariocreo`,`labor_usuariomodifico`) values (1,'Ingenieria para el montaje de un nuevo modulo de transformador a nivel de tension  230 kV o 115 kV - Configuracion Barra Sencilla',1,'2017-03-15 07:42:13',NULL,'C/U',NULL,NULL),(2,'Ingenieria para el montaje de un nuevo modulo de transformador 230 o 115 kV - Configuracion Barra Doble o Barra principal +transferencia.',1,'2017-03-15 16:55:22',NULL,'C/U',NULL,NULL),(3,'Ingenieria para el montaje de un nuevo modulo de transformador 230  o 115 kV - Configuracion Barra Doble + Seccionador By Pass',1,'2017-03-15 19:18:00',NULL,'C/U',NULL,NULL),(4,'Ingenieria para el montaje de un nuevo modulo Transformador 500 kV - ( Cualquier configuracion de barra)',1,'2017-03-15 22:10:54',NULL,'C/U',NULL,NULL),(5,'Ingenieria para el reemplazo de Transformador de Potencia Trifasico 230, 115, 57.5 / 34.5, 11.4 kV',1,'2017-03-19 06:01:55',NULL,'C/U',NULL,NULL);

/*Table structure for table `cf_menu` */

DROP TABLE IF EXISTS `cf_menu`;

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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `cf_menu` */

insert  into `cf_menu`(`menu_id`,`menu_estado`,`menu_fechacreo`,`menu_fechamodifico`,`menu_icono`,`menu_idpadre`,`menu_nombre`,`menu_orderurl`,`menu_tipo`,`menu_URL`,`menu_usuariocreo`,`menu_usuariomodifico`) values (1,1,'2017-02-25 22:57:20',NULL,'fa fa-cog','0','CONFIGURAR',1,'MANU',NULL,1,0),(2,0,'2017-02-25 22:58:59',NULL,'fa fa-user','0','GESTION',3,'MENU',NULL,1,NULL),(3,1,'2017-02-25 23:04:48',NULL,'fa fa-user','0','FACTURA',4,'MENU',NULL,1,NULL),(4,1,'2017-02-26 01:26:49',NULL,NULL,'1','Usuarios',1,'FUNCION','lib/2usuario/view/grit.php',1,NULL),(5,1,'2017-02-26 01:28:17',NULL,NULL,'2','Descargos',1,'FUNCION',NULL,1,NULL),(6,1,'2017-02-26 01:29:03',NULL,NULL,'3','Listar',1,'FUNCION',NULL,1,NULL),(7,1,'2017-03-02 03:41:29',NULL,NULL,'1','Clientes',1,'FUNCION','lib/2usuario/view/formDataClient.php',1,0),(8,1,'2017-03-11 20:49:03',NULL,NULL,'1','Baremos',5,'FUNCION','lib/1config/vista/formLsBaremos.php',0,NULL),(9,1,'2017-03-17 06:53:18',NULL,NULL,'1','Alcances',3,'FUNCION','lib/1config/vista/formLsAlcance.php',1,NULL),(10,1,'2017-03-17 06:53:18',NULL,NULL,'1','Entregables',4,'FUNCION','lib/1config/vista/formLsEntregable.php',1,NULL),(11,1,'2017-03-25 21:00:45',NULL,'fa fa-laptop','0','PRESUPUESTO',2,'MENU','',1,NULL),(12,1,'2017-03-25 21:04:35',NULL,NULL,'11','Presupuestos',1,'FUNCION','lib/3presup/view/formLsPresup.php',1,NULL),(13,1,'2017-04-02 01:04:48',NULL,NULL,'11','Orden Trabajo',2,'FUNCION','lib/4ot/view/formLsOrdenTrabajo.php',1,NULL),(14,1,'2017-04-05 18:48:51',NULL,'fa fa-envelope-o','0','ACTIVIDADES',3,'MENU',NULL,1,NULL),(15,1,'2017-04-05 18:51:34',NULL,NULL,'14','Asociadas',1,'FUNCION','lib/4ot/view/formLsActividades.php',1,NULL),(16,1,'2017-04-19 22:03:53',NULL,NULL,'14','Gestionar',2,'FUNCION','lib/4ot/view/formGestionAct.php',1,NULL),(17,1,'2017-04-25 23:10:04',NULL,NULL,'3','Generar',1,'FUNCION','lib/5fct/view/formNewFct.php',1,NULL),(18,1,'2017-05-02 22:52:33',NULL,NULL,'3','Historial',2,'FUNCION',NULL,1,NULL);

/*Table structure for table `cf_modulo` */

DROP TABLE IF EXISTS `cf_modulo`;

CREATE TABLE `cf_modulo` (
  `modulo_id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_descripcion` varchar(100) NOT NULL,
  `modulo_estado` int(11) NOT NULL DEFAULT '1',
  `modulo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modulo_fechamodifico` datetime DEFAULT NULL,
  `modulo_usuariocreo` int(11) NOT NULL,
  `modulo_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`modulo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cf_modulo` */

insert  into `cf_modulo`(`modulo_id`,`modulo_descripcion`,`modulo_estado`,`modulo_fechacreo`,`modulo_fechamodifico`,`modulo_usuariocreo`,`modulo_usuariomodifico`) values (1,'SERVICIOS AUXILIARES AC 208VAC',1,'2017-03-29 22:30:21','2017-03-29 17:40:49',1,1),(2,'MODILO PRUEBA',1,'2017-03-30 06:27:51',NULL,1,NULL),(3,'TERCERA PRUEBA',1,'2017-03-30 07:14:38',NULL,1,NULL),(4,'TRES',1,'2017-03-31 03:18:10',NULL,1,NULL);

/*Table structure for table `cf_perfil` */

DROP TABLE IF EXISTS `cf_perfil`;

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

/*Data for the table `cf_perfil` */

insert  into `cf_perfil`(`perfil_id`,`perfil_estado`,`perfil_fechacreo`,`perfil_fechamodifico`,`perfil_nombre`,`perfil_usuariocreo`,`perfil_usuariomodifico`) values (1,1,'2017-02-25 20:15:16',NULL,'ADMINISTRADOR',1,NULL),(2,1,'0000-00-00 00:00:00',NULL,'GESTOR',1,0),(3,1,'2017-02-25 20:16:46',NULL,'INGENIERO',1,0);

/*Table structure for table `cf_subactividad` */

DROP TABLE IF EXISTS `cf_subactividad`;

CREATE TABLE `cf_subactividad` (
  `subactividad_id` int(11) NOT NULL AUTO_INCREMENT,
  `subactividad_descripcion` varchar(300) DEFAULT NULL,
  `subactividad_estado` int(5) DEFAULT '1',
  `subactividad_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `subactividad_fechamodifico` timestamp NULL DEFAULT NULL,
  `subactividad_usuariocreo` int(5) DEFAULT NULL,
  `subactividad_usuariomodifico` int(11) DEFAULT NULL,
  PRIMARY KEY (`subactividad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cf_subactividad` */

insert  into `cf_subactividad`(`subactividad_id`,`subactividad_descripcion`,`subactividad_estado`,`subactividad_fechacreo`,`subactividad_fechamodifico`,`subactividad_usuariocreo`,`subactividad_usuariomodifico`) values (1,'LEVANTAMIENTO',1,'2017-03-20 23:07:05','2017-03-23 19:34:09',1,1),(2,'INGENIERIA DE DETALLE',1,'2017-03-20 23:10:41',NULL,1,NULL),(3,'INGENIERIA DETALLADA',1,'2017-03-21 00:36:54','2017-03-27 18:54:56',1,1);

/*Table structure for table `cf_tipobaremo` */

DROP TABLE IF EXISTS `cf_tipobaremo`;

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

/*Data for the table `cf_tipobaremo` */

insert  into `cf_tipobaremo`(`tipobaremo_id`,`tipobaremo_descripcion`,`tipobaremo_estado`,`tipobaremo_fechacreo`,`tipobaremo_fechamodifico`,`tipobaremo_sigla`,`tipobaremo_usuariocreo`,`tipobaremo_usuariomodifico`) values (1,'MODULOS',1,'2017-03-13 21:40:09',NULL,'M',1,NULL),(2,'LABORES',1,'2017-03-13 21:40:09',NULL,'L',1,NULL),(3,'LINEA L',1,'2017-03-13 21:40:09',NULL,'LL',1,NULL);

/*Table structure for table `dt_cliente` */

DROP TABLE IF EXISTS `dt_cliente`;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `dt_cliente` */

insert  into `dt_cliente`(`cliente_id`,`cliente_descripcion`,`cliente_estado`,`cliente_fechacreo`,`cliente_fechamodifico`,`cliente_PID`,`cliente_usuariocreo`,`cliente_usuariomodifico`) values (1,'CODENSA S.A. ESP',1,'2017-03-09 05:15:52','2017-03-09 21:43:30','323',1,1),(2,'prueba',1,'2017-03-09 21:47:54',NULL,'2343243',1,NULL),(3,'jennifer M',1,'2017-03-09 21:51:47','2017-03-10 04:26:56','34545 M',1,1),(4,'segunda prueba',1,'2017-03-10 04:27:48',NULL,'23434',1,NULL);

/*Table structure for table `dt_contrato` */

DROP TABLE IF EXISTS `dt_contrato`;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `dt_contrato` */

insert  into `dt_contrato`(`contrato_id`,`contrato_estado`,`contrato_fechacreo`,`contrato_fechainicio`,`contrato_fechafin`,`contrato_fechamodifico`,`contrato_numero`,`contrato_usuariocreo`,`contrato_usuariomodifico`,`contrato_valor`,`cliente_id`) values (1,1,'2017-03-09 05:15:52','2017-01-01','2017-12-31',NULL,'234324',1,NULL,'32000000',1),(2,1,'2017-03-09 20:32:33','2017-03-09','2017-11-29',NULL,'2343242222',0,NULL,'34343434',1),(3,1,'2017-03-09 20:40:05','2017-03-09','2017-11-29',NULL,'33444444',0,NULL,'345435',1),(4,1,'2017-03-09 20:44:50','2017-03-09','2013-12-25',NULL,'2323423223',0,NULL,'3434',1),(5,1,'2017-03-09 20:47:24','2017-03-09','2013-12-25',NULL,'2323423223',0,NULL,'3434',1),(6,1,'2017-03-09 20:47:48','2017-03-09','2013-12-25',NULL,'2323423223',0,NULL,'3434',1),(7,1,'2017-03-09 21:02:15','2017-10-16','2017-12-26',NULL,'333344433434',1,NULL,'3453455',1),(8,1,'2017-03-09 21:31:20','2017-10-16','2017-12-26',NULL,'333344433434',1,NULL,'3453455',1),(9,1,'2017-03-09 21:43:30','2017-01-01','2017-12-31',NULL,'9666666666',1,NULL,'100000000000',1),(10,0,'2017-03-09 21:47:54','2017-01-01','2017-12-31','2017-03-09 22:59:54','366654488',1,1,'400000000',2),(11,0,'2017-03-09 21:51:47','2017-01-02','2017-12-31','2017-03-10 03:09:40','234324',1,1,'3434',3),(12,1,'2017-03-10 03:10:54','2017-01-01','2017-12-31','2017-03-10 04:26:57','234324',1,1,'2000',3),(13,1,'2017-03-10 04:24:48','2017-03-09','2017-03-09',NULL,'33445466',1,NULL,'3345345',3),(14,1,'2017-03-10 04:27:48','2017-09-24','2017-12-31',NULL,'1234567',1,NULL,'1000',4);

/*Table structure for table `dt_detalle_presupuesto` */

DROP TABLE IF EXISTS `dt_detalle_presupuesto`;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `dt_detalle_presupuesto` */

insert  into `dt_detalle_presupuesto`(`detallepresupuesto_id`,`detallepresupuesto_alcance`,`detallepresupuesto_estado`,`detallepresupuesto_fechaini`,`detallepresupuesto_fechafin`,`detallepresupuesto_fechacreo`,`detallepresupuesto_fechamodifico`,`detallepresupuesto_gestor`,`detallepresupuesto_nombre`,`detallepresupuesto_objeto`,`detallepresupuesto_total`,`detallepresupuesto_usuariocreo`,`detallepresupuesto_usuariomodifico`,`subestacion_id`,`contrato_id`) values (1,'Servicios Auxiliares AC 208VAC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Alterna  para las casetas de control distribuido.Servicios Auxiliares AC 208VAC: Rediseño de un  (1)  tableros de servicios Auxiliares de corriente Alterna. (Ubicado en la sala principal de la SE). \nServicios Auxiliares DC 125VCC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Continua  para las casetas de control distribuido.Servicios Auxiliares DC 125VCC: Rediseño de dos  (2)  tableros de servicios Auxiliares de corriente Continua .(Ubicado en la sala principal de la SE).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Autotransformador AT1  230/115kV / Autotransformador AT3  230/115kV : Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de nuevo tablero regulador de tensión, reubicación de medidores digitales de frontera lado 230kV ( Principal y Respaldo), Reubicación de registrador de fallas.                                                                                                                                                                                                                                                                                             \nAutotransformador AT2  230/115kV / Autotransformador AT4  230/115kV: Levantamiento eléctrico de control y protección (Lado 115 kV), normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de un (1) nuevo tablero Regulador de tensión, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo), Reubicación de registrador de fallas .                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Barra B1.1 y Barra B1.2   115kV: Normalización cajas de empalme PT?s 115kV.                                                                                                                                                                                                                                                                          \nUnión Barras B1.1 - B1.2 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s lado de 115kV (2) juegos de tres. Línea Colegio 115kV: Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s 115kV.                                                                                                                                                                                                                          \nLínea Facatativá, Fontibón, Fontibón 2, Mosquera 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s 115kV. Línea Balsilla (S/E Mosquera) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente.\nLínea Balsillas 1 y 2 (S/E Fontibón) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente. Transformador R1  115/34.5kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s  115kV,  levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas.                                                                                          \nTransformador R2  230/34.5kV: Levantamiento eléctrico de control y protección, normalización de caja de empalme CT?s  lado de 230kV, levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo),  Reubicación de registrador de fallas .                                                                                                               \nSubestación: Diseño de cuatro (4 casetas  para control distribuido, a ubicarse en el patio de conexión) y diseño de canalizaciones de control para comunicación de casetas nuevas con canalizaciones existentes.',3,'2017-03-05','2017-12-31','2017-03-29 19:01:36','2017-03-31 11:51:57',1,'PRESUPUESTO PRUEBA','NORMALIZACIÓN DE LA SUBESTACIÓN BALSILLAS CON LA IMPLEMENTACIÓN DE CONTROL DISTRIBUIDO Y PROTECCIONES NUMÉRICAS.','65819371',1,1,100,4),(2,'Servicios Auxiliares AC 208VAC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Alterna  para las casetas de control distribuido.Servicios Auxiliares AC 208VAC: Rediseño de un  (1)  tableros de servicios Auxiliares de corriente Alterna. (Ubicado en la sala principal de la SE). \nServicios Auxiliares DC 125VCC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Continua  para las casetas de control distribuido.Servicios Auxiliares DC 125VCC: Rediseño de dos  (2)  tableros de servicios Auxiliares de corriente Continua .(Ubicado en la sala principal de la SE).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Autotransformador AT1  230/115kV / Autotransformador AT3  230/115kV : Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de nuevo tablero regulador de tensión, reubicación de medidores digitales de frontera lado 230kV ( Principal y Respaldo), Reubicación de registrador de fallas.                                                                                                                                                                                                                                                                                             \nAutotransformador AT2  230/115kV / Autotransformador AT4  230/115kV: Levantamiento eléctrico de control y protección (Lado 115 kV), normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de un (1) nuevo tablero Regulador de tensión, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo), Reubicación de registrador de fallas .                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Barra B1.1 y Barra B1.2   115kV: Normalización cajas de empalme PT?s 115kV.                                                                                                                                                                                                                                                                          \nUnión Barras B1.1 - B1.2 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s lado de 115kV (2) juegos de tres. Línea Colegio 115kV: Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s 115kV.                                                                                                                                                                                                                          \nLínea Facatativá, Fontibón, Fontibón 2, Mosquera 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s 115kV. Línea Balsilla (S/E Mosquera) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente.\nLínea Balsillas 1 y 2 (S/E Fontibón) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente. Transformador R1  115/34.5kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s  115kV,  levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas.                                                                                          \nTransformador R2  230/34.5kV: Levantamiento eléctrico de control y protección, normalización de caja de empalme CT?s  lado de 230kV, levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo),  Reubicación de registrador de fallas .                                                                                                               \nSubestación: Diseño de cuatro (4 casetas  para control distribuido, a ubicarse en el patio de conexión) y diseño de canalizaciones de control para comunicación de casetas nuevas con canalizaciones existentes.',3,'2017-04-10','2017-04-11','2017-03-29 22:12:44','2017-04-10 12:52:25',1,'SEGUNDA PRUEBA','NORMALIZACIÓN DE LA SUBESTACIÓN BALSILLAS CON LA IMPLEMENTACIÓN DE CONTROL DISTRIBUIDO Y PROTECCIONES NUMÉRICAS.','121251180',0,1,100,4),(3,'Servicios Auxiliares AC 208VAC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Alterna  para las casetas de control distribuido.Servicios Auxiliares AC 208VAC: Rediseño de un  (1)  tableros de servicios Auxiliares de corriente Alterna. (Ubicado en la sala principal de la SE). \nServicios Auxiliares DC 125VCC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Continua  para las casetas de control distribuido.Servicios Auxiliares DC 125VCC: Rediseño de dos  (2)  tableros de servicios Auxiliares de corriente Continua .(Ubicado en la sala principal de la SE).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Autotransformador AT1  230/115kV / Autotransformador AT3  230/115kV : Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de nuevo tablero regulador de tensión, reubicación de medidores digitales de frontera lado 230kV ( Principal y Respaldo), Reubicación de registrador de fallas.                                                                                                                                                                                                                                                                                             \nAutotransformador AT2  230/115kV / Autotransformador AT4  230/115kV: Levantamiento eléctrico de control y protección (Lado 115 kV), normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de un (1) nuevo tablero Regulador de tensión, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo), Reubicación de registrador de fallas .                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Barra B1.1 y Barra B1.2   115kV: Normalización cajas de empalme PT?s 115kV.                                                                                                                                                                                                                                                                          \nUnión Barras B1.1 - B1.2 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s lado de 115kV (2) juegos de tres. Línea Colegio 115kV: Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s 115kV.                                                                                                                                                                                                                          \nLínea Facatativá, Fontibón, Fontibón 2, Mosquera 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s 115kV. Línea Balsilla (S/E Mosquera) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente.\nLínea Balsillas 1 y 2 (S/E Fontibón) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente. Transformador R1  115/34.5kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s  115kV,  levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas.                                                                                          \nTransformador R2  230/34.5kV: Levantamiento eléctrico de control y protección, normalización de caja de empalme CT?s  lado de 230kV, levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo),  Reubicación de registrador de fallas .                                                                                                               \nSubestación: Diseño de cuatro (4 casetas  para control distribuido, a ubicarse en el patio de conexión) y diseño de canalizaciones de control para comunicación de casetas nuevas con canalizaciones existentes.',1,'0000-00-00','0000-00-00','2017-03-29 22:22:29',NULL,1,'SEGUNDA PRUEBA  PRESUPUESTO','NORMALIZACIÓN DE LA SUBESTACIÓN BALSILLAS CON LA IMPLEMENTACIÓN DE CONTROL DISTRIBUIDO Y PROTECCIONES NUMÉRICAS.','',1,NULL,1,3),(4,'Servicios Auxiliares AC 208VAC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Alterna  para las casetas de control distribuido.Servicios Auxiliares AC 208VAC: Rediseño de un  (1)  tableros de servicios Auxiliares de corriente Alterna. (Ubicado en la sala principal de la SE). \nServicios Auxiliares DC 125VCC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Continua  para las casetas de control distribuido.Servicios Auxiliares DC 125VCC: Rediseño de dos  (2)  tableros de servicios Auxiliares de corriente Continua .(Ubicado en la sala principal de la SE).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Autotransformador AT1  230/115kV / Autotransformador AT3  230/115kV : Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de nuevo tablero regulador de tensión, reubicación de medidores digitales de frontera lado 230kV ( Principal y Respaldo), Reubicación de registrador de fallas.                                                                                                                                                                                                                                                                                             \nAutotransformador AT2  230/115kV / Autotransformador AT4  230/115kV: Levantamiento eléctrico de control y protección (Lado 115 kV), normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de un (1) nuevo tablero Regulador de tensión, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo), Reubicación de registrador de fallas .                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Barra B1.1 y Barra B1.2   115kV: Normalización cajas de empalme PT?s 115kV.                                                                                                                                                                                                                                                                          \nUnión Barras B1.1 - B1.2 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s lado de 115kV (2) juegos de tres. Línea Colegio 115kV: Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s 115kV.                                                                                                                                                                                                                          \nLínea Facatativá, Fontibón, Fontibón 2, Mosquera 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s 115kV. Línea Balsilla (S/E Mosquera) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente.\nLínea Balsillas 1 y 2 (S/E Fontibón) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente. Transformador R1  115/34.5kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s  115kV,  levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas.                                                                                          \nTransformador R2  230/34.5kV: Levantamiento eléctrico de control y protección, normalización de caja de empalme CT?s  lado de 230kV, levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo),  Reubicación de registrador de fallas .                                                                                                               \nSubestación: Diseño de cuatro (4 casetas  para control distribuido, a ubicarse en el patio de conexión) y diseño de canalizaciones de control para comunicación de casetas nuevas con canalizaciones existentes.',1,'2017-03-05','2018-02-04','2017-03-29 22:29:43',NULL,1,'PRESUPUESTO 1','NORMALIZACIÓN DE LA SUBESTACIÓN BALSILLAS CON LA IMPLEMENTACIÓN DE CONTROL DISTRIBUIDO Y PROTECCIONES NUMÉRICAS.','',1,NULL,119,7),(5,'Servicios Auxiliares AC 208VAC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Alterna  para las casetas de control distribuido.Servicios Auxiliares AC 208VAC: Rediseño de un  (1)  tableros de servicios Auxiliares de corriente Alterna. (Ubicado en la sala principal de la SE). \nServicios Auxiliares DC 125VCC: Diseño de Cuatro (4)  tableros de servicios Auxiliares de corriente Continua  para las casetas de control distribuido.Servicios Auxiliares DC 125VCC: Rediseño de dos  (2)  tableros de servicios Auxiliares de corriente Continua .(Ubicado en la sala principal de la SE).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Autotransformador AT1  230/115kV / Autotransformador AT3  230/115kV : Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de nuevo tablero regulador de tensión, reubicación de medidores digitales de frontera lado 230kV ( Principal y Respaldo), Reubicación de registrador de fallas.                                                                                                                                                                                                                                                                                             \nAutotransformador AT2  230/115kV / Autotransformador AT4  230/115kV: Levantamiento eléctrico de control y protección (Lado 115 kV), normalización de cajas de empalme CT?s lado de 115kV, lado de 230kV, Diseño de un (1) nuevo tablero Regulador de tensión, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo), Reubicación de registrador de fallas .                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Barra B1.1 y Barra B1.2   115kV: Normalización cajas de empalme PT?s 115kV.                                                                                                                                                                                                                                                                          \nUnión Barras B1.1 - B1.2 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s lado de 115kV (2) juegos de tres. Línea Colegio 115kV: Diseño de nuevo tablero de control tipo rack, con protecciones y control numérico, normalización de cajas de empalme CT?s 115kV.                                                                                                                                                                                                                          \nLínea Facatativá, Fontibón, Fontibón 2, Mosquera 115kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s 115kV. Línea Balsilla (S/E Mosquera) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente.\nLínea Balsillas 1 y 2 (S/E Fontibón) 115 kV: Levantamientos eléctricos  para el cambio del esquema de protección y levantamiento  mecánico  de transformadores de corriente. Transformador R1  115/34.5kV: Levantamiento eléctrico de control y protección, normalización de cajas de empalme CT?s  115kV,  levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas.                                                                                          \nTransformador R2  230/34.5kV: Levantamiento eléctrico de control y protección, normalización de caja de empalme CT?s  lado de 230kV, levantamiento eléctrico de señales de protecciones mecánicas y control de ventiladores y cambiador de tomas, Diseño de un (1) nuevo tablero de medidores, reubicación de medidores digitales de frontera lado 230 ( Principal y Respaldo),  Reubicación de registrador de fallas .                                                                                                               \nSubestación: Diseño de cuatro (4 casetas  para control distribuido, a ubicarse en el patio de conexión) y diseño de canalizaciones de control para comunicación de casetas nuevas con canalizaciones existentes.',1,'0000-00-00','0000-00-00','2017-03-29 22:43:32','2017-03-29 18:06:19',1,'PRUEBA','NORMALIZACIÓN DE LA SUBESTACIÓN BALSILLAS CON LA IMPLEMENTACIÓN DE CONTROL DISTRIBUIDO Y PROTECCIONES NUMÉRICAS.','',1,1,100,4);

/*Table structure for table `dt_factura` */

DROP TABLE IF EXISTS `dt_factura`;

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

/*Data for the table `dt_factura` */

/*Table structure for table `dt_soporte` */

DROP TABLE IF EXISTS `dt_soporte`;

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `dt_soporte` */

insert  into `dt_soporte`(`soporte_id`,`soporte_fechacreo`,`soporte_fechamodifico`,`soporte_nombre`,`soporte_tamano`,`soporte_tipo`,`soporte_url`,`soporte_usuariocreo`,`soporte_usuariomodifico`) values (1,'2017-04-06 23:26:05',NULL,'Chrysanthemum.jpg','879394','image/jpeg','lib/docs/Chrysanthemum.jpg',1,NULL),(2,'2017-04-06 23:26:05',NULL,'Jellyfish.jpg','775702','image/jpeg','lib/docs/Jellyfish.jpg',1,NULL),(3,'2017-04-06 23:26:05',NULL,'Penguins.jpg','777835','image/jpeg','lib/docs/Penguins.jpg',1,NULL),(4,'2017-04-06 23:37:03',NULL,'Tulips.jpg','620888','image/jpeg','lib/docs/Tulips.jpg',1,NULL),(5,'2017-04-06 23:38:09',NULL,'Lighthouse.jpg','561276','image/jpeg','lib/docs/Lighthouse.jpg',1,NULL),(6,'2017-04-09 00:28:15',NULL,'arrow_down.png','41521','image/png','lib/docs/arrow_down.png',1,NULL),(7,'2017-04-09 00:49:24',NULL,'bottom.png','43383','image/png','lib/docs/bottom.png',1,NULL),(8,'2017-04-10 16:10:56',NULL,'Koala.jpg','780831','image/jpeg','lib/docs/Koala.jpg',1,NULL),(9,'2017-04-10 16:13:04',NULL,'Desert.jpg','845941','image/jpeg','lib/docs/Desert.jpg',1,NULL),(10,'2017-04-10 16:13:04',NULL,'Hydrangeas.jpg','595284','image/jpeg','lib/docs/Hydrangeas.jpg',1,NULL),(11,'2017-04-10 16:14:28',NULL,'Chrysanthemum.jpg','879394','image/jpeg','lib/docs/Chrysanthemum.jpg',1,NULL),(12,'2017-04-10 16:14:28',NULL,'Desert.jpg','845941','image/jpeg','lib/docs/Desert.jpg',1,NULL),(13,'2017-04-10 16:14:28',NULL,'Hydrangeas.jpg','595284','image/jpeg','lib/docs/Hydrangeas.jpg',1,NULL),(14,'2017-04-10 16:22:55',NULL,'Chrysanthemum.jpg','879394','image/jpeg','lib/docs/Chrysanthemum.jpg',1,NULL),(15,'2017-04-10 16:23:44',NULL,'Hydrangeas.jpg','595284','image/jpeg','lib/docs/Hydrangeas.jpg',1,NULL),(16,'2017-04-10 16:23:45',NULL,'Jellyfish.jpg','775702','image/jpeg','lib/docs/Jellyfish.jpg',1,NULL),(17,'2017-04-17 18:29:25',NULL,'Hoja Membreteada Bogota Color.docx','1191388','application/vnd.openxmlformats-officedocument','lib/docs/Hoja Membreteada Bogota Color.docx',1,NULL),(18,'2017-04-17 20:59:05',NULL,'jennifer cabiativa.pdf','426028','application/pdf','lib/docs/jennifer cabiativa.pdf',0,NULL),(19,'2017-04-17 21:13:58',NULL,'Fase 2 - Desarrollo 1 - 10 Abr.xlsx','74710','application/vnd.openxmlformats-officedocument','lib/docs/Fase 2 - Desarrollo 1 - 10 Abr.xlsx',1,NULL),(20,'2017-04-19 22:57:15',NULL,'mafars194.pdf','185259','application/pdf','lib/docs/mafars194.pdf',1,NULL),(21,'2017-04-19 22:58:37',NULL,'jennifer cabiativa.pdf','426028','application/pdf','lib/docs/jennifer cabiativa.pdf',1,NULL),(22,'2017-04-19 23:04:52',NULL,'jennifer cabiativa.pdf','426028','application/pdf','lib/docs/jennifer cabiativa.pdf',1,NULL),(23,'2017-04-19 23:07:17',NULL,'jennifer cabiativa.pdf','426028','application/pdf','lib/docs/jennifer cabiativa.pdf',1,NULL),(24,'2017-04-19 23:09:37',NULL,'jennifer cabiativa.pdf','426028','application/pdf','lib/docs/jennifer cabiativa.pdf',1,NULL),(25,'2017-04-19 23:17:08',NULL,'actualizar datos de contacto (2).png','276359','image/png','lib/docs/actualizar datos de contacto (2).png',1,NULL),(26,'2017-05-02 22:21:12',NULL,'F1492795219.PDF','0','application/pdf','lib/docs/F1492795219.PDF',1,NULL);

/*Table structure for table `dt_subestacion` */

DROP TABLE IF EXISTS `dt_subestacion`;

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
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;

/*Data for the table `dt_subestacion` */

insert  into `dt_subestacion`(`subestacion_id`,`subestacion_aplicaiva`,`subestacion_codigo`,`subestacion_estado`,`subestacion_fax`,`subestacion_fechacreo`,`subestacion_fechamodifico`,`subestacion_hicom`,`subestacion_nombre`,`subestacion_telefono`,`subestacion_usuariocreo`,`subestacion_usuariomodifico`,`subestacion_ubicacion`) values (1,NULL,'AJ',1,'','2017-03-26 00:12:33',NULL,'6500','ARANJUEZ','5261687/76',NULL,NULL,'cr 24 # 159-80'),(2,NULL,'AU',1,'','2017-03-26 00:12:33',NULL,'6502','AUTOPISTA','2583906/0761',NULL,NULL,'autopista norte calle 129'),(3,NULL,'BA',1,'918276704','2017-03-26 00:12:33',NULL,'6504','BALSILLAS','918276704',NULL,NULL,'carretera la mesa Km 14'),(4,'no','BL',1,'','2017-03-26 00:12:33',NULL,'6506','BOLIVIA','2275669/9711',NULL,1,'autopista medellin cr 110-99'),(5,NULL,'BO',1,'','2017-03-26 00:12:33',NULL,'6508','BOSANOVA','7752006/7760443',NULL,NULL,'cll 57B sur # 71C-03'),(6,NULL,'CA',1,'','2017-03-26 00:12:33',NULL,'6518','CANOAS','7198202/8404',NULL,NULL,'municipio de charquito'),(7,NULL,'CC',1,'','2017-03-26 00:12:33',NULL,'6512','CALLE 51','2853290/2871613',NULL,NULL,'cll 51 # 3-65'),(8,NULL,'CH',1,'','2017-03-26 00:12:33',NULL,'6526','CHARQUITO','7198011',NULL,NULL,'municipio de charquito'),(9,NULL,'CI',1,'2096523','2017-03-26 00:12:33',NULL,'6530','CIRCO','2332585/2907/2096523',NULL,NULL,'Km 3 via choach'),(10,NULL,'CK',1,'','2017-03-26 00:12:33',NULL,'6528','CHICALA','4524992',NULL,NULL,''),(11,NULL,'CL',1,'','2017-03-26 00:12:33',NULL,'6510','CALERA','6340030 ext 1373',NULL,NULL,'municipio la calera via el rodeo mundo nuevo'),(12,NULL,'CN',1,'','2017-03-26 00:12:33',NULL,'6532','CONCORDIA','2437953/8069',NULL,NULL,'cr 1 # 13-85'),(13,NULL,'CO',1,'2215307','2017-03-26 00:12:33',NULL,'6534','DARIO VALENCIA (COLEGIO)','2218762/8867',NULL,NULL,'municipio mesitas del colegio Km 8 via la mesa'),(14,NULL,'CP',1,'','2017-03-26 00:12:33',NULL,'6516','CALLE PRIMERA','2463721/2333367',NULL,NULL,'cll 1 # 14-85'),(15,NULL,'CQ',1,'','2017-03-26 00:12:33',NULL,'0','CAQUEZA','98480269/0333263851',NULL,NULL,'caqueza cundinamarca'),(16,NULL,'CR',1,'','2017-03-26 00:12:33',NULL,'6520','CARRERA QUINTA','2854059/4436',NULL,NULL,'cr 5 # 30-55'),(17,NULL,'CS',1,'','2017-03-26 00:12:33',NULL,'6514','CALLE 67','2483093/2359809',NULL,NULL,'cll 67 # 15-13'),(18,NULL,'CT',1,'','2017-03-26 00:12:33',NULL,'6522','CASTELLANA','2188994/2564813',NULL,NULL,'av 37 # 88B-03'),(19,NULL,'CU',1,'','2017-03-26 00:12:33',NULL,'6524','CENTRO URBANO','2440369/2693606',NULL,NULL,'cll 22F cr 36'),(20,NULL,'EP',1,'','2017-03-26 00:12:33',NULL,'6536','EL PARAISO','2215804 ext 114/646',NULL,NULL,'municipio mesitas del colegio'),(21,NULL,'ES',1,'','2017-03-26 00:12:33',NULL,'6538','EL SOL','9188660101',NULL,NULL,'via zipaquira'),(22,NULL,'FO',1,'','2017-03-26 00:12:33',NULL,'6540','FONTIBON','4155625',NULL,NULL,'cll 31 # 93A-60'),(23,NULL,'GG',1,'','2017-03-26 00:12:33',NULL,'6542','GORGONZOLA','2692532/2374033 ext 201',NULL,NULL,'cll 13 # 39-61'),(24,NULL,'GV',1,'','2017-03-26 00:12:33',NULL,'0','GUAVIO','2216488/6626',NULL,NULL,'municipio de mambita'),(25,NULL,'IN',1,'','2017-03-26 00:12:33',NULL,'0','INDUMIL','7816665',NULL,NULL,'cll 7 # 22A-01 soacha zona industrial'),(26,NULL,'LA',1,'','2017-03-26 00:12:33',NULL,'6548','LAGUNETA','2218723/8887',NULL,NULL,'municipio del tequendama'),(27,NULL,'LG',1,'2215506','2017-03-26 00:12:33',NULL,'6544','LA GUACA','2215506/5212',NULL,NULL,'municipio mesitas del colegio Km 6 via la mesa'),(28,NULL,'LP',1,'','2017-03-26 00:12:33',NULL,'6546','LA PAZ','2611610/2904115',NULL,NULL,'cr 68D # 12B-96'),(29,NULL,'MB',1,'','2017-03-26 00:12:33',NULL,'0','MAMBITA','',NULL,NULL,'municipio de mambita'),(30,NULL,'ME',1,'','2017-03-26 00:12:33',NULL,'0','YALCONIA (MESITAS)','918475340',NULL,NULL,'mesitas del colegio 600 metros via planta El Paraiso'),(31,NULL,'MO',1,'','2017-03-26 00:12:33',NULL,'6552','MOSQUERA','8276158/8931120',NULL,NULL,'carretera occidente Km 18.5 via facatativa'),(32,NULL,'MR',1,'','2017-03-26 00:12:33',NULL,'6550','MORATO','2711093/7971',NULL,NULL,'transversal 49 # 98-11'),(33,NULL,'MU',1,'','2017-03-26 00:12:33',NULL,'6554','MUÃ‘A','7198511',NULL,NULL,'zona industria mu'),(34,NULL,'MUIII',1,'','2017-03-26 00:12:33',NULL,'6556','MUÃ‘A III','7198011/8202',NULL,NULL,'municipio de charquito'),(35,NULL,'MZ',1,'','2017-03-26 00:12:33',NULL,'6558','MUZU','2027484/2036300',NULL,NULL,'av 30 # 31-59 sur'),(36,NULL,'NO',1,'918247707','2017-03-26 00:12:33',NULL,'6560','NOROESTE','918247705/06/07/08/09/10',NULL,NULL,'via subachoque (prolongacion calle 80 al occidente, 2Km al occidente del reten de siberia, costado i'),(37,NULL,'PB',1,'','2017-03-26 00:12:33',NULL,'0','PUENTE BOSA','2382488',NULL,NULL,'autopista sur # 67-20'),(38,NULL,'SA',1,'','2017-03-26 00:12:33',NULL,'6564','SALITRE','2216701/conmutador ext 5352',NULL,NULL,'diagonal 53 # 57-62'),(39,NULL,'SC',1,'','2017-03-26 00:12:33',NULL,'6570','SAN CARLOS','2093335/2783909',NULL,NULL,'cll 32 sur # 16-00'),(40,NULL,'SF',1,'','2017-03-26 00:12:33',NULL,'6572','SAN FACON','3415114/2433993',NULL,NULL,'cr 19 # 19-81'),(41,NULL,'SI',1,'','2017-03-26 00:12:33',NULL,'6566','SALTO','2218948/68',NULL,NULL,'municipio del tequendama, vereda arracachal'),(42,NULL,'SJ',1,'','2017-03-26 00:12:33',NULL,'6574','SAN JOSE','2373415/2475015',NULL,NULL,'cr 20 # 11-24'),(43,NULL,'SK',1,'','2017-03-26 00:12:33',NULL,'0','SIMIJACA','918555521',NULL,NULL,'cr 8 # 11-25 municipio de simijaca'),(44,NULL,'SM',1,'7812420','2017-03-26 00:12:33',NULL,'6576','SAN MATEO','7812420/72',NULL,NULL,'urb. San mateo heroes supermanzana D1 cll 27N # 5-10 este soacha'),(45,NULL,'SO',1,'','2017-03-26 00:12:33',NULL,'0','SOACHA','7812428/4049',NULL,NULL,'cll 11 # 3A-01'),(46,NULL,'SQ',1,'','2017-03-26 00:12:33',NULL,'0','SESQUILE','CEL 2933031',NULL,NULL,'poblacion de sesquile'),(47,NULL,'SU',1,'','2017-03-26 00:12:33',NULL,'6578','SUBA','6718592/8652',NULL,NULL,'cll 170 cr 73'),(48,NULL,'TB',1,'','2017-03-26 00:12:33',NULL,'6586','TIBABUYES','6899793',NULL,NULL,'cr 108A # 122-40'),(49,NULL,'TE',1,'','2017-03-26 00:12:33',NULL,'6580','TECHO','2929001/5467',NULL,NULL,'transversal 85 cll 29 sur'),(50,NULL,'TJ',1,'','2017-03-26 00:12:33',NULL,'6582','TENJO','918646121',NULL,NULL,'municipio de tenjo, vereda poveda II, finca churruscones'),(51,NULL,'TO',1,'','2017-03-26 00:12:33',NULL,'6588','TORCA','6711977/6725459',NULL,NULL,'Km 16 autonorte, jardines de La paz'),(52,NULL,'TU',1,'2704155','2017-03-26 00:12:33',NULL,'6590','TUNAL','2704077/4155',NULL,NULL,'avenida boyaca parque tunal'),(53,NULL,'TZ',1,'','2017-03-26 00:12:33',NULL,'6584','TERMOZIPA','2218883/5983',NULL,NULL,'tocancipa verede verganzo Km 34 autopista norte'),(54,NULL,'UB',1,'','2017-03-26 00:12:33',NULL,'6609','UBATE','918890483',NULL,NULL,'municipio de ubate'),(55,NULL,'UM',1,'','2017-03-26 00:12:33',NULL,'6594','USME','2004010',NULL,NULL,'transversal 3H # 68A-41 sur'),(56,NULL,'US',1,'','2017-03-26 00:12:33',NULL,'6592','USAQUEN','2134723/3379',NULL,NULL,'cll 100 # 14-90'),(57,NULL,'VE',1,'','2017-03-26 00:12:33',NULL,'6596','VERAGUAS','2479842/2778126',NULL,NULL,'cll 3 cr 35'),(58,NULL,'VI',1,'','2017-03-26 00:12:33',NULL,'6598','VICTORIA','2060274/0400',NULL,NULL,'cr 1 este # 47-31 sur'),(59,NULL,'VT',1,'','2017-03-26 00:12:33',NULL,'0','VILLETA','918445100',NULL,NULL,'municipio de villeta, frente a Ecopetrol'),(60,NULL,'ZP',1,'','2017-03-26 00:12:33',NULL,'6600','ZIPAQUIRA','',NULL,NULL,'municipio zipaquira, contiguo dpto. Adminstrativo de transito y transporte (DATT)'),(61,NULL,'NA',1,'','2017-03-26 00:12:33',NULL,'0','NELSON ALONSO','',NULL,NULL,''),(62,NULL,'CH',1,'','2017-03-26 00:12:33',NULL,'0','CHIA','',NULL,NULL,''),(63,NULL,'FA',1,NULL,'2017-03-26 00:12:33',NULL,NULL,'FACATATIVA',NULL,NULL,NULL,NULL),(64,NULL,'UL',1,NULL,'2017-03-26 00:12:33',NULL,NULL,'UBALA',NULL,NULL,NULL,NULL),(65,NULL,'SE',1,'','2017-03-26 00:12:33',NULL,'0','SERVITA','',NULL,NULL,''),(66,NULL,'LEYD',1,'','2017-03-26 00:12:33',NULL,'0','LA ESTACION Y DISTRIBUCION','',NULL,NULL,''),(67,NULL,'BR',1,'','2017-03-26 00:12:33',NULL,'0','BRICEÃ‘O','',NULL,NULL,''),(68,NULL,'BTS',1,'','2017-03-26 00:12:33',NULL,'0','POWER NUSS','',NULL,NULL,''),(69,NULL,'SB',1,'','2017-03-26 00:12:33',NULL,'0','SIBERIA','',NULL,NULL,''),(70,NULL,'PDR',1,'','2017-03-26 00:12:33',NULL,'0','PAZ DEL RIO','',NULL,NULL,'DUITAMA  BOYACA'),(71,NULL,'VA',1,'7470390','2017-03-26 00:12:33',NULL,'0','VIDRIO ANDINO','7470390',NULL,NULL,'Km 6,5 Via Soacha MondoÃ±edo'),(72,NULL,'VARIAS',1,'','2017-03-26 00:12:33',NULL,'0','VARIAS','',NULL,NULL,'VARIAS'),(73,NULL,'AL',1,NULL,'2017-03-26 00:12:33',NULL,NULL,'ALQUERIA',NULL,NULL,NULL,NULL),(74,NULL,'CHH',1,'','2017-03-26 00:12:33',NULL,'0','CHOACHI','',NULL,NULL,'CUNDINAMARCA'),(75,NULL,'GS',1,'','2017-03-26 00:12:33',NULL,'0','GRAN SABANA','',NULL,NULL,'TOCANCIPA'),(76,NULL,'CZ',1,'','2017-03-26 00:12:33',NULL,'0','EL CORZO','',NULL,NULL,'MUNICIPIO EL ROSAL'),(77,NULL,'AE',1,'','2017-03-26 00:12:33',NULL,'0','AEROPUERTO','',NULL,NULL,'BOGOTA'),(78,NULL,'DI',1,'','2017-03-26 00:12:33',NULL,'0','DIAMANTE','DIAMANTE',NULL,NULL,'GIRARDOT'),(79,NULL,'SAU',1,'','2017-03-26 00:12:33',NULL,'0','SAUCES','',NULL,NULL,'FUSAGASUGA'),(80,NULL,'IS',1,'','2017-03-26 00:12:33',NULL,'0','ISLA','',NULL,NULL,'RICAURTE'),(81,NULL,'PO',1,'','2017-03-26 00:12:33',NULL,'0','PACHO','',NULL,NULL,'PACHO'),(82,NULL,'BM',1,'','2017-03-26 00:12:33',NULL,'0','BALMORAL','',NULL,NULL,'FUSAGASUGA'),(83,NULL,'PÃ‘',1,'','2017-03-26 00:12:33',NULL,'0','EL PEÃ‘ON','',NULL,NULL,'GIRARDOT'),(84,NULL,'MG',1,'','2017-03-26 00:12:33',NULL,'0','LOS MANGOS','',NULL,NULL,'GIRARDOT'),(85,NULL,'RI',1,'X','2017-03-26 00:12:33',NULL,'0','RIONEGRO','X',NULL,NULL,'PUERTO SALGAR CUND'),(86,NULL,'FM',1,'X','2017-03-26 00:12:33',NULL,'0','FOMEQUE','X',NULL,NULL,'CUNDINAMARCA'),(87,NULL,'GU',1,'X','2017-03-26 00:12:33',NULL,'0','GUADUAS','X',NULL,NULL,'CUNDINAMARCA'),(88,NULL,'PA',1,'X','2017-03-26 00:12:33',NULL,'0','PALOS','X',NULL,NULL,'BUCARAMANGA KM6 COSTA'),(89,NULL,'SBCH',1,'','2017-03-26 00:12:33',NULL,'0','SUBACHOQUE','',NULL,NULL,'CUNDINAMARCA'),(90,NULL,'COL',1,'','2017-03-26 00:12:33',NULL,'0','COLEGIO','',NULL,NULL,'MESITAS'),(91,NULL,'EEC',1,'','2017-03-26 00:12:33',NULL,'0','EEC ','',NULL,NULL,''),(92,NULL,'SBL',1,'','2017-03-26 00:12:33',NULL,'0','SABANILLA','',NULL,NULL,'TENJO'),(93,NULL,'CM',1,'','2017-03-26 00:12:33',NULL,'0','COMPARTIR','',NULL,NULL,'CUNDINAMARCA'),(94,NULL,'TS',1,'','2017-03-26 00:12:33',NULL,'0','TAUSA','',NULL,NULL,'TAUSA'),(95,NULL,'RA',1,'X','2017-03-26 00:12:33',NULL,'0','RABANAL','X',NULL,NULL,'CUNDINAMARCA'),(96,NULL,'CJ',1,'','2017-03-26 00:12:33',NULL,'0','CAJICÃ','',NULL,NULL,'CAJICÃ'),(97,NULL,'ER',1,'','2017-03-26 00:12:33',NULL,'0','EL ROSAL','',NULL,NULL,'CUNDINAMARCA'),(98,NULL,'ar',1,'s','2017-03-26 00:12:33',NULL,'0','armenia','s',NULL,NULL,'manizalez'),(99,NULL,'TEU',1,'','2017-03-26 00:12:33',NULL,'0','TERMINAL UNICA','',NULL,NULL,'CUNDINAMARCA'),(100,NULL,'AN',1,'','2017-03-26 00:12:33',NULL,'0','AERONAUTICA','',NULL,NULL,'CUNDINAMARCA'),(101,NULL,'BC',1,'','2017-03-26 00:12:33',NULL,'0','BACATÃ','',NULL,NULL,'CUNDINAMARCA'),(102,NULL,'CHO',1,'','2017-03-26 00:12:33',NULL,'0','CHOACHÃ','',NULL,NULL,''),(103,NULL,'SFR',1,'','2017-03-26 00:12:33',NULL,'0','SAN FRANCISCO','',NULL,NULL,''),(104,NULL,'EPE',1,'','2017-03-26 00:12:33',NULL,'0','EL PEÃ‘Ã“N','',NULL,NULL,''),(105,NULL,'AB',1,'','2017-03-26 00:12:33',NULL,'0','ARBOLEDA','',NULL,NULL,'CUNDINAMARCA'),(106,NULL,'TI',1,'','2017-03-26 00:12:33',NULL,'0','TIPICA','',NULL,NULL,'BTA'),(107,NULL,'PQ',1,'','2017-03-26 00:12:33',NULL,'0','PUENTEQUETAME','',NULL,NULL,'META'),(108,NULL,'QT',1,'','2017-03-26 00:12:33',NULL,'0','QUETAME','',NULL,NULL,''),(109,NULL,'BARR',1,'','2017-03-26 00:12:33',NULL,'0','BR','',NULL,NULL,''),(110,NULL,'WS',1,'','2017-03-26 00:12:33',NULL,'0','W','',NULL,NULL,''),(111,NULL,'G&J',1,'','2017-03-26 00:12:33',NULL,'0','G&J','',NULL,NULL,'BARRANQUILLA'),(112,NULL,'VN',1,'','2017-03-26 00:12:33',NULL,'0','VIANÃ','',NULL,NULL,''),(113,NULL,'CPP',1,'','2017-03-26 00:12:33',NULL,'0','CAPARRAPÃ','',NULL,NULL,''),(114,NULL,'FL',1,'','2017-03-26 00:12:33',NULL,'0','FLORIDA','',NULL,NULL,''),(115,NULL,'FLAND',1,'','2017-03-26 00:12:33',NULL,'0','FLANDES','',NULL,NULL,''),(116,NULL,'TER',1,'','2017-03-26 00:12:33',NULL,'0','TERMINAL ','',NULL,NULL,''),(117,NULL,'COTA',1,'','2017-03-26 00:12:33',NULL,'0','COTA','',NULL,NULL,''),(118,NULL,'CODM',1,'','2017-03-26 00:12:33',NULL,'0','CÃ“DIGO MEDIDA','',NULL,NULL,''),(119,'no','AGRO',1,'','2017-03-26 00:12:33','2017-03-26 00:18:29','0','AGROBETAÑA','',NULL,1,''),(120,NULL,'GT',1,'','2017-03-26 00:12:33',NULL,'0','GUATAQUÃ','',NULL,NULL,''),(121,NULL,'LM',1,'','2017-03-26 00:12:33',NULL,'0','LA MESA','',NULL,NULL,''),(122,NULL,'NC',1,'','2017-03-26 00:12:33',NULL,'0','NEMOCÃ“N','',NULL,NULL,''),(123,NULL,'NTC',1,'','2017-03-26 00:12:33',NULL,'0','NUEVA TERMINAL DE CARGA','',NULL,NULL,''),(124,NULL,'GCT',1,'','2017-03-26 00:12:33',NULL,'0','GUACHETÃ','',NULL,NULL,''),(125,NULL,'SCA',1,'','2017-03-26 00:12:33',NULL,'0','SUESCA','',NULL,NULL,''),(126,NULL,'CHEC',1,'','2017-03-26 00:12:33',NULL,'0','CHEC','',NULL,NULL,''),(127,NULL,'CHOCON',1,'','2017-03-26 00:12:33',NULL,'0','CHOCONTÃ','',NULL,NULL,''),(128,NULL,'ARB',1,'','2017-03-26 00:12:33',NULL,'0','ARBELÃEZ','',NULL,NULL,''),(129,NULL,'SG',1,'','2017-03-26 00:12:33',NULL,'0','SOGAMOSO','',NULL,NULL,''),(256,'no','JJ',1,'0','2017-03-26 05:12:06',NULL,'0','PRUEBA','234',1,NULL,'prueba');

/*Table structure for table `dt_usuario` */

DROP TABLE IF EXISTS `dt_usuario`;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `dt_usuario` */

insert  into `dt_usuario`(`usuario_id`,`usuario_afp`,`usuario_apellidos`,`usuario_arp`,`usuario_cajacomp`,`usuario_cargo`,`usuario_cedula`,`usuario_celular`,`usuario_condicionmedica`,`usuario_contrato`,`usuario_conyuge`,`usuario_correo`,`usuario_clasesalario`,`usuario_ctconduccion`,`usuario_direccion`,`usuario_eps`,`usuario_estado`,`usuario_expedicion`,`usuario_fechacreo`,`usuario_fechamodifico`,`usuario_fenacimiento`,`usuario_fentregacarp`,`usuario_fentregaceps`,`usuario_fentregacempresa`,`usuario_fentregaccodensa`,`usuario_fincontrato`,`usuario_horario`,`usuario_jornada`,`usuario_iniarp`,`usuario_iniafp`,`usuario_inicajacomp`,`usuario_inieps`,`usuario_inicontrato`,`usuario_inilaboral`,`usuario_lugnacimiento`,`usuario_matricula`,`usuario_nombre`,`usuario_nombrehijos`,`usuario_numcuenta`,`usuario_numhijos`,`usuario_numcontrato`,`usuario_observaciones`,`usuario_password`,`usuario_prompactado`,`usuario_porcentajearp`,`usuario_profesion`,`usuario_riesgoarp`,`usuario_RH`,`usuario_rol`,`usuario_salario`,`usuario_Tchaqueta`,`usuario_Tchaleco`,`usuario_Tcamisa`,`usuario_Tcamiseta`,`usuario_Tpantalon`,`usuario_Tcalzado`,`usuario_telefono`,`usuario_tipocontrato`,`usuario_tp`,`usuario_universidad`,`usuario_usuariocreo`,`usuario_usuariomodifico`) values (1,NULL,'ADMINISTRADOR','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Admin',NULL,NULL,NULL,NULL,'1',NULL,'2017-02-25 20:36:34','2017-02-26 05:44:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SISTEMA',NULL,NULL,NULL,NULL,NULL,'ee6d941274acaf7244125336fa9acb79cf197be1db7f604d3ebb828b79179382f22e850587c9c7d9d71ac22f797c92d28b64d7298184557c17075dd05f69dc95',NULL,NULL,NULL,NULL,NULL,'ADMINISTRADOR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(2,NULL,'cabiativa',NULL,NULL,'INGENIERO SISTEMAS',2147483647,233232,NULL,NULL,NULL,'jennifer@gmail.com',NULL,NULL,'CRR 123',NULL,'1',NULL,'2017-02-26 08:33:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jennifer',NULL,NULL,NULL,NULL,NULL,'ee6d941274acaf7244125336fa9acb79cf197be1db7f604d3ebb828b79179382f22e850587c9c7d9d71ac22f797c92d28b64',NULL,NULL,'INGENIERO SISTEMAS',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,23443434,NULL,'2343434',NULL,1,NULL),(3,NULL,'perez',NULL,NULL,'INGENIERO SISTEMAS',12323,2147483647,NULL,NULL,NULL,'maria@gmail.com',NULL,NULL,'DIG 123',NULL,'1',NULL,'2017-02-28 03:20:35',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'maria',NULL,NULL,NULL,NULL,NULL,'ee6d941274acaf7244125336fa9acb79cf197be1db7f604d3ebb828b79179382f22e850587c9c7d9d71ac22f797c92d28b64d7298184557c17075dd05f69dc95',NULL,NULL,'INGENIERO SISTEMAS',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2147483647,NULL,'',NULL,1,NULL),(4,NULL,'apellido',NULL,NULL,'INGENIERO SISTEMASM',86870000,1111110,NULL,NULL,NULL,'mjennifer@gmail.com',NULL,NULL,'CRR 123 12',NULL,'1',NULL,'2017-02-28 04:55:38','2017-03-01 04:06:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'modificar',NULL,NULL,NULL,NULL,NULL,'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e',NULL,NULL,'INGENIERO SISTEMASM',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2147483647,NULL,'2343434000',NULL,1,1),(5,NULL,'prueba',NULL,NULL,'VENTAS',123232323,1212121212,NULL,NULL,NULL,'njennifer@gmail.com',NULL,NULL,'CRR 123 # 212',NULL,'1',NULL,'2017-03-01 04:13:15','2017-03-01 04:15:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'usuario',NULL,NULL,NULL,NULL,NULL,'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e',NULL,NULL,'VENTAS',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1010101010,NULL,'',NULL,1,1),(6,NULL,'nuñés',NULL,NULL,NULL,558555555,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,'2017-06-02 11:26:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'maría',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `pt_alcance_subactividad` */

DROP TABLE IF EXISTS `pt_alcance_subactividad`;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `pt_alcance_subactividad` */

insert  into `pt_alcance_subactividad`(`alcancesubactividad_id`,`alcancesubactividad_estado`,`alcancesubactividad_fechacreo`,`alcancesubactividad_fechamodifico`,`alcancesubactividad_usuariocreo`,`alcancesubactividad_usuariomodifico`,`alcance_id`,`detalleactividad_id`) values (1,1,'2017-03-22 22:42:32','2017-03-23 00:33:42',1,1,3,4),(2,1,'2017-03-22 22:43:04','2017-03-22 23:24:50',1,1,2,4),(3,1,'2017-03-22 22:44:01',NULL,1,NULL,1,4),(4,1,'2017-03-23 00:37:37',NULL,1,NULL,2,5),(5,1,'2017-03-23 19:34:18',NULL,1,NULL,3,8);

/*Table structure for table `pt_baremo` */

DROP TABLE IF EXISTS `pt_baremo`;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `pt_baremo` */

insert  into `pt_baremo`(`baremo_id`,`baremo_estado`,`baremo_fechacreo`,`baremo_fechamodifico`,`baremo_item`,`baremo_totalsinIva`,`baremo_unidadservicio`,`baremo_usuariocreo`,`baremo_usuariomodifico`,`baremo_valorservicio`,`baremo_valortotalAct`,`cliente_id`,`labor_id`,`tipobaremo_id`) values (1,1,'2017-03-20 17:52:29','2017-03-23 04:14:40','M-1','25878218','C/U',1,1,'791','25878218',1,1,1),(2,1,'2017-03-23 17:38:03','2017-03-23 17:39:42','L-1','16161618','C/U',1,1,'494','16161618',1,5,3);

/*Table structure for table `pt_baremo_actividad` */

DROP TABLE IF EXISTS `pt_baremo_actividad`;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `pt_baremo_actividad` */

insert  into `pt_baremo_actividad`(`baremoactividad_id`,`baremoactividad_estado`,`baremoactividad_fechacreo`,`baremoactividad_fechamodifico`,`baremoactividad_usuariocreo`,`baremoactividad_usuariomodifico`,`actividad_id`,`baremo_id`) values (1,1,'2017-03-20 22:13:56',NULL,0,NULL,1,1),(2,1,'2017-03-20 22:15:22',NULL,0,NULL,4,1),(3,1,'2017-03-20 22:23:03',NULL,1,NULL,5,1),(6,1,'2017-03-23 17:39:05',NULL,1,1,2,2),(8,1,'2017-03-27 19:02:05',NULL,1,NULL,7,1),(9,1,'2017-03-31 03:01:03',NULL,1,NULL,8,1);

/*Table structure for table `pt_descargo` */

DROP TABLE IF EXISTS `pt_descargo`;

CREATE TABLE `pt_descargo` (
  `descargo_id` int(11) NOT NULL AUTO_INCREMENT,
  `descargo_actividad` varchar(5000) DEFAULT NULL,
  `descargo_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `descargo_fechamodifico` datetime DEFAULT NULL,
  `descargo_riesgo` varchar(2000) DEFAULT NULL,
  `descargo_usuariocreo` varchar(45) DEFAULT NULL,
  `descargo_usuariomodifico` varchar(45) DEFAULT NULL,
  `ordentrabajo_id` int(11) DEFAULT NULL,
  `presupuesto_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`descargo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `pt_descargo` */

insert  into `pt_descargo`(`descargo_id`,`descargo_actividad`,`descargo_fechacreo`,`descargo_fechamodifico`,`descargo_riesgo`,`descargo_usuariocreo`,`descargo_usuariomodifico`,`ordentrabajo_id`,`presupuesto_id`) values (1,'descargo prueba modificacion','2017-04-17 22:56:58','2017-06-07 15:46:48','sin riesgo cambio','1','1',1,33),(2,'validar actividades de descargo','2017-04-17 22:57:19','2017-06-07 15:44:56','con riesgo VYP','1','1',1,43);

/*Table structure for table `pt_detalle_actividad` */

DROP TABLE IF EXISTS `pt_detalle_actividad`;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `pt_detalle_actividad` */

insert  into `pt_detalle_actividad`(`detalleactividad_id`,`detallesubactividad_costosinIva`,`detalleactividad_estado`,`detalleactividad_fechacreo`,`detalleactividad_fechamodifico`,`detalleactividad_iva`,`detallesubactividad_porc`,`detalleactividad_usuariocreo`,`detalleactividad_usuariomodifico`,`actividad_id`,`baremoactividad_id`,`subactividad_id`) values (1,'4514784',1,'2017-03-20 23:07:05',NULL,NULL,'0.7',1,NULL,5,1,1),(2,'3160349',1,'2017-03-20 23:10:41',NULL,NULL,'0.3',1,NULL,5,1,2),(3,'2100356',1,'2017-03-20 23:36:28',NULL,NULL,'0.3',1,NULL,4,3,1),(4,'1354435',0,'2017-03-21 00:33:36','2017-03-23 03:39:28',NULL,'0.3',1,1,5,3,1),(5,'3160349',1,'2017-03-21 00:36:54',NULL,NULL,'0.7',1,NULL,5,3,3),(6,'2800475',1,'2017-03-22 19:54:51',NULL,NULL,'0.4',1,NULL,4,2,1),(7,'2149430',1,'2017-03-23 03:08:37','2017-03-23 03:39:57',NULL,'0.3',1,1,1,1,1),(8,'2970597',1,'2017-03-23 19:34:09',NULL,NULL,'0.4',1,NULL,2,6,0),(9,'5015336',1,'2017-03-27 18:54:56',NULL,NULL,'0.7',1,NULL,1,1,3),(10,'50000000',1,'2017-03-31 03:49:04',NULL,NULL,'1',1,NULL,8,9,0);

/*Table structure for table `pt_detalle_factura` */

DROP TABLE IF EXISTS `pt_detalle_factura`;

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

/*Data for the table `pt_detalle_factura` */

/*Table structure for table `pt_detalle_subactividad` */

DROP TABLE IF EXISTS `pt_detalle_subactividad`;

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

/*Data for the table `pt_detalle_subactividad` */

/*Table structure for table `pt_entregable_subactividad` */

DROP TABLE IF EXISTS `pt_entregable_subactividad`;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `pt_entregable_subactividad` */

insert  into `pt_entregable_subactividad`(`entregablesubactividad_id`,`entregablesubactividad_estado`,`entregablesubactividad_fechacreo`,`entregablesubactividad_fechamodifico`,`entregablesubactividad_usuariocreo`,`entregablesubactividad_usuariomodifico`,`entregable_id`,`detalleactividad_id`) values (1,1,'2017-03-23 01:59:16','2017-03-23 02:01:24',1,1,2,4),(2,1,'2017-03-23 01:59:22','2017-03-23 02:01:27',1,1,1,4),(3,1,'2017-03-23 03:40:07',NULL,1,NULL,2,7),(4,1,'2017-03-23 03:40:22',NULL,1,NULL,2,5);

/*Table structure for table `pt_menu_perfil` */

DROP TABLE IF EXISTS `pt_menu_perfil`;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `pt_menu_perfil` */

insert  into `pt_menu_perfil`(`menuperfil_id`,`menuperfil_estado`,`menuperfil_fechacreo`,`menuperfil_fechamodifico`,`menuperfil_usuariocreo`,`menuperfil_usuariomodifico`,`menu_id`,`perfil_id`) values (1,1,'2017-02-25 23:01:45',NULL,1,NULL,1,1),(2,1,'2017-02-25 23:02:08',NULL,1,NULL,2,1),(3,1,'2017-02-25 23:02:30',NULL,1,NULL,3,1),(4,1,'2017-03-11 20:49:42',NULL,1,NULL,8,1),(5,1,'2017-03-17 18:59:00',NULL,NULL,NULL,9,1),(6,1,'2017-03-17 18:59:00',NULL,NULL,NULL,10,1),(7,1,'2017-03-25 21:05:27',NULL,NULL,NULL,11,1),(8,1,'2017-04-05 18:53:45',NULL,1,NULL,14,1),(9,1,'2017-04-05 19:21:48',NULL,NULL,NULL,14,3),(10,1,'2017-04-19 22:23:05',NULL,NULL,NULL,12,1),(11,1,'2017-04-19 22:23:05',NULL,NULL,NULL,13,1),(12,1,'2017-04-19 22:24:49',NULL,NULL,NULL,4,1),(13,1,'2017-04-19 22:24:49',NULL,NULL,NULL,7,1),(14,1,'2017-04-19 22:25:53',NULL,NULL,NULL,15,1),(15,1,'2017-04-19 22:25:53',NULL,NULL,NULL,16,1),(16,1,'2017-04-19 22:26:39',NULL,NULL,NULL,15,3),(17,1,'2017-04-19 22:32:07',NULL,NULL,NULL,14,2),(18,1,'2017-04-19 22:32:07',NULL,NULL,NULL,15,2),(19,1,'2017-05-02 22:40:21',NULL,NULL,NULL,17,1),(20,1,'2017-05-02 22:53:04',NULL,NULL,NULL,18,1);

/*Table structure for table `pt_orden_trabajo` */

DROP TABLE IF EXISTS `pt_orden_trabajo`;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `pt_orden_trabajo` */

insert  into `pt_orden_trabajo`(`ordentrabajo_id`,`ordentrabajo_contratista`,`ordentrabajo_estado`,`ordentrabajo_fechacreo`,`ordentrabajo_fechaemision`,`ordentrabajo_fechaini`,`ordentrabajo_fechamodifico`,`ordentrabajo_GOM`,`ordentrabajo_num`,`ordentrabajo_obs`,`ordentrabajo_usuariocreo`,`ordentrabajo_usuariomodifico`,`detallepresupuesto_id`) values (1,'AC ENERGY',NULL,'2017-04-03 22:32:35','2017-04-03','2017-04-03','2017-04-17 22:16:38','GMR','01','PRUEBA',1,1,1),(2,'ENERGY AC','1','2017-04-10 17:55:03','2017-04-10','2017-06-30',NULL,'ERTRTER','OT2','segunta prueba seguimiento',1,NULL,2);

/*Table structure for table `pt_perfil_usuario` */

DROP TABLE IF EXISTS `pt_perfil_usuario`;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `pt_perfil_usuario` */

insert  into `pt_perfil_usuario`(`perfilusuario_id`,`perfilusuario_estado`,`perfilusuario_fechacreo`,`perfilusuario_fechamodifico`,`perfilusuario_usuariocreo`,`perfilusuario_usuariomodifico`,`area_id`,`perfil_id`,`usuario_id`) values (1,1,'2017-02-25 20:30:51',NULL,1,NULL,1,1,1),(2,1,'2017-02-25 20:31:33',NULL,1,NULL,3,2,1),(3,1,'2017-02-25 20:32:20',NULL,1,NULL,2,3,1),(4,1,'2017-02-25 20:53:40',NULL,NULL,NULL,2,2,1),(7,1,'2017-03-09 03:27:07',NULL,1,NULL,1,1,2),(8,1,'2017-06-02 12:45:53',NULL,1,NULL,1,1,6),(9,1,'2017-06-02 12:45:53',NULL,1,NULL,1,2,6),(10,1,'2017-06-02 12:45:54',NULL,1,NULL,1,3,6);

/*Table structure for table `pt_prerfil_usuario` */

DROP TABLE IF EXISTS `pt_prerfil_usuario`;

CREATE TABLE `pt_prerfil_usuario` (
  `perfilusuario_id` int(11) NOT NULL,
  `perfilusuario_estado` int(5) DEFAULT '1',
  `perfilusuario_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `perfilusuario_fechamodifico` timestamp NULL DEFAULT NULL,
  `perfilusuario_usuariocreo` int(11) DEFAULT NULL,
  `perfilusuario_usuariomodifico` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `perfil_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`perfilusuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pt_prerfil_usuario` */

/*Table structure for table `pt_presupuesto` */

DROP TABLE IF EXISTS `pt_presupuesto`;

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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

/*Data for the table `pt_presupuesto` */

insert  into `pt_presupuesto`(`presupuesto_id`,`presupuesto_alcances`,`presupuesto_encargado`,`presupuesto_entregables`,`presupuesto_asignadopor`,`presupuesto_estado`,`presupuesto_fechaini`,`presupuesto_fechafin`,`presupuesto_fechacreo`,`presupuesto_fechamodifico`,`presupuesto_horaini`,`presupuesto_horafin`,`presupuesto_obs`,`presupuesto_porcentaje`,`presupuesto_progestado`,`presupuesto_usuariocreo`,`presupuesto_usuariomodifico`,`presupuesto_valorporcentaje`,`area_id`,`detallepresupuesto_id`,`baremoactividad_id`,`baremo_id`,`detalleactividad_id`,`modulo_id`,`tipobaremo_id`) values (26,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-29 22:49:17','2017-03-29 18:10:31',NULL,NULL,'Labor asimilada para el diseño de canalizaciones de control para comunicacion de casetas nuevas con canalizaciones existentes. Incuye cárcamos, bancos de ductos y cajas de inspección. Factor 72 = 48 H.H Diseñador +  24 H.H  Revisión)','0.3',NULL,1,1,'2149430',NULL,5,1,1,7,1,1),(27,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-29 22:49:17','2017-03-29 18:10:31',NULL,NULL,'Labor asimilada para el diseño de canalizaciones de control para comunicacion de casetas nuevas con canalizaciones existentes. Incuye cárcamos, bancos de ductos y cajas de inspección. Factor 72 = 48 H.H Diseñador +  24 H.H  Revisión)','0.7',NULL,1,1,'5015336',NULL,5,1,1,9,1,1),(28,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-29 22:49:17','2017-03-29 18:10:31',NULL,NULL,'Labor asimilada para el diseño de canalizaciones de control para comunicacion de casetas nuevas con canalizaciones existentes. Incuye cárcamos, bancos de ductos y cajas de inspección. Factor 72 = 48 H.H Diseñador +  24 H.H  Revisión)','0.4',NULL,1,1,'2800475',NULL,5,2,1,6,1,1),(29,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-29 22:49:17','2017-03-29 18:10:31',NULL,NULL,'Labor asimilada para el diseño de canalizaciones de control para comunicacion de casetas nuevas con canalizaciones existentes. Incuye cárcamos, bancos de ductos y cajas de inspección. Factor 72 = 48 H.H Diseñador +  24 H.H  Revisión)','0.7',NULL,1,1,'3160349',NULL,5,3,1,5,1,1),(30,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-29 22:49:17','2017-03-29 18:10:31',NULL,NULL,'Labor asimilada para el diseño de canalizaciones de control para comunicacion de casetas nuevas con canalizaciones existentes. Incuye cárcamos, bancos de ductos y cajas de inspección. Factor 72 = 48 H.H Diseñador +  24 H.H  Revisión)','1',NULL,1,1,'10000000',NULL,5,8,1,0,1,1),(32,NULL,NULL,NULL,NULL,0,NULL,NULL,'2017-03-29 22:54:30','2017-03-30 02:54:22',NULL,NULL,'Diseño de cuatro (4) casetas de control distribuido en patio.','1',NULL,1,1,'0',NULL,5,6,2,0,1,3),(33,'',1,'',1,1,'2017-04-06','2017-04-04','2017-03-30 06:22:20','2017-04-19 18:10:49','10:53 AM','8:00 PM','Labor asimilada para el diseño de canalizaciones de control para comunicacion de casetas nuevas con canalizaciones existentes. Incuye cárcamos, bancos de ductos y cajas de inspección. Factor 72 = 48 H.H Diseñador +  24 H.H  Revisión)','0.4','FINALIZADA',1,1,'2865906',1,1,1,1,7,1,1),(34,'',3,'',1,1,'2017-04-12','2017-05-01','2017-03-30 06:22:20','2017-05-05 10:28:53','11:18 AM','2:18 PM','prueba','0.7','FACTURA PARCIAL',1,1,'5015336',2,1,1,1,9,1,1),(35,'',4,'',1,1,'2017-04-05','2017-04-05','2017-03-30 06:22:20','2017-04-05 13:39:23','11:27 AM','6:27 PM','prueba','0.4','PROGRAMADA',1,1,'2800475',2,1,2,1,6,1,1),(36,'',2,'',1,1,'2017-04-05','2017-04-05','2017-03-30 06:22:20','2017-04-05 13:39:32','12:17 PM','6:17 PM','prueba','0.7','PROGRAMADA',1,1,'3160349',3,1,3,1,5,1,1),(37,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-30 06:22:20','2017-04-04 15:47:06',NULL,NULL,'prueba','0.2',NULL,1,1,'2000000',NULL,1,8,1,0,1,1),(38,'',0,'',NULL,0,'0000-00-00','0000-00-00','2017-03-30 06:27:51','2017-03-30 21:57:59',NULL,NULL,'prueba','0.3',NULL,1,1,'2149430',NULL,1,1,1,7,2,1),(39,'',0,'',NULL,0,'0000-00-00','0000-00-00','2017-03-30 06:27:51','2017-03-30 21:57:59',NULL,NULL,'prueba','0.2',NULL,1,1,'1432953',NULL,1,1,1,9,2,1),(40,'',0,'',NULL,0,'0000-00-00','0000-00-00','2017-03-30 06:27:51','2017-03-30 21:57:59',NULL,NULL,'prueba','0.3',NULL,1,1,'2100356',NULL,1,2,1,6,2,1),(41,'',0,'',NULL,0,'0000-00-00','0000-00-00','2017-03-30 06:27:51','2017-03-30 21:57:59',NULL,NULL,'prueba','0.2',NULL,1,1,'902957',NULL,1,3,1,5,2,1),(42,'',0,'',NULL,0,'0000-00-00','0000-00-00','2017-03-30 06:27:51','2017-03-30 21:57:59',NULL,NULL,'prueba','0.3',NULL,1,1,'3000000',NULL,1,8,1,0,2,1),(43,NULL,1,NULL,1,1,'2017-04-10','2017-04-14','2017-03-30 07:14:38','2017-04-25 18:03:19','11:20 AM','11:20 AM','tercera prueba','0.3','FINALIZADA',1,1,'2149430',1,1,1,1,7,3,1),(44,NULL,5,NULL,1,1,'2017-04-10','2017-04-14','2017-03-30 07:14:38','2017-04-10 11:21:54','11:21 AM','11:21 AM','tercera prueba','0.4','PROGRAMADA',1,1,'2865906',1,1,1,1,9,3,1),(45,NULL,NULL,NULL,NULL,1,NULL,NULL,'2017-03-30 07:14:38','2017-03-30 21:55:07',NULL,NULL,'tercera prueba','0.4',NULL,1,1,'2800475',NULL,1,2,1,6,3,1),(46,NULL,NULL,NULL,NULL,1,NULL,NULL,'2017-03-30 07:14:38','2017-03-30 21:55:07',NULL,NULL,'tercera prueba','0.7',NULL,1,1,'3160349',NULL,1,3,1,5,3,1),(47,NULL,NULL,NULL,NULL,1,NULL,NULL,'2017-03-30 07:14:38','2017-03-30 21:55:07',NULL,NULL,'tercera prueba','0.5',NULL,1,1,'5000000',NULL,1,8,1,0,3,1),(48,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-31 03:18:10','2017-03-30 22:25:26',NULL,NULL,'una prueba mas','0.2',NULL,1,1,'1432953',NULL,1,1,1,7,4,1),(49,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-31 03:18:10','2017-03-30 22:25:26',NULL,NULL,'una prueba mas','0.1',NULL,1,1,'716477',NULL,1,1,1,9,4,1),(50,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-31 03:18:10','2017-03-30 22:25:26',NULL,NULL,'una prueba mas','0.2',NULL,1,1,'1400237',NULL,1,2,1,6,4,1),(51,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-31 03:18:10','2017-03-30 22:25:27',NULL,NULL,'una prueba mas','0.1',NULL,1,1,'451478',NULL,1,3,1,5,4,1),(52,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-31 03:18:11','2017-03-30 22:25:27',NULL,NULL,'una prueba mas','1',NULL,1,1,'10000000',NULL,1,8,1,0,4,1),(53,'',0,'',NULL,1,'0000-00-00','0000-00-00','2017-03-31 03:18:11','2017-03-30 22:25:27',NULL,NULL,'una prueba mas','0.4',NULL,1,1,'20000000',NULL,1,9,1,0,4,1),(56,'',NULL,'2',NULL,1,NULL,NULL,'2017-04-10 17:37:39','2017-04-10 12:49:32',NULL,NULL,'esto es una prueba','0.3',NULL,1,1,'2149430',NULL,2,1,1,7,1,1),(57,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:37:39','2017-04-10 12:49:32',NULL,NULL,'esto es una prueba','0.7',NULL,1,1,'5015336',NULL,2,1,1,9,1,1),(58,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:37:39','2017-04-10 12:49:32',NULL,NULL,'esto es una prueba','0.4',NULL,1,1,'2800475',NULL,2,2,1,6,1,1),(59,'2',NULL,'2',NULL,1,NULL,NULL,'2017-04-10 17:37:39','2017-04-10 12:49:32',NULL,NULL,'esto es una prueba','0.7',NULL,1,1,'3160349',NULL,2,3,1,5,1,1),(60,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:37:39','2017-04-10 12:49:32',NULL,NULL,'esto es una prueba','1',NULL,1,1,'10000000',NULL,2,8,1,0,1,1),(61,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:37:39','2017-04-10 12:49:32',NULL,NULL,'esto es una prueba','1',NULL,1,1,'50000000',NULL,2,9,1,0,1,1),(62,'',3,'2',1,1,'2017-04-17','2017-04-13','2017-04-10 17:50:38','2017-05-02 17:21:12','8:00 AM','5:00 PM','esto es otra prueba','0.3','FACTURA PARCIAL',1,1,'2149430',2,2,1,1,7,2,1),(63,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:50:38','2017-04-10 12:51:22',NULL,NULL,'esto es otra prueba','0.7',NULL,1,1,'5015336',NULL,2,1,1,9,2,1),(64,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:50:38','2017-04-10 12:51:22',NULL,NULL,'esto es otra prueba','0.4',NULL,1,1,'2800475',NULL,2,2,1,6,2,1),(65,'2',NULL,'2',NULL,1,NULL,NULL,'2017-04-10 17:50:38','2017-04-10 12:51:22',NULL,NULL,'esto es otra prueba','0.7',NULL,1,1,'3160349',NULL,2,3,1,5,2,1),(66,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:50:38','2017-04-10 12:51:22',NULL,NULL,'esto es otra prueba','1',NULL,1,1,'10000000',NULL,2,8,1,0,2,1),(67,'',NULL,'',NULL,1,NULL,NULL,'2017-04-10 17:50:38','2017-04-10 12:51:22',NULL,NULL,'esto es otra prueba','0.5',NULL,1,1,'25000000',NULL,2,9,1,0,2,1);

/*Table structure for table `pt_seguimiento` */

DROP TABLE IF EXISTS `pt_seguimiento`;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `pt_seguimiento` */

insert  into `pt_seguimiento`(`seguimiento_id`,`seguimiento_avance`,`seguimiento_ejecutor`,`seguimiento_estado`,`seguimiento_fechaini`,`seguimiento_fechafin`,`seguimiento_fechacreo`,`seguimiento_fechamodifico`,`seguimiento_horaini`,`seguimiento_horafin`,`seguimiento_num`,`seguimiento_obs`,`seguimiento_usuariocreo`,`seguimiento_usuariomodifico`,`baremo_id`,`ordentrabajo_id`,`presupuesto_id`,`tipobaremo_id`) values (1,'0.2',1,'1','2017-04-06','2017-04-06','2017-04-06 23:26:05','2017-04-10 11:13:04','8:00 AM','6:25 PM','1','prueba seguimiento modificacion dos',1,1,1,1,33,1),(2,'0.4',1,'1','2017-04-06','2017-04-06','2017-04-06 23:37:02',NULL,'6:36 PM','6:36 PM','1','final',1,NULL,1,1,33,1),(3,'0.4',1,'1','2017-04-06','2017-04-06','2017-04-06 23:38:09',NULL,'6:37 PM','6:37 PM','1','final',1,NULL,1,1,33,1),(4,'0.4',1,'1','2017-04-08','2017-04-08','2017-04-09 00:28:15',NULL,'7:26 PM','7:26 PM','4','prueba 3',1,NULL,1,1,33,1),(5,'0.4',1,'1','2017-04-04','2017-04-07','2017-04-09 00:49:24',NULL,'7:48 PM','7:48 PM','5','prueba 4',1,NULL,1,1,33,1),(6,'0.4',1,'1','2017-04-10','2017-04-10','2017-04-10 16:14:28',NULL,'11:13 AM','11:13 AM','6','prueba finalizada',1,NULL,1,1,33,1),(7,'0.1',1,'1','2017-04-10','2017-04-10','2017-04-10 16:22:55','2017-04-17 16:13:58','11:22 AM','11:22 AM','1','esto es un seguimiento prueba',1,1,1,1,43,1),(8,'0.3',1,'1','2017-04-10','2017-04-10','2017-04-10 16:23:44',NULL,'6:00 AM','6:00 PM','2','fin de la prueba',1,NULL,1,1,43,1),(9,'0.3',1,'1','2017-04-17','2017-04-17','2017-04-17 18:28:16',NULL,'1:27 PM','1:27 PM','3','SIN DOCUMENTOS',1,NULL,1,1,43,1),(10,'0.3',1,'1','2017-04-17','2017-04-17','2017-04-17 18:29:24',NULL,'1:28 PM','1:28 PM','4','WORD',1,NULL,1,1,43,1),(11,'0.4',1,'1','2017-04-19','2017-04-19','2017-04-19 23:09:37',NULL,'6:02 PM','6:02 PM','7','prueba de gestion de la actividad',1,NULL,1,1,33,1),(12,'0.4',1,'1','2017-04-19','2017-04-19','2017-04-19 23:10:49',NULL,'6:10 PM','6:10 PM','8','listo para facturar',1,NULL,1,1,33,1),(13,'0',1,'1','2017-04-19','2017-04-19','2017-04-19 23:16:17',NULL,'6:15 PM','6:15 PM','5','no se a realizado ningun seguimiento',1,NULL,1,1,43,1),(14,'0.3',1,'1','2017-04-19','2017-04-19','2017-04-19 23:17:08',NULL,'6:16 PM','6:16 PM','6','se se realizo la actividad',1,NULL,1,1,43,1),(15,'0.3',1,'1','2017-04-25','2017-04-25','2017-04-25 23:03:19',NULL,'6:02 PM','6:02 PM','7','tarea finalizada',1,NULL,1,1,43,1),(16,'0.2',1,'1','2017-05-02','2017-05-02','2017-05-02 22:21:11',NULL,'5:18 PM','5:18 PM','1','facturar parcialmente',1,NULL,1,2,62,1),(17,'0.2',1,'1','2017-05-05','2017-05-05','2017-05-05 15:28:53',NULL,'10:28 AM','10:28 AM','1','esto es una prueba',1,NULL,1,1,34,1);

/*Table structure for table `pt_soporte_seguimiento` */

DROP TABLE IF EXISTS `pt_soporte_seguimiento`;

CREATE TABLE `pt_soporte_seguimiento` (
  `soporteseguimiento_id` int(11) NOT NULL AUTO_INCREMENT,
  `soporteseguimiento_estado` int(5) DEFAULT '1',
  `soporteseguimiento_fechacreo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `soporteseguimiento_fechamodifico` datetime DEFAULT NULL,
  `soporteseguimiento_usuariocreo` int(11) DEFAULT NULL,
  `soporteseguimiento_usuariomodifico` int(11) DEFAULT NULL,
  `seguimiento_id` int(11) NOT NULL,
  `soporte_id` int(11) NOT NULL,
  PRIMARY KEY (`soporteseguimiento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `pt_soporte_seguimiento` */

insert  into `pt_soporte_seguimiento`(`soporteseguimiento_id`,`soporteseguimiento_estado`,`soporteseguimiento_fechacreo`,`soporteseguimiento_fechamodifico`,`soporteseguimiento_usuariocreo`,`soporteseguimiento_usuariomodifico`,`seguimiento_id`,`soporte_id`) values (1,1,'2017-04-06 23:26:05',NULL,1,NULL,1,1),(2,1,'2017-04-06 23:26:05',NULL,1,NULL,1,2),(3,0,'2017-04-06 23:26:05','2017-04-10 11:10:42',1,1,1,3),(4,1,'2017-04-06 23:37:03',NULL,1,NULL,2,4),(5,1,'2017-04-06 23:38:09','2017-04-10 10:33:54',1,1,3,5),(6,1,'2017-04-09 00:28:15',NULL,1,NULL,4,6),(7,1,'2017-04-09 00:49:24',NULL,1,NULL,5,7),(8,0,'2017-04-10 16:10:56','2017-04-10 11:12:38',1,1,1,8),(9,1,'2017-04-10 16:13:04',NULL,1,NULL,1,9),(10,1,'2017-04-10 16:13:04',NULL,1,NULL,1,10),(11,1,'2017-04-10 16:14:28',NULL,1,NULL,6,11),(12,1,'2017-04-10 16:14:28',NULL,1,NULL,6,12),(13,1,'2017-04-10 16:14:28',NULL,1,NULL,6,13),(14,1,'2017-04-10 16:22:55',NULL,1,NULL,7,14),(15,1,'2017-04-10 16:23:45',NULL,1,NULL,8,15),(16,1,'2017-04-10 16:23:45',NULL,1,NULL,8,16),(17,1,'2017-04-17 18:29:25',NULL,1,NULL,10,17),(18,1,'2017-04-17 20:59:05',NULL,0,NULL,7,18),(19,1,'2017-04-17 21:13:58',NULL,1,NULL,7,19),(20,1,'2017-04-19 22:57:15',NULL,1,NULL,0,20),(21,1,'2017-04-19 22:58:37',NULL,1,NULL,0,21),(22,1,'2017-04-19 23:04:52',NULL,1,NULL,0,22),(23,1,'2017-04-19 23:07:17',NULL,1,NULL,0,23),(24,1,'2017-04-19 23:09:37',NULL,1,NULL,11,24),(25,1,'2017-04-19 23:17:09',NULL,1,NULL,14,25),(26,1,'2017-05-02 22:21:12',NULL,1,NULL,16,26);

/* Procedure structure for procedure `PS_ptBaremoactividad` */

/*!50003 DROP PROCEDURE IF EXISTS  `PS_ptBaremoactividad` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `PS_ptBaremoactividad`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfactividad` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfactividad` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfactividad`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfalcance` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfalcance` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfalcance`(
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

end */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfentregable` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfentregable` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfentregable`(
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

end */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cflabor` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cflabor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cflabor`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfmodulo` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfmodulo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfmodulo`(
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

	SELECT * FROM cf_modulo WHERE modulo_estado=1;

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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfperfil` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfperfil` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfperfil`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfsubactividad` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfsubactividad` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfsubactividad`(
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

end */$$
DELIMITER ;

/* Procedure structure for procedure `SP_cfTipobaremo` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_cfTipobaremo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_cfTipobaremo`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_dtCliente` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_dtCliente` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_dtCliente`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_dtcontrato` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_dtcontrato` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_dtcontrato`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_dtdetallepresupuesto` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_dtdetallepresupuesto` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_dtdetallepresupuesto`(
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
		   detallepresupuesto_total=_detallepresupuesto_total,
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
			    AND dp.detallepresupuesto_estado IN (3,4);
END IF;

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_dtsoporte` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_dtsoporte` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_dtsoporte`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_dtsubestacion` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_dtsubestacion` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_dtsubestacion`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_dtusuario` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_dtusuario` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_dtusuario`(
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


END if;

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptalcancesubactividad` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptalcancesubactividad` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptalcancesubactividad`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptBaremo` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptBaremo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptBaremo`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptdescargo` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptdescargo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptdescargo`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptdetalleactividad` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptdetalleactividad` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptdetalleactividad`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptentregablesubactividad` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptentregablesubactividad` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptentregablesubactividad`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptordentrabajo` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptordentrabajo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptordentrabajo`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptperfil_usuario` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptperfil_usuario` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptperfil_usuario`(
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
           JOIN dt_usuario usu_enc ON pt.presupuesto_encargado=usu_enc.usuario_id
		   JOIN cf_area ar ON pt.area_id=ar.area_id
           JOIN cf_modulo md ON pt.modulo_id=md.modulo_id           
			AND pt.presupuesto_estado=1;              

END if;


END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptpresupuesto` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptpresupuesto` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptpresupuesto`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptseguimiento` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptseguimiento` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptseguimiento`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptsoporteseguimiento` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptsoporteseguimiento` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptsoporteseguimiento`(
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

END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_validaUsuario` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_validaUsuario` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_validaUsuario`(
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

END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
