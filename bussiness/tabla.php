<?php

class clsTabla
{
	function clsTabla()
	{
		$this->objData = new Db();
	}

	function ValorPorCampo($campo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_valorporcampo', array($campo));
		return $rs;
	}

	function ValorReferencia($campo, $codigoreferencia)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_referencia', array($campo, $codigoreferencia));
		return $rs;
	}

	function ValorExcluido($campo, $valorexcluido)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_valorexcluido', array($campo, $valorexcluido));
		return $rs;
	}

	function GetSpecificValue($field, $key, $value)
	{
		$bd = $this->objData;
		$specificValue = '';
		$tabla = 'ta_tabla';
		$condicion = ' ta_campo = \''.$key.'\' and ta_codigo = \''.$value.'\'';
		$rs = $bd->set_select($field, $tabla, $condicion);
		$countRs = count($rs);
		if ($countRs > 0)
			$specificValue = $rs[0][$field];
		return $specificValue;
	}
}
?>