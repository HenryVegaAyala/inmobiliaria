<?php
/**
* 
*/
class clsPropiedad
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

    function Listar($tipo, $id, $idtipopropiedad, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_listar', array($tipo, $id, $idtipopropiedad, $criterio, $pagina));
        return $rs;
    }

    function ListarSimpleId($id)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_simple_id', array($id));
        return $rs;
    }

    function ListarPropiedad_Maestra($idproyecto, $idpropiedad)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_maestra', array($idproyecto, $idpropiedad));
        return $rs;
    }

	function Registrar($idpropiedad, $descripcionpropiedad, $idproyecto, $idtipopropiedad, $idpropiedadrelacionada, $idtorre, $area, $area_sintechar, $area_techada, $ratio, $importefijo, $saldoinicial, $clasepropiedad, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedad_registrar';
        $params = array($idpropiedad, $descripcionpropiedad, $idproyecto, $idtipopropiedad, $idpropiedadrelacionada, $idtorre, $area, $area_sintechar, $area_techada, $ratio, $importefijo, $saldoinicial, $clasepropiedad, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    /*function RegistrarMasivo($idproyecto, $idtipopropiedad, $ingresotorre, $idtorre, $nombretorre, $area, $ratio, $nroinicial, $nrofinal, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_propiedad_registrar';
        $i = 0;

        if ($ingresotorre != '0'){
            $result = $bd->exec_sp_iud('pa_torre_registrar', array('0', $nombretorre, $idproyecto, $idusuario));
            $idtorre = $result[0]['rpta'];
        }

        for ($i = $nroinicial; $i <= $nrofinal; $i++){
            $result = $bd->exec_sp_iud($sp_name, array('0', $idtipopropiedad.$i, $idproyecto, $idtipopropiedad, '', $idtorre, $area, $ratio, $idusuario));

            if ($result[0]['rpta'] != '0'){

            }
        }
        
        if (count($result) > 0) {
        	$rpta = $result[0]['rpta'];
	        $titulomsje = $result[0]['titulomsje'];
	        $contenidomsje = $result[0]['contenidomsje'];
        }

    	return $rpta;
    }*/

    function GetLastIndexPropiedad($idtipopropiedad, $idproyecto)
    {
        $bd = $this->objData;
        $result = $bd->exec_sp_one_value('pa_propiedad_getlastindex', array($idtipopropiedad, $idproyecto), '1');
        return $result;
    }

    function AsignarPropiedad($listpropiedades, $tipopersona, $idpersona, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;

        if ($tipopersona == '00')
            $sp_name = 'pa_propiedadpropietario_registrar';
        else if ($tipopersona == '01')
            $sp_name = 'pa_propiedadinquilino_registrar';

        $params = array($listpropiedades, $idpersona, $idusuario);
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function ListarRelacionadas($idproyecto, $id, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_relacionadas_listar', array($idproyecto, $id, $criterio, $pagina));
        return $rs;
    }

    function ListarPropiedadByPropietario($idtipopropiedad, $idpropietario)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedadpropietario_bypropietario', array($idtipopropiedad, $idpropietario));
        return $rs;
    }

    function ListarPropiedadByInquilino($idtipopropiedad, $idinquilino)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedadinquilino_byinquilino', array($idtipopropiedad, $idinquilino));
        return $rs;
    }

    function EliminarConceptoPropiedad($idpropiedad, $idproyecto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_conceptospropiedad_eliminar';
        $params = array($idpropiedad, $idproyecto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function RegistrarConceptoPropiedad($idpropiedad, $idproyecto, $idconcepto, $valorconcepto, $tiporesultado, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_conceptospropiedad_registrar';
        $params = array($idpropiedad, $idproyecto, $idconcepto, $valorconcepto, $tiporesultado, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Eliminar($strlist, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedad_eliminar';
        $result = $bd->exec_sp_iud($sp_name, array($strlist, $idusuario));
        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];
        return $rpta;
    }

    function EliminarStepByStep($idproyecto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedad_eliminar_stepbystep';
        $params = array($idproyecto, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function Relacionar($iddepartamento, $idpropiedad, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedad_relacionar';
        $params = array($iddepartamento, $idpropiedad, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function RomperRelaciones($idpropiedad, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedad_relacionbreak';
        $params = array($idpropiedad, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function ListarPropiedadFacturacion($codigoproyecto, $anho, $meses, $idpropietario, $tipopropiedad, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_facturacion_listar', array($codigoproyecto, $anho, $meses, $idpropietario, $tipopropiedad, $criterio, $pagina));
        return $rs;
    }

    function Reporte($idproyecto)
    {
        $bd = $this->objData;
        $sp_name = 'pa_Propiedades';
        $params = array($idproyecto);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rs = $bd->set_select('*', $result[0]['respuesta'], '');

        return $rs;
    }

    function ReporteImporteRatio($idproyecto)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_importe_listar', array($idproyecto));
        return $rs;
    }

    function ExportarPropiedades($idproyecto)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_exportar', array($idproyecto));
        return $rs;
    }

    function ExportarPropiedades_Concepto($idproyecto, $idconcepto)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_propiedad_concepto_exportar', array($idproyecto, $idconcepto));
        return $rs;
    }

    function ActualizarValores($idpropiedad, $tipovaloracion, $valor, $saldoranterior, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedadesvalores_actualizar';
        $params = array($idpropiedad, $tipovaloracion, $valor, $saldoranterior, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }

    function AsignarValorMasivo($idproyecto, $tipovaloracion, $valor, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_propiedadesvalores_actualizar_masivo';
        $params = array($idproyecto, $tipovaloracion, $valor, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params);

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
    }
}
?>