<?php
/**
* 
*/
class clsLiquidacion
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	// function Listar($tipo, $id, $idproyecto, $anho, $mes)
	// {
	// 	$bd = $this->objData;
	// 	$rs = $bd->exec_sp_select('pa_liquidacion_listar', array($tipo, $id, $idproyecto, $anho, $mes));
	// 	return $rs;
	// }

	// function Registrar($idliquidacion, $per_ano, $per_mes, $idproyecto, $saldoinicial, $saldofinal, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	// {
	// 	$bd = $this->objData;
 //        $sp_name = 'pa_liquidacion_registrar';
 //        $params = array($idliquidacion, $per_ano, $per_mes, $idproyecto, $saldoinicial, $saldofinal, $idusuario);
        
 //        $result = $bd->exec_sp_iud($sp_name, $params);

 //        $rpta = $result[0]['rpta'];
 //        $titulomsje = $result[0]['titulomsje'];
 //        $contenidomsje = $result[0]['contenidomsje'];

 //        return $rpta;
	// }

	function LiquidacionInicial_Listar($tipo, $id, $idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_cierre_liquidacion_listar', array($tipo, $id, $idproyecto, $anho, $mes));
		return $rs;
	}

	function LiquidacionInicial_Registrar($idcierreliquidacion, $idproyecto, $per_mes, $per_anho, $saldo_inicial, $saldo_final, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_cierre_liquidacion_registrar';
        $params = array($idcierreliquidacion, $idproyecto, $per_mes, $per_anho, $saldo_inicial, $saldo_final, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}
}