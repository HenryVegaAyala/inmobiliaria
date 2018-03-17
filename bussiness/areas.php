<?php
class clsArea {
	private $objData;
	
	function clsArea(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_area_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idarea, $idempresa, $idcentro, $idarearef, $nombre, $esdespacho, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_area_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idarea, $idempresa, $idcentro, $idarearef, $nombre, $esdespacho, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), "tp_area", "tp_idarea IN ($listIds)");
		return $rpta;
	}
}
?>