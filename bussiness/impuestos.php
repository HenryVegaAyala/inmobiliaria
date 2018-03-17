<?php
class clsImpuesto {
	private $objData;
	
	function clsImpuesto(){
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_impuesto_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Registrar($idimpuesto, $nombre, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_impuesto_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idimpuesto,	$nombre, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_impuesto', "tm_idimpuesto IN ($listIds)");
		return $rpta;
	}

	function ListarVigImpuesto($tipo = "ACTUAL", $fechaini = "", $fechafin = "")
	{
		$bd = $this->objData;

		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		if ($tipo === "ACTUAL"){
			$tabla = "td_vigencia_impuesto as a INNER JOIN tm_impuesto as b ON a.tm_idimpuesto = b.tm_idimpuesto";
			$campos = "b.tm_idimpuesto, UPPER(b.tm_nombre) as tm_nombre, a.td_valorimpuesto";
			$condicion = "(NOW() BETWEEN a.td_fechainicio AND a.td_fechafin) and b.Activo = 1";
			$orden = ' b.tm_nombre DESC ';
		}

		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
}
?>