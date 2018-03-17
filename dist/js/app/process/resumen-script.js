$(function () {
	$('#btnConsultar').on('click', function(event) {
		event.preventDefault();
		MostrarResumen();
	});

    $('#ddlProyecto').on('change', function(event) {
        event.preventDefault();
        var today = new Date();
        var yyyy = today.getFullYear();
        
        var idproyecto = $(this).val();
        
        $('#hdIdProyecto').val(idproyecto);
        
        window.top.idproyecto = idproyecto;

        ListarAnhoProceso(yyyy);
    });

    $('#ddlProyecto').trigger('change');

	$('#ddlAnho').on('click', function(event) {
		event.preventDefault();
		MostrarResumen();
	});

	$('#ddlMes').on('click', function(event) {
		event.preventDefault();
		MostrarResumen();
	});
});

function Resumen_Proyecto () {
	$.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'reporte-resumen',
            tipobusqueda: '1',
            id: $('#hdIdProyecto').val(),
            anho: $('#ddlAnho').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + data[i].mes + '</td>';
                    strhtml += '<td class="text-right">' + Number(data[i].importe_facturado).toFixed(2) + '</td>';
                    strhtml += '<td class="text-right">' + Number(data[i].importe_cobrado).toFixed(2) + '</td>';
                    strhtml += '<td class="text-right">' + Number(data[i].saldo).toFixed(2) + '</td>';
                    strhtml += '<td class="text-right">' + Number(data[i].porcentaje_saldo).toFixed(2) + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#tableDetalle tbody').html(strhtml);
            $('#tableDetalle .ibody table').enableCellNavigation();

            CalcularTotal();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function Resumen_Propietario () {
	$.ajax({
        url: 'services/propietario/propietario-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'REPORTE',
            tipobusqueda: '1',
            idproyecto: $('#hdIdProyecto').val(),
            id: $('#hdIdPropietario').val(),
            anho: $('#ddlAnho').val(),
            mes: $('#ddlMes').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            
            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + data[i].descripcionpropiedad + '</td>';
                    strhtml += '<td class="importe_facturado">' + Number(data[i].importe_facturado).toFixed(2) + '</td>';
                    strhtml += '<td class="importe_cobrado">' + Number(data[i].importe_cobrado).toFixed(2) + '</td>';
                    strhtml += '<td class="saldo">' + Number(data[i].saldo).toFixed(2) + '</td>';
                    strhtml += '<td class="porcentaje_saldo">' + Number(data[i].porcentaje_saldo).toFixed(2) + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#tableDetalle tbody').html(strhtml);
            $('#tableDetalle .ibody table').enableCellNavigation();
            
            CalcularTotal();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function MostrarResumen () {
	if ($('#hdIdPerfil').val() == '61') {
		Resumen_Proyecto();
	}
	else {
		Resumen_Propietario();
	};
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
                strhtml += '<option value="0">NO HAY PROCESOS RELACIOANDOS CON EL PROYECTO SELECCIONADO</option>';
            };

            $('#ddlAnho').html(strhtml);

            MostrarResumen();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function IniciarForm () {
	if ($('#hdIdPerfil').val() == '61') {
	    var idproyecto = getParameterByName('idproyecto');

		ProyectoByIdX(idproyecto);
	};
}

function setProyecto (idproyecto, logo, nombre) {
    $('#hdIdProyecto').val(idproyecto);

    $('#pnlInfo').attr('data-idproyecto', idproyecto);

    $('#imgFoto').attr('src', logo);
    $('#pnlInfo .info .descripcion').text(nombre);

    var today = new Date();
    var yyyy = today.getFullYear();
    
    ListarAnhoProceso(yyyy);
}

function ProyectoByIdX (idproyecto) {
    $.ajax({
        url: 'services/condominio/condominio-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: 'defecto',
            tipobusqueda: idproyecto
        },
        success: function (data) {
            var countdata = data.length;

            if (countdata > 0){
                var idproyecto = data[0].idproyecto;
                var descripcion = data[0].nombreproyecto;
                var logo = data[0].logo;
                
                setProyecto (idproyecto, logo, descripcion);
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function CalcularTotal () {
    var total_facturado = 0;
    var total_cobrado = 0;
    var total_saldo = 0;
    var i = 0;

    var itemsDetalle = $('#tableDetalle .ibody table');
    var tableDetalle = itemsDetalle[0];

    var countdata = tableDetalle.rows.length;

    if (countdata > 0){
        while (i < countdata){ 
            total_facturado += Number(tableDetalle.rows[i].cells[1].innerHTML);
            total_cobrado += Number(tableDetalle.rows[i].cells[2].innerHTML);
            total_saldo += Number(tableDetalle.rows[i].cells[3].innerHTML);
            ++i;
        };
    };

    document.getElementById('lblTotalFacturado').innerText = total_facturado.toFixed(2);
    document.getElementById('lblTotalCobrado').innerText = total_cobrado.toFixed(2);
    document.getElementById('lblTotalSaldo').innerText = total_saldo.toFixed(2);
}