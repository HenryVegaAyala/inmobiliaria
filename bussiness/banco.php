<?php
/**
* 
*/
class clsBanco
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_bancos_listar', array($tipo, $id, $criterio));
        return $rs;
	}

	function Registrar($idbanco, $nombrebanco, $codigosunat, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_bancos_registrar';
        $params = array($idbanco, $nombrebanco, $codigosunat, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function Eliminar($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_bancos_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}
}
?>