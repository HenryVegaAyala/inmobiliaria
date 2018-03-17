<?php 
/**
* 
*/
class clsPresupuesto
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_presupuesto_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idpresupuesto, $idproyecto, $idmoneda, $tipocambio, $per_ano, $per_mes, $presupuestototal, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_presupuesto_registrar';
        $params = array($idpresupuesto, $idproyecto, $idmoneda, $tipocambio, $per_ano, $per_mes, $presupuestototal, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function EliminarStepByStep($idpresupuesto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_presupuesto_eliminar_stepbystep';
        $params = array($idpresupuesto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	function ListarConceptoPresupuesto($tipo, $id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptospresupuesto_listar', array($tipo, $id));
		return $rs;
	}

	function EliminarConceptoPresupuesto($idpresupuesto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptospresupuesto_eliminar';
        $params = array($idpresupuesto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function RegistrarConceptoPresupuesto($idpresupuesto, $idproyecto, $idconcepto, $cantidad, $valor_unitario, $valorconcepto, $tiporesultado, $anho, $mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptospresupuesto_registrar';
        $params = array($idpresupuesto, $idproyecto, $idconcepto, $cantidad, $valor_unitario, $valorconcepto, $tiporesultado, $anho, $mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

		$rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function ProyectarPresupuesto($idpresupuesto, $nromes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_presupuesto_proyectar';
        $params = array($idpresupuesto, $nromes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

		$rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function Reporte($anho1, $mes1, $anho2, $mes2, $idproyecto)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_presupuesto';
        $params = array($anho1, $mes1, $anho2, $mes2, $idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
    }
}
?>