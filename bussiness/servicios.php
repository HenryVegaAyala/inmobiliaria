<?php
/**
* 
*/
class clsServicio
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_servicios_listar', array($tipo, $id, $criterio));
		return $rs;
	}
}
?>