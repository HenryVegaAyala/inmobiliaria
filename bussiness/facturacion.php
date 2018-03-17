<?php
/**
* 
*/
class clsFacturacion
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $anho, $mes, $idtipopropiedad, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_facturaciony_listar', array($tipo, $id, $criterio, $anho, $mes, $idtipopropiedad, $pagina));
		return $rs;
	}

    function Eliminar($strlist, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_facturacion_eliminar';
        $params = array($strlist, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function EliminarStepByStep($idfacturacion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_facturacion_eliminar_stepbystep';
        $params = array($idfacturacion, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	function ListarAllFields($tipo, $id, $criterio, $anho, $mes, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_facturacion_allfields_listar', array($tipo, $id, $criterio, $anho, $mes, $pagina));
		return $rs;
	}

	function GenerarFacturacion($idproyecto, $tipoFacturacion, $idpropiedad, $anho, $mes, $fechavencimiento, $fechatope, $idmoneda, $tipocambio, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_facturacionx_generar';
        $params = array($idproyecto, $tipoFacturacion, $idpropiedad, $anho, $mes, $fechavencimiento, $fechatope, $idmoneda, $tipocambio, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

    function ListarDetalleFacturacion($idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_facturacion_detalle_listar', array($idproyecto, $anho, $mes));
        return $rs;
    }

	function ListarConceptoFacturacion($tipo, $id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_conceptosfacturacion_listar', array($tipo, $id));
		return $rs;
	}

	function ListarPropiedadConsumo($tipo, $idproyecto, $anho, $mes, $idpropiedad)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_propiedad_consumo_listar', array($tipo, $idproyecto, $anho, $mes, $idpropiedad));
		return $rs;
	}

    function ListarPropiedadConsumo_Concepto($tipo, $idproyecto, $anho, $mes, $idpropiedad, $idconcepto)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_consumo_concepto_listar', array($tipo, $idproyecto, $anho, $mes, $idpropiedad, $idconcepto));
        return $rs;
    }

    function ListarPropiedadConsumoPromedio($idproyecto, $mesinicio, $mesfin)
    {
       $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_consumo_agua_promediomes', array($idproyecto, $mesinicio, $mesfin));
        return $rs;
    }

	function EliminarConsumoEscalonable($idproyecto, $anho, $mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_consumoescalonable_eliminar';
        $params = array($idproyecto, $anho, $mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

    function EliminarConsumoConcepto($idproyecto, $idconcepto, $anho, $mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_consumoconcepto_eliminar';
        $params = array($idproyecto, $idconcepto, $anho, $mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function ActualizarDetalleFacturacion($idconceptofacturacion, $valorconcepto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_facturacion_detalle_update';
        $params = array($idconceptofacturacion, $valorconcepto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	function RegistrarConsumoEscalonable($idconsumoescalonable, $idproyecto, $idpropiedad, $per_ano, $per_mes, $idconcepto, $lecturaanterior, $lecturaactual, $consumo, $fechaini, $fechafin, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_consumoescalonable_registrar';
        $params = array($idconsumoescalonable, $idproyecto, $idpropiedad, $per_ano, $per_mes, $idconcepto, $lecturaanterior, $lecturaactual, $consumo, $fechaini, $fechafin, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

    function RegistrarConceptoVariable($idconsumoconcepto, $idproyecto, $idpropiedad, $per_ano, $per_mes, $idconcepto, $importe, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedad_consumo_concepto_registrar';
        $params = array($idconsumoconcepto, $idproyecto, $idpropiedad, $per_ano, $per_mes, $idconcepto, $importe, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

	function RegistrarConceptoTrans($idconceptofacturacion, $valorconcepto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptosfacturacion_updatetrans';
        $params = array($idconceptofacturacion, $valorconcepto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function ActualizarImporteFacturacion($idfacturacion, $importefacturado, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_facturacion_actualizarimporte';
        $params = array($idfacturacion, $importefacturado, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function ListarFacturacionPropiedad($idproyecto, $anho, $idpropiedad)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_facturacion_propiedad_listar', array($idproyecto, $anho, $idpropiedad));
        return $rs;
    }

    function ListarFacturacionPropiedad__SumaDeuda($idproyecto, $anho, $mes, $idpropiedad)
    {
        $bd = $this->objData;
        $sp_name = 'pa_facturacion_propiedad_deudames_listar';
        $params = array($idproyecto, $anho, $mes, $idpropiedad);
        
        $rpta = $bd->exec_sp_one_value($sp_name, $params);

        return $rpta;
    }

    function ListarFacturacionPropiedad__SaldoMes($idproyecto, $anho, $mes, $idpropiedad)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_facturacion_propiedad_saldomes_listar', array($idproyecto, $anho, $mes, $idpropiedad));
        return $rs;
    }

    function ListarPropiedadPorFactura($idfacturacion, $tipopropiedad, $id)
    {
    	$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_tipo_propiedad_factura', array($idfacturacion, $tipopropiedad, $id));
        return $rs;
    }

    function ListarPropiedad_RelacionadaProyecto($idproyecto, $idpropiedad, $tipopropiedad)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_tipo_propiedad_relacionada', array($idproyecto, $idpropiedad, $tipopropiedad));
        return $rs;
    }

    function ListarPropietarioPorFactura($idfacturacion)
    {
    	$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propietario_factura', array($idfacturacion));
        return $rs;
    }

    function ListarConsumoAscensor($tipo, $idproyecto, $anho, $mes)
    {
    	$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_torres_suministro_listar', array($tipo, $idproyecto, $anho, $mes));
        return $rs;
    }

    function RegistrarConsumoAscensor($idconsumoascensor, $idproyecto, $idtorre, $per_mes, $per_ano, $nrosuministro, $importe, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_torres_suministro_registrar';
        $params = array($idconsumoascensor, $idproyecto, $idtorre, $per_mes, $per_ano, $nrosuministro, $importe, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function ListarIncidenciaPropietario($idpropiedad, $idproyecto, $anho, $mes)
    {
    	$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_incidencias_propietario_listar', array($idpropiedad, $idproyecto, $anho, $mes));
        return $rs;
    }

    function RegistrarIncidencias($idincidencia, $idproyecto, $per_ano, $per_mes, $idpropiedad, $idpropietario, $diasincidencia, $idconcepto, $idmoneda, $tipocambio, $importeincidencia, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_incidencias_registrar';
        $params = array($idincidencia, $idproyecto, $per_ano, $per_mes, $idpropiedad, $idpropietario, $diasincidencia, $idconcepto, $idmoneda, $tipocambio, $importeincidencia, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Reporte($anho, $mes, $idproyecto)
    {
    	$bd = $this->objData;
        $sp_name = 'pivotFacturacionResumen';
        $params = array($anho, $mes, $idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '', '');

        return $rs;
    }

    function ConsumoBarras($idpropiedad, $anho, $nmes)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_consumo_barras', array($idpropiedad, $anho, $nmes));
        return $rs;
    }
    
    function ConsumoMinMax($idpropiedad, $anho, $nmes)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_consumo_minmax', array($idpropiedad, $anho, $nmes));
        return $rs;
    }

    function EliminarFacturacionPrevia($idproyecto, $anho, $mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_facturacion_eliminacionprevia';
        $params = array($idproyecto, $anho, $mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    // function SumarAguaMes($idproyecto, $anho, $mes, &$rpta, &$aguasuma)
    // {
    //     $bd = $this->objData;
    //     $sp_name = 'pa_sumar_agua';
    //     $params = array($idproyecto, $anho, $mes);
        
    //     $result = $bd->exec_sp_iud($sp_name, $params);

    //     $rpta = $result[0]['rpta'];
    //     $aguasuma = $result[0]['aguasuma'];

    //     return $rpta;
    // }

    function SumarAguaMes($idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $sp_name = 'pa_agua_mes';
        $params = array($idproyecto, $mes, $anho);
        
        $rpta = $bd->exec_sp_one_value($sp_name, $params);

        return $rpta;
    }

    function ConceptoAgua($idproyecto)
    {
        $bd = $this->objData;
        $sp_name = 'pa_concepto_getidconceptoagua';
        $params = array($idproyecto);
        
        $rpta = $bd->exec_sp_one_value($sp_name, $params);

        return $rpta;
    }
}
?>