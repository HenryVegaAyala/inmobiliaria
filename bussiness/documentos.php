<?php
class clsDocumentos {
	private $objData;
	
	function clsDocumentos(){
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_documento_identificacion_listar', array($tipo, $id, $criterio));
        return $rs;
	}

	function CodigoTributable($criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_documento_identificacion_codtributable', array($criterio));
        return $rs;
	}

	function GetIdByName($nombre)
	{
		$bd = $this->objData;
        $result = $bd->exec_sp_one_value('pa_documento_identificacion_getidbyname', array($nombre), 'DNI');
        return $result;
	}
}
?>