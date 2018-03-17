<?php 
require 'adata/Db.class.php';
require 'functions.php';

$path_URLEditService = '';
$path_URLListService = '';
/*** PATH MODULES ***/
$admin = "admin/";
$common = "common/";
$security = "security/";
$process = "process/";
$reports = "reports/";
$settings = "settings/";
/*******************/
/*** PATH VIEWS ***/
$views = "views/";
/*******************/
/*** NAMEPAGES ***/
/***** COMMON ***/
$p_home = "home.php";
$p_uploader = "uploader.php";
$p_settings = "settings.php";
$p_reports = "reports.php";
$p_logout = "logout.php";
/******************/
/******ADMIN****/
$p_concepto = "concepto.php";
$p_condominio = "condominio.php";
$p_departamento = "departamento.php";
//$p_facturacionmaestro = "facturacionmaestro.php";
$p_formulaConcepto = "formulaConcepto.php";
$p_inquilino = "inquilino.php";
$p_propietario = "propietario.php";
$p_propietariobuqueda = "propietariobuqueda.php";
$p_conceptoescalonable = "conceptoescalonable.php";
$p_notificaciones = "notificaciones.php";
$p_modelos = "modelos.php";
$p_email = "email.php";
$p_constructora = "constructora.php";
/*/////////////////*/
/********PROCESS*******/
$p_resumen = "resumen.php";
$p_facturacion = "facturacion.php";
$p_presupuesto = "presupuesto.php";
$p_gastos = "gastos.php";
$p_cobranza = "cobranza.php";
$p_estadocuenta = "estadocuenta.php";
$p_liquidacion = "liquidacion.php";
/*************/
/********REPORTS*******/
$p_reporteador = 'reporteador.php';
$p_archivos = 'archivos.php';
$p_repsales = "repsales.php";
$p_repbuy = "repbuy.php";
$p_repproductsales = "repproductssales.php";
/*************/
/********SECURITY*******/
$p_users = "users-list.php";
$p_change_password = "change-password.php";;
/****************/
/********SETTINGS*******/
$p_billticket = "billticket.php";
$p_currency = "currency.php";
$p_waypay = "waypay.php";
$p_duty = "duty.php";
$p_documents = "documents.php";
$p_filing = "filing.php";
$p_worksarea = "worksarea.php";
$p_geopolitics = "geopolitics.php";
$p_upexcel = "upexcel.php";
$p_tipocobranza = "tiposcobranza.php";
$p_bancos = "bancos.php";
$p_cuentabancaria = "cuentabancaria.php";
/****************/
$pathview = "";
$subcontent = "";
$pathcontroller = "";

if ($pag == "inicio")
	$pathview = $common.$p_home;
elseif ($pag == 'uploader')
    $pathview = $common.$p_uploader;
elseif ($pag == "admin") {
    if ($subpag == "concepto")
        $subcontent = $p_concepto;
    elseif ($subpag == "condominio")
        $subcontent = $p_condominio;
    elseif ($subpag == "departamento")
        $subcontent = $p_departamento;
    elseif ($subpag == "facturacion")
        $subcontent = $p_facturacion;
    elseif ($subpag == "facturacionmaestro")
        $subcontent = $p_facturacionmaestro;
    elseif ($subpag == "formulaConcepto")
        $subcontent = $p_formulaConcepto;
    elseif ($subpag == "inquilino")
        $subcontent = $p_inquilino;
    elseif ($subpag == "presupuesto")
        $subcontent = $p_presupuesto;
    elseif ($subpag == "propietario")
        $subcontent = $p_propietario;
    elseif ($subpag == "propietariobusqueda")
        $subcontent = $p_propietariobusqueda;
    elseif ($subpag == "conceptoescalonable")
        $subcontent = $p_conceptoescalonable;   
    elseif ($subpag == "notificaciones")
        $subcontent = $p_notificaciones; 
    elseif ($subpag == "modelos")
        $subcontent = $p_modelos;
    elseif ($subpag == "email")
        $subcontent = $p_email;
    elseif ($subpag == "constructora")
        $subcontent = $p_constructora;   
    elseif ($subpag == "gastos")
        $subcontent = $p_gastos;
    $pathview = $admin.$subcontent;
}
elseif ($pag == "procesos") {
	if ($subpag == "facturacion")
		$subcontent = $p_facturacion;
    elseif ($subpag == "resumen")
        $subcontent = $p_resumen;
    elseif ($subpag == "cobranza")
        $subcontent = $p_cobranza;
    elseif ($subpag == "presupuesto")
        $subcontent = $p_presupuesto;
    elseif ($subpag == "gastos")
        $subcontent = $p_gastos;
    elseif ($subpag == "liquidacion")
        $subcontent = $p_liquidacion;
    elseif ($subpag == "estadocuenta")
        $subcontent = $p_estadocuenta;
	$pathview = $process.$subcontent;
}
elseif ($pag == "reports") {
    /*if (strlen(trim($subpag)) == 0)
        $pathview = $common.$p_reports;
    else {
        if ($subpag == "ventas")
            $subcontent = $p_repsales;
        elseif ($subpag == "compras")
            $subcontent = $p_repbuy;
        $pathview = $reports.$subcontent;
    }*/
    if ($subpag == "reportes")
        $subcontent = $p_reporteador;
    else if ($subpag == "archivos")
        $subcontent = $p_archivos;
    
    $pathview = $reports.$subcontent;
}
elseif ($pag == "security") {
	if ($subpag == "usuarios")
		$subcontent = $p_users;
    else if ($subpag == "changepassword")
        $subcontent = $p_change_password;
	$pathview = $security.$subcontent;
}
elseif ($pag == "settings"){
    if (strlen(trim($subpag)) == 0)
        $pathview = $common.$p_settings;
    else {
        if ($subpag == 'tipo-comprobante')
            $subcontent = $p_billticket;
        elseif ($subpag == 'moneda')
            $subcontent = $p_currency;
        elseif ($subpag == 'forma-pago')
            $subcontent = $p_waypay;
        elseif ($subpag == 'impuestos')
            $subcontent = $p_duty;
        elseif ($subpag == 'documentos')
            $subcontent = $p_documents;
        elseif ($subpag == 'areas-trabajo')
            $subcontent = $p_worksarea;
        elseif ($subpag == 'ubicaciones')
            $subcontent = $p_geopolitics;
        elseif ($subpag == 'subirexcel')
            $subcontent = $p_upexcel;
        elseif ($subpag == 'tiposcobranza')
            $subcontent = $p_tipocobranza;
        elseif ($subpag == 'bancos')
            $subcontent = $p_bancos;
        elseif ($subpag == 'cuentabancaria')
            $subcontent = $p_cuentabancaria;
        $pathview = $settings.$subcontent;   
    }
}

if ($pathview != "") {
    if ($pag == 'inicio'){
        $allheight = '';

        if ($idperfil != '61')
            $allheight = ' all-height';

        echo '<body class="fixed hold-transition skin-blue sidebar-mini' . $allheight . '">';
    }
    else
        echo '<body class="metro">';
	$pathview = $views.$pathview;
	include($pathview);
    echo '</body>';
}
?>
<input type="hidden" name="hdIdPerfil" id="hdIdPerfil" value="<?php echo $idperfil; ?>">
<input type="hidden" name="hdIdProyecto_Sesion" id="hdIdProyecto_Sesion" value="<?php echo $idproyecto_sesion; ?>">
<script>
$(function () {
    $('#btnBack').on('click', function(event) {
        event.preventDefault();
        window.top.showDesktop();
    });

    $('.close-modal-example').on('click', function(event) {
        event.preventDefault();
        closeCustomModal(this);
    });

    $(document).on('dragenter', function (event) {
        event.stopPropagation();
        event.preventDefault();
    });

    $(document).on('dragover', function (event) {
      event.stopPropagation();
      event.preventDefault();
    });

    $(document).on('drop', function (event) {
        event.stopPropagation();
        event.preventDefault();
    });

    ApplyValidNumbers();
});

function clearSelection () {
    $('.contentPedido ul li.selected').removeClass('selected');
}

function clearOnlyListSelection () {
    $('.gridview .selected').removeClass('selected');
    $('.gridview .tile input:checkbox').removeAttr('checked');
    $('.tile .input_spinner').hide();
}

function Cambiar_DatosProyecto_Work (idproyecto, anho, mes) {
    $('#hdIdProyecto').val(idproyecto);
    $('#ddlAnho').val(anho);
    $('#ddlMes').val(mes);

    if (typeof IniciarForm !== 'undefined')
        IniciarForm();
}
</script>