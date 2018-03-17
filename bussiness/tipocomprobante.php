<?php
class clsTipoComprobante
{
	function clsTipoComprobante()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tipocomprobante_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function ListarTipoDocumento($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tipodocumento_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Registrar($idtipocomprobante, $nombre, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_tipodocumento_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idtipocomprobante, $nombre, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_tipodocumento_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}
}
?>