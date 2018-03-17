<?php
class clsConstructora
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_constructora_listar', array($tipo, $criterio));
		return $rs;
	}

	function ListarConLocalidad($tipo, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_constructora_localidad_listar', array($tipo, $criterio));
		return $rs;
	}

	function ListarPorId($criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_constructora_localidad_byid', array($criterio));
		return $rs;
	}

	function Registrar($idconstructora, $tipoconstructora, $nombreconstructora, $idlocalidad, $idtipopropietario, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_constructora_registrar';
        $params = array($idconstructora, $tipoconstructora, $nombreconstructora, $idlocalidad, $idtipopropietario, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function Eliminar($strlist, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_constructora_eliminar';
        $result = $bd->exec_sp_iud($sp_name, array($strlist, $idusuario));
        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];
        return $rpta;
    }

    function EliminarStepByStep($idconstructora, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_constructora_eliminar_stepbystep';
        $params = array($idconstructora, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }
}
?>