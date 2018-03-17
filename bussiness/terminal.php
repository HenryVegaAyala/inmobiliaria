<?php
class clsTerminal
{
	function clsTerminal()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_terminal_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idterminal, $idempresa, $idcentro, $nombre, $direccionip, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_terminal_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idterminal, $idempresa, $idcentro, $nombre, $direccionip, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_terminal', "tm_idterminal IN ($listIds)");
		return $rpta;
	}
}