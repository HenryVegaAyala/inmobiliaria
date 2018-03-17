<?php
/**
* 
*/
class clsCobranza
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_conceptoscobranza_listar', array($tipo, $id, $criterio));
        return $rs;
	}

	function ListarCobranza($tipo, $idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_cobranza_listar', array($tipo, $idproyecto, $anho, $mes));
        return $rs;
	}

	function Obtener($id)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_cobranza_obtener', array($id));
        return $rs;
	}

	function Registrar($idfacturacion, $idproyecto, $idpropiedad, $idconcepto, $fecha, $valorconcepto, $importemora, $tipo_operacion, $idbanco, $idcuentabancaria, $num_operacion, $tiporesultado, $anho_ori, $mes_ori, $anho, $mes, $imagenvoucher, $flagfactura, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_conceptoscobranza_registrar';
        $params = array($idfacturacion, $idproyecto, $idpropiedad, $idconcepto, $fecha, $valorconcepto, $importemora, $tipo_operacion, $idbanco, $idcuentabancaria, $num_operacion, $tiporesultado, $anho_ori, $mes_ori, $anho, $mes, $imagenvoucher, $flagfactura, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function RegistraCobranzaFactura($idfacturacion, $idconceptocobranza, $idproyecto, $idpropiedad, $importepago, $anho, $mes, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_cobranza_facturacion_registrar';
        $params = array($idfacturacion, $idconceptocobranza, $idproyecto, $importepago, $anho, $mes, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}

	function ReporteLiquidacion($anho1, $mes1, $anho2, $mes2, $idproyecto)
	{
		$bd = $this->objData;
        $sp_name = 'pa_liquidacion';
        $params = array($anho1, $mes1, $anho2, $mes2, $idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
	}

	function EstadoCuentaPropietario($anho1, $mes1, $anho2, $mes2, $idpropietario)
	{
		$bd = $this->objData;
        $sp_name = 'pa_resumencuentacorriente_propietario';
        $params = array($anho1, $mes1, $anho2, $mes2, $idpropietario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
	}

	public function SaldoAnteriorPropietario($idpropietario, $anho, $mes)
	{
		$bd = $this->objData;
        $sp_name = 'pa_propietario_saldoanterior';
        $params = array($idpropietario, $anho, $mes);

        $rs = $bd->exec_sp_one_value('pa_propietario_saldoanterior', $params, 0);

        return $rs;
	}

	function EstadoCuentaProyecto($anho1, $mes1, $anho2, $mes2, $idproyecto)
	{
		$bd = $this->objData;
        $sp_name = 'pa_resumencuentacorriente_proyecto';
        $params = array($anho1, $mes1, $anho2, $mes2, $idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
	}

	function ObtenerImporte_Proyecto($idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
        $result = $bd->exec_sp_one_value('pa_cobranza_importe_proyecto', array($idproyecto, $anho, $mes));
        return $result;
	}

	function CobranzaResumen_liquidacion($idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_liquidacion_groupcobranza', array($idproyecto, $anho, $mes));
        return $rs;
	}

	function CobranzaFactura_Saldo($idproyecto, $anho, $idpropiedad)
	{
		$bd = $this->objData;
        $result = $bd->exec_sp_one_value('pa_cobranza_factura_saldo', array($idproyecto, $anho, $idpropiedad));
        return $result;
	}

	function ReporteRecaudacion($idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
        $result = $bd->exec_sp_select('pa_cobranza_recaudacion', array($idproyecto, $anho, $mes));
        return $result;
	}

	function ReportePendiente($idproyecto, $anho, $mes)
	{
		$bd = $this->objData;
        $result = $bd->exec_sp_select('pa_cobranza_pendiente', array($idproyecto, $anho, $mes));
        return $result;
	}
}
?>