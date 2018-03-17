<?php
class clsMoneda {
	private $objData;
	
	function clsMoneda()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $param1)
	{
		$bd = $this->objData;
		
		$tabla = 'tm_moneda';
		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		$criterio = '';

		if ($tipo === 'L' || $tipo === 'ALL'){			
			if ($tipo === 'L')
				$campos = array('tm_idmoneda', 'tm_nombre', 'tm_simbolo');
			elseif ($tipo === 'ALL')
				$campos = '*';
			
			$condicion = 'Activo = 1';
			if ($param1 != '')
				$condicion .= ' AND tm_nombre like \'%'.$param1.'%\'';
			$orden = 'tm_nombre';
		}
		elseif ($tipo === 'O'){
			$campos = array('tm_idmoneda', 'tm_nombre', 'tm_simbolo');
			$condicion = 'tm_idmoneda = '.$param1;
		}
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}

	function Registrar(array $entidad)
	{
		$bd = $this->objData;
		$rpta = 0;
		if ($entidad['tm_idmoneda'] == 0)
			$rpta = $bd->set_insert($entidad, 'tm_moneda');
		else
			$rpta = $bd->set_update($entidad, 'tm_moneda', 'tm_idmoneda = '.$entidad['tm_idmoneda']);
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_moneda', "tm_idmoneda IN ($listIds)");
		return $rpta;
	}

	function ListarVigMoneda($tipo = "ACTUAL", $fechaini = "", $fechafin = "")
	{
		$bd = $this->objData;

		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		if ($tipo === "ACTUAL"){
			$tabla = "td_vigencia_moneda as a INNER JOIN tm_moneda as b ON a.tm_idmoneda = b.tm_idmoneda";
			$campos = "b.tm_idmoneda, b.tm_nombre, b.tm_simbolo, a.td_importe";
			$condicion = "(NOW() BETWEEN a.td_fechainicio AND a.td_fechafin) and b.Activo = 1";
			$orden = "b.tm_default DESC";
		}

		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
}
?>