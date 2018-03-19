<?php
include("../../common/sesion.class.php");
include('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/perfil.php');
include('../../bussiness/usuarios.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$IdEmpresa = 1;
$IdCentro = 1;
$Id = 0;
$Codigo = '';
$Nombre = '';
$IdCargo = 0;
$IdSubCategoria = 0;

$counterCategoria = 0;
$counterProducto = 0;
$counterValidItems = 0;

$strListItems = '';
$strListDelete = '';
$strListValids = '';
$validItems = false;
$arrayValid = array();
$arrayDelete = array();

$objPerfil = new clsPerfil();
$objUsuario = new clsUsuario();

$rpta = '0';
$titulomsje = '';
$contenidomensaje = '';

if ($_POST){
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    if (isset($_POST['btnGuardarPerfil'])) {
        $hdIdPerfil = isset($_POST['hdIdPerfil']) ? $_POST['hdIdPerfil'] : '0';
        $txtNombrePerfil = isset($_POST['txtNombrePerfil']) ? $_POST['txtNombrePerfil'] : '';
        $txtDescripcionPerfil = isset($_POST['txtDescripcionPerfil']) ? $_POST['txtDescripcionPerfil'] : '';
        $txtAbreviaturaPerfil = isset($_POST['txtAbreviaturaPerfil']) ? $_POST['txtAbreviaturaPerfil'] : '';

        $rpta = $objPerfil->Guardar($hdIdPerfil, $txtNombrePerfil, $txtDescripcionPerfil, $txtAbreviaturaPerfil, $idusuario, $rpta, $titulomsje, $contenidomensaje);
        
        $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomensaje));
    }
    elseif (isset($_POST['btnEliminarPerfil'])){
        $hdIdPerfil = isset($_POST['hdIdPerfil']) ? $_POST['hdIdPerfil'] : '0';

        $objPerfil->Eliminar($hdIdPerfil, $idusuario, $rpta, $titulomsje, $contenidomensaje);
        
        $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    }
    elseif (isset($_POST['btnAplicarPerfil'])){
        $hdIdPerfil = isset($_POST['hdIdPerfil']) ? $_POST['hdIdPerfil'] : '0';
        $listIdMenu = isset($_POST['listIdMenu']) ? $_POST['listIdMenu'] : '';
        
        $objPerfil->RegistrarPerfilMenu($hdIdPerfil, $listIdMenu, $idusuario, $rpta, $titulomsje, $contenidomensaje);
        
        $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    }
    elseif (isset($_POST['btnGuardar'])){
        $hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
        $ddlPerfil = isset($_POST['ddlPerfil']) ? $_POST['ddlPerfil'] : '0';
        $txtApellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : '';
        $txtNombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : '';
        $txtNumeroDoc = isset($_POST['txtNumeroDoc']) ? $_POST['txtNumeroDoc'] : '';
        $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
        $txtClave = isset($_POST['txtClave']) ? $_POST['txtClave'] : '';
        $hdTipoDataPersona = isset($_POST['hdTipoDataPersona']) ? $_POST['hdTipoDataPersona'] : '00';
        $hdIdPersona = isset($_POST['hdIdPersona']) ? $_POST['hdIdPersona'] : '0';
        $hdIdProyecto = isset($_POST['hdIdProyecto']) ? $_POST['hdIdProyecto'] : '0';
        $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';
        $txtEmail = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
        $txtTelefono = isset($_POST['txtTelefono']) ? $_POST['txtTelefono'] : '';

        if (empty($_FILES['archivo']['name'])) {
            $urlFoto = $hdFoto;
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
                $urlFoto = $url_folder.$nombre_archivo;
            }
            else {
                $urlFoto = $hdFoto;
            }
        }

        $objUsuario->Registrar($hdIdPrimary, $ddlPerfil, $hdIdPersona, $hdTipoDataPersona, $txtNombre, $txtNombres, $txtClave, $txtApellidos, '00', $txtNumeroDoc, '', '', '', $txtEmail, $txtTelefono, $urlFoto, $hdIdProyecto, '01', $idusuario, $rpta, $titulomsje, $contenidomsje);
        
        $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    }
    elseif (isset($_POST['btnEliminar'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem))
            if (is_array($chkItem)) {
                $countCheckItems = count($chkItem);
                $strListItems = implode(',', $chkItem);
                $rpta = $objUsuario->MultiDelete($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    }
    elseif (isset($_POST['btnActivarUsuarios'])) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem))
            if (is_array($chkItem)) {
                $countCheckItems = count($chkItem);
                $strListItems = implode(',', $chkItem);
                $rpta = $objUsuario->Activar($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    }
    echo json_encode($jsondata);
    exit(0);
}
?>