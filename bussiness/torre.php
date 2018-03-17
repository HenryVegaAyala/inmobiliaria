<?php
/**
* 
*/
class clsTorre
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	public function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_torres_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	public function Registrar($idtorre, $nombretorre, $nrosuministro, $idproyecto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_torre_registrar';
        $params = array($idtorre, $nombretorre, $nrosuministro, $idproyecto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}
}
?>