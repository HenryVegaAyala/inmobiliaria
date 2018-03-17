<?php
class clsProyecto
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina = 1)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_proyecto_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

    function ListarPorPropietario($idpropietario)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_propietario', array($idpropietario));
        return $rs;
    }

    function ProyectoFacturar($tipo, $id)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_parafacturar', array($tipo, $id));
        return $rs;
    }

    function ListarParaAsignacion($tipo, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_asignar_listar', array($tipo, $criterio, $pagina));
        return $rs;
    }

    function RegistroPorDefecto($tipo)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_pordefecto', array($tipo));
        return $rs;
    }

    function ListarParaAsignacionCuenta($tipo, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_asignarcuenta_listar', array($tipo, $criterio, $pagina));
        return $rs;
    }

    function RegistroPorDefectoCuenta($tipo)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_pordefectocuenta', array($tipo));
        return $rs;
    }

    function RegistroPorDefectoSinProceso($tipo)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_proyecto_pordefecto_sinproceso', array($tipo));
        return $rs;
    }

	function Registrar($idproyecto, $codigoproyecto, $nombreproyecto, $tipoproyecto, $tipovaloracion, $idconstructora, $idlocalidad, $direccionproyecto, $escobrodiferenciado, $datosimpleduplex, $tieneporcjduplex, $porcjduplex, $logo, $idbanco, $idcuentabancaria, $direccionpago, $emailpago, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proyecto_registrar';
        $params = array($idproyecto, $codigoproyecto, $nombreproyecto, $tipoproyecto, $tipovaloracion, $idconstructora, $idlocalidad, $direccionproyecto, $escobrodiferenciado, $datosimpleduplex, $tieneporcjduplex, $porcjduplex, $logo, $idbanco, $idcuentabancaria, $direccionpago, $emailpago, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Eliminar($strlist, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proyecto_eliminar';
        $result = $bd->exec_sp_iud($sp_name, array($strlist, $idusuario));
        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];
        return $rpta;
    }

    function EliminarStepByStep($idproyecto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proyecto_eliminar_stepbystep';
        $params = array($idproyecto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function EliminarConceptoProyecto($idproyecto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_conceptosproyecto_eliminar';
        $params = array($idproyecto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function RegistrarConceptoProyecto($idproyecto, $idconcepto, $valorconcepto, $tiporesultado, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_conceptosproyecto_registrar';
        $params = array($idproyecto, $idconcepto, $valorconcepto, $tiporesultado, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function FijarProyecto($idproyecto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proyecto_fijar';
        $params = array($idproyecto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function ReporteSaldos($tipo, $idproyecto, $anho)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_resumenproyecto_saldos_reporte', array($tipo, $idproyecto, $anho));
        return $rs;
    }
}
?>