<?php
/**
* 
*/
class clsCuentaCorriente
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function ListarDetalle($idpropietario, $idproyecto, $anho)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_cuentacorriente_listar', array($idpropietario, $idproyecto, $anho));
		return $rs;
	}

	function EliminarDetalle($idcuentacorriente, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_detalle_cuentacorriente_eliminar';
        $params = array($idcuentacorriente, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function RegistrarDetalle($idcuentacorriente, $idfacturacion, $per_ano, $per_mes, $idmoneda, $importefacturado, $importepagado, $importesaldo, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_detalle_cuentacorriente_registrar';
        $params = array($idcuentacorriente, $idfacturacion, $per_ano, $per_mes, $idmoneda, $importefacturado, $importepagado, $importesaldo, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function ListarResumenCuenta($idproyecto, $idpropietario)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_cuentacorriente_resumen_listar', array($idproyecto, $idpropietario));
		return $rs;
	}
}