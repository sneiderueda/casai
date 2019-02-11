/*
SQLyog Community Edition- MySQL GUI v8.05 
MySQL - 5.5.5-10.1.30-MariaDB : Database - energy_ac
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`energy_ac` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `energy_ac`;

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
    and baremo_id=_baremo_id
    and contrato_id=_baremoactividad_estado;
elseif _tipoControl='2' THEN -- Insertar la actividades del baremo
			  INSERT INTO pt_baremo_actividad(baremoactividad_usuariocreo,
											 actividad_id,
                                             contrato_id,
											 baremo_id)
									  VALUES(_baremoactividad_usuariocreo,
  											 _actividad_id,
                                             _baremoactividad_estado,
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
IN _actividad_descripcion varchar(5000),
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
   and contrato_id=_actividad_estado
   and actividad_estado=1;
elseif _tipoControl='2' THEN -- Insertar la actividad
			  INSERT INTO cf_actividad(actividad_descripcion,
									   actividad_GOM,
									   actividad_unidadservicio,
									   actividad_usuariocreo,
									   actividad_valorservicio,
                                       contrato_id)
								VALUES(_actividad_descripcion,	
									   _actividad_GOM,
									   _actividad_unidadservicio,
									   _actividad_usuariocreo,
									   _actividad_valorservicio,
                                       _actividad_estado);
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
        actividad_valordecimal=_actividad_valorservicio,
		actividad_usuariomodifico =_actividad_usuariomodifico,
		actividad_valorservicio = _actividad_valorservicio
  WHERE actividad_id = _actividad_id;
  
			
		 ACTIVIDADES: BEGIN
				
				DECLARE _rowsact BOOLEAN DEFAULT FALSE;
				DECLARE _actividad_id INT DEFAULT 0;
				DECLARE _actividad_valorservicio INT DEFAULT 0;
				DECLARE _actividad_unidadservicio INT DEFAULT 0;
				DECLARE _baremoactividad_id INT DEFAULT 0;
				DECLARE _newactividad_valorservicio DECIMAL(20,6);
				DECLARE _newbaremo_totalsiniva INT DEFAULT 0;
				
				DECLARE CR_actividad CURSOR FOR 
									SELECT  ac.actividad_id,											
											ac.actividad_valorservicio,
											ac.actividad_unidadservicio,
											ba.baremoactividad_id
									   FROM pt_baremo_actividad ba
									   JOIN cf_actividad ac ON ba.actividad_id=ac.actividad_id
										AND ba.baremo_id=_actividad_estado
										AND ba.baremoactividad_estado=1;   
				declare continue handler  for not found  
    
				SET _rowsact = TRUE;
				OPEN CR_actividad;
						Loop_act : LOOP
								FETCH CR_actividad INTO _actividad_id,_actividad_valorservicio,_actividad_unidadservicio,_baremoactividad_id;
								IF _rowsact THEN
									 LEAVE Loop_act;
								END IF;
							
								SET  _newactividad_valorservicio = _actividad_valorservicio;
								SET _newbaremo_totalsiniva=_newbaremo_totalsiniva+_newactividad_valorservicio;
								UPDATE pt_baremo SET baremo_totalsinIva = ROUND(_newbaremo_totalsiniva), baremo_valortotalAct=ROUND(_newbaremo_totalsiniva)  WHERE baremo_id=_actividad_estado;
								 SUBACTIVIDADES:BEGIN 
										DECLARE _rowsub BOOLEAN DEFAULT FALSE;
										DECLARE _detalleactividad_id INT DEFAULT 0;
										DECLARE _detallesubactividad_costosinIva INT DEFAULT 0;
										DECLARE _detallesubactividad_porc  double(15,8);
										DECLARE _newdetallesubactividad_costosiniva DECIMAL(20,6);
										
										DECLARE CR_subactividad CURSOR FOR 
																	SELECT  da.detalleactividad_id,
																			da.detallesubactividad_costosinIva,
																			REPLACE(da.detallesubactividad_porc,',','.') detallesubactividad_porc
																			FROM pt_detalle_actividad da
																		   WHERE da.detalleactividad_estado=1
																			 AND da.baremoactividad_id=_baremoactividad_id
																			 AND da.actividad_id=_actividad_id;   
										declare continue handler for not found  																						
										SET _rowsub = TRUE;
										OPEN CR_subactividad;
												Loop_sub:LOOP
														FETCH CR_subactividad INTO _detalleactividad_id,_detallesubactividad_costosinIva,_detallesubactividad_porc;
														IF _rowsub THEN
															LEAVE Loop_sub;
														END IF;
														
														SET _newdetallesubactividad_costosiniva=_newactividad_valorservicio*_detallesubactividad_porc;
														UPDATE pt_detalle_actividad SET detallesubactividad_costosinIva = ROUND(_newdetallesubactividad_costosiniva) WHERE detalleactividad_id=_detalleactividad_id;
												END LOOP Loop_sub;
										CLOSE CR_subactividad;
								 END SUBACTIVIDADES;													
						END LOOP Loop_act;
				CLOSE CR_actividad;													
		 END ACTIVIDADES;	
     
end if;
END */$$
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

/* Procedure structure for procedure `SP_factura` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_factura` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_factura`(
IN _tipoControl varchar(11),
IN _detallefactura_id varchar(45),
IN _detallefactura_avance varchar(45),
IN _detallefactura_obs varchar(5000),
IN _detallefactura_usuariocreo varchar(45),
IN _detallefactura_usuariomodifico varchar(45),
IN _detallefactura_valoravance varchar(45),
IN _factura_id varchar(45),
IN _factura_fechainicio varchar(45),
IN _factura_fechafin varchar(45),
IN _factura_numero varchar(45),
IN _factura_porcentajeactual varchar(45),
IN _factura_porcentajefacturado varchar(45),
IN _factura_porcentajependiente varchar(45),
IN _factura_usuariocreo varchar(45),
IN _factura_usuariomodifico varchar(45),
IN _factura_valorfacturado varchar(45),
IN _factura_valorpendiente varchar(45),
IN _factura_valortotal varchar(45),
IN _detallepresupuesto_id varchar(45),
IN _ordentrabajo_id varchar(45),
IN _factura_actanum varchar(45)
)
BEGIN
DECLARE factura_id_insert INT;
DECLARE detallefactura_id_insert INT;
if _tipoControl='1' THEN -- Consultar
		/*
		SELECT ot.ordentrabajo_num,
				ot.ordentrabajo_obs,
				dp.detallepresupuesto_total,
				dp.detallepresupuesto_porcentincremento,
				dp.detallepresupuesto_valorincremento,
				sum(ps.presupuesto_valorporcentaje) as valor_porc,
				ps.presupuesto_porcentaje,
				sum(ps.presupuesto_porcentaje) as sum_por
		FROM pt_presupuesto ps
		JOIN dt_detalle_presupuesto dp ON dp.detallepresupuesto_id=ps.detallepresupuesto_id
		JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
		WHERE  ps.presupuesto_progestado='FINALIZADA' OR ps.presupuesto_progestado='FACTURA PARCIAL'
		GROUP BY ot.ordentrabajo_num;
		*/
		/*MODIFICAR CONSULTA*/
		/*PENDIENTE VALIDAR QUE LAS ACTIVIDADES DE TIPO LAVOR NO SE PUEDEN DEJAR EN ESTADO FACTURA PAARCIAL*/
		SELECT ps.presupuesto_id,
				ps.detallepresupuesto_id,
                ot.ordentrabajo_id,
				ot.ordentrabajo_num,
				ot.ordentrabajo_obs,
                ot.ordentrabajo_ordenpresupuestal,
                ot.ordentrabajo_pep,
                ot.ordentrabajo_GOM,
				dp.detallepresupuesto_total,
                dp.detallepresupuesto_tipoincremento,
				dp.detallepresupuesto_porcentincremento,
				dp.detallepresupuesto_valorincremento,
                sb.subestacion_nombre,
			CASE ps.presupuesto_progestado WHEN 'FINALIZADA' THEN 
																	(SELECT sum(presupuesto_valorporcentaje) as valor_total_porcentaje
																		 FROM pt_presupuesto
																		 WHERE presupuesto_progestado='FINALIZADA'
																		 AND presupuesto_estado=1
																		 AND detallepresupuesto_id=ps.detallepresupuesto_id)
				end  AS valor_porc,      
				-- sum(ps.presupuesto_valorporcentaje) as valor_porc,
				ps.presupuesto_porcentaje,
				sum(ps.presupuesto_porcentaje) as sum_por, 
                CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS gestor,
				(SELECT count(da1.subactividad_id)
										   FROM pt_presupuesto pt1
									 INNER JOIN pt_detalle_actividad da1 ON pt1.detalleactividad_id=da1.detalleactividad_id
										   JOIN cf_subactividad sb1 ON da1.subactividad_id=sb1.subactividad_id
										   JOIN dt_detalle_presupuesto dp1 ON pt1.detallepresupuesto_id=dp1.detallepresupuesto_id
										  WHERE da1.subactividad_id=1
											AND pt1.presupuesto_estado=1
											AND dp1.detallepresupuesto_id=ps.detallepresupuesto_id
											AND sb1.subactividad_descripcion='LEVANTAMIENTO') AS levantamiento_pt,
				(SELECT COUNT(pt2.presupuesto_id)
				   FROM pt_presupuesto pt2
				   JOIN pt_detalle_actividad da2 ON pt2.detalleactividad_id=da2.detalleactividad_id
				   JOIN cf_subactividad sb2 ON da2.subactividad_id=sb2.subactividad_id
				   JOIN dt_detalle_presupuesto dp2 ON pt2.detallepresupuesto_id=dp2.detallepresupuesto_id
				  WHERE pt2.presupuesto_estado=1
					AND dp2.detallepresupuesto_id=ps.detallepresupuesto_id) as total_actividades
    
			  FROM pt_presupuesto ps
			  JOIN dt_detalle_presupuesto dp ON dp.detallepresupuesto_id=ps.detallepresupuesto_id
              JOIN dt_usuario usu ON dp.detallepresupuesto_gestor=usu.usuario_id
			  JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
		INNER JOIN pt_detalle_actividad da ON ps.detalleactividad_id=da.detalleactividad_id
              JOIN dt_subestacion sb ON dp.subestacion_id=sb.subestacion_id
			-- WHERE ps.presupuesto_progestado='FINALIZADA'
             WHERE ps.presupuesto_progestado IN ('FACTURA PARCIAL','FINALIZADA')
            -- AND ps.detallepresupuesto_id in (189,802)
             AND dp.detallepresupuesto_estado=3
		  GROUP BY ot.ordentrabajo_num;
ELSEIF (_tipoControl='2') THEN -- Consultar la ubicacion por levantamiento
     SELECT pt1.presupuesto_id,
			pt1.presupuesto_valorporcentaje,
			sb1.subactividad_descripcion,
			pt1.presupuesto_progestado
	   FROM pt_presupuesto pt1
       JOIN pt_detalle_actividad da1 ON pt1.detalleactividad_id=da1.detalleactividad_id
       JOIN cf_subactividad sb1 ON da1.subactividad_id=sb1.subactividad_id
       JOIN dt_detalle_presupuesto dp1 ON pt1.detallepresupuesto_id=dp1.detallepresupuesto_id
	  WHERE da1.subactividad_id=1
	    AND pt1.presupuesto_estado=1
	    AND dp1.detallepresupuesto_id=_detallepresupuesto_id
        AND pt1.presupuesto_progestado='FINALIZADA'  OR pt1.presupuesto_progestado='FACTURA PARCIAL';
     
ELSEIF(_tipoControl='3') THEN -- Consultar las actividades finalizadas o factura parcial del presupuesto
     SELECT pt1.presupuesto_id,
			pt1.presupuesto_valorporcentaje,
			sb1.subactividad_descripcion,
			pt1.presupuesto_progestado
	   FROM pt_presupuesto pt1
	   JOIN pt_detalle_actividad da1 ON pt1.detalleactividad_id=da1.detalleactividad_id
	   JOIN cf_subactividad sb1 ON da1.subactividad_id=sb1.subactividad_id
	   JOIN dt_detalle_presupuesto dp1 ON pt1.detallepresupuesto_id=dp1.detallepresupuesto_id
	  WHERE pt1.presupuesto_estado=1
		AND dp1.detallepresupuesto_id=_detallepresupuesto_id
		AND pt1.presupuesto_progestado='FINALIZADA'
		 OR pt1.presupuesto_progestado='FACTURA PARCIAL';
      
ELSEIF(_tipoControl='4') THEN -- consultar el numero de acta a facturar
		SELECT COUNT(*) AS acta 
		  FROM dt_factura 
		 WHERE ordentrabajo_id=_ordentrabajo_id;
ELSEIF(_tipoControl='5') THEN -- Consultar las actividades a facturar de la OT
		SELECT  pt.presupuesto_id,
					pt.baremoactividad_id,
					pt.presupuesto_porcentaje,
                    pt.detallepresupuesto_id,
					-- (select seguimiento_id from pt_seguimiento where  seguimiento_fechacreo=(Select MAX(seguimiento_fechacreo) from pt_seguimiento where  presupuesto_id=pt.presupuesto_id))as seguimiento_id,
					-- (select seguimiento_avance from pt_seguimiento where  seguimiento_fechacreo=(Select MAX(seguimiento_fechacreo) from pt_seguimiento where  presupuesto_id=pt.presupuesto_id))as avance,
					pt.presupuesto_valorporcentaje,
					pt.presupuesto_progestado,
					bm.baremo_item,
					bm.baremo_id,
					tb.tipobaremo_sigla,
					ac.actividad_id,
					ac.actividad_descripcion,
					ac.actividad_GOM,
					ac.actividad_valorservicio,
					md.modulo_descripcion,
					lb.labor_descripcion
		FROM pt_presupuesto pt
		JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
		JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
		JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
		JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
		JOIN cf_labor lb ON bm.labor_id=lb.labor_id
		JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		JOIN pt_seguimiento sg ON pt.presupuesto_id=sg.presupuesto_id
		WHERE pt.detallepresupuesto_id=_detallepresupuesto_id
		AND pt.presupuesto_progestado IN ('FACTURA PARCIAL','FINALIZADA')
		AND pt.presupuesto_estado=1
		group by sg.presupuesto_id;
ELSEIF (_tipoControl='6') THEN -- Cancelar actividad para facturar
INSERT INTO pt_seguimiento (seguimiento_avance,
							seguimiento_ejecutor,
							seguimiento_num,
							seguimiento_obs,
							seguimiento_revision,
							seguimiento_usuariocreo,
							baremo_id,
							ordentrabajo_id,
							presupuesto_id,
							tipobaremo_id)
				    SELECT seguimiento_avance,
							seguimiento_ejecutor,
							sum(seguimiento_num+1),
							concat(_detallefactura_obs,'',sum(seguimiento_num+1)),
							_detallefactura_avance,
							_factura_usuariocreo ,
							baremo_id,
							ordentrabajo_id,
							presupuesto_id,
							tipobaremo_id
					   FROM pt_seguimiento WHERE seguimiento_id=_ordentrabajo_id;
  
  
ELSEIF(_tipoControl='7') THEN -- CONSULTAR EL AVANCE DE LAS ACTIIDADES A FACTURAR
          		SELECT  pt.presupuesto_id,
					pt.baremoactividad_id,
					pt.presupuesto_porcentaje,
                    pt.detallepresupuesto_id,
					-- (select seguimiento_id from pt_seguimiento where  seguimiento_fechacreo=(Select MAX(seguimiento_fechacreo) from pt_seguimiento where  presupuesto_id=pt.presupuesto_id))as seguimiento_id,
					-- (select seguimiento_avance from pt_seguimiento where  seguimiento_fechacreo=(Select MAX(seguimiento_fechacreo) from pt_seguimiento where  presupuesto_id=pt.presupuesto_id))as avance,
					pt.presupuesto_valorporcentaje,
					pt.presupuesto_progestado,
					ac.actividad_id,
					ac.actividad_valorservicio
		FROM pt_presupuesto pt
        JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
		JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
		JOIN pt_seguimiento sg ON pt.presupuesto_id=sg.presupuesto_id
		WHERE pt.presupuesto_id=_detallepresupuesto_id
		AND pt.presupuesto_progestado IN ( 'FACTURA PARCIAL','FINALIZADA' )
		AND pt.presupuesto_estado=1
		group by sg.presupuesto_id; 
  
  
ELSEIF(_tipoControl='8') THEN -- CONSULTAR EL ACUMULADO POR PRESUPUESTO_ID
 
	SELECT sum(df.detallefactura_avance) as porcetaje_aco,
		   sum(df.detallefactura_valoravance) as valor_aco,
           sum(df.detallefactura_cantidad) as cantidad_aco,
		   pt.presupuesto_valorporcentaje
	  FROM pt_detalle_factura df
	  JOIN pt_presupuesto pt ON df.presupuesto_id=pt.presupuesto_id
	  WHERE df.presupuesto_id=_detallepresupuesto_id
       GROUP BY pt.presupuesto_valorporcentaje;
ELSEIF(_tipoControl='9') THEN -- CALCULAR LA UBICACION ACUMULADA
	SELECT sum(factura_valorubicacion) as ubicacion 
      FROM dt_factura 
	 WHERE ordentrabajo_id=_ordentrabajo_id;
ELSEIF(_tipoControl='10') THEN -- INSERTAR FACTURA
 INSERT INTO dt_factura( factura_actanum,
						factura_estado,
						factura_fechainicio,
						factura_fechafin,
						factura_fechacreo,
						factura_numero,
						factura_porcentajeactual,
						factura_porcentajefacturado,
						factura_porcentajependiente,
						factura_usuariocreo,
						factura_valorfacturado,
						factura_valorpendiente,
						factura_valortotal,
						factura_valorubicacion,
						ordentrabajo_id)
				 VALUES(_factura_actanum,
						1,
						_factura_fechainicio,
						_factura_fechafin,
						NOW(),
						_factura_numero,
						_factura_porcentajeactual,
						_factura_porcentajefacturado,
						_factura_porcentajependiente,
						_factura_usuariocreo,
						_factura_valorfacturado,
						_factura_valorpendiente,
						_factura_valortotal,
						_detallepresupuesto_id,
						_ordentrabajo_id);
                        
 SET factura_id_insert= LAST_INSERT_ID();
 select factura_id_insert;
ELSEIF(_tipoControl='11') THEN -- INSERTAR ACTIVIDADES A FACTURAR
		INSERT INTO pt_detalle_factura(detallefactura_avance,
                                        detallefactura_cantidad,
										detallefactura_estado,
										detallefactura_fechacreo,
										detallefactura_obs,
										detallefactura_usuariocreo,
										detallefactura_valoravance,
										detallepresupuesto_id,
										factura_id,
										presupuesto_id)
								 VALUES (_detallefactura_avance,
                                         _detallefactura_id,
										_factura_numero,
                                        NOW(),
                                        _detallefactura_obs,
                                        _detallefactura_usuariocreo,
                                        _detallefactura_valoravance,
                                        _detallepresupuesto_id,
                                        _factura_id,
                                        _ordentrabajo_id
                                 );
		SET detallefactura_id_insert=LAST_INSERT_ID();
         select detallefactura_id_insert;
        
ELSEIF(_tipoControl='12') THEN -- CONSULTAR EL PORCENTAJE ACTUAL DE LA OT
		SELECT factura_porcentajependiente ,
			   factura_porcentajeactual,
               factura_porcentajefacturado,
               max(factura_id) as ultima_acta
		  FROM dt_factura 
		 WHERE ordentrabajo_id=_ordentrabajo_id
		   AND factura_estado=1;
           
  
ELSEIF (_tipoControl='13') THEN -- CALCULAR VALOR FACTURADO POR OT
  
		SELECT sum(factura_valorfacturado) AS valor_pagado
		FROM dt_factura 
		WHERE ordentrabajo_id=_ordentrabajo_id
		AND factura_estado=1;
        
ELSEIF(_tipoControl='14') THEN -- ACTUALIZAR VALORES DE LA FACTURA   
	UPDATE dt_factura 
	   SET factura_valorfacturado=_factura_valorfacturado,                      
   		   factura_valorpendiente=_factura_valorpendiente,
		   factura_valortotal=_factura_valortotal,          
           factura_valorubicacion=_detallepresupuesto_id,
           factura_iva=_ordentrabajo_id,
           factura_subtotal_incremento=_factura_actanum,
           factura_subtotal=_factura_usuariomodifico
	 WHERE factura_id = _factura_id;
     
ELSEIF (_tipoControl='15') THEN -- Consultar facturas cerradas
SELECT factura_fechainicio,
		factura_fechafin,
		factura_numero,
		sum(factura_subtotal) AS subtotal,
		sum(factura_iva) AS iva,
		sum(factura_valorubicacion) AS ubicacion,
		sum(factura_valorfacturado) AS total_facturado
   FROM dt_factura
GROUP BY factura_numero;
     
ELSEIF(_tipoControl='16') THEN -- Consultar las actas
SELECT factura_subtotal,
	   factura_porcentajefacturado,
       factura_actanum
  FROM dt_factura
 WHERE ordentrabajo_id=_ordentrabajo_id;
     
     ELSEIF(_tipoControl='17') THEN 
     
     	SELECT sum(sg.seguimiento_avance*ac.actividad_valorservicio) as factura_parcial
		  FROM pt_presupuesto ps
		  JOIN dt_detalle_presupuesto dp ON dp.detallepresupuesto_id=ps.detallepresupuesto_id
		  JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
          INNER JOIN pt_detalle_actividad da ON ps.detalleactividad_id=da.detalleactividad_id
           JOIN cf_actividad ac ON ac.actividad_id=da.actividad_id
           join pt_seguimiento sg ON ps.presupuesto_id=sg.presupuesto_id
		 WHERE (presupuesto_progestado='FACTURA PARCIAL')
          AND ps.presupuesto_estado=1
          AND ps.detallepresupuesto_id=_detallepresupuesto_id
          and seguimiento_id=(select max(seguimiento_id) from pt_seguimiento where presupuesto_id=ps.presupuesto_id);
          
   END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_NewContratoIndexacion` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_NewContratoIndexacion` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewContratoIndexacion`(
IN _contrato_anterior varchar(11),
IN _contrato_new varchar(11)
)
NEWBAREMOS:BEGIN
DECLARE _actividad_id INT DEFAULT 0;
DECLARE _detalleactividad_id INT DEFAULT 0;
DECLARE _entregablesubactividad_id INT DEFAULT 0;
DECLARE _alcancesubactividad_id INT DEFAULT 0;
DECLARE _actividad_id_insert INT DEFAULT 0;
DECLARE _detalleactividad_id_insert INT DEFAULT 0;
DECLARE _rowsactividades BOOLEAN DEFAULT FALSE;
	/*cursor insertar actividades*/
    DECLARE CR_ACTIVIDADES CURSOR FOR 
			SELECT actividad_id 
              FROM cf_actividad
			 WHERE contrato_id=_contrato_anterior
			   AND actividad_estado=1;
			
            
            DECLARE CONTINUE handler FOR NOT FOUND
            SET _rowsactividades=TRUE;
            
            OPEN CR_ACTIVIDADES;
				loop_actividades: LOOP
					
                    FETCH CR_ACTIVIDADES INTO _actividad_id;
                    
                    IF _rowsactividades=TRUE THEN 
						LEAVE loop_actividades;
                    END IF;
                    
					INSERT INTO cf_actividad(actividad_descripcion,
									   actividad_GOM,
									   actividad_unidadservicio,
									   actividad_usuariocreo,
									   actividad_valorservicio,
                                       contrato_id)
								SELECT actividad_descripcion,	
									   actividad_GOM,
									   actividad_unidadservicio,
									   actividad_usuariocreo,
									   actividad_valorservicio,
                                       _contrato_new
								  FROM cf_actividad
								 WHERE actividad_id=_actividad_id;
					SET _actividad_id_insert= LAST_INSERT_ID();
					
                    /*Actividades relacionadas con los baremos*/
                    BAREMO_ACTIVIDAD:BEGIN
                    
						DECLARE _existe_baremo INT DEFAULT 0;
						DECLARE _baremo_item INT DEFAULT 0;
						DECLARE _rowsbaremoactividades BOOLEAN DEFAULT FALSE;
                        DECLARE _baremo_id_insert INT DEFAULT 0;
                        DECLARE _baremo_id INT DEFAULT 0;
                        DECLARE _tipobaremo_id INT DEFAULT 0;
						DECLARE _baremoactividad_id INT DEFAULT 0;
                        DECLARE _baremoactividad_id_insert INT DEFAULT 0;
						
						DECLARE CR_BAREMO_ACTIVIDAD CURSOR FOR
                        
                        SELECT pt_baremo_actividad.baremoactividad_id,pt_baremo_actividad.baremo_id,pt_baremo.tipobaremo_id
						  FROM pt_baremo_actividad
					INNER JOIN pt_baremo on pt_baremo_actividad.baremo_id=pt_baremo.baremo_id
						 WHERE pt_baremo_actividad.actividad_id=_actividad_id
						   AND pt_baremo_actividad.baremoactividad_estado=1;
                        /*
								SELECT baremoactividad_id,baremo_id 
                                  FROM pt_baremo_actividad
								 WHERE actividad_id=_actividad_id
                                   AND baremoactividad_estado=1;
                                   */
                                      
						declare continue handler  for not found     
						SET _rowsbaremoactividades = TRUE;
                        
                        OPEN CR_BAREMO_ACTIVIDAD;
							Loop_baremo_actividades:LOOP
								
                                FETCH CR_BAREMO_ACTIVIDAD INTO _baremoactividad_id,_baremo_id,_tipobaremo_id;
								IF _rowsbaremoactividades THEN
									 LEAVE Loop_baremo_actividades;
								END IF;
                                
                                -- validar si existe el baremo
                                SELECT baremo_item FROM pt_baremo WHERE baremo_id=_baremo_id and tipobaremo_id=_tipobaremo_id
                                INTO _baremo_item;
                                
                                SELECT baremo_id FROM pt_baremo where baremo_item=_baremo_item AND contrato_id=_contrato_new AND tipobaremo_id=_tipobaremo_id
                                INTO _existe_baremo;
                                
                                
                               IF _existe_baremo >0 then
									SET _baremo_id_insert=_existe_baremo;
								else
                               
									INSERT INTO pt_baremo(baremo_item,
														   baremo_totalsinIva,
														   baremo_unidadservicio,
														   baremo_valorservicio,
														   baremo_valortotalAct,
														   baremo_usuariocreo,
														   cliente_id,
														   labor_id,
														   tipobaremo_id,
                                                           contrato_id)
													 SELECT baremo_item,
															baremo_totalsinIva,
															baremo_unidadservicio,
															baremo_valorservicio,
															baremo_valortotalAct,
															baremo_usuariocreo,
															cliente_id,
															labor_id,
															tipobaremo_id,
                                                            _contrato_new
													   FROM pt_baremo
                                                      WHERE baremo_id=_baremo_id;
										SET _baremo_id_insert= LAST_INSERT_ID();
								END IF;
								-- fin de validacion del baremo
                                
                                -- insertamos pt_baremo_actividad
								INSERT INTO pt_baremo_actividad(baremoactividad_usuariocreo,
																 actividad_id,
                                                                 contrato_id,
																 baremo_id)
														  SELECT baremoactividad_usuariocreo,
																 _actividad_id_insert,
                                                                 _contrato_new,
																 _baremo_id_insert
															FROM pt_baremo_actividad
                                                            WHERE baremoactividad_id=_baremoactividad_id;
								SET _baremoactividad_id_insert= LAST_INSERT_ID();
                                -- fin insertar pt_baremo_actividad
                                
                                -- Insertar pt_detalle_actividad
                                DETALLEACTIVIDAD:BEGIN
								DECLARE _rowsdetalleactividad BOOLEAN DEFAULT FALSE;
								
									DECLARE CR_detalleactividad CURSOR FOR 
                                    
										SELECT detalleactividad_id
                                          FROM pt_detalle_actividad 
										 WHERE actividad_id=_actividad_id
										   AND detalleactividad_estado=1; 
                                           
										declare continue handler for not found  
										SET _rowsdetalleactividad = TRUE;
                                        
                                        OPEN CR_detalleactividad;
											Loop_detalleactividad:LOOP
												FETCH CR_detalleactividad INTO _detalleactividad_id;
                                                
                                                IF _rowsdetalleactividad THEN
													LEAVE Loop_detalleactividad;
												END IF;
                                                
											    INSERT INTO pt_detalle_actividad(detallesubactividad_costosinIva,
																				  detallesubactividad_porc,
																				  detalleactividad_usuariocreo,
																				  actividad_id,
                                                                                  contrato_id,
																				  baremoactividad_id,
																				  subactividad_id)
																		   SELECT detallesubactividad_costosinIva,
																				  detallesubactividad_porc,
																				  detalleactividad_usuariocreo,
																				  _actividad_id_insert,
                                                                                  _contrato_new,
																				  _baremoactividad_id_insert,
																				  subactividad_id
																			 FROM pt_detalle_actividad
																			WHERE detalleactividad_id=_detalleactividad_id;
                                                 SET _detalleactividad_id_insert= LAST_INSERT_ID();
                                                 
                                                 -- insertar pt_entregable_subactividad
                                                 ENTREGABLESUBACTIVIDAD:BEGIN 
                                                    DECLARE _rowsentregablesubactividad BOOLEAN DEFAULT FALSE;
													DECLARE _entregablesubactividad_id_insert INT DEFAULT 0;
                                                    
													DECLARE CR_entregablesubactividad CURSOR FOR 
														SELECT entregablesubactividad_id 
                                                        FROM pt_entregable_subactividad
                                                        WHERE detalleactividad_id=_detalleactividad_id
                                                        AND entregablesubactividad_estado=1;
                                                        
                                                        DECLARE continue handler for NOT found
                                                        SET _rowsentregablesubactividad=TRUE;
                                                        
                                                        OPEN CR_entregablesubactividad;
															Loop_entregable:LOOP
																FETCH CR_entregablesubactividad INTO _entregablesubactividad_id;
                                                                
                                                                IF _rowsentregablesubactividad THEN 
																	LEAVE Loop_entregable;
                                                                END IF;
                                                                
                                                                	 INSERT INTO pt_entregable_subactividad(
																				  entregablesubactividad_usuariocreo,
                                                                                  contrato_id,
																				  entregable_id,
																				  detalleactividad_id)
																		    SELECT entregablesubactividad_usuariocreo,
																				   _contrato_new,
																				   entregable_id,
																				   _detalleactividad_id_insert
																			 FROM pt_entregable_subactividad
                                                                             WHERE entregablesubactividad_id=_entregablesubactividad_id;
																	 SET _entregablesubactividad_id_insert= LAST_INSERT_ID();
                                                                     
                                                            END LOOP Loop_entregable;
                                                        CLOSE CR_entregablesubactividad;                                                        
                                                 END ENTREGABLESUBACTIVIDAD;
                                                 -- fin insertar pt_entregable_subactividad
                                                 
                                                 -- Insertar pt_alcance_subactividad
                                                 ALCENCESUBACTIVIDAD:BEGIN
													DECLARE _rowsalcancesubactividad BOOLEAN DEFAULT FALSE;
													DECLARE _alcancesubactividad_id_insert INT DEFAULT 0;
                                                    
													DECLARE CR_ALCANCESUBACTIVIDAD cursor for
														SELECT alcancesubactividad_id 
                                                        FROM pt_alcance_subactividad 
                                                        WHERE detalleactividad_id=_detalleactividad_id 
                                                        AND alcancesubactividad_estado=1; 
                                                        
                                                        DECLARE CONTINUE HANDLER FOR NOT FOUND
                                                        SET _rowsalcancesubactividad=TRUE;
                                                        
                                                        OPEN CR_ALCANCESUBACTIVIDAD;
															Loop_alcancesubactividad:LOOP
																FETCH CR_ALCANCESUBACTIVIDAD INTO _alcancesubactividad_id;
                                                                
                                                                IF _rowsalcancesubactividad THEN
                                                                LEAVE Loop_alcancesubactividad;
                                                                END IF;
                                                                
																INSERT INTO pt_alcance_subactividad(alcancesubactividad_usuariocreo,
                                                                            alcance_id,
                                                                            contrato_id,
																		    detalleactividad_id)
																     SELECT alcancesubactividad_usuariocreo,
																		    alcance_id,
                                                                            _contrato_new,
																		    _detalleactividad_id_insert
																	   FROM pt_alcance_subactividad
																	  WHERE alcancesubactividad_id=_alcancesubactividad_id;
																SET _alcancesubactividad_id_insert= LAST_INSERT_ID();
                                                                
                                                            END LOOP Loop_alcancesubactividad;
                                                        CLOSE CR_ALCANCESUBACTIVIDAD;
                                                 END ALCENCESUBACTIVIDAD;
                                                 -- fin insertar pt_alcance_subactividad
                                                 
											END LOOP Loop_detalleactividad;
                                        CLOSE CR_detalleactividad;
                                END DETALLEACTIVIDAD;
                                -- fin insertar pt_detalle_actividad
                                
	
							END LOOP Loop_baremo_actividades;
                        CLOSE CR_BAREMO_ACTIVIDAD;
                    END BAREMO_ACTIVIDAD;
                    /*Fin actividades relacionadas con los baremos*/
					
                END LOOP loop_actividades;
            CLOSE CR_ACTIVIDADES;
    /*fin cursor insertar actividades*/
END NEWBAREMOS */$$
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
		select per.perfil_id,per.perfil_nombre,perUsu.perfilusuario_id,ar.area_nombre,ar.area_id
		  from pt_perfil_usuario perUsu
		  join dt_usuario usu on perUsu.usuario_id=usu.usuario_id
          JOIN cf_area ar ON perUsu.area_id=ar.area_id
		   and perUsu.usuario_id=_usuario_id
	       and perUsu.perfilusuario_estado=1
		  join cf_perfil per on perUsu.perfil_id=per.perfil_id
          ORDER BY per.perfil_nombre ASC;
	--  GROUP BY per.perfil_nombre;
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
                    CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS asigno,
                    sbe.subestacion_nombre,
                    CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) AS tipo_labor
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   LEFT JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   LEFT JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
           JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
           JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
           JOIN dt_subestacion sbe ON dp.subestacion_id=sbe.subestacion_id
           JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		   JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
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
                   CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS asigno,
                   sbe.subestacion_nombre,
                   CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) AS tipo_labor
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   LEFT JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   LEFT JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
           JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
           JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
           JOIN dt_subestacion sbe ON dp.subestacion_id=sbe.subestacion_id
           JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		   JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
           JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
           JOIN dt_usuario usu ON pt.presupuesto_asignadopor=usu.usuario_id
		   JOIN pt_perfil_usuario per_enc ON pt.presupuesto_encargado=per_enc.perfilusuario_id
		   JOIN dt_usuario usu_enc ON per_enc.usuario_id=usu_enc.usuario_id
		   JOIN cf_area ar ON pt.area_id=ar.area_id
           JOIN cf_modulo md ON pt.modulo_id=md.modulo_id           
			AND pt.presupuesto_estado=1;  
            
            
elseif _tipoControl='11' THEN -- filtar actividades por area
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
                   CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS asigno,
                   sbe.subestacion_nombre,
                   CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) AS tipo_labor
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   LEFT JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   LEFT JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
           JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
           JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
           JOIN dt_subestacion sbe ON dp.subestacion_id=sbe.subestacion_id
           JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		   JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
           JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
           JOIN dt_usuario usu ON pt.presupuesto_asignadopor=usu.usuario_id
		   JOIN pt_perfil_usuario per_enc ON pt.presupuesto_encargado=per_enc.perfilusuario_id
		   JOIN dt_usuario usu_enc ON per_enc.usuario_id=usu_enc.usuario_id
		   JOIN cf_area ar ON pt.area_id=ar.area_id
           JOIN cf_modulo md ON pt.modulo_id=md.modulo_id           
			AND pt.presupuesto_estado=1
			AND ar.area_id=_area_id;  
            
                   
	elseif _tipoControl='12' THEN  -- consultar labores asignadas den tabla cf_tecnico_presupuesto
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
                    CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS asigno,
                    sbe.subestacion_nombre,
                    CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) AS tipo_labor
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   LEFT JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   LEFT JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
           JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
           JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
           JOIN dt_subestacion sbe ON dp.subestacion_id=sbe.subestacion_id
           JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		   JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
           JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
           JOIN dt_usuario usu ON pt.presupuesto_asignadopor=usu.usuario_id
		   
		   JOIN cf_tecnico_presupuesto tp ON pt.presupuesto_id=tp.presupuesto_id
		   JOIN pt_perfil_usuario pu ON tp.perfilusuario_id=pu.perfilusuario_id
		   JOIN cf_area ar ON pu.area_id=ar.area_id
           JOIN cf_modulo md ON pt.modulo_id=md.modulo_id 
		   
           AND tp.perfilusuario_id IN (SELECT perUsu.perfilusuario_id
											  FROM pt_perfil_usuario perUsu
											  JOIN dt_usuario usu on perUsu.usuario_id=usu.usuario_id          
											  AND perUsu.usuario_id=_usuario_id											   
											   AND perUsu.perfil_id=_perfil_id
                                               AND perUsu.perfilusuario_estado=1)
			AND tp.tecnicopresupuesto_tipotecnico=2
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
IN _presupuesto_alcances varchar(1000),
IN _presupuesto_encargado varchar(11),
IN _presupuesto_entregables varchar(500),
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
DECLARE _existe_tecnico INT DEFAULT 0;
DECLARE _total_actividades INT;
DECLARE _total_programadas INT;
DECLARE _tecnicopresupuesto_id INT;
DECLARE _existe_programacion INT DEFAULT 0;
DECLARE _CPpresupuesto_id varchar(45);
DECLARE _CPbaremoactividad_id varchar(45);
DECLARE _CPbaremo_id varchar(45);
DECLARE _CPdetalleactividad_id varchar(45);
DECLARE _CPtipobaremo_id varchar(45);
DECLARE _CPpresupuesto_obs varchar(5000);
DECLARE _baremo_item varchar(45);
DECLARE _actividad_GOM varchar(45);
                   
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
	AND presupuesto_obs=_presupuesto_obs
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
		SELECT pt.presupuesto_id,
               pt.baremo_id,
			   pt.tipobaremo_id,
			   pt.detallepresupuesto_id,
               pt.presupuesto_obs,
			   bm.baremo_item,
               bm.labor_id,
               lb.labor_descripcion,
			   CONCAT(bm.labor_id,' - ',lb.labor_descripcion) AS labor,
               CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) AS item,
			   tb.tipobaremo_descripcion,
			   md.modulo_descripcion,
               md.modulo_id,
			   pt.presupuesto_obs,
			   sum(presupuesto_valorporcentaje) as total_actividad
		  FROM pt_presupuesto pt
		  JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		  JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
		  JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
	      JOIN cf_labor lb ON bm.labor_id=lb.labor_id
		   AND pt.presupuesto_estado=1
		   AND pt.detallepresupuesto_id=_detallepresupuesto_id
	  GROUP BY pt.baremo_id,
			   pt.tipobaremo_id,
			   pt.detallepresupuesto_id,
			   bm.baremo_item,
			   tb.tipobaremo_descripcion,
				pt.presupuesto_obs,
			   md.modulo_descripcion
	  ORDER BY md.modulo_descripcion ASC;
elseif _tipoControl='4' THEN -- ACTUALIZAR ESTADO
	UPDATE pt_presupuesto 
	   SET presupuesto_estado = 0,
           presupuesto_fechamodifico=NOW(),
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico
	 WHERE baremo_id = _baremo_id
	   AND detallepresupuesto_id=_detallepresupuesto_id
       AND modulo_id=_modulo_id
       AND presupuesto_obs=_presupuesto_obs;
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
            pt.presupuesto_alcances,
            pt.presupuesto_entregables,
            pt.tipobaremo_id,
            pt.detalleactividad_id,
			bm.baremo_item,
            bm.baremo_id,
			ac.actividad_id,
			ac.actividad_descripcion,
			ac.actividad_GOM,
			ac.actividad_valorservicio,
            ac.actividad_valordecimal,
            ac.contrato_id
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
        AND pt.presupuesto_obs=_presupuesto_obs
   group by actividad_id;
elseif _tipoControl='6' THEN -- CONSULTAR SUBACTIVIDADES DEL PRESUPUESTO
		 SELECT pt.presupuesto_id,
				pt.baremoactividad_id,
                pt.detalleactividad_id,								
				sb.subactividad_descripcion,
                pt.presupuesto_porcentaje,
                pt.presupuesto_valorporcentaje,
                pt.presupuesto_alcances,
                pt.presupuesto_entregables,
                pt.presupuesto_encargado,
				ba.contrato_id,
				da.actividad_id
           FROM pt_presupuesto pt
		   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
		   JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
		   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
		    AND da.detalleactividad_estado=1
		    AND pt.baremoactividad_id=_baremoactividad_id
			AND pt.detallepresupuesto_id=_detallepresupuesto_id
			AND pt.modulo_id=_modulo_id
			AND pt.presupuesto_obs=_presupuesto_obs
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
           presupuesto_programacion_obs=_presupuesto_obs,
           presupuesto_vehiculo=_presupuesto_alcances,
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
  
elseif _tipoControl='12' THEN    
		/*Detalle de la actividad*/
		SELECT sb.subestacion_nombre,
				ot.ordentrabajo_num,
				dp.detallepresupuesto_objeto,
				dp.detallepresupuesto_alcance,
				md.modulo_descripcion,
				lb.labor_descripcion,
                lb.labor_id,
				bm.baremo_item,
				ac.actividad_descripcion,
				ac.actividad_GOM,
				pt.presupuesto_porcentaje,
                pt.presupuesto_obs,
				pt.presupuesto_valorporcentaje,
                CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) AS item
			FROM pt_presupuesto pt
			JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
			LEFT JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
			JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id			
			JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
			JOIN dt_subestacion sb ON dp.subestacion_id=sb.subestacion_id	
			JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
			JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
			JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
			JOIN cf_labor lb ON bm.labor_id=lb.labor_id
			JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
			AND pt.presupuesto_estado=1
			AND pt.presupuesto_id=_presupuesto_id; 
elseif _tipoControl='13' THEN -- ACTUALIZAR ALCANCES
	UPDATE pt_presupuesto 
	   SET presupuesto_alcances=_presupuesto_alcances,
           presupuesto_fechamodifico=NOW(),                      
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico
	 WHERE presupuesto_id = _presupuesto_id;  
elseif _tipoControl='14' THEN -- ACTUALIZAR ENTREGABLES
	UPDATE pt_presupuesto 
	   SET presupuesto_entregables=_presupuesto_entregables,
           presupuesto_fechamodifico=NOW(),                      
           presupuesto_usuariomodifico=_presupuesto_usuariomodifico
	 WHERE presupuesto_id = _presupuesto_id;
     
elseif _tipoControl='15' THEN -- PORCENTAJE DE PROGRAMACION
SELECT COUNT(*) AS total FROM pt_presupuesto WHERE detallepresupuesto_id=_detallepresupuesto_id
 INTO _total_actividades;
SELECT COUNT(*) AS total FROM pt_presupuesto WHERE presupuesto_encargado IS NOT NULL AND detallepresupuesto_id=_detallepresupuesto_id
INTO _total_programadas;
SELECT _total_actividades AS total_actividades, _total_programadas AS total_programadas;
ELSEIF _tipoControl='16' THEN -- INSERTAR INGENIEROS y/O RESPONSABLES DE LA CUMPLIMENTACION Y/O PROGRAMACION
SELECT tecnicopresupuesto_id
            FROM cf_tecnico_presupuesto 
            WHERE presupuesto_id=_presupuesto_id AND perfilusuario_id=_presupuesto_encargado
            AND tecnicopresupuesto_tipotecnico=_presupuesto_entregables
            INTO _existe_tecnico;
            
             IF _existe_tecnico ="" THEN 
            
    
             
				INSERT INTO cf_tecnico_presupuesto(tecnicopresupuesto_usuariocreo,
												tecnicopresupuesto_fechacreo,	
                                                tecnicopresupuesto_porcentaje,
												presupuesto_id,
												perfilusuario_id,
                                                tecnicopresupuesto_tipotecnico,
                                                tecnicopresupuesto_estado)
										 VALUES(_presupuesto_alcances,		
												 NOW(),
												_presupuesto_porcentaje,
												_presupuesto_id,
												_presupuesto_encargado,
                                                _presupuesto_entregables,
                                                1
												);
				SET _tecnicopresupuesto_id= LAST_INSERT_ID();
                
               ELSE 
               
					
                    UPDATE cf_tecnico_presupuesto 
					   SET tecnicopresupuesto_usuariocreo=_presupuesto_alcances,
                           tecnicopresupuesto_porcentaje=_presupuesto_porcentaje,
						   tecnicopresupuesto_estado=1                      
					 WHERE tecnicopresupuesto_id = _existe_tecnico;
               
			END IF;
ELSEIF _tipoControl='17' THEN -- ELIMINAR TECNICOS DEL PRESUPUESTO
DELETE  FROM cf_tecnico_presupuesto WHERE presupuesto_id=_presupuesto_id AND tecnicopresupuesto_tipotecnico=1;
elseif _tipoControl='18' THEN -- CONSULTAR TECNICOS DEL PRESUPUESTO
		SELECT  pu.perfilusuario_id,
                us.usuario_id,
				concat(us.usuario_apellidos,' ',us.usuario_nombre)as tecnico
		   FROM pt_perfil_usuario pu
		   JOIN dt_usuario us ON pu.usuario_id=us.usuario_id
           JOIN cf_tecnico_presupuesto tp ON tp.perfilusuario_id=pu.perfilusuario_id 
           and tp.presupuesto_id=_presupuesto_id
            AND tp.tecnicopresupuesto_tipotecnico=1;
           
           
elseif _tipoControl='19' THEN -- COPIAR ACTIVIDADES DEL PRESUPUESTO     
    SET @ARRAY="0";
			SELECT presupuesto_id,                   
                   baremoactividad_id,
                   baremo_id,
                   detalleactividad_id,
                   tipobaremo_id,
                   presupuesto_obs
			  FROM pt_presupuesto 
			 WHERE detallepresupuesto_id=_detallepresupuesto_id
			   AND presupuesto_id=_presupuesto_id
			   AND presupuesto_estado=1
			  INTO _CPpresupuesto_id,                   
                   _CPbaremoactividad_id,
                   _CPbaremo_id,
                   _CPdetalleactividad_id,
                   _CPtipobaremo_id,
                   _CPpresupuesto_obs;
               
			SELECT presupuesto_id
			  FROM pt_presupuesto
			 WHERE detallepresupuesto_id=_detallepresupuesto_id
				AND baremoactividad_id=_CPbaremoactividad_id
				AND baremo_id=_CPbaremo_id
				AND detalleactividad_id=_CPdetalleactividad_id
				AND modulo_id=_modulo_id
				AND tipobaremo_id=_CPtipobaremo_id
				AND presupuesto_obs=_CPpresupuesto_obs
			  INTO _existe_presupuesto;
               
               IF _existe_presupuesto >0 THEN -- EXISTE PRESUPUESTO
					SET presupuesto_id_insert=_existe_presupuesto;
                    SET @ARRAY="0";
               ELSE -- NO EXISTE PRESUPUESTO
               
					ACTIVIDADES_CP: BEGIN
							
                            DECLARE _rowsPresupuesto BOOLEAN DEFAULT FALSE;
							DECLARE _CRtipoControl varchar(11);
							DECLARE _CRpresupuesto_id varchar(11);
							DECLARE _CRpresupuesto_alcances varchar(1000);
							DECLARE _CRpresupuesto_encargado varchar(11);
							DECLARE _CRpresupuesto_entregables varchar(500);
							DECLARE _CRpresupuesto_estado varchar(45);
							DECLARE _CRpresupuesto_fechaDECLAREi varchar(45);
							DECLARE _CRpresupuesto_fechafDECLARE varchar(45);
							DECLARE _CRpresupuesto_fechacreo varchar(45);
							DECLARE _CRpresupuesto_fechamodifico varchar(45);
							DECLARE _CRpresupuesto_obs varchar(5000);
							DECLARE _CRpresupuesto_porcentaje varchar(45);
							DECLARE _CRpresupuesto_usuariocreo varchar(45);
							DECLARE _CRpresupuesto_usuariomodifico varchar(45);
							DECLARE _CRpresupuesto_valorporcentaje varchar(45);
							DECLARE _CRarea_id varchar(45);
							DECLARE _CRdetallepresupuesto_id varchar(45);
							DECLARE _CRbaremoactividad_id varchar(45);
							DECLARE _CRbaremo_id varchar(45);
							DECLARE _CRdetalleactividad_id varchar(45);
							DECLARE _CRmodulo_id varchar(45);
							DECLARE _CRtipobaremo_id varchar(45);
                
                
							/*consular presupuesto*/
							DECLARE CR_presupuesto CURSOR FOR 
									SELECT presupuesto_id,
										   baremo_id,
                                           tipobaremo_id,
                                           modulo_id,
                                           detallepresupuesto_id,
                                           presupuesto_obs
									  FROM pt_presupuesto 
									 WHERE detallepresupuesto_id=_detallepresupuesto_id
									   AND presupuesto_id=_presupuesto_id									  
									   AND presupuesto_estado=1;   
								declare continue handler  for not found      
								SET _rowsPresupuesto = TRUE;
                                
								OPEN CR_presupuesto;
										Loop_presupuesto : LOOP
                                        
											FETCH CR_presupuesto INTO _CRpresupuesto_id,_CRbaremo_id,_CRtipobaremo_id,_CRmodulo_id,
																	  _CRdetallepresupuesto_id,_CRpresupuesto_obs;
											IF _rowsPresupuesto THEN
												 LEAVE Loop_presupuesto;
											END IF;
                                            
                                            -- traemos las labores de esta actividad
                                            LABORES:BEGIN
                                            
                                             DECLARE _rowslabores BOOLEAN DEFAULT FALSE;
										     DECLARE _CRlBpresupuesto_id varchar(11);
											 DECLARE _CRlBbaremoactividad_id varchar(11);	
                                             DECLARE _CRlBactividad_id varchar(45);
                                            
                                             DECLARE CR_labores CURSOR FOR 
                                             
															 SELECT pt.presupuesto_id,pt.baremoactividad_id,ac.actividad_id
															   FROM pt_presupuesto pt
															   JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
															   JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
															   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
																AND pt.baremo_id=_CRbaremo_id
																AND pt.tipobaremo_id=_CRtipobaremo_id
																AND pt.modulo_id=_CRmodulo_id
																AND bm.baremo_estado=1
																AND pt.detallepresupuesto_id=_CRdetallepresupuesto_id
																AND pt.presupuesto_estado=1
																AND pt.presupuesto_obs=_CRpresupuesto_obs
														   group by ac.actividad_id;
                                               
                                               declare continue handler  for not found      
											   SET _rowslabores = TRUE;
                                               
                                               OPEN CR_labores;
													Loop_labores:LOOP
														FETCH CR_labores INTO _CRlBpresupuesto_id,_CRlBbaremoactividad_id,_CRlBactividad_id;
															
                                                            IF _rowslabores THEN
																LEAVE Loop_labores;
															END IF;
                                                            
															SET  _CRlBpresupuesto_id = _CRlBpresupuesto_id;
															SET @ARRAY =CONCAT(@ARRAY,',',_CRlBpresupuesto_id);
															-- select  @ARRAY;
                                                            
                                                            -- consultar subactividades de las labores
                                                            SUBACTIVIDADES:BEGIN
																 DECLARE _rowsSubactividades BOOLEAN DEFAULT FALSE;
																 DECLARE _CRsBpresupuesto_id varchar(11);
                                             
																DECLARE CR_subactividades CURSOR FOR
                                                                
																		SELECT pt.presupuesto_id
																		  FROM pt_presupuesto pt
																		  JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
																		  JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
																		  JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
																			AND da.detalleactividad_estado=1
																			AND pt.baremoactividad_id=_CRlBbaremoactividad_id
																			AND pt.detallepresupuesto_id=_CRdetallepresupuesto_id
																			AND pt.modulo_id=_CRmodulo_id
																			AND pt.presupuesto_obs=_CRpresupuesto_obs
																			AND pt.presupuesto_estado=1;
                                                                    
                                                                    declare continue handler  for not found      
																	SET _rowsSubactividades = TRUE;
                                                                    
                                                                    OPEN CR_subactividades;
																		Loop_subactividades:LOOP
																		
                                                                        FETCH CR_subactividades INTO _CRsBpresupuesto_id;
																			
                                                                            IF _rowsSubactividades THEN 
																				LEAVE Loop_subactividades;
																			END IF;
                                                                            
                                                                            SET _CRsBpresupuesto_id = _CRsBpresupuesto_id;
																			SET @ARRAY =CONCAT(@ARRAY,',',_CRsBpresupuesto_id);
                                                                            
                                                                        END LOOP Loop_subactividades;
                                                                    
                                                                    CLOSE CR_subactividades;
                                                                    
                                                            END SUBACTIVIDADES;
                                                            
                                                    END LOOP Loop_labores;
                                               CLOSE CR_labores;
                                               
                                             END LABORES;
                                                                                          
										END LOOP Loop_presupuesto;
								CLOSE CR_presupuesto;	                
                    END ACTIVIDADES_CP;
                  
                  /*validar insert*/
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
							 SELECT presupuesto_alcances,
								    presupuesto_entregables,
									presupuesto_obs,
									presupuesto_porcentaje,
									presupuesto_usuariocreo,
									presupuesto_valorporcentaje,
									detallepresupuesto_id,
									baremoactividad_id,
									baremo_id,
									detalleactividad_id,
									_modulo_id,
									tipobaremo_id
                               from pt_presupuesto 
                               where FIND_IN_SET(presupuesto_id,@ARRAY); 
                               
						SET @ARRAY="1";
                        
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
		 SELECT @ARRAY as inserto;   
         
         
elseif _tipoControl='20' THEN -- INACTIVAR RESPONSABLE ACTIVIDAD
	UPDATE cf_tecnico_presupuesto 
	   SET tecnicopresupuesto_usuariocreo=_presupuesto_alcances,
           tecnicopresupuesto_estado=0                      
	 WHERE presupuesto_id = _presupuesto_id
       AND tecnicopresupuesto_tipotecnico=2;
       
elseif _tipoControl='21' THEN -- CONSULTAR ENCARGADO DEL PRESUPUESTO
		 SELECT pu.perfilusuario_id,
                us.usuario_id,
                us.usuario_apellidos,
				us.usuario_nombre,
				pr.perfil_nombre,
                ar.area_id,
                ar.area_nombre,
                pt.presupuesto_porcentaje
		   FROM pt_perfil_usuario pu
		   JOIN dt_usuario us ON pu.usuario_id=us.usuario_id
           JOIN cf_area ar ON pu.area_id=ar.area_id
		   JOIN cf_perfil pr ON pu.perfil_id=pr.perfil_id
           JOIN pt_presupuesto pt ON pu.perfilusuario_id=pt.presupuesto_encargado
		    AND pt.presupuesto_id=_presupuesto_id
	   GROUP BY pr.perfil_nombre,us.usuario_apellidos,us.usuario_nombre;
       
           
elseif _tipoControl='22' THEN -- CONSULTAR ENCARGADOS DEL PRESUPUESTO TABLA cf_tecnico_presupuesto
			SELECT pu.perfilusuario_id,
                us.usuario_id,
                us.usuario_apellidos,
				us.usuario_nombre,
				pr.perfil_nombre,
                ar.area_id,
                ar.area_nombre,
                pt.presupuesto_porcentaje
		   FROM pt_perfil_usuario pu
		   JOIN dt_usuario us ON pu.usuario_id=us.usuario_id
           JOIN cf_area ar ON pu.area_id=ar.area_id
		   JOIN cf_perfil pr ON pu.perfil_id=pr.perfil_id
           JOIN cf_tecnico_presupuesto tp ON pu.perfilusuario_id=tp.perfilusuario_id
		   JOIN pt_presupuesto pt ON tp.presupuesto_id=pt.presupuesto_id
		    AND tp.presupuesto_id=_presupuesto_id
			AND tp.tecnicopresupuesto_estado=1
            AND tp.tecnicopresupuesto_tipotecnico=2
	   GROUP BY pr.perfil_nombre,us.usuario_apellidos,us.usuario_nombre;
 
elseif _tipoControl='23' THEN -- cambiar presupuesto de contrato
	/*Entrada:_detallepresupuesto_id, contrato_id
    tipobaremo_id,baremo_item,contrato_id,detalleactividad_id,actividad_GOM,detalleactividad_id*/
    -- Salida
   -- baremoactividad_id
   -- baremo_id
   -- detalleactividad_id - 0
   -- 1.Sacar todos los presupuestos del detalle del presupuesto 
   /*AND pt.baremo_id=80
        AND pt.tipobaremo_id=1
	    AND pt.modulo_id=159
        AND bm.baremo_estado=1
        AND pt.detallepresupuesto_id=489
        AND pt.presupuesto_estado=1
        AND pt.presupuesto_ob*/
        
        PRESUPUESTO_CP: BEGIN
        
			DECLARE _rowsPresupuestoContrato BOOLEAN DEFAULT FALSE;
			DECLARE _ACpresupuesto_id varchar(45);
			DECLARE _ACtipobaremo_id varchar(45);
			DECLARE _ACdetalleactividad_id varchar(45);
			DECLARE _ACbaremoactividad_id varchar(45);
			DECLARE _ACbaremo_item varchar(45);
			DECLARE _ACactividad_GOM varchar(45);
                
                
			DECLARE CR_presupuesto_contrato CURSOR FOR
					
			SELECT pt.presupuesto_id,
				   pt.tipobaremo_id,
				   pt.detalleactividad_id,
				   pt.baremoactividad_id,
				   bm.baremo_item,
				   ac.actividad_GOM
			  FROM pt_presupuesto pt
			  JOIN pt_baremo_actividad ba ON pt.baremoactividad_id = ba.baremoactividad_id
			  JOIN pt_baremo bm ON ba.baremo_id = bm.baremo_id
			  JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
			 WHERE detallepresupuesto_id = _detallepresupuesto_id
			   AND presupuesto_estado = 1;
               							
               
			declare continue handler  for not found      
			SET _rowsPresupuestoContrato = TRUE;
			OPEN CR_presupuesto_contrato;
            
				Loop_presupuestoContrato : LOOP
                
					FETCH CR_presupuesto_contrato INTO _ACpresupuesto_id,_ACtipobaremo_id,_ACdetalleactividad_id,_ACbaremoactividad_id,
													   _ACbaremo_item,_ACactividad_GOM;
                                              
					IF _rowsPresupuestoContrato THEN
						 LEAVE Loop_presupuestoContrato;
					END IF;
                                              
					/*traemos el baremo_id del presupuesto*/
                     CP_BAREMO_ID:BEGIN
                     
						DECLARE _rowsbaremo_id BOOLEAN DEFAULT FALSE;
						DECLARE _ACbaremo_id varchar(11);
                        
                        DECLARE CR_baremo_id CURSOR FOR 
                        
							SELECT baremo_id 
							  FROM pt_baremo 
							 WHERE tipobaremo_id=_ACtipobaremo_id 
							   AND baremo_item=_ACbaremo_item 
							   AND contrato_id=_presupuesto_id; 
                           
                           declare continue handler  for not found      
						   SET _rowsbaremo_id = TRUE;
                           
                           OPEN CR_baremo_id;
								Loop_baremoId:LOOP
									FETCH CR_baremo_id INTO _ACbaremo_id;
                                    
										IF _rowsbaremo_id THEN 
											LEAVE Loop_baremoId;
										END IF;
                                        
										/*sacar el id de la actividad*/
                                        BG_IDACTIVIDAD:BEGIN
											DECLARE _rowactividad_id BOOLEAN DEFAULT FALSE;
											DECLARE _actividad_id VARCHAR(21);
                                            
                                            DECLARE CR_ACTIVIDADID CURSOR FOR
                                            
                                            SELECT actividad_id
                                            FROM cf_actividad 
                                            WHERE actividad_GOM=_ACactividad_GOM 
                                            AND contrato_id=_presupuesto_id;
                                            
                                            declare continue handler for not found
                                            SET _rowactividad_id=TRUE;
                                            
                                            OPEN CR_ACTIVIDADID;
                                            
												Loop_actividadId:LOOP
                                                
													FETCH CR_ACTIVIDADID INTO _actividad_id;
                                                    
                                                    IF _rowactividad_id THEN 
														LEAVE Loop_actividadId;
													END IF;
                                                    
                                                    /*Sacar el baremoactividad_id*/
                                                     BG_IDBAREMOACTIVIDAD:BEGIN
														DECLARE _rowbaremoactividad_id BOOLEAN DEFAULT FALSE;
														DECLARE _baremoactividad_id VARCHAR(21);
                                                        
                                                        DECLARE CR_BAREMOACTIVIDAD_ID CURSOR FOR
															SELECT baremoactividad_id 
															  FROM pt_baremo_actividad 
															 WHERE baremo_id=_ACbaremo_id 
															   AND actividad_id=_actividad_id  
															   AND contrato_id=_presupuesto_id
															   AND baremoactividad_estado=1;
                                                                
                                                    declare continue handler for not found
													SET _rowbaremoactividad_id=TRUE;
                                            
														OPEN CR_BAREMOACTIVIDAD_ID;
														
															Loop_baremoActividadId:LOOP 
																FETCH CR_BAREMOACTIVIDAD_ID INTO _baremoactividad_id;
																	  IF _rowbaremoactividad_id THEN 
																			LEAVE Loop_baremoActividadId;
																		END IF;
                                                                        
                                                                /*Validar detalleactividad_id*/
                                                                 BG_DETALLEACTIVIDADID:BEGIN
																	DECLARE _rowadetallectividad_id BOOLEAN DEFAULT FALSE;
																	DECLARE _NewDetalleactividad_id VARCHAR(21);
                                                                    DECLARE _subactividad_id VARCHAR(21);
                                                                    DECLARE _NewPresupuesto_id VARCHAR(21);
                                                                    
																	IF  _ACdetalleactividad_id=0 THEN 
                                                                    
																		SET	_NewDetalleactividad_id=_NewDetalleactividad_id;
                                                                        
																	else
																		
                                                                        /*Sacar el id de la subactividad*/
																			SELECT subactividad_id 
																			  FROM pt_detalle_actividad 
																			 WHERE detalleactividad_id=_ACdetalleactividad_id
																			  INTO _subactividad_id;
                                                                              
                                                                           /*traer el detalleactividad_id para insertar en el nuevp cpntrato*/
																			   SELECT detalleactividad_id 
																				 FROM pt_detalle_actividad 
																				 WHERE actividad_id=_actividad_id
																				   AND contrato_id=_presupuesto_id 
																				   AND baremoactividad_id=_baremoactividad_id 
																				   AND subactividad_id=_subactividad_id
																				   AND detalleactividad_estado=1
                                                                                   INTO _NewDetalleactividad_id;
																	
                                                                    END IF;
                                                                    
                                                                    
                                                                    /*INSERTAR Y VALIDAR EL REGISTRO DEL PRESUPUESTO*/
                                                                    -- _NewDetalleactividad_id
                                                                    -- _baremoactividad_id
																	-- _ACbaremo_id
                                                                    
                                                                    -- Validar si ya se encuentra registrada
																		SELECT presupuesto_id 
                                                                          FROM pt_presupuesto 
																		 WHERE detallepresupuesto_id=_detallepresupuesto_id
																		   AND baremoactividad_id=_baremoactividad_id
                                                                           AND baremo_id=_ACbaremo_id 
                                                                           AND detalleactividad_id=_NewDetalleactividad_id
																		   INTO _NewPresupuesto_id;
                                                                           
                                                                           IF _NewPresupuesto_id <> "" THEN
                                                                           
																			-- ACTUALIZAMOS EL REGISTRO
																				SET _NewPresupuesto_id=_NewPresupuesto_id;
                                                                            -- FIN ACTUALIZAR REGISTRO
                                                                            ELSE 
                                                                             -- ACTUALIZAR REGISTRO PRESUPUESTO
                                                                             	UPDATE pt_presupuesto 
																				   SET baremoactividad_id = _baremoactividad_id,           
																					   baremo_id=_ACbaremo_id,
																					   detalleactividad_id=_NewDetalleactividad_id,      
																					   presupuesto_fechamodifico=NOW()	
																				 WHERE presupuesto_id = _ACpresupuesto_id;
																			-- 	 SET presupuesto_id_insert= _existe_presupuesto;
                                                                                 																
                                                                           END IF;
                                                                    -- Fin validacion
                                                                    /*FIN INSERTAR Y VALIDAR REGISTRO PRESUPUESTO*/
                                                                    
																 END BG_DETALLEACTIVIDADID;
                                                                /*Fin valida detalleactividad_id*/
                                                                
															END LOOP Loop_baremoActividadId;
														CLOSE CR_BAREMOACTIVIDAD_ID;
                                                     END BG_IDBAREMOACTIVIDAD;
                                                    /*Fin Sacar el baremoactividad_id*/
                                                    
                                                END LOOP Loop_actividadId;
                                            CLOSE CR_ACTIVIDADID;
                                        END BG_IDACTIVIDAD;
                                        /*fin consulta actividad_id*/
                                    
								END LOOP Loop_baremoId;
							CLOSE CR_baremo_id;
                    END CP_BAREMO_ID;
                    
				END LOOP Loop_presupuestoContrato;
			CLOSE CR_presupuesto_contrato;
                    /*
			  INTO _CPpresupuesto_id,
				   _CPtipobaremo_id,
				   _CPdetalleactividad_id,
				   _CPbaremoactividad_id,
				   _baremo_item,
				   _actividad_GOM;
			*/
			/*
			   select * from pt_baremo where tipobaremo_id=1 and baremo_item=1 and contrato_id=2; -- baremo_id
			   select * from cf_actividad where actividad_GOM='SM01CIV' and contrato_id=2;
			   select * from pt_baremo_actividad where baremo_id=196 and actividad_id=349  and contrato_id=2; -- baremoactividad_id
			   select * from pt_detalle_actividad where detalleactividad_id=273;
			   select * from pt_detalle_actividad where actividad_id=349 and contrato_id=2 and baremoactividad_id=349 and subactividad_id=1;
			*/
			
		END PRESUPUESTO_CP;
end if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_RplaboresAsignadas` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_RplaboresAsignadas` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RplaboresAsignadas`(
IN _tipoControl varchar(11),
IN _detallepresupuesto_id varchar(11)
)
BEGIN 
DECLARE baremoactividad_id_insert INT;
/*select * from pt_seguimiento where seguimiento_fechacreo = (
    SELECT MAX(seguimiento_fechacreo)
    FROM pt_seguimiento where presupuesto_id=11693
    );
SELECT *
    FROM pt_seguimiento where presupuesto_id=11693;*/
if _tipoControl='1' THEN -- mostrar ot con el numero de labores, porcentaje y total programado
SELECT 
		pt.presupuesto_id,
		dp.detallepresupuesto_id,
		ot.ordentrabajo_num,
		ot.ordentrabajo_fechaini,
        ot.ordentrabajo_fechafin,        
		DATEDIFF( NOW(), ot.ordentrabajo_fechaini) as valor_1,
		DATEDIFF( ot.ordentrabajo_fechafin, ot.ordentrabajo_fechaini) as valor_2,  
		ROUND((( DATEDIFF( NOW(), ot.ordentrabajo_fechaini)/DATEDIFF( ot.ordentrabajo_fechafin, ot.ordentrabajo_fechaini))*100 ), 1 )AS porcentaje_tiempo,
		dp.detallepresupuesto_nombre,
		sbe.subestacion_nombre,
		md.modulo_descripcion,
		ROUND(sum(pt.presupuesto_porcentaje),1)as porcentaje,        
		sum(pt.presupuesto_valorporcentaje) as valor_total,
        (round((sum(pt.presupuesto_valorporcentaje)*1)/dp.detallepresupuesto_total,1) *100) as porcentaje_asignado,
		COUNT(*) Total
   FROM pt_presupuesto pt
   JOIN pt_orden_trabajo ot ON pt.detallepresupuesto_id=ot.detallepresupuesto_id
   JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
   JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
   JOIN dt_subestacion sbe ON dp.subestacion_id=sbe.subestacion_id
	AND pt.presupuesto_estado=1
	AND ot.ordentrabajo_estado=1
	AND dp.detallepresupuesto_estado <>0
	AND pt.presupuesto_encargado is not null
group by dp.detallepresupuesto_id
  HAVING COUNT(*) >= 1;
 
 
 elseif _tipoControl='2' THEN -- consultar el % y el valor del avance de las actividades asignadas
	AVANCE:BEGIN
		DECLARE _rowslb BOOLEAN DEFAULT FALSE;
        DECLARE _presupuesto_id INT DEFAULT 0;
        DECLARE _presupuesto_porcentaje DECIMAL(4,3);
        DECLARE _presupuesto_valorporcentaje DECIMAL(20,3);
        DECLARE _detallepresupuesto_total DECIMAL(20,3);
		DECLARE _total_porcentaje DECIMAL(20,4) default 0;
		DECLARE _total_avance DECIMAL(20,4) default 0;
        
        /*labores asignadas*/
            DECLARE CR_LABORES CURSOR FOR 
			
				SELECT pt.presupuesto_id,
					   pt.presupuesto_porcentaje,
					   pt.presupuesto_valorporcentaje,
                       dp.detallepresupuesto_total
				  FROM pt_presupuesto pt
                  JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
				 WHERE pt.presupuesto_estado=1
				   AND pt.presupuesto_encargado is not null
				   AND pt.detallepresupuesto_id=_detallepresupuesto_id;
				   
					  DECLARE CONTINUE handler FOR NOT FOUND
					  SET _rowslb=TRUE;
            
					  OPEN CR_LABORES;
						loop_labores: LOOP
                        
							FETCH CR_LABORES INTO _presupuesto_id,_presupuesto_porcentaje,_presupuesto_valorporcentaje,_detallepresupuesto_total;
                    
								IF _rowslb=TRUE THEN 
									LEAVE loop_labores;
								END IF;
                                
                                
                                
                                CALCULAR:BEGIN 
									DECLARE _rowcal_avanve BOOLEAN DEFAULT FALSE;
									DECLARE _porcentaje_avc DECIMAL(20,3);
									DECLARE _total_avc DECIMAL(20,4);
                                    DECLARE _seguimiento_avance DECIMAL(20,4);									
									
									DECLARE CR_AVANCE CURSOR FOR 
                                    
										  SELECT seguimiento_avance 
											FROM pt_seguimiento 
											WHERE seguimiento_fechacreo  = (SELECT MAX(seguimiento_fechacreo)
																		      FROM pt_seguimiento
																		     WHERE presupuesto_id =_presupuesto_id AND seguimiento_estado=1);
																		  
									declare continue handler for not found  
									-- for sqlstate '02000'																								
									SET _rowcal_avanve = TRUE;
									OPEN CR_AVANCE;
											Loop_avance:LOOP
													FETCH CR_AVANCE INTO _seguimiento_avance;
													IF _rowcal_avanve THEN
														LEAVE Loop_avance;
													END IF;
													
														/*calcular % y valor de avance*/
                                                     
														IF(_seguimiento_avance>1)THEN
                                                        
															SET _porcentaje_avc=_seguimiento_avance;
															SET _total_avc=(_presupuesto_valorporcentaje*_porcentaje_avc)/100;	
																													
															
															
															SET _total_avance=_total_avc+_total_avance;
															-- se multiplica por 100 para ver el valor en una escala 0 al 100 %
															-- SET _total_porcentaje=_total_porcentaje + _porcentaje_avc;
															SET _total_porcentaje=ROUND(((_total_avance*1)/_detallepresupuesto_total)*100);
                                                            
                                                        ELSE	
														
															-- SET _porcentaje_avc=(_seguimiento_avance*100)/_presupuesto_porcentaje;
                                                            
                                                            SET _porcentaje_avc=(_seguimiento_avance*100);
															SET _total_avc=(_presupuesto_valorporcentaje*_porcentaje_avc)/100;	
																																						
															
                                                            
                                                            
                                                            
                                                            
															SET _total_avance=_total_avc+_total_avance;
                                                            
															-- se multiplica por 100 para ver el valor en una escala 0 al 100 %
															-- SET _total_porcentaje=_total_porcentaje + _porcentaje_avc;
															SET _total_porcentaje=((_total_avance*1)/_detallepresupuesto_total)*100;
                                                           
                                                          --  SET _total_porcentaje=_total_porcentaje*100;
                                                        END IF;
			
                                                        
														/*Fin calcular % y valor de avance*/
                                                    
											END LOOP Loop_avance;
									CLOSE CR_AVANCE;
								END CALCULAR;                                
						END LOOP loop_labores;
					  CLOSE CR_LABORES;                      
		/*Fin de labores asignadas*/
          SELECT _total_porcentaje,  _total_avance;
    END AVANCE;
    
ELSEIF _tipoControl='3' THEN -- Traer el detalle de las labores asignadas
	SELECT ot.ordentrabajo_num,
		   md.modulo_descripcion,
		   pt.presupuesto_id,
		   tb.tipobaremo_sigla,
		   bm.baremo_item,	  
		   lb.labor_descripcion,
		 --  ac.actividad_descripcion,
		   pt.presupuesto_porcentaje,
		   pt.presupuesto_valorporcentaje,
		   ar.area_nombre,
		   sb.subactividad_descripcion,
		   pt.presupuesto_progestado,
		   sg.seguimiento_estado,  
		   sg.seguimiento_avance,
		   if(sg.seguimiento_avance>1,convert((pt.presupuesto_valorporcentaje*(sg.seguimiento_avance))/100 ,decimal(20,2)) ,
									  convert((pt.presupuesto_valorporcentaje*(sg.seguimiento_avance*100))/100 ,decimal(20,2)) ) as valor_avance,
		   
		   -- convert((pt.presupuesto_valorporcentaje*(sg.seguimiento_avance*100))/100 ,decimal(20,2)) as valor_avance ,
		 if(sg.seguimiento_avance>1,sg.seguimiento_avance,sg.seguimiento_avance*100) as avance_porc,
		  CONCAT(usu_enc.usuario_nombre, ' ', usu_enc.usuario_apellidos ) AS responsable
			
	  FROM pt_presupuesto pt
	  JOIN cf_area ar ON pt.area_id=ar.area_id
      JOIN pt_orden_trabajo ot ON pt.detallepresupuesto_id=ot.detallepresupuesto_id
	  JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
	   left join(SELECT presupuesto_id, max(seguimiento_fechacreo) AS max_fecha 
				FROM pt_seguimiento
				WHERE seguimiento_estado=1
				GROUP BY presupuesto_id
				) AS seg 
		   ON pt.presupuesto_id = seg.presupuesto_id      
	LEFT JOIN pt_seguimiento sg ON pt.presupuesto_id=sg.presupuesto_id
		  AND sg.seguimiento_fechacreo  = seg.max_fecha
		 JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		 JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		 JOIN pt_perfil_usuario per_enc ON pt.presupuesto_encargado=per_enc.perfilusuario_id
			   JOIN dt_usuario usu_enc ON per_enc.usuario_id=usu_enc.usuario_id
	   --  JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id 
		 -- JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
		 JOIN cf_labor lb ON bm.labor_id=lb.labor_id
	LEFT JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
	LEFT JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	 
		WHERE pt.presupuesto_estado=1
		  AND pt.presupuesto_encargado is not null  
		  AND pt.detallepresupuesto_id=_detallepresupuesto_id;
    
    
ELSEIF _tipoControl='4' THEN -- Traer el total de tareas finalizadas por area
    select  ar.area_nombre,
			 pt.presupuesto_progestado,
			 pt.presupuesto_fechamodifico,
              sum(pt.presupuesto_valorporcentaje) AS valor_factura,
			 MONTH(pt.presupuesto_fechamodifico)  as mes_num,
			 CASE MONTH(pt.presupuesto_fechamodifico)
				 WHEN 1 THEN '0'
				 WHEN 2 THEN '1'
				 WHEN 3 THEN '2'
				 WHEN 4 THEN '3'
				 WHEN 5 THEN '4'
				 WHEN 6 THEN '5'
				 WHEN 7 THEN '6'
				 WHEN 8 THEN '7'
				 WHEN 9 THEN '8'
				 WHEN 10 THEN '9'
				 WHEN 11 THEN '10'
				 WHEN 12 THEN '11'            
             END mes,
			 date_format( pt.presupuesto_fechamodifico,'%Y') as year,
			 COUNT(*) Total
			 from pt_presupuesto pt
			JOIN cf_area ar ON pt.area_id=ar.area_id
			where pt.presupuesto_progestado  IN ('FINALIZADA','FACTURA PARCIAL')
			group by ar.area_nombre, mes
			HAVING count( pt.area_id) >1;
            
ELSEIF _tipoControl='5' THEN
		SELECT ot.ordentrabajo_num,
				concat(tb.tipobaremo_sigla,'-',bm.baremo_item)as labor,
				pt.detallepresupuesto_id,
				pt.presupuesto_id,
				seg.seguimiento_id,
				ar.area_nombre,
				pt.presupuesto_progestado,
				pt.presupuesto_fechamodifico,
				seg.seguimiento_fechacreo,
				-- DATE_FORMAT(seg.seguimiento_fechaini,'%Y-%m-%d') as fecha_inicio,
                DATE_FORMAT(seg.seguimiento_fechaini,'%d-%m-%Y') as fecha_inicio,
				DATE_FORMAT(seg.seguimiento_fechafin,'%d-%m-%Y') as fecha_fin,
				-- seg.seguimiento_fechafin,
				date_format( pt.presupuesto_fechamodifico,'%M') as mes,
				date_format( pt.presupuesto_fechamodifico,'%Y') as year
				-- COUNT(*) Total
		FROM pt_presupuesto pt
        JOIN pt_orden_trabajo ot ON pt.detallepresupuesto_id=ot.detallepresupuesto_id
		JOIN cf_area ar ON pt.area_id=ar.area_id
		JOIN pt_seguimiento seg ON pt.presupuesto_id=seg.presupuesto_id
        JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		WHERE pt.presupuesto_progestado  IN ('FINALIZADA','FACTURA PARCIAL')
		AND seg.seguimiento_estado=1
        group by pt.presupuesto_id;
		-- AND pt.detallepresupuesto_id=7;   
        
ELSEIF _tipoControl='6' THEN
		SELECT ot.ordentrabajo_num,
				concat(tb.tipobaremo_sigla,'-',bm.baremo_item)as labor,
				pt.detallepresupuesto_id,
				pt.presupuesto_id,
				seg.seguimiento_id,
				ar.area_nombre,
                md.modulo_descripcion,
				pt.presupuesto_progestado,
				pt.presupuesto_fechamodifico,
				seg.seguimiento_fechacreo,
				-- DATE_FORMAT(seg.seguimiento_fechaini,'%Y-%m-%d') as fecha_inicio,
                DATE_FORMAT(seg.seguimiento_fechaini,'%d-%m-%Y') as fecha_inicio,
				DATE_FORMAT(seg.seguimiento_fechafin,'%d-%m-%Y') as fecha_fin,
				-- seg.seguimiento_fechafin,
				date_format( pt.presupuesto_fechamodifico,'%M') as mes,
				date_format( pt.presupuesto_fechamodifico,'%Y') as year
				-- COUNT(*) Total
		FROM pt_presupuesto pt
        JOIN pt_orden_trabajo ot ON pt.detallepresupuesto_id=ot.detallepresupuesto_id
		JOIN cf_area ar ON pt.area_id=ar.area_id
		JOIN pt_seguimiento seg ON pt.presupuesto_id=seg.presupuesto_id
        JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
		JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
		-- WHERE pt.presupuesto_progestado  IN ('FINALIZADA','FACTURA PARCIAL')
		AND seg.seguimiento_estado=1
        AND pt.detallepresupuesto_id=_detallepresupuesto_id
        group by pt.presupuesto_id;
		-- AND pt.detallepresupuesto_id=7; 
        
        
ELSEIF _tipoControl='7' THEN
            select  ar.area_nombre,
			 pt.presupuesto_progestado,
			 pt.presupuesto_fechamodifico,
             round(sum(pt.presupuesto_valorporcentaje),2)as factura,
			 MONTH(pt.presupuesto_fechamodifico)  as mes_num,
			 CASE MONTH(pt.presupuesto_fechamodifico)
				 WHEN 1 THEN '0'
				 WHEN 2 THEN '1'
				 WHEN 3 THEN '2'
				 WHEN 4 THEN '3'
				 WHEN 5 THEN '4'
				 WHEN 6 THEN '5'
				 WHEN 7 THEN '6'
				 WHEN 8 THEN '7'
				 WHEN 9 THEN '8'
				 WHEN 10 THEN '9'
				 WHEN 11 THEN '10'
				 WHEN 12 THEN '11'            
             END mes,
			 date_format( pt.presupuesto_fechamodifico,'%Y') as year,
			 COUNT(*) Total
			 from pt_presupuesto pt
			JOIN cf_area ar ON pt.area_id=ar.area_id
			where pt.presupuesto_progestado  IN ('FINALIZADA','FACTURA PARCIAL')
			group by ar.area_nombre
			HAVING count( pt.area_id) >1;
END IF;
    
 
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
DECLARE subestacionmodulo_id_insert INT;
DECLARE _existe_subestacionmodulo INT DEFAULT 0;
 
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
elseif _tipoControl='3' THEN -- Consultar Tipo Modulo
	SELECT * FROM dt_tipo_modulo WHERE tipomodulo_estado=1 ORDER BY tipomodulo_descripcion ASC;
elseif _tipoControl='4' THEN -- Insertar Tipo Modulo
	SELECT tipomodulo_id 
      FROM dt_tipo_modulo 
	 WHERE tipomodulo_descripcion=_modulo_descripcion
	  INTO _existe_modulo;
IF _existe_modulo >0 then
	UPDATE dt_tipo_modulo 
	   SET tipomodulo_estado = 1,
           tipomodulo_fechamodifico=NOW(),
           tipomodulo_usuariomodifico=_modulo_usuariocreo
	 WHERE tipomodulo_id = _existe_modulo;
	 SET modulo_id_insert= _existe_modulo;
ELSE
	 INSERT INTO dt_tipo_modulo(tipomodulo_descripcion,
						        tipomodulo_usuariocreo)
					VALUES(_modulo_descripcion,
						   _modulo_usuariocreo
							);
	 SET modulo_id_insert= LAST_INSERT_ID();
END IF;
select modulo_id_insert;
elseif _tipoControl='5' THEN -- Insertar cf_modulo_subestacion
  -- activar o insertar modulos a la subestacion
	SELECT modulsubestacion_id 
      FROM cf_modulo_subestacion
	 WHERE modulo_id=_modulo_descripcion
	   AND subestacion_id=_modulo_estado
	   AND tipomodulo_id=_modulo_fechacreo
	   AND modulosubestacion_voltaje=_modulo_usuariomodifico
	  INTO _existe_subestacionmodulo;
IF _existe_subestacionmodulo >0 then
	UPDATE cf_modulo_subestacion 
	   SET modulosubestacion_estado = 1,
           modulosubestacion_fechamodifico=NOW(),
           modulosubestacion_usuariomodifico=_modulo_usuariocreo
	 WHERE modulsubestacion_id = _existe_subestacionmodulo;
	 SET subestacionmodulo_id_insert= _existe_subestacionmodulo;
ELSE
	 INSERT INTO cf_modulo_subestacion(modulosubestacion_usuariocreo,
									   modulosubestacion_voltaje,
									   modulo_id,
									   subestacion_id,
									   tipomodulo_id)
								VALUES(_modulo_usuariocreo,
									   _modulo_usuariomodifico,
									   _modulo_descripcion,
									   _modulo_estado,
									   _modulo_fechacreo
										);
	 SET subestacionmodulo_id_insert= LAST_INSERT_ID();
END IF;
select subestacionmodulo_id_insert;
elseif _tipoControl='6' THEN -- Consultar subestaciones
	SELECT ms.subestacion_id,sb.subestacion_nombre
	FROM cf_modulo_subestacion ms
	JOIN dt_subestacion sb ON ms.subestacion_id=sb.subestacion_id
	AND sb.subestacion_estado=1
	group by sb.subestacion_nombre desc;
elseif _tipoControl='7' THEN -- detalle de los modulos por subestacion
	SELECT ms.modulsubestacion_id,
		   ms.subestacion_id,
		   sb.subestacion_nombre,
		   tm.tipomodulo_id,
		   tm.tipomodulo_descripcion,
		   md.modulo_id,
		   md.modulo_descripcion,
		   ms.modulosubestacion_voltaje
	FROM cf_modulo_subestacion ms
	JOIN dt_subestacion sb ON ms.subestacion_id=sb.subestacion_id
	JOIN dt_tipo_modulo tm ON ms.tipomodulo_id=tm.tipomodulo_id
	JOIN cf_modulo md ON ms.modulo_id=md.modulo_id
	AND ms.modulosubestacion_estado=1
	AND ms.subestacion_id=_modulo_id;
elseif _tipoControl='8' THEN -- Eliminar Subestacionmodulo
  	UPDATE cf_modulo_subestacion 
	   SET modulosubestacion_estado = 0,
           modulosubestacion_fechamodifico=NOW(),
           modulosubestacion_usuariomodifico=_modulo_usuariocreo
	 WHERE subestacion_id = _modulo_id;
     
elseif _tipoControl='9' then
  -- Inactivar modulos a la subactividad
  	UPDATE cf_modulo_subestacion 
	   SET modulosubestacion_estado = 0,
           modulosubestacion_fechamodifico=NOW(),
           modulosubestacion_usuariomodifico=_modulo_usuariocreo
	 WHERE subestacion_id = _modulo_estado;
END IF;
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
	        AND cl.cliente_estado=1
	   GROUP BY cl.cliente_descripcion,ct.contrato_numero;
       
elseif _tipoControl='7' THEN -- listar los contratos por los clientes
		SELECT * FROM dt_contrato
		WHERE cliente_id=_cliente_id
		AND contrato_estado=1;
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
elseif _tipoControl='3' THEN -- Actualizar soporte
	UPDATE dt_soporte 
	   SET soporte_nombre = _soporte_nombre,
           soporte_tamano=_soporte_tamano,
           soporte_tipo=_soporte_tipo,
		   soporte_url=_soporte_url,
		   soporte_usuariomodifico=_soporte_usuariomodifico,
		   soporte_fechamodifico=NOW()
	 WHERE soporte_id = _soporte_id;
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
IN _detallepresupuesto_usuariocreo varchar(100),
IN _detallepresupuesto_usuariomodifico varchar(45),
IN _subestacion_id varchar(45),
IN _contrato_id varchar(45),
IN _detallepresupuesto_porcentincremento varchar(45),
IN _detallepresupuesto_valorincremento varchar(10000)
)
BEGIN
DECLARE detallepresupuesto_id_insert INT;
DECLARE _incrementopresupuesto_id_insert INT;
DECLARE _existe_detallepresupuesto INT DEFAULT 0;
 
if _tipoControl='1' THEN -- Consultar
			 SELECT dp.detallepresupuesto_id,
					dp.detallepresupuesto_estado,
					cl.cliente_descripcion,
					sb.subestacion_nombre,
					dp.detallepresupuesto_fechaini,
					dp.detallepresupuesto_nombre,
					dp.detallepresupuesto_total,
                    (detallepresupuesto_total+IFNULL(detallepresupuesto_valorincremento,0)) as total_presupuesto_incremento 
			   FROM dt_detalle_presupuesto dp
			   JOIN dt_contrato ct ON dp.contrato_id=ct.contrato_id
			   JOIN dt_cliente cl ON ct.cliente_id=cl.cliente_id
			   JOIN dt_subestacion sb ON dp.subestacion_id=sb.subestacion_id
			    AND dp.detallepresupuesto_estado <> 0
                ORDER BY dp.detallepresupuesto_id DESC;
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
           detallepresupuesto_codensaGestor=_detallepresupuesto_valorincremento,
		   -- detallepresupuesto_total=_detallepresupuesto_total,
           detallepresupuesto_fechamodifico=NOW(),
           detallepresupuesto_usuariomodifico=_detallepresupuesto_usuariocreo,
           contrato_id=_contrato_id
	 WHERE detallepresupuesto_id = _existe_detallepresupuesto;
	 SET detallepresupuesto_id_insert= _existe_detallepresupuesto;
ELSE
	 INSERT INTO dt_detalle_presupuesto(detallepresupuesto_alcance,
										detallepresupuesto_codensaGestor,
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
									   _detallepresupuesto_valorincremento,
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
					-- (SELECT count(*) FROM pt_presupuesto WHERE presupuesto_encargado IS NOT NULL AND detallepresupuesto_id=dp.detallepresupuesto_id AND presupuesto_estado=1) AS actividades_programadas,
					-- (SELECT count(*) FROM pt_presupuesto WHERE detallepresupuesto_id=dp.detallepresupuesto_id AND presupuesto_estado=1) AS total_actividades,
					dp.detallepresupuesto_estado,
					cl.cliente_descripcion,
					sb.subestacion_nombre,
					dp.detallepresupuesto_fechaini,
					dp.detallepresupuesto_nombre,
					dp.detallepresupuesto_total,
					dp.detallepresupuesto_valorincremento,
                    ot.ordentrabajo_fechaini,
                    ot.ordentrabajo_fechafin
			FROM dt_detalle_presupuesto dp
			INNER JOIN dt_subestacion sb ON dp.subestacion_id=sb.subestacion_id
			LEFT JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
			INNER JOIN dt_contrato ct ON dp.contrato_id=ct.contrato_id
			INNER JOIN dt_cliente cl ON ct.cliente_id=cl.cliente_id
			AND dp.detallepresupuesto_estado=3 OR dp.detallepresupuesto_estado=4;
        
elseif _tipoControl='6' THEN
	UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_estado = 1,
           detallepresupuesto_alcance=_detallepresupuesto_alcance,
		   detallepresupuesto_fechaini=_detallepresupuesto_fechaini,
		   detallepresupuesto_fechafin=_detallepresupuesto_fechafin, 
		   detallepresupuesto_gestor=_detallepresupuesto_gestor,
		   detallepresupuesto_objeto=_detallepresupuesto_objeto,
		   detallepresupuesto_nombre=_detallepresupuesto_nombre,
           detallepresupuesto_codensaGestor=_detallepresupuesto_valorincremento,
		   -- detallepresupuesto_total=_detallepresupuesto_total,
           detallepresupuesto_fechamodifico=NOW(),
           detallepresupuesto_usuariomodifico=_detallepresupuesto_usuariocreo,
           contrato_id=_contrato_id
	 WHERE detallepresupuesto_id = _detallepresupuesto_id;
	 SET detallepresupuesto_id_insert= _detallepresupuesto_id;
select detallepresupuesto_id_insert;
ELSEIF _tipoControl='7' THEN -- buscar actividades de tipo labor de un presupuesto
SELECT dp.detallepresupuesto_id,
		pt.presupuesto_id,
		pt.presupuesto_valorporcentaje,
		sb.subactividad_descripcion
   FROM pt_presupuesto pt
   JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
   JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
	AND sb.subactividad_id=1
	AND pt.presupuesto_estado=1
	AND dp.detallepresupuesto_id=_detallepresupuesto_id;
ELSEIF _tipoControl='8' THEN -- Actualizar el incremento del presupuesto
	UPDATE dt_detalle_presupuesto 
	   SET detallepresupuesto_porcentincremento = _detallepresupuesto_porcentincremento,
           detallepresupuesto_tipoincremento=_detallepresupuesto_usuariocreo,
		   detallepresupuesto_valorincremento=_detallepresupuesto_valorincremento,
           detallepresupuesto_fechamodifico=NOW(),
           detallepresupuesto_usuariomodifico=_detallepresupuesto_usuariomodifico
	 WHERE detallepresupuesto_id = _detallepresupuesto_id;
     
     ELSEIF _tipoControl='9' THEN -- Insertar varios incrementos
     
     
     	 INSERT INTO dt_incremento_presupuesto(incrementopresupuesto_estado,
									    incrementopresupuesto_porcentaje,
										incrementopresupuesto_tipo,
                                        incrementopresupuesto_idtipo,
										incrementopresupuesto_usuariocreo,
										incrementopresupuesto_valor,
										detallepresupuesto_id)
								VALUES(1,
									   _detallepresupuesto_porcentincremento,
									   _detallepresupuesto_usuariocreo,
                                       _detallepresupuesto_estado,
									   _detallepresupuesto_usuariomodifico,
									   _detallepresupuesto_valorincremento,
									   _detallepresupuesto_id);
	 SET _incrementopresupuesto_id_insert= LAST_INSERT_ID();
     
ELSEIF _tipoControl='10' THEN 
     delete from dt_incremento_presupuesto where detallepresupuesto_id=_detallepresupuesto_id;
     
elseif _tipoControl='11' THEN -- consultar los incrementos del presupuesto
		SELECT * 
		  FROM dt_incremento_presupuesto 
		 WHERE detallepresupuesto_id=_detallepresupuesto_id
         AND incrementopresupuesto_estado=1;
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
		    AND pr.perfil_id=8
	   GROUP BY pr.perfil_nombre,us.usuario_apellidos,us.usuario_nombre;
elseif _tipoControl='5' THEN -- cambiar clave
	UPDATE dt_usuario 
	   SET usuario_password = _usuario_password,
           usuario_fechamodifico=NOW(),
           usuario_usuariomodifico=_usuario_usuariomodifico
	 WHERE usuario_id = _usuario_id;
END if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_idexacionBm` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_idexacionBm` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_idexacionBm`(
IN _valor double(15,10),
IN _contrato_id varchar(10)
)
BAREMOS:BEGIN
		
		DECLARE _baremo_id INT DEFAULT 0;
		DECLARE _rowsbm BOOLEAN DEFAULT FALSE;
		DECLARE _baremo_totalsiniva INT DEFAULT 0;		
		DECLARE CR_baremos CURSOR FOR 
							SELECT bm.baremo_id,
								   bm.baremo_totalsinIva
							  FROM pt_baremo bm
							 WHERE bm.baremo_estado=1
                               AND bm.contrato_id=_contrato_id; 
       declare continue handler for not found  
		 -- for sqlstate '02000'
			SET _rowsbm = TRUE;           
		OPEN CR_baremos;
				Loop_BM: LOOP
						FETCH CR_baremos INTO _baremo_id,_baremo_totalsiniva;						
							IF _rowsbm =TRUE THEN
								LEAVE Loop_BM;
							END IF;
							 ACTIVIDADES: BEGIN
									
									DECLARE _rowsact BOOLEAN DEFAULT FALSE;
									DECLARE _actividad_id INT DEFAULT 0;
									DECLARE _actividad_valorservicio INT DEFAULT 0;
									DECLARE _actividad_unidadservicio INT DEFAULT 0;
									DECLARE _baremoactividad_id INT DEFAULT 0;
									DECLARE _newactividad_valorservicio DECIMAL(20,6);
									DECLARE _newbaremo_totalsiniva INT DEFAULT 0;
	
									DECLARE CR_actividad CURSOR FOR 
														SELECT  ac.actividad_id,											
																ac.actividad_valorservicio,
																ac.actividad_unidadservicio,
																ba.baremoactividad_id
														   FROM pt_baremo_actividad ba
														   JOIN cf_actividad ac ON ba.actividad_id=ac.actividad_id
															AND ba.baremo_id=_baremo_id
															AND ba.baremoactividad_estado=1
                                                            AND ba.contrato_id=_contrato_id;   
			
									declare continue handler  for not found  
									-- for sqlstate '02000'									
									-- SET _rowsact := TRUE;      
									SET _rowsact = TRUE;
									OPEN CR_actividad;
											Loop_act : LOOP
													FETCH CR_actividad INTO _actividad_id,_actividad_valorservicio,_actividad_unidadservicio,_baremoactividad_id;
													IF _rowsact THEN
														 LEAVE Loop_act;
													END IF;
                                                    -- SET  _newactividad_valorservicio = _actividad_unidadservicio * _valor;
                                                    SET  _newactividad_valorservicio = _actividad_valorservicio;
                                                   -- SELECT _newactividad_valorservicio;
													SET _newbaremo_totalsiniva=_newbaremo_totalsiniva+_newactividad_valorservicio;
													-- UPDATE cf_actividad SET actividad_valorservicio = ROUND(_newactividad_valorservicio), actividad_valordecimal=_newactividad_valorservicio WHERE actividad_id=_actividad_id;
													 UPDATE pt_baremo SET baremo_totalsinIva = ROUND(_newbaremo_totalsiniva), baremo_valortotalAct=ROUND(_newbaremo_totalsiniva)  WHERE baremo_id=_baremo_id;
	
													 SUBACTIVIDADES:BEGIN 
															DECLARE _rowsub BOOLEAN DEFAULT FALSE;
															DECLARE _detalleactividad_id INT DEFAULT 0;
															DECLARE _detallesubactividad_costosinIva INT DEFAULT 0;
															DECLARE _detallesubactividad_porc  double(15,8);
														    DECLARE _newdetallesubactividad_costosiniva DECIMAL(20,6);
															
															DECLARE CR_subactividad CURSOR FOR 
																						SELECT  da.detalleactividad_id,
																								da.detallesubactividad_costosinIva,
																								REPLACE(da.detallesubactividad_porc,',','.') detallesubactividad_porc
																								FROM pt_detalle_actividad da
																							   WHERE da.detalleactividad_estado=1
																								 AND da.baremoactividad_id=_baremoactividad_id
																								 AND da.actividad_id=_actividad_id
                                                                                                 AND da.contrato_id=_contrato_id;   
			
															declare continue handler for not found  
															-- for sqlstate '02000'																								
															SET _rowsub = TRUE;
															OPEN CR_subactividad;
																	Loop_sub:LOOP
																			FETCH CR_subactividad INTO _detalleactividad_id,_detallesubactividad_costosinIva,_detallesubactividad_porc;
																			IF _rowsub THEN
																				LEAVE Loop_sub;
																			END IF;
																			
																			SET _newdetallesubactividad_costosiniva=_newactividad_valorservicio*_detallesubactividad_porc;
																			UPDATE pt_detalle_actividad SET detallesubactividad_costosinIva = ROUND(_newdetallesubactividad_costosiniva) WHERE detalleactividad_id=_detalleactividad_id;
																	END LOOP Loop_sub;
															CLOSE CR_subactividad;
													 END SUBACTIVIDADES;													
											END LOOP Loop_act;
									CLOSE CR_actividad;													
							 END ACTIVIDADES;
			
				END LOOP Loop_BM;
		CLOSE CR_baremos;
SET @x = _baremo_id;
END BAREMOS */$$
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
            AND alsub.contrato_id=_alcance_id
		    AND alsub.alcancesubactividad_estado=1;
    
elseif _tipoControl='2' THEN -- Insertar
		SELECT alcancesubactividad_id
		  FROM pt_alcance_subactividad
		 WHERE alcance_id=_alcance_id
		   AND detalleactividad_id=_detalleactividad_id	
           AND contrato_id=_alcancesubactividad_estado
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
								      detalleactividad_id,
                                      contrato_id)
							   VALUES(_alcancesubactividad_usuariocreo,
                                      _alcance_id,
									  _detalleactividad_id,
                                      _alcancesubactividad_estado);
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

/* Procedure structure for procedure `SP_ptdescargo` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptdescargo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptdescargo`(
IN _tipoControl varchar(11),
IN _descargo_id varchar(11),
IN _descargo_actividad varchar(5000),
IN _descargo_usuariocreo varchar(45),
IN _descargo_usuariomodifico varchar(45),
IN _ordentrabajo_id varchar(45),
IN _presupuesto_id varchar(45),
IN _descargo_tipo varchar(45),
IN _descargo_riesgo varchar(45),
IN _descargo_preipoanexo varchar(45),
IN _descargo_codensa varchar(45)
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
		   descargo_usuariomodifico=_descargo_usuariocreo,
           descargo_tipo=_descargo_tipo,
           descargo_preipoanexo=_descargo_preipoanexo,
           descargo_codensa=_descargo_codensa
	 WHERE descargo_id = _existe_descargo;
	 SET descargo_id_insert= _existe_descargo;
ELSE
	 INSERT INTO pt_descargo(descargo_actividad,
								descargo_riesgo,
								descargo_usuariocreo,	
								ordentrabajo_id,																		
								presupuesto_id,
                                descargo_tipo,
                                descargo_preipoanexo,
                                descargo_codensa)
						 VALUES(_descargo_actividad,
								_descargo_riesgo,
								_descargo_usuariocreo,
								_ordentrabajo_id,
								_presupuesto_id,
                                _descargo_tipo,
                                _descargo_preipoanexo,
                                _descargo_codensa);
		SET descargo_id_insert= LAST_INSERT_ID();
END IF;
		SELECT descargo_id_insert;
          
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
           AND contrato_id=_entregablesubactividad_estado
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
								      detalleactividad_id,
                                      contrato_id)
							   VALUES(_entregablesubactividad_usuariocreo,
                                      _entregable_id,
									  _detalleactividad_id,
                                      _entregablesubactividad_estado);
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
		   AND es.contrato_id=_entregable_id
		   AND es.entregablesubactividad_estado=1;
      
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
				tb.tipobaremo_descripcion,
                ct.contrato_numero
		   FROM pt_baremo bm
		   JOIN dt_cliente cl ON bm.cliente_id=cl.cliente_id
		   JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
           JOIN dt_contrato ct ON bm.contrato_id=ct.contrato_id
		    AND bm.baremo_estado=1;
elseif _tipoControl='2' THEN -- Insertar la baremo
 SELECT baremo_id
   FROM pt_baremo
  WHERE baremo_item=_baremo_item
    -- AND baremo_estado=1
    AND cliente_id=_cliente_id
    AND contrato_id=_baremo_estado
    AND tipobaremo_id=_tipobaremo_id
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
           labor_id=_labor_id,
           contrato_id=_baremo_estado
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
                                   contrato_id,
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
                                    _baremo_estado,
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
    AND bm.baremo_item=_baremo_item
    AND bm.contrato_id=_baremo_estado;
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
        bm.tipobaremo_id,
        bm.contrato_id
   FROM pt_baremo bm
   JOIN cf_labor lb ON bm.labor_id=lb.labor_id    
    AND bm.baremo_estado=1    
    AND bm.baremo_id=_baremo_id;
    
elseif _tipoControl='6' THEN -- CONSULTAR BAREMO_ITEM
	 SELECT ba.baremoactividad_id,
			bm.baremo_item,
            bm.baremo_id,
			bm.baremo_valortotalAct,
            tb.tipobaremo_sigla,
            lb.labor_descripcion,
			ac.actividad_id,
			ac.actividad_descripcion,
			ac.actividad_GOM,
			ac.actividad_valorservicio,
            ac.actividad_valordecimal
	   FROM pt_baremo_actividad ba
	   JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
	   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
       JOIN cf_labor lb ON bm.labor_id=lb.labor_id
       JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
	    AND bm.baremo_item=_baremo_item
        AND bm.tipobaremo_id=_tipobaremo_id
        AND bm.contrato_id=_cliente_id
        AND bm.baremo_estado=1
        AND ba.baremoactividad_estado=1;
elseif _tipoControl ='7' THEN -- INFORMACION DE BARMOES
		 SELECT tb.tipobaremo_descripcion,
				CONCAT(tb.tipobaremo_sigla,'-',bm.baremo_item) as  item,
                lb.labor_descripcion,
				cl.cliente_descripcion
		   FROM pt_baremo bm
		   JOIN dt_cliente cl ON bm.cliente_id=cl.cliente_id
		   JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
		   JOIN cf_labor lb ON bm.labor_id=lb.labor_id
		    AND bm.baremo_estado=1;
end if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptCumplimentaciones` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptCumplimentaciones` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptCumplimentaciones`(
IN _tipoControl varchar(11),
IN _tipodescargo_descripcion varchar(45),
IN _tipodescargo_usuariocreo varchar(11),
IN _cumplimentacion_Id varchar(45),
IN _cumplimentacion_aperturarp varchar(45),
IN _cumplimentacion_cierreapertura varchar(45),
IN _cumplimentacion_descargo varchar(45),
IN _tipodescargo varchar(45),
IN _cumplimentacion_fechainicod varchar(45),
IN _cumplimentacion_fechafincod varchar(45),
IN _cumplimentacion_jornada varchar(45),
IN _cumplimentacion_gestor varchar(45),
IN _cumplimentacion_obs varchar(5000),
IN _cumplimentacion_operadorapertura varchar(200),
IN _cumplimentacion_operariocierre varchar(200),
IN _ingenieros varchar(45),
IN _subestacion  varchar(10)
)
BEGIN
DECLARE descargo_id_insert INT;
DECLARE cumplimentacion_id_insert INT;
DECLARE ingenierocumplimentacion_id INT;
DECLARE _vartipodescargo_descripcion varchar(45);
DECLARE area_id varchar(45);
 
if _tipoControl='1' THEN -- Consultar cumplimentaciones
 SELECT cm.cumplimentacion_id,
		cm.cumplimentacion_descargo,
		ds.tipodescargo_descripcion,
	    se.subestacion_nombre,
        CONCAT(us.usuario_apellidos,' ', us.usuario_nombre) AS gestor
  FROM  cf_cumplimentacion cm
   JOIN dt_tipo_descargo ds ON ds.tipodescargo_id=cm.tipodescargo_id
   JOIN dt_subestacion se ON se.subestacion_id=cm.subestacion_id
   JOIN dt_usuario us ON cm.cumplimentacion_gestor=us.usuario_id;
 
 elseif _tipoControl='2' THEN -- Consultar tipo descargo
 SELECT * 
   FROM dt_tipo_descargo 
   WHERE tipodescargo_estado=1
   ORDER BY tipodescargo_descripcion ASC;
   
 elseif _tipoControl='3' THEN -- Insertar tipo descargo
    INSERT INTO dt_tipo_descargo(tipodescargo_descripcion,
								tipodescargo_fechacreo,
								tipodescargo_fechamodifico,
								tipodescargo_usuariocreo)
						VALUES(_tipodescargo_descripcion,
								now(),
                                now(),
                                _tipodescargo_usuariocreo
								);
	 SET descargo_id_insert= LAST_INSERT_ID();
    SELECT descargo_id_insert;
elseif _tipoControl='4' THEN -- Insertar cumplimentacion
SELECT cumplimentacion_id
  FROM cf_cumplimentacion 
 WHERE cumplimentacion_descargo=_cumplimentacion_descargo
  INTO cumplimentacion_id_insert;
IF cumplimentacion_id_insert > 0 THEN 
    
UPDATE cf_cumplimentacion 
	   SET cumplimentacion_aperturarp=_cumplimentacion_aperturarp,
		   cumplimentacion_cierreapertura=_cumplimentacion_cierreapertura,
		   cumplimentacion_descargo=_cumplimentacion_descargo, 
		   cumplimentacion_fechafincod=_cumplimentacion_fechafincod,
		   cumplimentacion_fechainicod=_cumplimentacion_fechainicod,
		   cumplimentacion_gestor=_cumplimentacion_gestor,
           cumplimentacion_jornada=_cumplimentacion_jornada,
           cumplimentacion_obs=_cumplimentacion_obs,
           cumplimentacion_operadorapertura=_cumplimentacion_operadorapertura,
           cumplimentacion_operariocierre=_cumplimentacion_operariocierre,
           cumplimentacion_usuariomodifico=_tipodescargo_usuariocreo,
		   cumplimentacion_fechamodifico=NOW(),
		   cumplimentacion_estado=1
	 WHERE cumplimentacion_id = cumplimentacion_id_insert;
	 SET cumplimentacion_id_insert= cumplimentacion_id_insert;
ELSE
INSERT INTO cf_cumplimentacion(cumplimentacion_aperturarp,
									cumplimentacion_cierreapertura,
									cumplimentacion_descargo,
									cumplimentacion_fechacreo,
									cumplimentacion_fechafincod,
									cumplimentacion_fechainicod,
									cumplimentacion_gestor,
									cumplimentacion_jornada,
									cumplimentacion_obs,
									cumplimentacion_operadorapertura,
									cumplimentacion_operariocierre,
									cumplimentacion_usuariocreo,
									tipodescargo_id,
									subestacion_id)
							 VALUES(_cumplimentacion_aperturarp,
									_cumplimentacion_cierreapertura,
									_cumplimentacion_descargo,
									now(),
									_cumplimentacion_fechafincod,
									_cumplimentacion_fechainicod,
									_cumplimentacion_gestor,
									_cumplimentacion_jornada,
									_cumplimentacion_obs,
									_cumplimentacion_operadorapertura,
									_cumplimentacion_operariocierre,
									_tipodescargo_usuariocreo,
									_tipodescargo,
									_subestacion);
	 SET cumplimentacion_id_insert= LAST_INSERT_ID();
END IF;
  SELECT cumplimentacion_id_insert;
elseif _tipoControl='5' THEN -- Insertar cumplimentacion
		SELECT * 
		  FROM cf_cumplimentacion 
		 WHERE cumplimentacion_id=_cumplimentacion_Id;
elseif _tipoControl='6' THEN -- Modificar cumplimentacion
    UPDATE cf_cumplimentacion 
	   SET cumplimentacion_aperturarp=_cumplimentacion_aperturarp,
		   cumplimentacion_cierreapertura=_cumplimentacion_cierreapertura,
		   cumplimentacion_descargo=_cumplimentacion_descargo, 
		   cumplimentacion_fechafincod=_cumplimentacion_fechafincod,
		   cumplimentacion_fechainicod=_cumplimentacion_fechainicod,
		   cumplimentacion_gestor=_cumplimentacion_gestor,
           cumplimentacion_jornada=_cumplimentacion_jornada,
           cumplimentacion_obs=_cumplimentacion_obs,
           cumplimentacion_operadorapertura=_cumplimentacion_operadorapertura,
           cumplimentacion_operariocierre=_cumplimentacion_operariocierre,
           cumplimentacion_usuariomodifico=_tipodescargo_usuariocreo
	 WHERE cumplimentacion_id = _cumplimentacion_Id;
	 SET cumplimentacion_id_insert= _tipodescargo_usuariocreo;
ELSEIF _tipoControl='7' THEN  
	
	SELECT tipodescargo_descripcion 
	  FROM dt_tipo_descargo
	 WHERE tipodescargo_id=_tipodescargo
      INTO _vartipodescargo_descripcion;
    SELECT * 
      FROM cf_area 
	 WHERE area_nombre LIKE _vartipodescargo_descripcion;
ELSEIF _tipoControl='8' THEN -- INSERTAR INGENIEROS DE LA CUMPLIMENTACION
		     INSERT INTO cf_ingeniero_cumplementacion(ingenierocumplimentacion_usuariocreo,
													  ingenierocumplimentacion_fechacreo,											
													  cumplimentacion_id,
													  perfilusuario_id)
											 VALUES(_tipodescargo_usuariocreo,		
												     NOW(),
													_cumplimentacion_Id,
													_ingenieros
													);
SET ingenierocumplimentacion_id= LAST_INSERT_ID();
select ingenierocumplimentacion_id;
ELSEIF _tipoControl='9' THEN
	DELETE  FROM cf_ingeniero_cumplementacion WHERE cumplimentacion_id=_cumplimentacion_id;
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
    AND contrato_id=_detalleactividad_estado
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
								      subactividad_id,
                                      contrato_id)
							   VALUES(_detallesubactividad_costosinIva,
                                      _detallesubactividad_porc,
									  _detalleactividad_usuariocreo,
									  _actividad_id,
									  _baremoactividad_id,
									  _subactividad_id,
                                      _detalleactividad_estado);
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
				REPLACE(da.detallesubactividad_porc,',','.') detallesubactividad_porc,
				-- da.detallesubactividad_porc,
				da.detallesubactividad_costosinIva,
                ac.actividad_valordecimal
		   FROM pt_baremo_actividad ba
		   JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
		   JOIN pt_detalle_actividad da ON ba.baremoactividad_id=da.baremoactividad_id
		   JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
		    AND da.actividad_id=ac.actividad_id
		    AND da.detalleactividad_estado=1
            AND ba.contrato_id=_subactividad_id
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
            
elseif _tipoControl='7' THEN -- consultar el valor de la actividad en decimal
	  SELECT  *
	   FROM cf_actividad 
		WHERE actividad_id=_actividad_id;
        
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
IN _detallepresupuesto_id varchar(45),
IN _ordentrabajo_ordenpresupuestal varchar(45),
IN _ordentrabajo_pep varchar(45)
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
		   ordentrabajo_fechafin=_ordentrabajo_id,
           ordentrabajo_fechamodifico=NOW(),
   		   ordentrabajo_GOM=_ordentrabajo_GOM,
		   ordentrabajo_num=_ordentrabajo_num,          
           ordentrabajo_obs=_ordentrabajo_obs,
           ordentrabajo_ordenpresupuestal=_ordentrabajo_ordenpresupuestal,
           ordentrabajo_pep=_ordentrabajo_pep,
           ordentrabajo_usuariomodifico=_ordentrabajo_usuariocreo	
	 WHERE ordentrabajo_id = _existe_ordentrabajo;
	 SET ordentrabajo_id_insert= _existe_ordentrabajo;
ELSE
	 INSERT INTO pt_orden_trabajo(ordentrabajo_contratista,
								ordentrabajo_fechaemision,
								ordentrabajo_fechaini,
								ordentrabajo_fechafin,
								ordentrabajo_GOM,																		
								ordentrabajo_num,
								ordentrabajo_obs,
                                ordentrabajo_ordenpresupuestal,
                                ordentrabajo_pep,
								ordentrabajo_usuariocreo,
								detallepresupuesto_id)
						 VALUES(_ordentrabajo_contratista,
								_ordentrabajo_fechaemision,
								_ordentrabajo_fechaini,
								_ordentrabajo_id,
								_ordentrabajo_GOM,
								_ordentrabajo_num,
								_ordentrabajo_obs,
                                _ordentrabajo_ordenpresupuestal,
                                _ordentrabajo_pep,
								_ordentrabajo_usuariocreo,
								_detallepresupuesto_id);
		SET ordentrabajo_id_insert= LAST_INSERT_ID();
END IF;
		SELECT ordentrabajo_id_insert;
          
end if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `SP_ptseguimiento` */

/*!50003 DROP PROCEDURE IF EXISTS  `SP_ptseguimiento` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ptseguimiento`(
IN _tipoControl varchar(11),
IN _seguimiento_id varchar(45),
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
IN _seguimiento_revision varchar(45),
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
			 SELECT sg.*,
			    CONCAT(usu.usuario_nombre, ' ', usu.usuario_apellidos ) AS responsable
               -- area.area_nombre
		   FROM pt_seguimiento sg
           JOIN dt_usuario usu ON sg.seguimiento_ejecutor=usu.usuario_id
          -- JOIN pt_presupuesto ps ON sg.presupuesto_id=ps.presupuesto_id
		   -- JOIN cf_area area ON ps.area_id=area.area_id
           WHERE sg.presupuesto_id=_presupuesto_id
             AND sg.seguimiento_estado=1;
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
                                            seguimiento_proceso,
											seguimiento_revision,
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
                                            _seguimiento_id,
											_seguimiento_revision,
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
     
elseif _tipoControl='6' THEN -- traer datos para seguimiento
		SELECT pt.baremo_id,ot.ordentrabajo_id,pt.presupuesto_id,pt.tipobaremo_id,pt.presupuesto_porcentaje
		FROM pt_presupuesto pt
		INNER JOIN pt_orden_trabajo ot on pt.detallepresupuesto_id=ot.detallepresupuesto_id
		WHERE pt.presupuesto_id=_presupuesto_id;
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
    
 elseif _tipoControl='4' THEN -- Insertar cumplimentacion
 
 			     INSERT INTO pt_soporte_seguimiento(																																																						
													soporteseguimiento_usuariocreo,											
													soporteseguimiento_tipo,
													soporte_id,
                                                    id)
											 VALUES(											
													_soporteseguimiento_usuariocreo,											
													_seguimiento_id,
													_soporte_id,
                                                    _soporteseguimiento_id
													);
SET soporteseguimiento_id_insert= LAST_INSERT_ID();
select soporteseguimiento_id_insert;
elseif _tipoControl='5' THEN -- validar documento cumplimentacion
SELECT soporte_id 
  FROM pt_soporte_seguimiento 
 WHERE cumplimentacion_id=_seguimiento_id;
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
