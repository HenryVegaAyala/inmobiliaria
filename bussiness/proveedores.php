<?php
class clsProveedor
{
	function clsProveedor()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $tipodocumento, $nrodocumento, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_proveedor_listar', array($tipo, $tipodocumento, $nrodocumento, $criterio));
		return $rs;
	}
}
?>