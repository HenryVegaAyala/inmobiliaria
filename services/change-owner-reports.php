<?php
set_time_limit(0);

include("../common/sesion.class.php");
require('../common/class.translation.php');
include('../adata/Db.class.php');
include('../common/functions.php');

class clsSimpleSql
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function _ejecutar_sql($strsql)
	{
		$bd = $this->objData;
		$rs = $bd->exec_simple_sql($strsql);
		return $rs;
	}
}

$newSImpleSql = new clsSimpleSql();

$newSImpleSql->_ejecutar_sql('ALTER TABLE  facturacion_resumencd0000000220182 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  facturacion_resumencd0000000520182 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  facturacion_resumencd0000003420182 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  facturacion_resumencd0000004220182 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  liquidacioncd000000422001120011 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  propietarios_cd00000002 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  propietarios_cd00000005 OWNER TO cinadsac_inmobiliaria');
$newSImpleSql->_ejecutar_sql('ALTER TABLE  propietarios_cd00000034 OWNER TO cinadsac_inmobiliaria');

?>