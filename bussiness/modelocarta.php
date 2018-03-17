<?php
/**
* 
*/
class clsModeloCarta
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_modelocarta_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idmodelocarta, $nombre, $contenido, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_modelocarta_registrar';
        $params = array($idmodelocarta, $nombre, $contenido, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function Eliminar($strlist, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_modelocarta_eliminar';
        $params = array($strlist, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}
}