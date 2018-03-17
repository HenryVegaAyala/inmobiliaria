<?php
/**
* 
*/
class clsProceso
{
	function clsProceso()
	{
		$this->objData = new Db();
	}

	function ListarAnho($idproyecto)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_proceso_anho_listar', array($idproyecto));
		return $rs;
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_proceso_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Registrar($idproceso, $idproyecto, $per_ano, $per_mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_proceso_registrar';
        $params = array($idproceso, $idproyecto, $per_ano, $per_mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Reaperturar($idproceso, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_proceso_reaperturar';
        $params = array($idproceso, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function EliminarStepByStep($idproceso, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proceso_eliminar';
        $params = array($idproceso, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }
}