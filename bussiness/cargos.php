<?php
class clsCargo {
	private $objData;
	
	function clsCargo(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_cargo_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idcargo, $idempresa, $idcentro, $nombre, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_cargo_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idcargo, $idempresa, $idcentro, $nombre, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), "tp_cargo", "tp_idcargo IN ($listIds)");
		return $rpta;
	}
}
?>