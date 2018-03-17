$(window).load(function () {
	ajustarColumnas('#tableResumenProyecto');
	ajustarColumnas('#tableResumenPropietario');
});

$(function () {
	RegistroPorDefecto();

	$('#pnlFiltroProyecto').on('click', function(event) {
        event.preventDefault();
        ShowPanelProyecto();
    });

    $('#btnHideProyecto').on('click', function(event) {
        event.preventDefault();
        $('#pnlProyecto').fadeOut(400, function() {
            
        });
    });

    $('#gvProyecto > .items-area').on('scroll', function(){
        var paginaActual = 0;

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            paginaActual = Number($('#hdPageProyecto').val());

            ListarProyectos(paginaActual);
        };
    });

    $('#gvProyecto .items-area').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var idproyecto = '0';
        var nombre = '';

        idproyecto = this.getAttribute('data-idproyecto');
        nombre = this.getAttribute('data-nombre');

        setProyecto(idproyecto, nombre);
    });

    $('#btnBuscar').on('click', function(event) {
    	event.preventDefault();
    	verDatos();
    });
});

function verDatos () {
	var data = new FormData();

	data.append('hdIdProyecto', $('#hdIdProyecto').val());
	data.append('ddlAnhoIni', $('#ddlAnhoIni').val());
	data.append('ddlMesIni', $('#ddlMesIni').val());
	data.append('ddlAnhoFin', $('#ddlAnhoFin').val());
	data.append('ddlMesFin', $('#ddlMesFin').val());
	
	$.ajax({
		url: 'services/reporteria/estadocuenta-post.php',
		type: 'POST',
		dataType: 'json',
		data: data,
		cache: false,
        contentType:false,
        processData: false,
		success: function (data) {
			$('#tableResumenProyecto thead tr').html(data.strcolumnasProyecto);
			$('#tableResumenProyecto tbody').html(data.strfilasProyecto);

			$('#tableResumenPropietario thead tr').html(data.strcolumnasPropietario);
			$('#tableResumenPropietario tbody').html(data.strfilasPropietario);
		},
		error: function (data) {
			console.log(data);
		}
	});
}

function ShowPanelProyecto() {
    $('#pnlProyecto').fadeIn(400, function () {
        paginaProyecto = 1;
        $('#hdPageProyecto').val('1');
        ListarProyectos('1');
    });
}

function RegistroPorDefecto () {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {tipo: 'defecto-sinproceso'},
        success: function (data) {
            var countdata = 0;
            var idproyecto = '0';
            var descripcion = '';

            countdata = data.length;

            if (countdata > 0){
                idproyecto = data[0].idproyecto;
                descripcion = data[0].nombreproyecto;

                setProyecto(idproyecto, descripcion);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function setProyecto (idproyecto, nombre) {
    $('#hdIdProyecto').val(idproyecto);

    $('#pnlFiltroProyecto').attr('data-idproyecto', idproyecto);
    $('#pnlFiltroProyecto .info .descripcion').text(nombre);

    $('#pnlProyecto').fadeOut('400', function() {
        var today = new Date();
        var yyyy = today.getFullYear();
        
        //paginaPropiedad = 1;

        ListarAnhoProceso(yyyy);
    });
}

function ListarProyectos (pagina) {
    var selector = '#gvProyecto .items-area';

    precargaExp('#gvProyecto', true);

    $.ajax({
        type: "GET",
        url: "services/condominio/condominio-search.php",
        cache: false,
        dataType: 'json',
        data: "tipo=1&criterio=" + $('#txtSearchProyecto').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].idproyecto;
                    strhtml += '<a href="#" class="list dato without-foto bg-gray-glass bg-cyan g200" data-idproyecto="' + iditem + '" data-tipoproyecto="' + data[i].tipoproyecto + '" data-nombre="' + data[i].nombreproyecto + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content pos-rel">';
                    strhtml += '<div class="data">';
                    strhtml += '<main><p class="fg-white"><span class="descripcion">' + data[i].nombreproyecto + '</span></p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                };

                paginaProyecto = paginaProyecto + 1;

                $('#hdPageProyecto').val(paginaProyecto);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No hay datos.</h2>');
                };
            };
            
            precargaExp('#gvProyecto', false);
        }
    });
}

function ListarAnhoProceso (anhodefault) {
    $.ajax({
        url: 'services/proceso/proceso-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'ANHO',
            idproyecto: $('#hdIdProyecto').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selected = '';
            
            countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    if (anhodefault == data[i].per_ano) {
                        selected = ' selected="selected"';
                    }
                    else {
                        selected = '';
                    };

                    strhtml += '<option' + selected + ' value="' + data[i].per_ano + '">' + data[i].per_ano + '</option>';
                    ++i;
                };
            }
            else {
                strhtml += '<option value="0">NO HAY PROCESOS RELACIONADOS CON EL PROYECTO SELECCIONADO</option>';
            };

            $('#ddlAnhoIni').html(strhtml);
            $('#ddlAnhoFin').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
