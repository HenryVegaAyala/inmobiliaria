<?php
/**
* 
*/
class clsCuentaBancaria
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $idproyecto, $criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_cuentabancaria_listar', array($tipo, $id, $idproyecto, $criterio));
        return $rs;
	}

	function Registrar($idcuentabancaria, $descripcioncuenta, $idproyecto, $idbanco, $iddocident, $nrodoc, $razonsocial, $email, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_cuentabancaria_registrar';
        $params = array($idcuentabancaria, $descripcioncuenta, $idproyecto, $idbanco, $iddocident, $nrodoc, $razonsocial, $email, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function Eliminar($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_cuentabancaria_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario));
		$rpta = $result[0]['rpta'];
		$titulomsje = $result[0]['titulomsje'];
		$contenidomsje = $result[0]['contenidomsje'];
		return $rpta;
	}
}
?>