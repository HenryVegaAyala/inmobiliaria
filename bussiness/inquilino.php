<?php
class clsInquilino
{
    private $objData;

    function __construct()
    {
        $this->objData = new Db();
    }

    function Listar($tipo, $idempresa, $idcentro, $id, $tipocliente, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_inquilino_listar', array($tipo, $idempresa, $idcentro, $id, $tipocliente, $criterio, $pagina));
        return $rs;
    }

    function Registrar($tipoinquilino, $idinquilino, $idempresa, $idcentro, $iddocident, $numerodoc, $razsocial, $representante, $nombres, $apepaterno, $apematerno, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idubigeo, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = '';
        $params = array();

        if ($tipoinquilino === 'JU'){
            $sp_name = 'pa_inquilino_juridico_registrar';
            $params = array($idinquilino, $idempresa, $idcentro, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idubigeo, $idusuario, $razsocial, $representante);
        }
        else {
            $sp_name = 'pa_inquilino_natural_registrar';
            $params = array($idinquilino, $idempresa, $idcentro, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $idubigeo, $idusuario, $nombres, $apepaterno, $apematerno);
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
        $sp_name = 'pa_inquilino_eliminar';
        $result = $bd->exec_sp_iud($sp_name, array($strlist, $idusuario));
        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];
        return $rpta;
    }

    function EliminarStepByStep($idinquilino, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_inquilino_eliminar_stepbystep';
        $params = array($idinquilino, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }
}
?>