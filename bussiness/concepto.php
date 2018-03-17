<?php
/**
* 
*/
class clsConcepto
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $tipoconcepto, $esformula, $escalonable, $idproyecto, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptos_listar', array($tipo, $id, $criterio, $tipoconcepto, $esformula, $escalonable, $idproyecto, $pagina));
		return $rs;
	}

	function ListarConceptoTipo($tipoconcepto, $subtipoconcepto)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptos_tipo_listar', array($tipoconcepto, $subtipoconcepto));
		return $rs;
	}

	function ListarConceptoProyecto($tipoconcepto, $subtipoconcepto, $idproyecto)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptosproyecto_listar', array($tipoconcepto, $subtipoconcepto, $idproyecto));
		return $rs;
	}

	function ListarConceptoPropiedad($tipoconcepto, $subtipoconcepto, $idproyecto, $idpropiedad)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptospropiedad_listar', array($tipoconcepto, $subtipoconcepto, $idproyecto, $idpropiedad));
		return $rs;
	}

	function ObtenerPorId($id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptos_porid', array($id));
		return $rs;
	}

	function Registrar($idconcepto, $idproyecto, $descripcionconcepto, $tipoconcepto, $subtipoconcepto, $ascensor, $esformula, $definicion_formula, $html_formula, $escalonable, $tituloconcepto, $tipovalor, $numerocaracteres, $numerodecimales, $essaldoanterior, $esconsumoagua, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptos_registrar';
        $params = array($idconcepto, $idproyecto, $descripcionconcepto, $tipoconcepto, $subtipoconcepto, $ascensor, $esformula, $definicion_formula, $html_formula, $escalonable, $tituloconcepto, $tipovalor, $numerocaracteres, $numerodecimales, $essaldoanterior, $esconsumoagua, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function EliminarStepByStep($idconcepto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_concepto_eliminar_stepbystep';
        $params = array($idconcepto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function EliminarStepByStep_ConFactura($idconcepto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_conceptofacturacion_eliminar_stepbystep';
        $params = array($idconcepto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	function RegistrarDetalle($idconcepto, $idconceptorel, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_detalle_conceptos_registrar';
        $params = array($idconcepto, $idconceptorel, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function ListarEscalonables($tipo, $id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptoescalonable_listar', array($tipo, $id));
		return $rs;
	}

	function EliminarEscalonables($idconcepto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptoescalonable_eliminar';
        $params = array($idconcepto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function RegistrarEscalonables($idconcepto, $valor_inicial, $valor_final, $valorintervalo, $textointervalo, $idusuario)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptoescalonable_registrar';
        $params = array($idconcepto, $valor_inicial, $valor_final, $valorintervalo, $textointervalo, $idusuario);
        
        $result = $bd->exec_sp_one_value($sp_name, $params, 0);

        return $result;
	}
}
?>