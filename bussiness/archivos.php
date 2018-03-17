<?php
class clsArchivo
{
	function clsArchivo()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $mes, $anno, $proceso, $proyecto, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_proceso_documento_listar', array($tipo, $id, $mes, $anno, $proceso, $proyecto, $criterio));
		return $rs;
	}

	function Registrar($idprocesoDocumento, $idproceso, $idproyecto, $per_mes, $per_ano, $ubicacionDocumento, $nombreDocumento, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_proceso_documento_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idprocesoDocumento, $idproceso, $idproyecto, $per_mes, $per_ano, $ubicacionDocumento, $nombreDocumento, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_proceso_documento_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}
}
?>