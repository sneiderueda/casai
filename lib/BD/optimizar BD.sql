OPTIMIZE TABLE cf_actividad;
ALTER TABLE cf_actividad ADD INDEX (actividad_id);

OPTIMIZE TABLE cf_alcance;
ALTER TABLE cf_alcance ADD INDEX (alcance_id);

OPTIMIZE TABLE cf_area;
ALTER TABLE cf_area ADD INDEX (area_id);

OPTIMIZE TABLE cf_cumplimentacion;
ALTER TABLE cf_cumplimentacion ADD INDEX (cumplimentacion_id);

OPTIMIZE TABLE cf_entregable;
ALTER TABLE cf_entregable ADD INDEX (entregable_id);

OPTIMIZE TABLE cf_ingeniero_cumplementacion;
ALTER TABLE cf_ingeniero_cumplementacion ADD INDEX (ingenierocumplimentacion_id);

OPTIMIZE TABLE cf_labor;
ALTER TABLE cf_labor ADD INDEX (labor_id);

OPTIMIZE TABLE cf_menu;
ALTER TABLE cf_menu ADD INDEX (menu_id);

OPTIMIZE TABLE cf_modulo;
ALTER TABLE cf_modulo ADD INDEX (modulo_id);

OPTIMIZE TABLE cf_modulo_subestacion;
ALTER TABLE cf_modulo_subestacion ADD INDEX (modulsubestacion_id);

OPTIMIZE TABLE cf_perfil;
ALTER TABLE cf_perfil ADD INDEX (perfil_id);

OPTIMIZE TABLE cf_subactividad;
ALTER TABLE cf_subactividad ADD INDEX (subactividad_id);

OPTIMIZE TABLE cf_tecnico_presupuesto;
ALTER TABLE cf_tecnico_presupuesto ADD INDEX (tecnicopresupuesto_id);

OPTIMIZE TABLE cf_tipobaremo;
ALTER TABLE cf_tipobaremo ADD INDEX (tipobaremo_id);

OPTIMIZE TABLE dt_cliente;
ALTER TABLE dt_cliente ADD INDEX (cliente_id);

OPTIMIZE TABLE dt_contrato;
ALTER TABLE dt_contrato ADD INDEX (contrato_id);

OPTIMIZE TABLE dt_detalle_presupuesto;
ALTER TABLE dt_detalle_presupuesto ADD INDEX (detallepresupuesto_id);

OPTIMIZE TABLE dt_detalle_presupuesto_mg;
ALTER TABLE dt_detalle_presupuesto_mg ADD INDEX (detallepresupuesto_id);

OPTIMIZE TABLE dt_factura;
ALTER TABLE dt_factura ADD INDEX (factura_id);

OPTIMIZE TABLE dt_incremento_presupuesto;
ALTER TABLE dt_incremento_presupuesto ADD INDEX (incrementopresupuesto_id);

OPTIMIZE TABLE dt_soporte;
ALTER TABLE dt_soporte ADD INDEX (soporte_id);

OPTIMIZE TABLE dt_subestacion;
ALTER TABLE dt_subestacion ADD INDEX (subestacion_id);

OPTIMIZE TABLE dt_tipo_descargo;
ALTER TABLE dt_tipo_descargo ADD INDEX (tipodescargo_id);

OPTIMIZE TABLE dt_tipo_modulo;
ALTER TABLE dt_tipo_modulo ADD INDEX (tipomodulo_id);

OPTIMIZE TABLE dt_usuario;
ALTER TABLE dt_usuario ADD INDEX (usuario_id);

OPTIMIZE TABLE pt_alcance_subactividad;
ALTER TABLE pt_alcance_subactividad ADD INDEX (alcancesubactividad_id);

OPTIMIZE TABLE pt_baremo;
ALTER TABLE pt_baremo ADD INDEX (baremo_id);

OPTIMIZE TABLE pt_baremo_actividad;
ALTER TABLE pt_baremo_actividad ADD INDEX (baremoactividad_id);

OPTIMIZE TABLE pt_descargo;
ALTER TABLE pt_descargo ADD INDEX (descargo_id);

OPTIMIZE TABLE pt_detalle_actividad;
ALTER TABLE pt_detalle_actividad ADD INDEX (detalleactividad_id);

OPTIMIZE TABLE pt_detalle_factura;
ALTER TABLE pt_detalle_factura ADD INDEX (detallefactura_id);

OPTIMIZE TABLE pt_detalle_subactividad;
ALTER TABLE pt_detalle_subactividad ADD INDEX (detallesubactividad_id);

OPTIMIZE TABLE pt_entregable_subactividad;
ALTER TABLE pt_entregable_subactividad ADD INDEX (entregablesubactividad_id);

OPTIMIZE TABLE pt_menu_perfil;
ALTER TABLE pt_menu_perfil ADD INDEX (menuperfil_id);

OPTIMIZE TABLE pt_orden_trabajo;
ALTER TABLE pt_orden_trabajo ADD INDEX (ordentrabajo_id);

OPTIMIZE TABLE pt_perfil_usuario;
ALTER TABLE pt_perfil_usuario ADD INDEX (perfilusuario_id);

OPTIMIZE TABLE pt_presupuesto;
ALTER TABLE pt_presupuesto ADD INDEX (presupuesto_id);

OPTIMIZE TABLE pt_presupuesto_mg;
ALTER TABLE pt_presupuesto_mg ADD INDEX (presupuesto_id);

OPTIMIZE TABLE pt_seguimiento;
ALTER TABLE pt_seguimiento ADD INDEX (seguimiento_id);

OPTIMIZE TABLE pt_soporte_seguimiento;
ALTER TABLE pt_soporte_seguimiento ADD INDEX (soporteseguimiento_id);
