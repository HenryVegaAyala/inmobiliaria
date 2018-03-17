// JavaScript Document
var isCtrl = false;
(function (jQuery) {
    jQuery.fn.clickoutside = function (callback) {
        var outside = 1, self = $(this);
        self.cb = callback;
        this.click(function () {
            outside = 0;
        });
        $(document).click(function () {
            outside && self.cb();
            outside = 1;
        });
        return $(this);
    }
})(jQuery);

(function ($) {
    $.fn.zIndex = function( zIndex ) {
        if ( zIndex !== undefined ) {
            return this.css( "zIndex", zIndex );
        };

        if ( this.length ) {
            var elem = $( this[ 0 ] ), position, value;
            while ( elem.length && elem[ 0 ] !== document ) {
                // Ignore z-index if position is set to a value where z-index is ignored by the browser
                // This makes behavior of this function consistent across browsers
                // WebKit always returns auto if the element is positioned
                position = elem.css( "position" );
                if ( position === "absolute" || position === "relative" || position === "fixed" ) {
                    // IE returns 0 when zIndex is not specified
                    // other browsers return a string
                    // we ignore the case of nested elements with an explicit value of 0
                    // <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
                    value = parseInt( elem.css( "zIndex" ), 10 );
                    if ( !isNaN( value ) && value !== 0 ) {
                        return value;
                    }
                }
                elem = elem.parent();
            };
        };

        return this;
    };
}(jQuery));

(function ($) {
   $.fn.liveDraggable = function (opts, sub) {
      this.on("mouseover", sub, function() {
         if (!$(this).data("init")) {
            $(this).data("init", true).draggable(opts);
         }
      });
      return this;
   };
}(jQuery));

var getParentsUntil = function (elem, parent, selector) {
    var parents = [];
    if ( parent ) {
        var parentType = parent.charAt(0);
    }
    if ( selector ) {
        var selectorType = selector.charAt(0);
    }

    // Get matches
    for ( ; elem && elem !== document; elem = elem.parentNode ) {

        // Check if parent has been reached
        if ( parent ) {
            // If parent is a class
            if ( parentType === '.' ) {

                if ( elem.classList.contains( parent.substr(1) ) ) {
                    break;
                }
            }

            // If parent is an ID
            if ( parentType === '#' ) {
                if ( elem.id === parent.substr(1) ) {
                    break;
                }
            }

            // If parent is a data attribute
            if ( parentType === '[' ) {
                if ( elem.hasAttribute( parent.substr(1, parent.length - 1) ) ) {
                    break;
                }
            }

            // If parent is a tag
            if ( elem.tagName.toLowerCase() === parent ) {
                break;
            }

        }

        if ( selector ) {

            // If selector is a class
            if ( selectorType === '.' ) {
                if ( elem.classList.contains( selector.substr(1) ) ) {
                    parents.push( elem );
                }
            }

            // If selector is an ID
            if ( selectorType === '#' ) {
                if ( elem.id === selector.substr(1) ) {
                    parents.push( elem );
                }
            }

            // If selector is a data attribute
            if ( selectorType === '[' ) {
                if ( elem.hasAttribute( selector.substr(1, selector.length - 1) ) ) {
                    parents.push( elem );
                }
            }

            // If selector is a tag
            if ( elem.tagName.toLowerCase() === selector ) {
                parents.push( elem );
            }

        } else {
            parents.push( elem );
        }

    }

    // Return parents if any exist
    if ( parents.length === 0 ) {

        return null;
    } else {
        return parents;
    }
};

function precargaExp(capa, bloqueo) {
    if (bloqueo){
        //$(capa).append('<div class="modal-preload"><div class="modal-preload-content"><div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div></div></div>');
        $(capa).append('<div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div>');
    }
    else {
        //$(capa + ' .modal-preload').remove();
        $(capa + ' .preloaderbar').remove();
    };
}

serializa = function(obj, prefix) {
  var str = [];
  for(var p in obj) {
    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
    k = k.replace(/"/g, '');
    str.push(typeof v == "object" ?
      serializa(v, k) :
      encodeURIComponent(k) + "=" + encodeURIComponent(v));
  }
  return str.join("&");
}

function CuadrarColumnasTabla(selector) {
    var rows;
    var rcounter = 0;
    var countrows = 0;

    rows = $('#tableDetalle ihead table tbody tr:last td');

    countorws = rows.length;
}

function customAutoSearcd(typesource, obj, inSelect) {
    $(obj).autocomplete({
        source:function( request, response ) {
            $.getJSON( 'public/generic-search.php', {
                typesource: typesource,
                term: request.term
            }, response );
        }, 
        minLength:2,
        select: inSelect,
        html: true,
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 1000);
        }
    });
}

function setSelectOptions(objSelect, state){
    $(objSelect).find('option').each(function(){
        if (state==true)
            $(this).attr('selected', 'selected');
        else
            $(this).removeAttr('selected');
    });
}

function habilitarLink (selector, flag) {
    if (flag){
        if ($(selector).hasClass('disabled')){
            $(selector).removeClass('disabled').attr("href", $(selector).data("href")).removeAttr("disabled");
        };
    }
    else {
        if (!$(selector).hasClass('disabled')){
            $(selector).addClass('disabled').data("href", $(selector).attr("href")).attr("href", "javascript:void(0)").attr("disabled", "disabled");
        };
    };
}

function habilitarControl(idcontrol, flag) {
    if (flag == true)
        $(idcontrol).removeAttr("disabled").removeClass('disabled');
    else
        $(idcontrol).attr("disabled","-1").addClass('disabled');
}

function enterTextArea(idtextarea, destino){
    $(idtextarea).keyup(function(e) {
        if (e.which == 17) isCtrl = false;
    }).keydown(function(e) {
        if (e.which == 17) isCtrl = true;
        if (e.which == 13 && isCtrl == true) {
            $(destino).focus();
            isCtrl = false;
            return false;
        }
    });
}

function showEditForm(idform){
    $(idform).show();
}

function closeEditForm(idform){
    $(idform).hide();   
    precargaExp(".divload", false);
}

function ConvertMySQLDate (date) {
    var dateOriginal = new String(date);
    var dateConverted = '';
    var year = '';
    var month = '';
    var day = '';
    dateSlash = dateOriginal.split("-");
    year = dateSlash[0];
    month = dateSlash[1];
    dayIncoming = dateSlash[2];
    day = new String(dayIncoming).split(' ');
    day = day[0];
    dateConverted = day + '/' + month + '/' + year;
    return dateConverted;
}

function ConvertMySQLTime (date) {
    var dateOriginal = new String(date);
    var dateConverted = '';
    dateSpace = dateOriginal.split(" ");
    strTime = dateSpace[1];
    
    return strTime;
}

function buscarItem(lista, valor){
    var ind, pos;
    for(ind=0; ind<lista.length; ind++)
    {
        if (lista[ind] == valor)
        break;
    }
    pos = (ind < lista.length)? ind : -1;
    return (pos);
}

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
}

function dialogo(capa, ancho, alto, titulo, redimensionar) {
    var ResZ = false;
    $(capa).removeClass("oculto");
    if (redimensionar == null)
        ResZ = false;
    else
        ResZ = redimensionar;
    $(capa).dialog({
        bgiframe: true,
        draggable: true,
        title: titulo,
        width: ancho,
        height: alto,
        position: 'center',
        modal: true,
        resizable: ResZ,
        hide: 'fade',
        overlay: {
            backgroundColor: '#336699',
            opacity: 0.5
        },
        create: function () {
            $("form").append($("body > .ui-widget-overlay"));
            $("form").append($(capa).parent());
        },
        open: function () {
            $("form").append($("body > .ui-widget-overlay"));
            $("form").append($(capa).parent());
        },
        close: function () {
            $(capa).addClass("oculto");
            $("form").append($(capa).parent());
        }
    });
}

function cargarDatePicker(ctrl, fnSelect) {
    $(ctrl).datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        showMonthAfterYear: false,
        onSelect: fnSelect
    }, $.datepicker.regional['es']);
}

function onlyNumbers (e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function MessageBox (title, message, buttons, callback) {
    $.MetroMessageBox({
        title: title,
        content: message,
        NormalButton: "#232323",
        ActiveButton: "#a20025",
        buttons: buttons
    }, callback);
}

function audioNotif (tipo) {
    var i = document.createElement("audio");
    var pathAudio = '';
    if (tipo == 'BigBox')
        pathAudio = "scripts/metro-alert/sound/bigbox.mp3";
    i.setAttribute("src", pathAudio);
    i.addEventListener("load", function () {
        i.play()
    }, true);
    i.pause();
    i.play();
}

function resetForm (idform) {
    var formulario = document.getElementById(idform);
    $('#hdIdPrimary').val('0');
    formulario.reset();
}

function showErrorsInValidate (errorMap, errorList) {
    $.each(this.validElements(), function (index, element) {
        var $element = $(element);

        $element.data("title", "")
        .removeClass("error state")
        .tooltip("destroy");

        $element.parent('div').removeClass('error-state');
    });

    $.each(errorList, function (index, error) {
        var $element = $(error.element);

        $element.tooltip("destroy")
        .data("title", error.message)
        .addClass("error state")
        .tooltip();

        $element.parent('div').addClass('error-state');
    });
}

function ApplyValidNumbers () {
    $('.only-numbers').numeric(".");
}

function addLeadingZero(num) {
    return ((num < 10) ? "0" + num : "" + num);
}

function GetToday () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd < 10) {
        dd = '0' + dd;
    } 

    if(mm < 10) {
        mm = '0' + mm;
    }

    today = dd + '/' + mm + '/' + yyyy;
    return today;
}

function padZero(num, size) {
    var s = num + '';
    while (s.length < size) s = '0' + s;
    return s;
}

function toggleSlideButton (obj, slideSelector, params) {
    var pathIcon = '';
    var labelButton = '';
    if (!$(obj).hasClass('active')){
        pathIcon = params.icon_deactive;
        labelButton = params.msje_deactive;
        $(obj).addClass('active');
        $(slideSelector).slideDown();
    }
    else {
        pathIcon = params.icon_active;
        labelButton = params.msje_active;
        $(obj).removeClass('active');
        $(slideSelector).slideUp();
    }
    $(obj).find('.content img').attr('src', pathIcon);
    $(obj).find('.content .text').html(labelButton);
}

function toggleSlidePanel(layout, state) {
    if (state == false) {
        if ($(layout).is(':visible')){
            $('.control-app', parent.document).removeClass('oculto');
            $(layout).hide('slide', {'direction':'right'}, 400);
        }
    }
    else {
        if (!$(layout).is(':visible')) {
            $('.control-app', parent.document).addClass('oculto');
            $(layout).show('slide', {'direction':'right'}, 400);
        }
    }
}

function toggleOptions(layout, state) {
    if (state == false) {
        if ($(layout).is(':visible')){
            $(layout).hide('slide', {'direction':'left'}, 400);
        }
    }
    else {
        if (!$(layout).is(':visible')) {
            $(layout).show('slide', {'direction':'left'}, 400);
        }
    }
}

function openModal (idmodal) {
    $(idmodal + '.custombox-modal').css({
        'transition': '600ms',
        '-webkit-transition': '600ms'
    }).addClass('custombox-slit').addClass('custombox-show').after('<div class="modal-example-overlay"></div>');
}

function closeModal (idmodal) {
    $(idmodal + '.custombox-modal').removeClass('custombox-slit').removeClass('custombox-show').removeAttr('style').nextAll('.modal-example-overlay').remove();
}

function openCustomModal (idmodal) {
    var lastZIndex = 0;
    var styleIndex = '';
    
    lastZIndex = $('.modal-example-content:visible').zIndex();

    $(idmodal).fadeIn(300, function() {
    });
    
    if (lastZIndex > 0)
        $(idmodal).zIndex(lastZIndex + 2);
    
    idmodal = idmodal.substring(1, idmodal.length);
    
    if (lastZIndex > 0)
        styleIndex = ' style="z-index: ' + (lastZIndex + 1) + ';"';
    
    $('body').append('<div id="over' + idmodal + '" class="modal-example-overlay"' + styleIndex + '></div>');
}

function closeCustomModal (selector) {
    var idmodal = '';

    if (typeof selector != 'string'){
        var elemDialog = getParentsUntil(selector, 'body', '.modal-example-content');
        idmodal = '#' + elemDialog[0].getAttribute('id');

        console.log(idmodal);
    }
    else
        idmodal = selector;

    $(idmodal).fadeOut(300, function() {
        
    });

    idmodal = idmodal.substring(1, idmodal.length);
    $('#over' + idmodal).remove();
}

function openModalCallBack (idmodal, callback) {
    var lastZIndex = 0;
    var styleIndex = '';
    
    lastZIndex = $('.modal-example-content:visible').zIndex();

    $(idmodal).fadeIn(400, function () {
        callback();
    });

    if (lastZIndex > 0)
        $(idmodal).zIndex(lastZIndex + 2);
    
    idmodal = idmodal.substring(1, idmodal.length);
    
    if (lastZIndex > 0)
        styleIndex = ' style="z-index: ' + (lastZIndex + 1) + ';"';
    
    $('body').append('<div id="over' + idmodal + '" class="modal-example-overlay"' + styleIndex + '></div>');
}

function hideTopCharmOptions() {
    var charmOptions = $("#charmOptions", top.document);
    if (charmOptions.is(':visible'))
        charmOptions.hide('slide', {'direction':'right'}, 300);
}

function mostrarPanel (idpanel, url) {
    var panel = $(idpanel);
    panel.fadeIn(1, function() {
        precargaExp(idpanel, true);
    });
    frame = $('<iframe></iframe>')
                    .attr({
                        "scrolling": "no",
                        "marginwidth" : "0",
                        "marginheight" : "0",
                        "width" : "100%",
                        "height" : "100%",
                        "frameborder" : "no",
                        "src" : url
                    }).load(function(){
                        precargaExp(idpanel, false);
                        $(this).contents().find("body, body *").on('click', function(event) {
                            hideTopCharmOptions();
                        });
                    });
    panel.html('').append(frame);
}

function setSpecialTab (idtab, callback) {
    $(idtab + '.special-tab > .menu').on('click', 'li > a', function(event) {
        var aLink = '';
        event.preventDefault();
        aLink = $(this).attr('href');

        $(idtab + '.special-tab > .menu li a.active').removeClass('active');
        $(this).addClass('active');
        $(idtab + ' > .content > .paneltab').hide();
        $(aLink).fadeIn('400', function() {
            callback();
        });
    }).find('li:first-child a').addClass('active');
}

function habilitarDiv (idlayer, flag) {
    if (flag){
        $(idlayer + ' .panel-bloqueo').fadeOut(300);
        //$(idlayer + ' *:not(.panel-bloqueo)').removeClass('opaco-disabled');
    }
    else {
        $(idlayer + ' .panel-bloqueo').fadeIn(300);
        //$(idlayer + ' *:not(.panel-bloqueo)').addClass('opaco-disabled');
    }
}

function startTime(){
    var today;
    var mesPlus = 0;
    var mes = '';
    var dia = '';
    
    today = new Date();
    mesPlus = today.getMonth() + 1;

    dia = addLeadingZero(today.getDate());
    mes = addLeadingZero(mesPlus);

    h = today.getHours();
    m = today.getMinutes();
    s = today.getSeconds();
    
    m = addLeadingZero(m);
    s = addLeadingZero(s);
    
    document.getElementById('reloj').innerHTML = dia + '/' + mes + '/' + today.getFullYear() + ' ' + h + ':' + m + ':' + s;
    
    t = setTimeout(startTime, 500);
}

function BackToPrevPanel () {
    $('.inner-page:visible').fadeOut(400, function() {
        $(this).prev().fadeIn(400, function() {
            
        });
    });
}
 
function getStyle(el, styleProp) {
  var value, defaultView = (el.ownerDocument || document).defaultView;
  // W3C standard way:
  if (defaultView && defaultView.getComputedStyle) {
    // sanitize property name to css notation
    // (hypen separated words eg. font-Size)
    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
  } else if (el.currentStyle) { // IE
    // sanitize property name to camelCase
    styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
      return letter.toUpperCase();
    });
    value = el.currentStyle[styleProp];
    // convert other units to pixels on IE
    if (/^\d+(em|pt|%|ex)?$/i.test(value)) { 
      return (function(value) {
        var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;
        el.runtimeStyle.left = el.currentStyle.left;
        el.style.left = value || 0;
        value = el.style.pixelLeft + "px";
        el.style.left = oldLeft;
        el.runtimeStyle.left = oldRsLeft;
        return value;
      })(value);
    }
    return value;
  }
}

function ajustarColumnas (iditables) {
    if ($(iditables + ' tbody tr').length > 0){
        $(iditables + ' tbody tr:last td').each(function(index, el) {
            var columnas;
            var countdata = 0;

            columnas = $(iditables + ' thead th');
            countdata = columnas.length;

            if (countdata > 0){
                $(columnas[index]).width($(el).width());
            };
        });

        $(iditables + ' .ihead').height('auto');
        $(iditables + ' .ibody').css('padding-top', $(iditables + ' .ihead').height());
    };
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
   
String.prototype.repeat = function( num )
{
    return new Array( num + 1 ).join( this );
}

function Interval(fn, time) {
    var timer = false;
    this.start = function () {
        if (!this.isRunning())
            timer = setInterval(fn, time);
    };
    this.stop = function () {
        clearInterval(timer);
        timer = false;
    };
    this.isRunning = function () {
        return timer !== false;
    };
}

function ListarUbicacion (selector, idubigeopadre, defaultvalue, callback) {
    $.ajax({
        url: 'services/ubigeo/ubigeo-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda : '3',
            id: idubigeopadre
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selected = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    if (defaultvalue != '0'){
                        selected = defaultvalue == data[i].tm_idubigeo ? ' selected="selected"' : '';
                    };

                    strhtml += '<option value="' + data[i].tm_idubigeo + '" data-referencia="' + data[i].tm_idubigeoref + '" ' + selected + '>' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else {
                strhtml = '<option value="0" data-referencia="0">No hay ubicaciones relacionadas</option>';
            };

            $(selector).html(strhtml);
            callback();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function RedondeoMagico (numero) {
    var resultado = numero;
    var str_numero = numero.toString();
    var centesimo = Number(str_numero.substr(str_numero.length - 1));
    var diferencia = (10 - centesimo) / 100;

    // console.log('Numero original: ' + numero);
    // console.log('Centesimo: ' + centesimo);
    // console.log('Diferencia: ' + diferencia);

    resultado = Number(resultado);
    diferencia = Number(diferencia);

    if (centesimo > 0)
        resultado = resultado + diferencia;

    // console.log('Resultado: ' + resultado);

    return resultado;
}

function ProyectoById (idproyecto) {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'defecto',
            tipobusqueda: idproyecto
        },
        success: function (data) {
            var countdata = 0;
            var idproyecto = '0';
            var descripcion = '';

            countdata = data.length;

            if (countdata > 0){
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto + ' | Proceso: ' + arrMeses[parseInt(data[0].mesproceso) - 1] + ' ' + data[0].anhoproceso;

                $('#ddlMes').val(data[0].mesproceso);
                setProyecto ('#pnlInfoProyecto', idproyecto, descripcion);
                setProyecto ('#pnlFiltroProyecto', idproyecto, descripcion);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

$(function () {
    $(document).on('click touchend', '.grouped-buttons > [data-action="more"]', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var parent = $(this).parent();

        if (parent.hasClass('fixed')){
            parent.removeClass('fixed');
        }
        else {
            $('.grouped-buttons.fixed').removeClass('fixed');
            parent.addClass('fixed');
        };
    });

    $(document).on('click touchend', function (event) {
        if (!$(this).is(event.target) && !$(event.target).closest('.dropdown').length) {
            if($('.grouped-buttons.fixed').hasClass('fixed')) {
                $('.grouped-buttons.fixed').removeClass('fixed');
            };

            if($('.dropdown.is-visible').hasClass('is-visible')) {
                $('.dropdown.is-visible').removeClass('is-visible');
            };
        };
    });
});