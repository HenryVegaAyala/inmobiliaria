<?php
class clsEstadoResultados_oneconnect
{
    private $objData;
   
    function clsEstadoResultados_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function ListarProyecto($connect, $tipo, $id, $criterio, $pagina = 1)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select($connect, 'pa_proyecto_listar', array($tipo, $id, $criterio, $pagina));
        return $rs;
    }

    function ValorPorCampo($connect, $campo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select($connect, 'pa_tabla_valorporcampo', array($campo));
		return $rs;
	}

	function CobranzaResumen_liquidacion($connect, $idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select($connect, 'pa_liquidacion_groupcobranza', array($idproyecto, $anho, $mes));
        return $rs;
	}

	function GastoResumen_liquidacion($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select($connect, 'pa_liquidacion_groupgasto', array($idproyecto, $anho, $mes));
        return $rs;
    }

    function ListarDetallado($connect, $idproyecto, $anho, $codtipogasto)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select($connect, 'pa_gastosproyecto_detallado', array($idproyecto, $anho, $codtipogasto));
        return $rs;
    }

    function ObtenerImporte_Proyecto($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value($connect, 'pa_cobranza_importe_proyecto', array($idproyecto, $anho, $mes));
        return $result;
    }

    function ObtenerImporte_Proyecto__Count($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value($connect, 'pa_cobranza_importe_proyecto_count', array($idproyecto, $anho, $mes));
        return $result;
    }

    function Propiedades_Pendientes__Count($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value($connect, 'pa_cobranza_pendiente_count', array($idproyecto, $anho, $mes));
        return $result;
    }

    function Propiedades_Pendientes__Suma($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value($connect, 'pa_cobranza_pendiente_importe', array($idproyecto, $anho, $mes));
        return $result;
    }

    function ObtenerEstimacion_Proyecto__Count($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value($connect, 'pa_cobranza_estimada_count', array($idproyecto, $anho, $mes));
        return $result;
    }

    function ObtenerEstimacion_Proyecto($connect, $idproyecto, $anho, $mes)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value($connect, 'pa_cobranza_estimada_importe', array($idproyecto, $anho, $mes));
        return $result;
    }

    function _conectar()
    {
        $bd = $this->objData;
        return $bd->conectar();
    }

    function _desconectar($connect)
    {
        $bd = $this->objData;
        return $bd->desconectar($connect);
    }
}