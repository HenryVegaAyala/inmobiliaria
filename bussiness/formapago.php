<?php
class clsFormaPago {
	private $objData;

	function clsFormaPago()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_formapago_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Registrar($idformapago, $nombre, $descripcion, $codsunat, $abrev, $referencia, $propina, $puntos, $visible, $comision, $efectivo, $tipo_cambio, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_formapago_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idformapago, $nombre, $descripcion, $codsunat, $abrev, $referencia, $propina, $puntos, $visible, $comision, $efectivo, $tipo_cambio, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_forma_pago', "tm_idformapago IN ($listIds)");
		return $rpta;
	}
}
?>