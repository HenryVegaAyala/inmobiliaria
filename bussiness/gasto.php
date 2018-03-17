<?php 
/**
* 
*/
class clsGasto
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	// function Listar($tipo, $id, $criterio, $pagina)
	// {
	// 	$bd = $this->objData;
	// 	$rs = $bd->exec_sp_select('pa_gasto_listar', array($tipo, $id, $criterio, $pagina));
	// 	return $rs;
	// }
    
    function Listar($tipo, $id, $per_ano, $per_mes, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_gastosproyecto_listar', array($tipo, $id, $per_ano, $per_mes, $pagina));
        return $rs;
    }

    function ListarDetallado($idproyecto, $anho, $codtipogasto)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_gastosproyecto_detallado', array($idproyecto, $anho, $codtipogasto));
        return $rs;
    }

    function Obtener($id)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_gastosproyecto_getdata', array($id));
        return $rs;
    }

    function Registrar($idgastoproyecto, $idproyecto, $tipogasto, $tipodesembolso, $idconcepto, $numerosuministro, $descripciongasto, $per_mes, $per_ano, $idmoneda, $tipo_cambio, $idproveedor, $idtipodocumento, $serie_documento, $numero_documento, $fecha_documento, $importe, $tipoafectacion, $idpropietario, $idformapago, $fecha_vencimiento, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_gastosproyecto_registrar';
        $params = array($idgastoproyecto, $idproyecto, $tipogasto, $tipodesembolso, $idconcepto, $numerosuministro, $descripciongasto, $per_mes, $per_ano, $idmoneda, $tipo_cambio, $idproveedor, $idtipodocumento, $serie_documento, $numero_documento, $fecha_documento, $importe, $tipoafectacion, $idpropietario, $idformapago, $fecha_vencimiento, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	// function Registrar($idgasto, $idproyecto, $idmoneda, $tipocambio, $per_ano, $per_mes, $gastototal, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	// {
	// 	$bd = $this->objData;
 //        $sp_name = 'pa_gasto_registrar';
 //        $params = array($idgasto, $idproyecto, $idmoneda, $tipocambio, $per_ano, $per_mes, $gastototal, $idusuario);
        
 //        $result = $bd->exec_sp_iud($sp_name, $params);

 //        $rpta = $result[0]['rpta'];
 //        $titulomsje = $result[0]['titulomsje'];
 //        $contenidomsje = $result[0]['contenidomsje'];

 //        return $rpta;
	// }

	function EliminarStepByStep($idgasto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_gasto_eliminar_stepbystep';
        $params = array($idgasto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	function ListarConceptoGasto($tipo, $id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptosgasto_listar', array($tipo, $id));
		return $rs;
	}

	function EliminarConceptoGasto($idgasto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptosgasto_eliminar';
        $params = array($idgasto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function RegistrarConceptoGasto($idgasto, $idproyecto, $idconcepto, $cantidad, $valor_unitario, $valorconcepto, $tiporesultado, $anho, $mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptosgasto_registrar';
        $params = array($idgasto, $idproyecto, $idconcepto, $cantidad, $valor_unitario, $valorconcepto, $tiporesultado, $anho, $mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

		$rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function Reporte($anho1, $mes1, $anho2, $mes2, $idproyecto)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_gastos';
        $params = array($anho1, $mes1, $anho2, $mes2, $idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
    }

    function ObtenerImporte_Proyecto($idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value('pa_gasto_importe_proyecto', array($idproyecto, $anho, $mes));
        return $result;
    }

    function GastoResumen_liquidacion($idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_liquidacion_groupgasto', array($idproyecto, $anho, $mes));
        return $rs;
    }
}
?>