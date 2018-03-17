<?php
/**
* 
*/
class clsUbigeo
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_ubigeo_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function UbigeoAutocompletado($tipo, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_ubigeo_autocompletado', array($tipo, $criterio));
		return $rs;
	}
}
?>