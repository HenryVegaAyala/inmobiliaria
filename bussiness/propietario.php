<?php
class clsPropietario
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $tipocliente, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_propietario_listar', array($tipo, $idempresa, $idcentro, $id, $tipocliente, $criterio, $pagina));
		return $rs;
	}

	function Registrar($tipopropietario, $idpropietario, $idempresa, $idcentro, $iddocident, $numerodoc, $razsocial, $representante, $nombres, $apepaterno, $apematerno, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idubigeo, $esconstructora, $modolegal, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = '';
        $params = array();

        if ($tipopropietario == 'JU'){
            $sp_name = 'pa_propietario_juridico_registrar';
            $params = array($idpropietario, $idempresa, $idcentro, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idubigeo, $idusuario, $razsocial, $representante, $esconstructora, $modolegal);
        }
        else {
            $sp_name = 'pa_propietario_natural_registrar';
            $params = array($idpropietario, $idempresa, $idcentro, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $idubigeo, $idusuario, $nombres, $apepaterno, $apematerno, $modolegal);
        }

        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Eliminar($strlist, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propietario_eliminar';
        $result = $bd->exec_sp_iud($sp_name, array($strlist, $idusuario));
        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];
        return $rpta;
    }

    function EliminarStepByStep($idpropietario, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propietario_eliminar_stepbystep';
        $params = array($idpropietario, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Reporte($idproyecto)
    {
        $bd = $this->objData;
        $sp_name = 'propietarios';
        $params = array($idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
    }

    function ReporteSaldos($tipo, $idproyecto, $idpropietario, $anho, $mes)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_resumenpropietario_saldos_reporte', array($tipo, $idproyecto, $idpropietario, $anho, $mes));
        return $rs;
    }

    function ListarUsuarioPropietario()
    {
        
    }
}
?>