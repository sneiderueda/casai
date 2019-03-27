UPDATE `cf_menu` SET `menu_nombre`='Actas' WHERE `menu_id`='17';


ALTER TABLE `pt_orden_trabajo` CHANGE COLUMN `ordentrabajo_fechaini` `ordentrabajo_fechaini` DATE NULL DEFAULT NULL  , ADD COLUMN `ordentrabajo_fechafin` VARCHAR(45) NULL DEFAULT NULL  AFTER `ordentrabajo_fechaemision` ;

