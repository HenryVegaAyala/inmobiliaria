$(function() {
    $("#ddlAnho").on("change", function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarPropiedades("1");
    });
    $("#ddlMes").on("change", function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarPropiedades("1");
    });
    $("#ddlTipoPropiedadFiltro").on("change", function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarPropiedades("1");
    });
    $("#txtSearchPropiedad").keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            $("#btnSearchPropiedad").trigger("click");
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) return false;
    });
    $("#btnSearchPropiedad").on("click", function(event) {
        event.preventDefault();
        paginaGenFacturacion = 1;
        ListarPropiedades("1");
    });
    $("#txtSearchProyecto").keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            $("#btnSearchProyecto").trigger("click");
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) return false;
    });
    $("#btnSearchProyecto").on("click", function(event) {
        event.preventDefault();
        ListarProyectos("1");
    });
    $("#pnlInfoProyecto").on("click", function(event) {
        event.preventDefault();
        ShowPanelProyecto();
    });
    $("#btnHideProyecto").on("click", function(event) {
        event.preventDefault();
        $("#pnlProyecto").fadeOut(400, function() {});
    });
    $("#gvProyecto > .items-area").on("scroll", function() {
        var paginaActual = 0;
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            paginaActual = Number($("#hdPageProyecto").val());
            ListarProyectos(paginaActual);
        }
    });
    $("#gvProyecto .items-area").on("click", ".dato", function(event) {
        event.preventDefault();
        var idproyecto = "0";
        var nombre = "";
        idproyecto = this.getAttribute("data-idproyecto");
        nombre = this.getAttribute("data-nombre");
        idbanco = this.getAttribute("data-idbanco");
        nombrebanco = this.getAttribute("data-nombrebanco");
        idcuentabancaria = this.getAttribute("data-idcuentabancaria");
        descripcioncuenta = this.getAttribute("data-descripcioncuenta");
        $("#ddlMes").val(this.getAttribute("data-mes"));
        setProyecto(idproyecto, nombre, idbanco, nombrebanco, idcuentabancaria, descripcioncuenta);
    });
    $("#gvGenFacturacion > .gridview").on("scroll", function() {
        var paginaActual = 0;
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            paginaActual = Number($("#hdPageGenFacturacion").val());
            ListarPropiedades(paginaActual);
        }
    });
    $("#gvGenFacturacion").on("click", ".dato", function(event) {
        event.preventDefault();
        var idpropiedad = "0";
        idpropiedad = this.getAttribute("data-idpropiedad");
        $("#gvGenFacturacion .dato.selected").removeClass("selected");
        $(this).addClass("selected");
        $("#hdIdPropiedad").val(idpropiedad);
        ListarFacturacion(idpropiedad);
        ListarCobranza();
    });
    $("#tableFacturacion tbody").on("click", "tr", function(event) {
        event.preventDefault();
        var idfacturacion = "0";
        idfacturacion = this.getAttribute("data-idfacturacion");
        /*$(this).siblings('.selected').removeClass('selected');
        $(this).addClass('selected');*/
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
            if ($("#tableFacturacion tbody tr.selected").length == 0) $("#btnNuevo").addClass("oculto");
        } else {
            $(this).addClass("selected");
            $("#btnNuevo").removeClass("oculto");
        }
    });
    $("#pnlInfoConcepto").on("click", function(event) {
        event.preventDefault();
        var panelinfo = this;
        $("#pnlDatosFiltro").fadeIn(400, function() {
            var tipofiltro = "";
            var titulofiltro = "";
            tipofiltro = panelinfo.getAttribute("data-tipofiltro");
            titulofiltro = panelinfo.getAttribute("data-hint");
            paginaFiltro = 1;
            if (tipofiltro == "concepto") {
                ListarConcepto("1");
            }
            this.setAttribute("data-tipofiltro", tipofiltro);
            $("#txtTituloFiltro").text(titulofiltro);
        });
    });
    $("#gvFiltro").on("click", ".dato", function(event) {
        event.preventDefault();
        var pnlDatosFiltro;
        var idproyecto = "0";
        var nombre = "";
        var tipofiltro = "";
        pnlDatosFiltro = document.getElementById("pnlDatosFiltro");
        tipofiltro = pnlDatosFiltro.getAttribute("data-tipofiltro");
        if (tipofiltro == "concepto") {
            idconcepto = this.getAttribute("data-idconcepto");
            nombre = this.getAttribute("data-nombre");
            setConcepto(idconcepto, nombre);
        }
    });
    $("#btnEstadoCuenta").on("click", function(event) {
        event.preventDefault();
        openModalCallBack("#modalEstadoCuenta", function() {
            paginaPropietario = 1;
            ListarPropietario("propietario", "1");
        });
    });
    $("#btnNuevo").on("click", function(event) {
        event.preventDefault();
        LimpiarForm();
        var itemsDetalle = $("#tableFacturacion tbody tr.selected");
        var preTotalPagar = 0;
        var countdata = itemsDetalle.length;
        if (countdata > 0) {
            itemsDetalle.each(function(index, el) {
                preTotalPagar += Number(this.getAttribute("data-importefacturado"));
            });
        }
        $("#txtImporteCobranza").val(preTotalPagar.toFixed(2));
        openCustomModal("#modalCobranza");
    });
    $("#modalEstadoCuenta > .modal-example-header").on("click", "button", function(event) {
        var targedId = "";
        targedId = this.getAttribute("data-target");
        $(this).siblings(".success").removeClass("success");
        $(this).addClass("success");
        paginaPropietario = 1;
        ListarPropietario(targedId, "1");
    });
    $("#gvPropietario > .items-area").on("scroll", function() {
        var paginaActual = 0;
        var buttonSuccess = $("#modalEstadoCuenta > .modal-example-header button.success");
        var targedId = buttonSuccess.attr("data-target");
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            paginaActual = Number($("#hdPagePropietario").val());
            ListarPropietario(targedId, paginaActual);
        }
    });
    $("#gvPropietario").on("click", ".dato", function(event) {
        event.preventDefault();
        $(this).siblings(".selected").removeClass("selected");
        $(this).addClass("selected");
        ListarResumenCtaCorriente();
        ListarDetalleCtaCorriente();
    });
    $("#btnGuardar").on("click", function(event) {
        event.preventDefault();
        Registrar();
    });
    $("#btnHideFiltro").on("click", function(event) {
        event.preventDefault();
        $("#pnlDatosFiltro").fadeOut(400, function() {});
    });
    $("#txtSearchPropietario").keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            $("#btnSearchPropietario").trigger("click");
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) return false;
    });
    $("#btnSearchPropietario").on("click", function(event) {
        event.preventDefault();
        var buttonSuccess = $("#modalEstadoCuenta > .modal-example-header button.success");
        var targedId = buttonSuccess.attr("data-target");
        paginaPropietario = 1;
        ListarPropietario(targedId, "1");
    });
    $("#ddlBanco").on("change", function(event) {
        event.preventDefault();
        ListarCuentaBancaria();
    });
    $(".droping-air").on({
        dragenter: function(event) {
            event.stopPropagation();
            event.preventDefault();
        },
        dragover: function(event) {
            event.stopPropagation();
            event.preventDefault();
        },
        change: function(event) {
            event.preventDefault();
            prepareImport(this.files);
        },
        drop: function(event) {
            event.preventDefault();
            var files = event.originalEvent.dataTransfer.files;
            prepareImport(files);
        }
    }, ".file-import");
    $(".droping-air .cancel").on("click", function(event) {
        event.preventDefault();
        cancelImport();
    });
    $("#tableFacturacion tbody").on("click", "a", function(event) {
        event.preventDefault();
        VerImpresion(this);
        return false;
    });
    $("#btnHideImpresion").on("click", function(event) {
        event.preventDefault();
        $("#pnlImpresionFactura").fadeOut(400);
    });
});

var paginaProyecto = 1;

var paginaGenFacturacion = 1;

var paginaPropietario = 1;

var arrMeses = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];

var o = {
    38: "up",
    40: "bottom",
    37: "prev",
    39: "next"
};

var $card;

var fileValue = false;

function IniciarForm() {
    //ListarCuentaBancaria();
    // RegistroPorDefecto();
    var idproyecto = getParameterByName("idproyecto");
    // var anho = getParameterByName('anho');
    // var mes = getParameterByName('mes');
    $("#hdIdProyecto").val(idproyecto);
    // $('#hdAnho').val(anho);
    // $('#hdMes').val(mes);
    // RegistroPorDefectoId(idproyecto);
    // paginaGenFacturacion = 1;
    // ListarPropiedades('1');
    // ListarCobranza();
    var today = new Date();
    var yyyy = today.getFullYear();
    ListarAnhoProceso(yyyy);
}

function LimpiarForm() {
    cancelImport();
    setConcepto("0", "Conceptos");
    $("#txtNroOperacion").val("");
    $("#txtImporteCobranza").val("0.00");
}

function prepareImport(files) {
    var allowedTypes = [ "jpg", "png", "gif", "jpeg" ];
    var extension = "";
    var filename = "";
    var oFReader = new FileReader();
    fileValue = files[0];
    filename = files[0].name;
    extension = filename.split(".").pop().toLowerCase();
    if ($.inArray(extension, allowedTypes) == -1) {
        MessageBox("Archivo no v&aacute;lido", "El tipo de archivo *." + extension + " no es compatible", "[Aceptar]", function() {});
        return false;
    }
    oFReader.readAsDataURL(fileValue);
    console.log(fileValue);
    oFReader.onload = function(oFREvent) {
        $(".droping-air .help").text(filename);
        $(".droping-air").addClass("dropped");
        $(".droping-air > .icon").css("background", "url(" + oFREvent.target.result + ") no-repeat center");
        $(".droping-air > .cancel").removeClass("oculto");
    };
}

function cancelImport() {
    $("#fileImagen").val("");
    $(".droping-air .help").text("Seleccione o arrastre un archivo de imagen (*.jpg, .gif, *.png)");
    $(".droping-air").removeClass("dropped");
    $(".droping-air > .icon").css("background", "transparent");
    $(".droping-air > .cancel").addClass("oculto");
    $("#hdFoto").val("no-set");
    fileValue = false;
}

function ShowPanelProyecto() {
    $("#pnlProyecto").fadeIn(400, function() {
        paginaProyecto = 1;
        $("#hdPageProyecto").val("1");
        ListarProyectos("1");
    });
}

function RegistroPorDefecto() {
    $.ajax({
        url: "services/condominio/condominio-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipo: "defectoporcuenta"
        },
        success: function(data) {
            var countdata = 0;
            var idproyecto = "0";
            var descripcion = "";
            var idbanco = "";
            var nombrebanco = "";
            var idcuentabancaria = "";
            var descripcioncuenta = "";
            countdata = data.length;
            if (countdata > 0) {
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto;
                idbanco = data[0].idbanco;
                nombrebanco = data[0].nombrebanco;
                idcuentabancaria = data[0].idcuentabancaria;
                descripcioncuenta = data[0].descripcioncuenta;
                $("#ddlMes").val(data[0].mesproceso);
                setProyecto(idproyecto, descripcion, idbanco, nombrebanco, idcuentabancaria, descripcioncuenta);
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function RegistroPorDefectoId(idproyecto) {
    $.ajax({
        url: "services/condominio/condominio-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipo: "defectoporcuenta",
            tipobusqueda: idproyecto
        },
        success: function(data) {
            var countdata = 0;
            var idproyecto = "0";
            var descripcion = "";
            var idbanco = "";
            var nombrebanco = "";
            var idcuentabancaria = "";
            var descripcioncuenta = "";
            countdata = data.length;
            if (countdata > 0) {
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto;
                idbanco = data[0].idbanco;
                nombrebanco = data[0].nombrebanco;
                idcuentabancaria = data[0].idcuentabancaria;
                descripcioncuenta = data[0].descripcioncuenta;
                $("#ddlMes").val(data[0].mesproceso);
                setProyecto(idproyecto, descripcion, idbanco, nombrebanco, idcuentabancaria, descripcioncuenta);
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function setProyecto(idproyecto, nombre, idbanco, nombrebanco, idcuentabancaria, descripcioncuenta) {
    $("#hdIdProyecto").val(idproyecto);
    $("#pnlInfoProyecto").attr("data-idproyecto", idproyecto);
    $("#pnlInfoProyecto .info .descripcion").text(nombre);
    $("#hdIdBanco").val(idbanco);
    $("#hdIdCuentaBancaria").val(idcuentabancaria);
    $("#lblBanco").text(nombrebanco);
    $("#lblCuentaBancaria").text(descripcioncuenta);
    $("#pnlProyecto").fadeOut("400", function() {
        var today = new Date();
        var yyyy = today.getFullYear();
        ListarAnhoProceso(yyyy);
    });
}

function setConcepto(idconcepto, nombre) {
    $("#hdIdConcepto").val(idconcepto);
    $("#pnlInfoConcepto").attr("data-idconcepto", idconcepto);
    $("#pnlInfoConcepto .info .descripcion").text(nombre);
    $("#pnlDatosFiltro").fadeOut("400", function() {});
}

function ListarProyectos(pagina) {
    var selector = "#gvProyecto .items-area";
    precargaExp("#gvProyecto", true);
    $.ajax({
        type: "GET",
        url: "services/condominio/condominio-search.php",
        cache: false,
        dataType: "json",
        data: "tipo=asignacionporcuenta&criterio=" + $("#txtSearchFiltro").val() + "&pagina=" + pagina,
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    iditem = data[i].idproyecto;
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-nombre="' + data[i].nombreproyecto + '" data-mes="' + data[i].mesproceso + '" data-anho="' + data[i].anhoproceso + '" data-idbanco="' + data[i].idbanco + '" data-nombrebanco="' + data[i].nombrebanco + '"  data-idcuentabancaria="' + data[i].idcuentabancaria + '" data-descripcioncuenta="' + data[i].descripcioncuenta + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + "</span></p>";
                    strhtml += "</main></div></div>";
                    strhtml += "</a>";
                    ++i;
                }
                paginaProyecto = paginaProyecto + 1;
                $("#hdPageProyecto").val(paginaProyecto);
                if (pagina == "1") $(selector).html(strhtml); else $(selector).append(strhtml);
            } else {
                if (pagina == "1") {
                    $(selector).html("<h2>No hay datos.</h2>");
                }
            }
            precargaExp("#gvProyecto", false);
        }
    });
}

function ListarAnhoProceso(anhodefault) {
    $.ajax({
        url: "services/proceso/proceso-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "ANHO",
            idproyecto: $("#hdIdProyecto").val()
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            var selected = "";
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    if (anhodefault == data[i].per_ano) {
                        selected = ' selected="selected"';
                    } else {
                        selected = "";
                    }
                    strhtml += "<option" + selected + ' value="' + data[i].per_ano + '">' + data[i].per_ano + "</option>";
                    ++i;
                }
                $("#btnEstadoCuenta").removeClass("oculto");
            } else {
                strhtml += '<option value="0">NO HAY PROCESOS RELACIONADOS CON EL PROYECTO SELECCIONADO</option>';
                $("#btnEstadoCuenta").addClass("oculto");
            }
            $("#ddlAnho").html(strhtml);
            paginaGenFacturacion = 1;
            ListarPropiedades("1");
            ListarCobranza();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function VerImpresion(item) {
    $("#pnlImpresionFactura").fadeIn(400, function() {
        var data = new FormData();
        precargaExp("#pnlImpresionFactura", true);
        data.append("btnGenerarPDF", "btnGenerarPDF");
        data.append("tipoGen", "EXPORTACION");
        data.append("ddlAnho", item.getAttribute("data-anho"));
        data.append("ddlMes", item.getAttribute("data-mes"));
        data.append("hdIdFacturacion", item.getAttribute("data-idfacturacion"));
        data.append("hdIdProyecto", $("#hdIdProyecto").val());
        data.append("hdIdPropietario", item.getAttribute("data-idpropietario"));
        data.append("hdIdPropiedad", $("#hdIdPropiedad").val());
        data.append("txtCodigo", item.getAttribute("data-codigo"));
        data.append("txtFechaEmision", item.getAttribute("data-fechaemision"));
        data.append("txtFechaVencimiento", item.getAttribute("data-fechavencimiento"));
        data.append("txtFechaTope", item.getAttribute("data-fechatope"));
        data.append("txtRatio", item.getAttribute("data-ratio"));
        data.append("txtSimboloMoneda", item.getAttribute("data-simbolomoneda"));
        data.append("txtTotalImporte", item.getAttribute("data-importefacturado"));
        $.ajax({
            url: "services/facturacion/facturacion-post.php",
            type: "POST",
            dataType: "json",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                precargaExp("#pnlImpresionFactura", false);
                $("#ifrImpresionFactura").attr("src", item.getAttribute("href"));
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
}

function ListarFacturacion(idpropiedad) {
    var selector = "#tableFacturacion";
    precargaExp(selector, true);
    $.ajax({
        url: "services/facturacion/facturacion-search.php",
        type: "GET",
        dataType: "json",
        cache: false,
        data: {
            tipo: "FACTURACIONPROP",
            idproyecto: $("#hdIdProyecto").val(),
            anho: $("#ddlAnho").val(),
            idpropiedad: idpropiedad
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            var folder = "";
            countdata = data.length;
            folder = $("#hdIdProyecto").val();
            if (countdata > 0) {
                while (i < countdata) {
                    var _importe = Number(data[i].tm_importefacturado).toFixed(2);
                    strhtml += '<tr data-idfacturacion="' + data[i].tm_idfacturacion + '" data-anho="' + data[i].tm_per_ano + '" data-mes="' + data[i].tm_per_mes + '" data-importefacturado="' + _importe + '">';
                    strhtml += "<td>" + data[i].tm_codigo + "</td>";
                    strhtml += "<td>" + convertDate(data[i].tm_fechavencimiento) + "</td>";
                    strhtml += "<td>" + convertDate(data[i].tm_fechatope) + "</td>";
                    strhtml += "<td>" + arrMeses[parseInt(data[i].tm_per_mes) - 1] + "</td>";
                    strhtml += "<td>" + data[i].tm_per_ano + "</td>";
                    strhtml += "<td>" + data[i].simbolomoneda + "</td>";
                    strhtml += '<td class="importe">' + _importe + "</td>";
                    strhtml += '<td><a data-idfacturacion="' + data[i].tm_idfacturacion + '" data-idpropietario="' + data[i].idpropietario + '" data-codigo="' + data[i].tm_codigo + '" data-anho="' + data[i].tm_per_ano + '" data-mes="' + data[i].tm_per_mes + '" data-simbolomoneda="' + data[i].simbolomoneda + '" data-fechaemision="' + convertDate(data[i].tm_fechaemision) + '" data-fechavencimiento="' + convertDate(data[i].tm_fechavencimiento) + '" data-fechatope="' + convertDate(data[i].tm_fechatope) + '" data-ratio="' + data[i].tm_ratio + '" data-importefacturado="' + _importe + '" href="media/pdf/' + folder + data[i].tm_per_ano + data[i].tm_per_mes + "/" + data[i].tm_idfacturacion + '.pdf" class="fg-dark"><i class="icon-search"></i></a>' + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
                $(selector + " tbody").html(strhtml);
            } else {
                $(selector + " tbody").html("");
                $("#btnNuevo").addClass("oculto");
            }
            precargaExp(selector, false);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function ListarPropiedades(pagina) {
    var selector = "#gvGenFacturacion .items-area";
    precargaExp("#gvGenFacturacion", true);
    $.ajax({
        type: "GET",
        url: "services/propiedad/propiedad-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "propfacturacion",
            codigoproyecto: $("#hdIdProyecto").val(),
            anho: $("#ddlAnho").val(),
            meses: 0,
            idpropietario: $("#hdIdPersona").val(),
            idtipopropiedad: $("#ddlTipoPropiedadFiltro").val(),
            criterio: $("#txtSearchPropiedad").val(),
            pagina: pagina
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            var colortile = "";
            var idtipopropiedad = "";
            var nombrepropietario = "";
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    iditem = data[i].idpropiedad;
                    idtipopropiedad = data[i].idtipopropiedad;
                    if (data[i].descrippersona != null) {
                        nombrepropietario = data[i].descrippersona.trim().length == 0 ? "(EN BLANCO)" : data[i].descrippersona;
                    } else {
                        nombrepropietario = "(EN BLANCO)";
                    }
                    if (idtipopropiedad == "DPT") colortile = "bg-teal"; else if (idtipopropiedad == "DEP") colortile = "bg-blueGrey"; else if (idtipopropiedad == "EST") colortile = "bg-indigo";
                    strhtml += '<div class="tile dato double bg-gray-glass ' + colortile + '" ';
                    strhtml += 'data-idpropiedad="' + iditem + '" ';
                    strhtml += 'data-idtipopropiedad="' + idtipopropiedad + '" ';
                    strhtml += 'data-descripcion="' + data[i].descripcionpropiedad + '" ';
                    strhtml += 'data-area="' + data[i].area + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="blue-text">' + data[i].descripcionpropiedad + "</h2>";
                    strhtml += '<h6 class="padding5 text-ellipsis smaller bg-white text-center fg-dark">' + nombrepropietario + "</h6>";
                    strhtml += "</div></div>";
                    strhtml += '<div class="brand"><span class="badge bg-dark">Area: ' + data[i].area + " (m<sup>2</sup>)</span></div>";
                    strhtml += "</div>";
                    strhtml += "</div>";
                    ++i;
                }
                if (pagina == "1") {
                    elemindex = 0;
                    $(selector).html(strhtml);
                } else {
                    elemindex = $("#gvGenFacturacion .dato").length;
                    $(selector).append(strhtml);
                }
                $(selector).find(".dato").eq(elemindex).trigger("click");
                paginaGenFacturacion = paginaGenFacturacion + 1;
                $("#hdPageGenFacturacion").val(paginaGenFacturacion);
                $card = $("#gvGenFacturacion .dato");
            } else {
                if (pagina == 1) {
                    $(selector).html("<h2>No se encontraron resultados.</h2>");
                }
            }
            precargaExp("#gvGenFacturacion", false);
        }
    });
}

function ListarConcepto(pagina) {
    var selectorgrid = "#gvFiltro";
    var selector = selectorgrid + " .items-area";
    var tipobusqueda = "";
    var criterio = "";
    precargaExp(selectorgrid, true);
    $.ajax({
        url: "services/concepto/concepto-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "3",
            id: "0",
            criterio: $("#txtSearchFiltro").val(),
            tipoconcepto: "05",
            idproyecto: $("#hdIdProyecto").val(),
            pagina: pagina
        }
    }).done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = "";
        var iditem = "0";
        countdata = data.length;
        if (countdata > 0) {
            while (i < countdata) {
                iditem = data[i].tm_idconcepto;
                strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idconcepto="' + iditem + '" data-nombre="' + data[i].tm_descripcionconcepto + '" data-formula="' + data[i].tm_definicion_formula + '" data-tipovalor="concepto">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                strhtml += '<div class="list-content pos-rel">';
                strhtml += '<div class="data">';
                strhtml += '<main><p class="fg-white"><span class="codigo float-left">' + data[i].tm_idconcepto + ' -&nbsp;</span><span class="descripcion float-left">' + data[i].tm_descripcionconcepto + "</span></p>";
                strhtml += "</main></div></div>";
                if (data[i].tm_esformula == "1") strhtml += '<span class="place-top-right bg-emerald margin10"><h5 class="fg-white padding10 no-margin text-center"><i class="icon-calculate"></i></h5></span>';
                strhtml += '<div class="place-bottom-left fg-white">';
                strhtml += '<div class="tag-descrip bg-darkTeal">TIPO: ' + data[i].nomtipoconcepto + "</div>";
                strhtml += '<div class="tag-descrip bg-emerald">TIPO VALOR: ' + data[i].nomtipovalor + "</div>";
                strhtml += "</div>";
                strhtml += "</a>";
                ++i;
            }
            paginaFiltro = paginaFiltro + 1;
            $("#hdPage").val(paginaFiltro);
            if (pagina == "1") $(selector).html(strhtml); else $(selector).append(strhtml);
        } else {
            if (pagina == "1") {
                $(selector).html("<h2>No hay datos.</h2>");
            }
        }
        precargaExp(selectorgrid, false);
    }).fail(function() {
        console.log("error");
    }).always(function() {
        console.log("complete");
    });
}

function ListarCuentaBancaria() {
    $.ajax({
        url: "services/cuentabancaria/cuentabancaria-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "3",
            id: $("#ddlBanco").val(),
            idproyecto: $("#hdIdProyecto").val()
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<option value="' + data[i].tm_idcuentabancaria + '">' + data[i].tm_descripcioncuenta + "</option>";
                    ++i;
                }
            } else {
                strhtml = '<option value="0">No hay cuentas bancarias</option>';
            }
            $("#ddlCuentaBancaria").html(strhtml);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function ListarCobranza() {
    precargaExp("#tableCobranza", true);
    $.ajax({
        url: "services/cobranza/cobranza-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipo: "COBRANZAS",
            tipobusqueda: "1",
            idproyecto: $("#hdIdProyecto").val(),
            anho: $("#ddlAnho").val()
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            precargaExp("#tableCobranza", false);
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<tr data-idconceptocobranza="' + data[i].td_idconsumoescalonable + '">';
                    strhtml += "<td>" + data[i].tipooperacion + "</td>";
                    strhtml += "<td>" + data[i].nombrebanco + "</td>";
                    strhtml += "<td>" + data[i].descripcioncuenta + "</td>";
                    strhtml += "<td>" + data[i].td_num_operacion + "</td>";
                    strhtml += '<td class="consumo">' + data[i].td_valorconcepto + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
                $("#btnSelectAll").removeClass("oculto");
            } else {
                $("#btnSelectAll").addClass("oculto");
            }
            $("#tableCobranza tbody").html(strhtml);
            ajustarColumnas("#tableCobranza");
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function Registrar() {
    var data = new FormData();
    var i = 0;
    // var tableFacturacion;
    var listDetalle = [];
    var detalleFacturas = "";
    precargaExp("#modalCobranza", true);
    var itemsDetalle = $("#tableFacturacion tbody tr.selected");
    var input_data = $("#modalCobranza :input").serializeArray();
    var countdata = itemsDetalle.length;
    if (countdata > 0) {
        itemsDetalle.each(function(index, el) {
            listDetalle.push({
                idfacturacion: this.getAttribute("data-idfacturacion"),
                anho: this.getAttribute("data-anho"),
                mes: this.getAttribute("data-mes")
            });
        });
        detalleFacturas = JSON.stringify(listDetalle);
    }
    data.append("btnGuardar", "btnGuardar");
    data.append("hdIdProyecto", $("#hdIdProyecto").val());
    data.append("ddlAnho", $("#ddlAnho").val());
    data.append("ddlMes", $("#ddlMes").val());
    data.append("hdFoto", $("#hdFoto").val());
    data.append("detalleFacturas", detalleFacturas);
    data.append("archivo", fileValue);
    $.each(input_data, function(key, fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        url: "services/cobranza/cobranza-post.php",
        type: "POST",
        dataType: "json",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            precargaExp("#modalCobranza", false);
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function() {
                if (data.rpta != "0") {
                    closeCustomModal("#modalCobranza");
                    $("#btnNuevo").addClass("oculto");
                    // paginaGenFacturacion = 1;
                    // ListarPropiedades('1');
                    $("#gvGenFacturacion .selected").trigger("click");
                    ListarCobranza();
                }
            });
        },
        complete: function(data) {
            listDetalle = [];
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function ListarPropietario(targedId, pagina) {
    var selectorgrid = "#gvPropietario";
    var selector = "";
    var url = "";
    if (targedId == "propietario") {
        url = "services/propietario/propietario-search.php";
    } else if (targedId == "inquilino") {
        url = "services/inquilino/inquilino-search.php";
    }
    selector = selectorgrid + " .items-area";
    precargaExp(selector, true);
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dataType: "json",
        data: "criterio=" + $("#txtSearchPropietario").val() + "&pagina=" + pagina,
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            var iditem = "0";
            if (countdata > 0) {
                while (i < countdata) {
                    if (targedId == "propietario") {
                        iditem = data[i].tm_idtipopropietario;
                    } else {
                        iditem = data[i].tm_idtipoinquilino;
                    }
                    foto = data[i].tm_foto;
                    strhtml += '<a href="#" class="list dato bg-gray-glass bg-cyan" data-idpropietario="' + iditem + '" data-tipopropietario="' + data[i].tm_iditc + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += "<aside>";
                    if (foto == "no-set") strhtml += '<i class="fa fa-user"></i>'; else strhtml += '<img src="' + foto + '" />';
                    strhtml += "</aside>";
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].descripcion + '</span></p><p class="fg-white">Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].tipodoc + ": " + data[i].tm_numerodoc + "</span> - Email: " + data[i].tm_email + "</p>";
                    strhtml += "</main>";
                    strhtml += "</div></div>";
                    strhtml += "</a>";
                    ++i;
                }
                paginaPropietario = paginaPropietario + 1;
                $("#hdPagePropietario").val(paginaPropietario);
                if (pagina == "1") {
                    $(selector).html(strhtml).find(".dato").eq(0).trigger("click");
                } else $(selector).append(strhtml);
            } else {
                if (pagina == "1") {
                    $(selector).html("<h2>No hay datos.</h2>");
                }
            }
            precargaExp(selector, false);
        }
    });
}

function ListarResumenCtaCorriente() {
    var propietario;
    var idproyecto = "0";
    var idpropietario = "0";
    precargaExp("#tableMaestroCuenta", true);
    propietario = $("#gvPropietario .dato.selected");
    idproyecto = document.getElementById("hdIdProyecto").value;
    idpropietario = propietario[0].getAttribute("data-idpropietario");
    $.ajax({
        type: "GET",
        url: "services/cuentacorriente/cuentacorriente-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "2",
            idproyecto: idproyecto,
            idpropietario: idpropietario
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            precargaExp("#tableMaestroCuenta", false);
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<tr data-idmoneda="' + data[i].tm_idmoneda + '">';
                    strhtml += '<td class="text-right">' + data[i].tm_facturado + "</td>";
                    strhtml += '<td class="text-right">' + data[i].tm_cancelado + "</td>";
                    strhtml += '<td class="text-right">' + data[i].tm_saldo + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $("#tableMaestroCuenta tbody").html(strhtml);
        }
    });
}

function ListarDetalleCtaCorriente() {
    var propietario;
    var idproyecto = "0";
    var idpropietario = "0";
    var anho = "0";
    precargaExp("#tableDetalleCuenta", true);
    propietario = $("#gvPropietario .dato.selected");
    idpropietario = propietario[0].getAttribute("data-idpropietario");
    idproyecto = document.getElementById("hdIdProyecto").value;
    anho = $("#hdAnho").val();
    $.ajax({
        type: "GET",
        url: "services/cuentacorriente/cuentacorriente-search.php",
        cache: false,
        dataType: "json",
        data: {
            idpropietario: idpropietario,
            idproyecto: idproyecto,
            anho: anho
        },
        success: function(data) {
            var i = 0;
            var countdata = 0;
            var strhtml = "";
            precargaExp("#tableDetalleCuenta", false);
            countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<tr data-iddtalle="' + data[i].td_idcuentacorriente + '" data-nromes="' + data[i].tm_per_mes + '">';
                    strhtml += "<td>" + data[i].tm_descripcionpropiedad + "</td>";
                    strhtml += "<td>" + data[i].nombremes + "</td>";
                    strhtml += '<td><input type="text" class="facturado inputTextInTable text-right" value="' + data[i].td_importefacturado + '" /></td>';
                    strhtml += '<td><input type="text" class="pagado inputTextInTable text-right" value="' + data[i].td_importepagado + '" /></td>';
                    strhtml += '<td><input type="text" class="saldo inputTextInTable text-right" value="' + data[i].td_importesaldo + '" /></td>';
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $("#tableDetalleCuenta tbody").html(strhtml);
            $("#tableDetalleCuenta .ibody table").enableCellNavigation();
        }
    });
}