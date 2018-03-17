<?php
if ($_POST) {
    require('../../common/class.translation.php');
    require('../../adata/Db.class.php');
    require('../../common/functions.php');
    require('../../bussiness/perfil.php');
    require('../../bussiness/usuarios.php');

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    $rpta = '0';
    $titulomsje = '';
    $contenidomensaje = '';
    

    $hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
    
    $ddlPerfil = '0';

    $txtApellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : '';
    $txtNombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : '';
    $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
    $txtClave = isset($_POST['txtClave']) ? $_POST['txtClave'] : '';
    
    
    $hdTipoDataPersona = '04';

    $hdIdPersona = '0';

    $hdIdProyecto = '0';

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

    $objUsuario = new clsUsuario();

    $objUsuario->Registrar($hdIdPrimary, $ddlPerfil, $hdIdPersona, $hdTipoDataPersona, $txtNombre, $txtNombres, $txtClave, $txtApellidos, '00', '', '', '', '', $txtEmail, $txtTelefono, $urlFoto, $hdIdProyecto, '00', 1, $rpta, $titulomsje, $contenidomsje);

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    echo json_encode($jsondata);
}
?>