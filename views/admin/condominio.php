<?php
include('bussiness/banco.php');
include('bussiness/tabla.php');

$objBanco = new clsBanco();
$objTabla = new clsTabla();

$counterTipoProyecto = 0;
$counterTipoValoracion = 0;
$counterTipoPropiedad = 0;
$counterClasePropiedad = 0;
$counterBanco = 0;

$rowBanco = $objBanco->Listar('1', '0', '');
$countRowBanco = count($rowBanco);

$rowTipoProyecto = $objTabla->ValorPorCampo('ta_tipoproyecto');
$countRowTipoProyecto = count($rowTipoProyecto);

$rowTipoValoracion = $objTabla->ValorPorCampo('ta_tipovaloracion');
$countRowTipoValoracion = count($rowTipoValoracion);

$rowTipoPropiedad = $objTabla->ValorExcluido('ta_tipopropiedad', 'NA');
$countRowTipoPropiedad = count($rowTipoPropiedad);

$rowClasePropiedad = $objTabla->ValorPorCampo('ta_clasepropiedad');
$countRowClasePropiedad = count($rowClasePropiedad);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageProyecto" name="hdPageProyecto" value="1" />
    <input type="hidden" id="hdIdProyecto" name="hdIdProyecto" value="0">
    <input type="hidden" id="hdIdPropiedad" name="hdIdPropiedad" value="0">
    <input type="hidden" id="hdIdConstructora" name="hdIdConstructora" value="0">
    <input type="hidden" id="hdIdLocalidad" name="hdIdLocalidad" value="0">
    <input type="hidden" id="hdIdTorre" name="hdIdTorre" value="0">
    <input type="hidden" id="hdMnemonicoTipoPropiedad" name="hdMnemonicoTipoPropiedad" value="0">
    <input type="hidden" id="hdTipoValoracion" name="hdTipoValoracion" value="0">
    <input type="hidden" id="hdPagePropiedad" name="hdPagePropiedad" value="1">
    <input type="hidden" id="hdPagePropiedad__Orden" name="hdPagePropiedad__Orden" value="1">
    <input type="hidden" id="hdPagePropietario" name="hdPagePropietario" value="1">
    <input type="hidden" id="hdPageInquilino" name="hdPageInquilino" value="1">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region without-appbar">
        <div id="pnlListado" class="inner-page with-panel-search with-appbar <?php echo ($idproyecto_sesion == '') ? '' : 'hide' ; ?>">
            <h1 class="title-window hide">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Proyectos
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos" class="gridview scrollbarra col-md-12 padding-top20" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                </div>
            </div>
            <div class="appbar">
                <button id="btnEliminar" name="btnEliminar" type="button" class="metro_button oculto float-right" title="Eliminar Proyecto">
                    <h2><i class="icon-remove"></i></h2>
                </button>
                <button id="btnEditar" type="button" class="metro_button oculto float-right" title="Editar Proyecto">
                    <h2><i class="icon-pencil"></i></h2>
                </button>
                <button id="btnFijarProyecto" type="button" class="metro_button oculto float-right" title="Fijar Proyecto">
                    <h2><i class="fa icon-s fa-thumb-tack"></i></h2>
                </button>
                <button id="btnNuevo" type="button" class="metro_button float-right" title="Nuevo Proyecto">
                    <h2><i class="icon-plus-2"></i></h2>
                </button>
                <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left" title="Limpiar selecci&oacute;n">
                    <h2><i class="icon-undo"></i></h2>
                </button>
                <!-- <button id="btnProceso" type="button" class="metro_button oculto float-left" title="Proceso">
                    <h2><i class="icon-open"></i></h2>
                </button> -->
                <button id="btnListPropiedades" type="button" class="metro_button oculto float-left" title="Propiedades relacionadas">
                    <h2><i class="icon-grid"></i></h2>
                </button>
                <button id="btnIniciarFacturacion" type="button" class="metro_button oculto float-left" title="Generar facturaci&oacute;n">
                    <h2><i class="icon-dollar"></i></h2>
                </button>
            </div>
        </div>
        <div id="pnlOpciones" class="inner-page" <?php echo ($idproyecto_sesion == '') ? 'style="display: none;"' : '' ; ?>>
            <div class="title-window no-padding">
                <div class="row">
                    <div class="col-md-1 <?php echo ($idproyecto_sesion == '') ? '' : 'hide' ; ?>">
                        <a id="btnBackToProyecto" href="#" title="Atr&aacute;s" class="btnBackList btn btn-lg margin10 btn-primary">
                            <i class="icon-arrow-left-3 white-text"></i>
                        </a>
                    </div>
                    <div class="<?php echo ($idproyecto_sesion == '') ? 'col-md-7' : 'col-md-8' ; ?>">
                        <div id="lblTitleProceso" class="">
                            <h2 class="white-text left"><span class="title-window-details">Informaci&oacute;n de</span> <span id="tituloProyecto" class="title-window-details" data-hint-position="bottom" title=""></span></h2>
                            <!-- <button class="btn btn-default right margin20" id="btnCambiarProyecto">Cambiar</button> -->
                        </div>
                        <!-- <div id="inputInfoProceso" class="form-group margin20 hide">
                            <input type="text" name="txtSearchProyecto" id="txtSearchProyecto" placeholder="Buscar proyectos..." class="form-control" />
                        </div> -->
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-success margin20" id="btnProceso">Proceso</button>
                            </div>
                            <div class="col-md-8">
                                <h2 class="white-text"><span id="lblProceso" class="title-window-details">Ninguno</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="divload">
                <div id="pnlInfoGeneralProyecto" class="generic-panel gp-no-footer">
                    <div class="gp-header">
                        <div id="myTab" class="tabs-to-dropdown">
                            <nav class="tab-bar">
                                <ul>
                                    <li class="active"><a href="#tab_propiedades">Propiedades</a></li>
                                    <li><a href="#tab_conceptos" data-url="index.php?pag=admin&subpag=concepto">Conceptos</a></li>
                                    <li><a href="#tab_presupuesto" data-url="index.php?pag=procesos&subpag=presupuesto">Presupuesto</a></li>
                                    <li><a href="#tab_gastos" data-url="index.php?pag=procesos&subpag=gastos">Gastos</a></li>
                                    <li><a href="#tab_resumen" data-url="index.php?pag=procesos&subpag=resumen">Resumen</a></li>
                                    <li><a href="#tab_informes" data-url="index.php?pag=reports&subpag=reportes">Informes</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="gp-body">
                        <div id="tab_propiedades" class="panel-tab active">
                            <div id="pnlListPropiedades" class="inner-page with-panel-search with-appbar">
                                <div class="panel-search">
                                    <div class="grid fluid">
                                        <div class="row">
                                            <div class="span3">
                                                <div class="input-control select fa-caret-down" data-role="input-control">
                                                    <select id="ddlTipoPropiedadFiltro" name="ddlTipoPropiedadFiltro">
                                                        <option value="*">TODOS</option>
                                                        <?php
                                                        for ($counterTipoPropiedad=0; $counterTipoPropiedad < $countRowTipoPropiedad; $counterTipoPropiedad++):
                                                        ?>
                                                        <option value="<?php echo $rowTipoPropiedad[$counterTipoPropiedad]['ta_codigo']; ?>">
                                                            <?php $translate->__($rowTipoPropiedad[$counterTipoPropiedad]['ta_denominacion']); ?>
                                                        </option>
                                                        <?php
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="span9">
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtSearchPropiedad" name="txtSearchPropiedad" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                                    <button id="btnSearchPropiedad" name="btnSearchPropiedad" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divload">
                                    <div id="gvPropiedad" class="scrollbarra">
                                        <div class="items-area listview gridview">
                                        </div>
                                    </div>
                                </div>
                                <div class="appbar">
                                    <button id="btnGenPropFromList" type="button" class="metro_button float-right" title="Propiedades autom&aacute;ticas">
                                        <h2><i class="icon-diary"></i></h2>
                                    </button>
                                    <button id="btnEliminarPropiedad" type="button" class="metro_button oculto float-right" title="Eliminar">
                                        <h2><i class="icon-remove"></i></h2>
                                    </button>
                                    <button id="btnAsignPropToPerson" type="button" class="metro_button oculto float-right" title="Asignar propiedades a propietarios y/o inquilinos">
                                        <h2><i class="icon-user-3"></i></h2>
                                    </button>
                                    <button id="btnMassConcept" type="button" class="metro_button oculto float-right" title="Editar propiedades">
                                        <h2><i class="fa fa-object-group icon-s"></i></h2>
                                    </button>
                                    <button id="btnOrdenPropiedad" type="button" class="metro_button float-right" title="Orden de propiedades">
                                        <h2><i class="fa fa-sort" aria-hidden="true"></i></h2>
                                    </button>
                                    <button id="btnClearSelPropiedades" type="button" class="metro_button oculto float-left" title="Limpiar selecci&oacute;n">
                                        <h2><i class="icon-undo"></i></h2>
                                    </button>
                                    <button id="btnRelacionarPropiedades" type="button" class="metro_button oculto float-right" title="Relacionar propiedades">
                                        <h2><i class="icon-link"></i></h2>
                                    </button>
                                    <button id="btnRomperRelaciones" type="button" class="metro_button oculto float-right" title="Quitar relaciones">
                                        <h2><i class="icon-link-2"></i></h2>
                                    </button>
                                    <button id="btnSelectAllPropiedades" type="button" class="metro_button float-left" title="Seleccionar todo">
                                        <h2><i class="icon-checkbox"></i></h2>
                                    </button>
                                    <button id="btnSaveValuesPropiedades" type="button" class="metro_button float-left" title="Guardar cambios">
                                        <h2><i class="icon-floppy"></i></h2>
                                    </button>
                                    <button id="btnExportarPropiedad" type="button" class="metro_button float-left" data-hint-position="top" title="Exportar propiedades">
                                        <h2><i class="icon-download"></i></h2>
                                    </button>
                                    <button id="btnImportarPropiedad" type="button" class="metro_button float-left" data-hint-position="top" title="Importar consumo de agua">
                                        <h2><i class="icon-upload"></i></h2>
                                    </button>
                                </div>
                            </div>
                            <div id="pnlRelacionadas" class="generic-panel" style="display:none;">
                                <div class="gp-header">
                                    <h3>
                                        <a href="#" id="btnHideRelaciones" class="back-button black-text">
                                            <i class="icon-arrow-left-3 fg-darker left"></i> <?php $translate->__('Relaciones'); ?>
                                        </a>
                                    </h3>
                                    <div class="input-control text" data-role="input-control">
                                        <input type="text" id="txtSearchRelaciones" name="txtSearchRelaciones" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                        <button id="btnSearchRelaciones" type="button" class="btn-search" tabindex="-1"></button>
                                    </div>
                                </div>
                                <div class="gp-body">
                                    <div id="gvRelaciones" class="scrollbarra">
                                        <div class="items-area listview gridview"></div>
                                    </div>
                                </div>
                                <div class="gp-footer">
                                    <div class="appbar">
                                        <button id="btnEliminarRelacion" type="button" class="metro_button float-right oculto" title="Eliminar relaci&oacute;n">
                                            <h2><i class="icon-remove"></i></h2>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab_conceptos" class="panel-tab"></div>
                        <div id="tab_presupuesto" class="panel-tab"></div>
                        <div id="tab_gastos" class="panel-tab"></div>
                        <div id="tab_cobranza" class="panel-tab"></div>
                        <div id="tab_resumen" class="panel-tab"></div>
                        <div id="tab_informes" class="panel-tab"></div>
                    </div>
                    <!-- <div id="myTab">1
                        <ul>
                            <li><a href="#tab_propiedades">Propiedades</a></li>
                            <li><a href="#tab_conceptos">Conceptos</a></li>
                            <li><a href="#tab_presupuesto">Presupuesto</a></li>
                            <li><a href="#tab_cobranza">Cobranza</a></li>
                            <li><a href="#tab_resumen">Resumen</a></li>
                        </ul>
                        <div id="tab_propiedades"></div>
                        <div id="tab_conceptos"></div>
                        <div id="tab_presupuesto"></div>
                        <div id="tab_gastos"></div>
                        <div id="tab_cobranza"></div>
                    </div> -->
                    <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li role="presentation" class="active"><a href="#propiedades">Propiedades</a></li>
                        <li role="presentation"><a href="#conceptos" data-url="index.php?pag=admin&subpag=concepto">Conceptos</a></li>
                        <li role="presentation"><a href="#presupuesto" data-url="index.php?pag=procesos&subpag=presupuesto">Presupuesto</a></li>
                        <li role="presentation"><a href="#gastos" data-url="index.php?pag=procesos&subpag=gastos">Gastos</a></li>
                        <li role="presentation"><a href="#cobranza" data-url="index.php?pag=procesos&subpag=cobranza">Cobranza</a></li>
                        <li role="presentation"><a href="#resumen" data-url="index.php?pag=procesos&subpag=resumen">Resumen</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="propiedades">
                            <div id="pnlListPropiedades" class="inner-page with-panel-search with-appbar">
                                <div class="panel-search">
                                    <div class="grid fluid">
                                        <div class="row">
                                            <div class="span3">
                                                <div class="input-control select fa-caret-down" data-role="input-control">
                                                    <select id="ddlTipoPropiedadFiltro" name="ddlTipoPropiedadFiltro">
                                                        <option value="*">TODOS</option>
                                                        <?php
                                                        for ($counterTipoPropiedad=0; $counterTipoPropiedad < $countRowTipoPropiedad; $counterTipoPropiedad++):
                                                        ?>
                                                        <option value="<?php echo $rowTipoPropiedad[$counterTipoPropiedad]['ta_codigo']; ?>">
                                                            <?php $translate->__($rowTipoPropiedad[$counterTipoPropiedad]['ta_denominacion']); ?>
                                                        </option>
                                                        <?php
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="span9">
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtSearchPropiedad" name="txtSearchPropiedad" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                                    <button id="btnSearchPropiedad" name="btnSearchPropiedad" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divload">
                                    <div id="gvPropiedad" class="scrollbarra">
                                        <div class="items-area listview gridview">
                                        </div>
                                    </div>
                                </div>
                                <div class="appbar">
                                    <button id="btnGenPropFromList" type="button" class="metro_button float-right" title="Propiedades autom&aacute;ticas">
                                        <h2><i class="icon-diary"></i></h2>
                                    </button>
                                    <button id="btnEliminarPropiedad" type="button" class="metro_button oculto float-right" title="Eliminar">
                                        <h2><i class="icon-remove"></i></h2>
                                    </button>
                                    <button id="btnAsignPropToPerson" type="button" class="metro_button oculto float-right" title="Asignar propiedades a propietarios y/o inquilinos">
                                        <h2><i class="icon-user-3"></i></h2>
                                    </button>
                                    <button id="btnMassConcept" type="button" class="metro_button oculto float-right" title="Editar propiedades">
                                        <h2><i class="fa fa-object-group icon-s"></i></h2>
                                    </button>
                                    <button id="btnClearSelPropiedades" type="button" class="metro_button oculto float-left" title="Limpiar selecci&oacute;n">
                                        <h2><i class="icon-undo"></i></h2>
                                    </button>
                                    <button id="btnRelacionarPropiedades" type="button" class="metro_button oculto float-right" title="Relacionar propiedades">
                                        <h2><i class="icon-link"></i></h2>
                                    </button>
                                    <button id="btnRomperRelaciones" type="button" class="metro_button oculto float-right" title="Quitar relaciones">
                                        <h2><i class="icon-link-2"></i></h2>
                                    </button>
                                    <button id="btnSelectAllPropiedades" type="button" class="metro_button float-left" title="Seleccionar todo">
                                        <h2><i class="icon-checkbox"></i></h2>
                                    </button>
                                    <button id="btnSaveValuesPropiedades" type="button" class="metro_button float-left" title="Guardar cambios">
                                        <h2><i class="icon-floppy"></i></h2>
                                    </button>
                                </div>
                            </div>
                            <div id="pnlRelacionadas" class="generic-panel gp-no-footer" style="display:none;">
                                <div class="gp-header">
                                    <h3>
                                        <a href="#" id="btnHideRelaciones" class="back-button black-text">
                                            <i class="icon-arrow-left-3 fg-darker left"></i> <?php $translate->__('Relaciones'); ?>
                                        </a>
                                    </h3>
                                    <div class="input-control text" data-role="input-control">
                                        <input type="text" id="txtSearchRelaciones" name="txtSearchRelaciones" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                        <button id="btnSearchRelaciones" type="button" class="btn-search" tabindex="-1"></button>
                                    </div>
                                </div>
                                <div class="gp-body">
                                    <div id="gvRelaciones" class="scrollbarra">
                                        <div class="items-area listview gridview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="conceptos"></div>
                        <div role="tabpanel" class="tab-pane" id="presupuesto"></div>
                        <div role="tabpanel" class="tab-pane" id="gastos"></div>
                        <div role="tabpanel" class="tab-pane" id="cobranza"></div>
                        <div role="tabpanel" class="tab-pane" id="resumen"></div>
                    </div> -->
                </div>
                <div id="pnlInfoDetalleProyecto" class="inner-page" style="display: none;">
                    <div class="all-height pos-rel">
                        <button class="btn btn-primary place-top-right margin3" id="btnBackToInfoProyecto"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <ul class="nav nav-tabs" id="tabProyecto" role="tablist">
                            <li role="presentation" class="active"><a href="#facturacion" data-url="index.php?pag=procesos&subpag=facturacion">Facturaci&oacute;n</a></li>
                            <li role="presentation"><a href="#cobranza" data-url="index.php?pag=procesos&subpag=cobranza">Cobranza</a></li>
                            <li role="presentation"><a href="#liquidacion" data-url="index.php?pag=procesos&subpag=liquidacion">Liquidaci&oacute;n</a></li>
                            <li role="presentation"><a href="#documentos" data-url="index.php?pag=reports&subpag=archivos">Documentos</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="facturacion"></div>
                            <div role="tabpanel" class="tab-pane" id="cobranza"></div>
                            <div role="tabpanel" class="tab-pane" id="liquidacion"></div>
                            <div role="tabpanel" class="tab-pane" id="documentos"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlConstructora" class="top-panel generic-panel gp-no-footer" style="display:none;">
        <div class="gp-header light-blue darken-4">
            <div class="row padding10">
                <div class="col-md-1">
                    <a href="#" id="btnHideConstructora" class="btn btn-primary white-text left">
                        <i class="icon-arrow-left-3"></i></a>
                </div>
                <div class="col-md-4">
                    <h2 class="no-margin white-text"><?php $translate->__('Constructora'); ?></h2>
                </div>
                <div class="col-md-7">
                    <div class="input-control text right" data-role="input-control">
                        <input type="text" id="txtSearchConstructora" name="txtSearchConstructora" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                        <button id="btnSearchConstructora" type="button" class="btn-search" tabindex="-1"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="gp-body">
            <div id="gvConstructora" class="scrollbarra">
                <div class="items-area listview gridview"></div>
            </div>
        </div>
    </div>
    <div id="pnlPropietarioInquilino" class="top-panel inner-page with-appbar" style="display:none;">
        <h1 class="title-window hide">
            
            <?php $translate->__('Propietarios e Inquilinos'); ?>
        </h1>
        <div class="divContent">
            <div class="moduloTwoPanel default">
                <div class="colTwoPanel1">
                    <div id="pnlPropietario" class="inner-page with-title-search">
                        <h2 class="title-window">
                            <a href="#" id="btnHidePropietarioInquilino" class="btn btn-lg margin10 btn-primary"><i class="icon-arrow-left-3"></i></a>
                            Propietarios
                            <div class="col-md-6 no-float margin10 place-top-right">
                                <div class="input-group">
                                  <input id="txtSearchPropietario" name="txtSearchPropietario" type="text" class="form-control fg-dark" placeholder="Buscar...">
                                  <span class="input-group-btn">
                                    <button id="btnSearchPropietario" class="btn btn-default" type="button">Buscar</button>
                                  </span>
                                </div><!-- /input-group -->
                            </div>
                        </h2>
                        <div class="divload">
                            <div id="gvPropietario" class="scrollbarra">
                                <div class="items-area listview gridview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="colTwoPanel2">
                    <div id="pnlInquilino" class="inner-page with-title-search">
                        <h2 class="title-window" style="height: 86px;">
                            Inquilinos
                            <div class="col-md-6 no-float margin10 place-top-right">
                                <div class="input-group">
                                  <input id="txtSearchInquilino" name="txtSearchInquilino" type="text" class="form-control fg-dark" placeholder="Buscar...">
                                  <span class="input-group-btn">
                                    <button id="btnSearchInquilino" class="btn btn-default" type="button">Buscar</button>
                                  </span>
                                </div><!-- /input-group -->
                            </div>
                        </h2>
                        <div class="divload">
                            <div id="gvInquilino" class="scrollbarra">
                                <div class="items-area listview gridview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="appbar">
            <button id="btnAsignarPropiedades" type="button" class="metro_button oculto float-right" title="Asignar propietario/inquilino a propiedad">
                <h2><i class="icon-checkmark"></i></h2>
            </button>
            <button id="btnClearSelPropInquilino" type="button" class="metro_button oculto float-left" title="Limpiar selecci&oacute;n">
                <h2><i class="icon-undo"></i></h2>
            </button>
            <button id="btnSelectAllPropInquilino" type="button" class="metro_button float-left" title="Seleccionar todo">
                <h2><i class="icon-checkbox"></i></h2>
            </button>
        </div>
    </div>
    <div id="pnlDepartamento" class="top-panel inner-page with-panel-search with-appbar" style="display:none;">
        <h1 class="title-window no-padding">
            <a href="#" id="btnHideDepartamento" class="back-button"><i class="icon-arrow-left-3 fg-white"></i></a>
            <?php $translate->__('Departamentos'); ?>

            <div class="col-md-6 no-float margin5 place-top-right">
                <div class="input-group">
                  <input id="txtSearchDepartamento" name="txtSearchDepartamento" type="text" class="form-control fg-dark" placeholder="Buscar...">
                  <span class="input-group-btn">
                    <button id="btnSearchDepartamento" class="btn btn-default" type="button">Buscar</button>
                  </span>
                </div><!-- /input-group -->
            </div>
        </h1>
        <div class="divload">
            <div id="gvDepartamento" class="scrollbarra">
                <div class="items-area listview gridview"></div>
            </div>
        </div>
        <div class="appbar">
            <button id="btnClearSelDepartamentos" type="button" class="metro_button oculto float-left" title="Limpiar selecci&oacute;n">
                <h2><i class="icon-undo"></i></h2>
            </button>
            <button id="btnSelectAllDepartamentos" type="button" class="metro_button float-left" title="Seleccionar todo">
                <h2><i class="icon-checkbox"></i></h2>
            </button>
            <button id="btnRelacionar" type="button" class="metro_button oculto float-right" title="Relaci&oacute;nar">
                <h2><i class="icon-checkmark"></i></h2>
            </button>
        </div>
    </div>
    <div id="modalUbigeo" class="modaluno modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Ubigeo
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddlDepartamento">Departamento</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlDepartamento" name="ddlDepartamento">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlProvincia">Provincia</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlProvincia" name="ddlProvincia">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlDistrito">Distrito</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlDistrito" name="ddlDistrito">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                    </div>
                    <div class="span6">
                        <button id="btnAplicarUbigeo" type="button" class="command-button mode-add success">Aplicar Ubigeo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalRegistroProyecto" class="modalcuatro modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de Proyecto
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="moduloTwoPanel default">
                <div class="colTwoPanel1 scrollbarra">
                    <div class="grid fluid">
                        <div class="row">
                            <label for="ddlTipoProyecto">Tipo de proyecto</label>
                            <div class="input-control select fa-caret-down" data-role="input-control">
                                <select id="ddlTipoProyecto" name="ddlTipoProyecto">
                                    <?php
                                    for ($counterTipoProyecto=0; $counterTipoProyecto < $countRowTipoProyecto; $counterTipoProyecto++):
                                    ?>
                                    <option value="<?php echo $rowTipoProyecto[$counterTipoProyecto]['ta_codigo']; ?>">
                                        <?php $translate->__($rowTipoProyecto[$counterTipoProyecto]['ta_denominacion']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="ddlTipoValoracion">Tipo de valoraci&oacute;n</label>
                            <div class="input-control select fa-caret-down" data-role="input-control">
                                <select id="ddlTipoValoracion" name="ddlTipoValoracion">
                                    <?php
                                    for ($counterTipoValoracion=0; $counterTipoValoracion < $countRowTipoValoracion; $counterTipoValoracion++):
                                    ?>
                                    <option value="<?php echo $rowTipoValoracion[$counterTipoValoracion]['ta_codigo']; ?>">
                                        <?php $translate->__($rowTipoValoracion[$counterTipoValoracion]['ta_denominacion']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="rowCobroDiferenciado" class="row">
                            <div class="input-control checkbox" data-role="input-control">
                                <label>
                                    <input id="chkCobroDiferenciado" name="chkCobroDiferenciado" type="checkbox" value="1">
                                    <span class="check"></span>
                                    ¿Tiene cobro diferenciado de ascensores por torre?
                                </label>
                            </div>
                        </div>
                        <div id="rowDatoSimpleDuplex" class="row">
                            <div class="input-control checkbox" data-role="input-control">
                                <label>
                                    <input id="chkDatoSimpleDuplex" name="chkDatoSimpleDuplex" type="checkbox" value="1">
                                    <span class="check"></span>
                                    ¿Tiene departamentos dúplex?
                                </label>
                            </div>
                        </div>
                        <div id="rowPorcentajeDuplex" class="row">
                            <div id="rowChkPorcjDuplex" class="span12">
                                <div class="input-control checkbox" data-role="input-control">
                                    <label>
                                        <input id="chkPorcjDuplex" name="chkPorcjDuplex" type="checkbox" value="1">
                                        <span class="check"></span>
                                        ¿Tiene porcentaje de descuento por departamento duplex?
                                    </label>
                                </div>
                            </div>
                            <div id="rowPorcjDuplex" style="display: none;" class="span4">
                                <label for="txtPorcjDuplex">Porcentaje Dscto.</label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtPorcjDuplex" name="txtPorcjDuplex" type="text" placeholder="<?php $translate->__('Ejemplo: 0.00'); ?>" value="0.00">
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="pnlInfoConstructora" data-idconstructora="0" class="panel-info without-foto" title="Constructora">
                                <div class="info">
                                    <h3 class="descripcion">Constructora</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtCodigoProyecto">C&oacute;digo de proyecto</label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtCodigoProyecto" name="txtCodigoProyecto" type="text" placeholder="<?php $translate->__('Ejemplo: 001'); ?>">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtNombreProyecto">Nombre de proyecto</label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtNombreProyecto" name="txtNombreProyecto" type="text" placeholder="<?php $translate->__('Ejemplo: Proyecto X'); ?>">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                        <div class="row">
                            <label for="ddlBanco">Banco</label>
                            <div class="input-control select fa-caret-down" data-role="input-control">
                                <select id="ddlBanco" name="ddlBanco">
                                    <?php
                                    for ($counterBanco=0; $counterBanco < $countRowBanco; $counterBanco++):
                                    ?>
                                    <option value="<?php echo $rowBanco[$counterBanco]['tm_idbanco']; ?>">
                                        <?php $translate->__($rowBanco[$counterBanco]['tm_nombrebanco']); ?>
                                    </option>
                                    <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="ddlCuentaBancaria">Cuenta Bancaria</label>
                            <div class="input-control select fa-caret-down" data-role="input-control">
                                <select id="ddlCuentaBancaria" name="ddlCuentaBancaria">
                                    <option value="0">No hay cuentas bancarias</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtDireccionPago">Direcci&oacute;n de pago</label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtDireccionPago" name="txtDireccionPago" type="text" placeholder="<?php $translate->__('Ejemplo: Av. del pago Dpto 103 Torre Z'); ?>">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtEmailPago">Email de pago</label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtEmailPago" name="txtEmailPago" type="text" placeholder="<?php $translate->__('Ejemplo: infopago@info.pe'); ?>">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="colTwoPanel2 scrollbarra">
                    <div class="grid">
                        <div class="row">
                            <div id="pnlInfoUbigeo" data-idubigeo="0" class="panel-info without-foto" title="Localidad">
                                <div class="info">
                                    <h3 class="descripcion">Localidad</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtDireccion">Direcci&oacute;n</label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtDireccion" name="txtDireccion" type="text" placeholder="<?php $translate->__('Ejemplo: Proyecto 001'); ?>">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="pnlInfoConcepto" data-editado="0" class="panel-info without-foto">
                                <div class="info">
                                    <h3 class="descripcion">Conceptos del proyecto</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label>Logo de proyecto</label>
                        </div>
                        <div class="row text-center">
                            <div class="droping-air mode-image">
                                <input id="fileImagen" name="fileImagen" type="file" class="file-import">
                                <div class="icon"></div>
                                <div class="help">
                                    Seleccione o arrastre un archivo de imagen (*.jpg, .gif, *.png)
                                </div>
                                <a class="cancel oculto" title="Quitar imagen"><h2 class="no-margin fg-white fg-hover-amber"><i class="icon-cancel"></i></h2></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span8"></div>
                    <div class="span4">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Aplicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalGenValorFijo" class="modaltres modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Actualziaci&oacute;n de Valores Fijos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <fieldset>
                    <legend>Tipo de valor</legend>
                    <div class="row">
                         <div class="input-control radio default-style" data-role="input-control">
                            <label>
                                <input type="radio" id="optSaldoInicial" name="optValor" />
                                <span class="check"></span>
                                <span class="text">Saldo inicial</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-control radio  default-style" data-role="input-control">
                            <label>
                                <input type="radio" id="optOtroValor" name="optValor" />
                                <span class="check"></span>
                                <span class="text">Importe Fijo</span>
                            </label>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Tipo de operaci&oacute;n</legend>
                    <div class="row">
                         <div class="input-control radio default-style" data-role="input-control">
                            <label>
                                <input type="radio" id="optDirect" name="optTipoOperacion" />
                                <span class="check"></span>
                                Guardar seleccionados
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span6">
                            <div class="input-control radio  default-style" data-role="input-control">
                                <label>
                                    <input type="radio" id="optAllValue" name="optTipoOperacion" />
                                    <span class="check"></span>
                                    Aplicar a todos el valor
                                </label>
                            </div>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtValorFijo" name="txtValorFijo" type="text" title="" value="0.00">
                                <button class="btn-clear" type="button"></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span5"></div>
                    <div class="span7">
                        <button id="btnGuardarValores" type="button" class="command-button bg-blue fg-white mode-add">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalGenFacturacion" class="modalseis modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Generaci&oacute;n de facturaci&oacute;n
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <label for="ddlAnho">Año</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlAnho" name="ddlAnho">
                            </select>
                        </div>
                    </div>
                    <div class="span6">
                        <label for="ddlMes">Mes</label>
                        <div class="input-control select fa-caret-down" data-role="input-control">
                            <select id="ddlMes" name="ddlMes">
                                <?php ListarMeses(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span6">
                        <label for="txtFechaVencimiento">Fecha vencimiento</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtFechaVencimiento" name="txtFechaVencimiento" type="text" title="">
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                    <div class="span6">
                        <label for="txtFechaTope">Fecha tope</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtFechaTope" name="txtFechaTope" type="text" title="">
                            <button class="btn-clear" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span5"></div>
                    <div class="span7">
                        <button id="btnGenerarFacturacion" type="button" class="command-button bg-blue fg-white mode-add">Generar facturaci&oacute;n</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalGenPropiedad" class="modalcinco modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a id="btnCloseModalGenPropiedad" class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Generaci&oacute;n de propiedades
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="gpPropiedad" class="generic-panel gp-no-header">
                <div class="gp-body">
                    <div class="scrollbarra">                    
                        <div class="grid fluid">
                            <div id="rowTipoPropiedad" class="row">
                                <label for="ddlTipoPropiedad">Tipo de propiedad</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlTipoPropiedad" name="ddlTipoPropiedad">
                                        <?php
                                        for ($counterTipoPropiedad=0; $counterTipoPropiedad < $countRowTipoPropiedad; $counterTipoPropiedad++):
                                        ?>
                                        <option value="<?php echo $rowTipoPropiedad[$counterTipoPropiedad]['ta_codigo']; ?>">
                                            <?php $translate->__($rowTipoPropiedad[$counterTipoPropiedad]['ta_denominacion']); ?>
                                        </option>
                                        <?php
                                        endfor;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="rowClasePropiedad" class="row">
                                <label for="ddlClasePropiedad">Tipo de propiedad</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlClasePropiedad" name="ddlClasePropiedad">
                                        <?php
                                        for ($counterClasePropiedad=0; $counterClasePropiedad < $countRowClasePropiedad; $counterClasePropiedad++):
                                        ?>
                                        <option value="<?php echo $rowClasePropiedad[$counterClasePropiedad]['ta_codigo']; ?>">
                                            <?php $translate->__($rowClasePropiedad[$counterClasePropiedad]['ta_denominacion']); ?>
                                        </option>
                                        <?php
                                        endfor;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span4">
                                    <label for="txtAreaTechada">Area techada</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtAreaTechada" name="txtAreaTechada" type="text" value="0.00">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="span4">
                                    <label for="txtAreaSinTechar">Area sin techar</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtAreaSinTechar" name="txtAreaSinTechar" type="text" value="0.00">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="span4">
                                    <label for="txtAreaPropiedad">Area Propiedad</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtAreaPropiedad" name="txtAreaPropiedad" type="text" readonly="" value="0.00">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <!-- <div id="pnlInfoArea" class="panel-info without-foto" title="Area (m2)">
                                    <div class="info">
                                        <h3 class="descripcion">Area: 0 (m<sup>2</sup>)</h3>
                                    </div>
                                </div> -->
                            </div>
                            <div id="rowChkIngreso" class="row">
                                <div class="input-control checkbox" data-role="input-control">
                                    <label>
                                        <input id="chkIngresoTorre" name="chkIngresoTorre" type="checkbox" value="1">
                                        <span class="check"></span>
                                        Ingresar torre
                                    </label>
                                </div>
                            </div>
                            <div id="rowIngreso" class="row oculto">
                                <label for="txtIngresoTorre">Nombre de torre</label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtIngresoTorre" name="txtIngresoTorre" type="text" placeholder="<?php $translate->__('Ejemplo: Torre A'); ?>">
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                                <label for="txtNroSuministro">N&uacute;mero de suministro</label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtNroSuministro" name="txtNroSuministro" type="text" placeholder="<?php $translate->__('Ejemplo: ETR98798798'); ?>">
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                            <div class="row">
                                <div id="pnlInfoTorre" data-idubigeo="0" class="panel-info without-foto" title="Torre">
                                    <div class="info">
                                        <h3 class="descripcion">Torre</h3>
                                    </div>
                                </div>
                            </div>
                            <div id="rowRangos" class="row">
                                <div class="span4">
                                    <label for="txtNroInicial">N&uacute;mero inicial</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtNroInicial" name="txtNroInicial" type="text" placeholder="<?php $translate->__('Ejemplo: 1'); ?>" value="0">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="span4">
                                    <label for="txtNroFinal">N&uacute;mero final</label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtNroFinal" name="txtNroFinal" type="text" placeholder="<?php $translate->__('Ejemplo: 50'); ?>" value="0">
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="span4">
                                    <button id="btnGenVistaPropiedad" type="button" class="mode-add default margin10">Generar propiedades a registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-footer">
                    <div id="pnlPropiedadSelected" class="cover-panel bg-white">
                        <div class="generic-panel gp-no-footer">
                            <div class="gp-header">
                                <h2 class="margin10">Propiedades a gestionar</h2>
                            </div>
                            <div class="gp-body">
                                <div id="gvPropiedadSelected" class="scrollbarra">
                                    <div class="items-area listview gridview no-hover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnPropiedadMasiva" type="button" class="command-button mode-add success">Aplicar cambios</button>
                    </div>
                    <div class="span6">
                        <button id="btnCancelarGenProp" type="button" class="command-button mode-add default">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalOrdenPropiedad" class="modal-dialog-x modaluno modal-example-content without-footer">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Orden de propiedades
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="gvPropiedadOrden" class="scrollbarra padding20">
                <div class="listview">
                    <div class="ui-sortable">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalTorre" class="modal-dialog-x modaluno modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Lista de torres
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="grid padding10">
                        <div class="row">
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSearchTorre" name="txtSearchTorre" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearchTorre" name="btnSearchTorre" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div class="scrollbarra">
                        <div id="gvTorre" class="grid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardarTorre" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarTorre" type="button" class="command-button mode-add default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalConcepto" class="modal-dialog modal-nomodal modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Conceptos relacionados
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="gpConcepto" class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div id="tableConcepto" class="itables">
                        <div class="ihead">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Concepto de ingreso</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="ibody">
                            <div class="ibody-content">
                                <table>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="tableConceptoFormula" class="itables">
                        <div class="ihead">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Resultado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="ibody">
                            <div class="ibody-content">
                                <table>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span9"></div>
                    <div class="span3">
                        <button id="btnAplicarConcepto" type="button" class="command-button mode-add success">Aplicar conceptos</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalProceso" class="modaluno modal-dialog-x modal-example-content <?php echo ($idproyecto_sesion == '') ? '' : 'without-footer' ; ?>">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Procesos
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="gpProceso" class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="grid fluid">
                        <div class="row">
                            <div class="span4">
                                <label for="ddlAnhoProceso">A&ntilde;o</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlAnhoProceso" name="ddlAnhoProceso">
                                        <?php
                                        $i = 2000;
                                        while ($i <= (int)date('Y') + 1):

                                            ++$i;
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span4">
                                <label for="ddlMesProceso">Mes</label>
                                <div class="input-control select fa-caret-down" data-role="input-control">
                                    <select id="ddlMesProceso" name="ddlMesProceso">
                                        <?php ListarMeses(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span4">
                                <?php
                                if ($idperfil == '61'):
                                    if ($idproyecto_sesion == ''):
                                ?>
                                <button id="btnAbrirProceso" type="button" class="command-button mode-add success">Abrir Proceso</button>
                                <?php
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="tableProceso" class="itables">
                        <div class="ihead">
                            <table>
                                <thead>
                                    <tr>
                                        <th>A&ntilde;o</th>
                                        <th>Mes</th>
                                        <th>Estado</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="ibody">
                            <div class="ibody-content">
                                <table>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($idperfil == '61'):
            if ($idproyecto_sesion == ''):
        ?>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span7"></div>
                    <div class="span5">
                        <button id="btnCerrarProceso" type="button" class="command-button oculto mode-add danger">Cerrar Proceso</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            endif;
        endif;
        ?>
    </div>
    <div id="modalLiquidacion" class="modaluno modal-dialog-x modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Liquidaci&oacute;n - Saldo inicial
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddlAnho_Liquidacion">Año</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlAnho_Liquidacion" name="ddlAnho_Liquidacion">
                            <option value="0">SELECCIONE PROYECTO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlMes_Liquidacion">Mes</label>
                    <div class="input-control select fa-caret-down" data-role="input-control">
                        <select id="ddlMes_Liquidacion" name="ddlMes_Liquidacion">
                            <?php ListarMeses(); ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="txtSaldoInicial">Saldo Inicial</label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtSaldoInicial" name="txtSaldoInicial" type="text" placeholder="Ingrese Saldo" aria-required="true" aria-invalid="false" data-original-title="" title="">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="row">
                <div class="col-md-9">
                </div>
                <div class="col-md-3">
                    <button id="btnGuardarLiquidacion" type="button" class="btn btn-primary full-size">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="dist/js/responsive-tabs.min.js"></script>
<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script>
<script src="dist/js/app/admin/condominio-script.js"></script>