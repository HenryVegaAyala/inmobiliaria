<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include("../../common/functions.php");
include('../../bussiness/documentos.php');
include('../../bussiness/ubigeo.php');
include('../../bussiness/propietario.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$objDocIdentidad = new clsDocumentos();
$objUbigeo = new clsUbigeo();
$objPropietario = new clsPropietario();

if ($_POST){
    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $hdIdContactoEmpresa = (isset($_POST['hdIdContactoEmpresa'])) ? $_POST['hdIdContactoEmpresa'] : '0';
        $hdTipoPropietario = (isset($_POST['hdTipoPropietario'])) ? $_POST['hdTipoPropietario'] : 'NA';
        $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';
        $ddlCanal = isset($_POST['ddlCanal']) ? $_POST['ddlCanal'] : 0;
        $ddlTipoDocNatural = (isset($_POST['ddlTipoDocNatural'])) ? $_POST['ddlTipoDocNatural'] : '0';
        $txtNroDocNatural = isset($_POST['txtNroDocNatural']) ? $_POST['txtNroDocNatural'] : '';
        $txtApePaterno = isset($_POST['txtApePaterno']) ? $_POST['txtApePaterno'] : '';
        $txtApeMaterno = isset($_POST['txtApeMaterno']) ? $_POST['txtApeMaterno'] : '';
        $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
        $txtDireccionNatural = isset($_POST['txtDireccionNatural']) ? $_POST['txtDireccionNatural'] : '';
        $txtTelefonoNatural = isset($_POST['txtTelefonoNatural']) ? $_POST['txtTelefonoNatural'] : '';
        $txtEmailNatural = isset($_POST['txtEmailNatural']) ? $_POST['txtEmailNatural'] : '';
        $hdIdUbigeoNatural = isset($_POST['hdIdUbigeoNatural']) ? $_POST['hdIdUbigeoNatural'] : '0';
        $chkEsConstructora = isset($_POST['chkEsConstructora']) ? $_POST['chkEsConstructora'] : '0';
        
        $ddlTipoDocJuridica = (isset($_POST['ddlTipoDocJuridica'])) ? $_POST['ddlTipoDocJuridica'] : '0';
        $txtRucEmpresa = isset($_POST['txtRucEmpresa']) ? $_POST['txtRucEmpresa'] : '';
        $txtRazonSocial = isset($_POST['txtRazonSocial']) ? $_POST['txtRazonSocial'] : '';
        $txtRepresentante = isset($_POST['txtRepresentante']) ? $_POST['txtRepresentante'] : '';
        $txtDireccionEmpresa = isset($_POST['txtDireccionEmpresa']) ? $_POST['txtDireccionEmpresa'] : '';
        $txtTelefonoEmpresa = isset($_POST['txtTelefonoEmpresa']) ? $_POST['txtTelefonoEmpresa'] : '';
        $txtEmailEmpresa = isset($_POST['txtEmailEmpresa']) ? $_POST['txtEmailEmpresa'] : '';
        $hdIdUbigeoJuridico = isset($_POST['hdIdUbigeoJuridico']) ? $_POST['hdIdUbigeoJuridico'] : '0';
        $txtWebEmpresa = isset($_POST['txtWebEmpresa']) ? $_POST['txtWebEmpresa'] : '0';

        $IdCanal = ($hdTipoPropietario == 'JU') ? $ddlCanal : 1;
        $IdDocIdent = ($hdTipoPropietario == 'JU') ? $ddlTipoDocJuridica : $ddlTipoDocNatural;
        $NroDocIdent = ($hdTipoPropietario == 'JU') ? $txtRucEmpresa : $txtNroDocNatural;
        $Direccion = ($hdTipoPropietario == 'JU') ? $txtDireccionEmpresa : $txtDireccionNatural;
        $Telefono = ($hdTipoPropietario == 'JU') ? $txtTelefonoEmpresa : $txtTelefonoNatural;
        $Email = ($hdTipoPropietario == 'JU') ? $txtEmailEmpresa : $txtEmailNatural;
        $IdUbigeo = ($hdTipoPropietario == 'JU') ? $hdIdUbigeoJuridico : $hdIdUbigeoNatural;

        $ddlTipoDocUE = (isset($_POST['ddlTipoDocUE'])) ? $_POST['ddlTipoDocUE'] : '0';
        $txtNroDocUE = isset($_POST['txtNroDocUE']) ? $_POST['txtNroDocUE'] : '';
        $txtApePaternoUE = isset($_POST['txtApePaternoUE']) ? $_POST['txtApePaternoUE'] : '';
        $txtApeMaternoUE = isset($_POST['txtApeMaternoUE']) ? $_POST['txtApeMaternoUE'] : '';
        $txtNombresUE = isset($_POST['txtNombresUE']) ? $_POST['txtNombresUE'] : '';
        $txtEmailUE = isset($_POST['txtEmailUE']) ? $_POST['txtEmailUE'] : '';
        $hdIdUbigeoUE = isset($_POST['hdIdUbigeoUE']) ? $_POST['hdIdUbigeoUE'] : '';

        $hdLegal = isset($_POST['hdLegal']) ? $_POST['hdLegal'] : '';

        if (empty($_FILES['archivo']['name'])) {
            $urlLogo = $hdFoto;
        }
        else {
            $upload_folder  = '../../media/images/';
            $url_folder  = 'media/images/';

            $nombre_archivo = $_FILES['archivo']['name'];
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            $nombre_archivo = trim($nombre_archivo);
            $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            $archivador = $upload_folder.$nombre_archivo;

            if (move_uploaded_file($tmp_archivo, $archivador)) {
                $urlLogo = $url_folder.$nombre_archivo;
            }
            else {
                $urlLogo = $hdFoto;
            }
        }

        $rpta = $objPropietario->Registrar($hdTipoPropietario, $hdIdPrimary, $IdEmpresa, $IdCentro, $IdDocIdent, $NroDocIdent, $txtRazonSocial, $txtRepresentante, $txtNombres, $txtApePaterno, $txtApeMaterno, $Direccion, $Telefono, '', $Email, $urlLogo, $txtWebEmpresa, $IdUbigeo, $chkEsConstructora, $hdLegal, $idusuario, $rpta, $titulomsje, $contenidomsje);

        /*if ($hdTipoPropietario == 'JU'){
            if ($rpta > 0){
                $objPropietario->RegistrarContactoEmpresa($hdIdContactoEmpresa, $rpta, $ddlTipoDocUE, $txtNroDocUE, $txtNombresUE, $txtApePaternoUE, $txtApeMaternoUE, $txtEmailUE, $hdIdUbigeoUE, $idusuario);
            }
        }*/
    }
    elseif (isset($_POST['btnEliminar'])) {
        /*$chkItem = $_POST['chkItem'];
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $countCheckItems = count($chkItem);
                $strListItems = implode(',', $chkItem);
                $rpta = $objPropietario->Eliminar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }*/

        $hdIdPropietario = $_POST['hdIdPropietario'];
        $rpta = $objPropietario->EliminarStepByStep($hdIdPropietario, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnSubirDatos'])) {
        if (!empty($_FILES['archivo']['name'])) {
            $upload_folder  = '../../media/xls/';

            $nombre_archivo = $_FILES['archivo']['name'];
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            $nombre_archivo = trim($nombre_archivo);
            $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            $archivador = $upload_folder.$nombre_archivo;

            if (move_uploaded_file($tmp_archivo, $archivador)) {
                require('../../common/PHPExcel.php');
                require('../../common/PHPExcel/Reader/Excel2007.php');

                $rowDocIdent = $objDocIdentidad->Listar('1', 0, '');
                $rowUbigeo = $objUbigeo->Listar('1', '0', '');

                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($archivador);
                //$objFecha = new PHPExcel_Shared_Date();

                $objPHPExcel->setActiveSheetIndex(0);
                $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
                
                for ($i = 1; $i <= $countRowsExcel; $i++){
                    $Tipo = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

                    if ($Tipo == 'PROPIETARIO'){
                        $IdPropietario = '0';
                        $hdTipoPropietario = '';
                        $TipoDocPropietario = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
                        $txtRazonSocial = trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());
                        $CodigoUbigeo = trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue());

                        if ($TipoDocPropietario == 'RUC'){
                            $hdTipoPropietario = 'JU';
                        }
                        else {
                            if ($txtRazonSocial == ''){
                                $hdTipoPropietario = 'NA';
                            }
                            else {
                                $hdTipoPropietario = 'JU';
                            }
                        }

                        $IdDocIdent = in_array_column($TipoDocPropietario, 'tm_iddocident', 'tm_descripcion', $rowDocIdent);
                        $IdUbigeo = in_array_column($CodigoUbigeo, 'tm_idubigeo', 'tm_codigosunat', $rowUbigeo);

                        $IdDocIdent = ($IdDocIdent == false) ? 0 : $IdDocIdent;
                        $IdUbigeo = ($IdUbigeo == false) ? 0 : $IdUbigeo;
                        
                        $NroDocIdent = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
                        $txtNombres = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                        $txtApePaterno = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                        $txtApeMaterno = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());
                        $Direccion = trim($objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue());
                        $Telefono = trim($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue());
                        $Fax = trim($objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue());
                        $Email = trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue());
                        $txtWebEmpresa = '';

                        $rpta = $objPropietario->Registrar($hdTipoPropietario, $IdPropietario, $IdEmpresa, $IdCentro, $IdDocIdent, $NroDocIdent, $txtRazonSocial, '', $txtNombres, $txtApePaterno, $txtApeMaterno, $Direccion, $Telefono, $Fax, $Email, 'no-set', $txtWebEmpresa, $IdUbigeo, 0, $idusuario, $rpta, $titulomsje, $contenidomsje);
                    }
                }
            }
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
    exit(0);
}

?>