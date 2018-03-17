<?php 
/**
* 
*/
class clsTipoPropiedad
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tipopropiedad_listar', array($criterio));
		return $rs;
	}
}
?>