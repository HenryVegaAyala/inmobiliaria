$(function () {
    IniciarForm();

    $('#btnImportarArchivos').on('click', function(event) {
        openModalCallBack('#modalUploadExcel', function () {
            ListarProcesos();
        });
    });

    $('.droping-air .file-import').on({
        'dragenter': function (event) {
            event.stopPropagation();
            event.preventDefault();
        },
        'dragover': function (event) {
            event.stopPropagation();
            event.preventDefault();
        },
        'change': function(event) {
            event.preventDefault();

            prepareImport(this.files);
        },
        'drop': function (event) {
            event.preventDefault();
            var files = event.originalEvent.dataTransfer.files;

            prepareImport(files);
        }
    });

    $('#btnCancelarSubida').on('click', function(event) {
        event.preventDefault();
        cancelImport();
    });

    $('#btnSubirDatos').on('click', function(event) {
        event.preventDefault();
        executeImport();
    });

    $('#ddlProceso').on('change', function(event) {
        event.preventDefault();
        var opt_selected = $('#ddlProceso option:selected');
        var anho = opt_selected.attr('data-anho');
        var mes = opt_selected.attr('data-mes');
        var estado_proceso = opt_selected.attr('data-estado');

        $('#hdAnho').val(anho);
        $('#hdMes').val(mes);
        $('#hdEstado_proceso').val(estado_proceso);
    });
});

var fileValue = false;
var progressError = false;
var progressSuccess = false;
var arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

function ListarArchivos () {
    var idproyecto = window.top.idproyecto;
    $('#hdIdProyecto').val(idproyecto);

    $.ajax({
        url: 'services/archivos/archivos-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: '4',
            idproyecto: idproyecto
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            
            var countdata = data.length;
            
            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<tr><td>' + data[i].tm_nombredocumento + '</td><td><a href="' + data[i].tm_ubicaciondocumento + '" class="btn btn-primary" target="_blank">Descargar archivo</a></td></tr>';
                    ++i;
                };
            };

            $('#tableDocumentos tbody').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function prepareImport (files) {
    var allowedTypes = ['xls','xlsx','pdf','doc','docx','jpg','png','gif','ppt','pptx'];
    var extension = '';
    var filename = '';

    fileValue = files[0]; 
    filename = files[0].name;
    extension = filename.split('.').pop().toLowerCase();

    if($.inArray(extension, allowedTypes) == -1) {
        MessageBox('Extensi&oacute;n no v&aacute;lida', 'El tipo de archivo no es compatible para la importaci&oacute;n', "[Aceptar]", function () {

        });
        return false;
    };

    $('.droping-air .help').text(filename);
    $('.droping-air').addClass('dropped');

    habilitarControl('#btnSubirDatos', true);
    $('#btnSubirDatos').addClass('success');
}

function cancelImport () {
    // var pbMetro;

    // pbMetro = $('.progress-bar').progressbar();
    
    $('.droping-air .help').text('Seleccione o arrastre un archivo de Excel');
    $('.droping-air').removeClass('dropped');

    habilitarControl('#btnSubirDatos', false);
    $('#btnSubirDatos').removeClass('success');

    $('.droping-air .file-import').val('');

    // pbMetro.progressbar('value', 0);
    // pbMetro.progressbar('color', 'bg-cyan');

    fileValue = false;
}

function executeImport () {
    // var pbMetro;
    var file = fileValue;
    var data = new FormData();
    var intervalProgress;

    // pbMetro = $('.progress-bar').progressbar();

    // intervalProgress = new Interval(function(){
    //     pbMetro.progressbar('value', (++progress));
    //     if (progress == 100){
    //         intervalProgress.stop();
    //         if (progressSuccess)
    //             intervalProgress.start();
    //     };
    // }, 100);

    // pbMetro.progressbar('value', '0');
    // pbMetro.progressbar('color', 'bg-cyan');

    data.append('btnSubirDatos', 'btnSubirDatos');
    data.append('hdIdProceso', $('#ddlProceso').val());
    data.append('hdIdProyecto', $('#hdIdProyecto').val());
    data.append('hdAnho', $('#hdAnho').val());
    data.append('hdMes', $('#hdMes').val());
    data.append('archivo', file);

    $.ajax({
        type: "POST",
        url: "services/archivos/archivos-post.php",
        contentType:false,
        processData:false,
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            progressError = false;
            if (data.rpta != '0')
                progressSuccess = true;
            
            // pbMetro.progressbar('value', 100);
            // pbMetro.progressbar('color', 'bg-green');

            // if (intervalProgress.isRunning())
            //     intervalProgress.stop();
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    closeCustomModal('#modalUploadExcel');
                    cancelImport(); 
                    ListarArchivos();
                };
            });
        },
        beforeSend: function () {
            // intervalProgress.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                setTimeout(function () {
                    // if (intervalProgress.isRunning())
                        // intervalProgress.stop();
                    // pbMetro.progressbar('value', 100);
                    executeImport();
                }, 10000);
            };
        },
        error:function (data){
            progress = 0;
            // pbMetro.progressbar('color', 'bg-red');
            progressError = true;
            console.log(data);
        }
    });
}

function ListarProcesos () {
    var idproyecto = window.top.idproyecto;
    $('#hdIdProyecto').val(idproyecto);

    $.ajax({
        url: 'services/proceso/proceso-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'LISTADO',
            tipo: '1',
            id: idproyecto
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<option value="' + data[i].tm_idproceso + '" data-mes="' + data[i].tm_per_mes + '" data-anho="' + data[i].tm_per_ano + '" data-estado="' + data[i].tm_idestadoproceso + '">';
                    
                    strhtml += 'PROCESO ' + arrMeses[parseInt(data[i].tm_per_mes) - 1] + ' ' + data[i].tm_per_ano + '</option>';
                    
                    ++i;
                };

                $('#ddlProceso').html(strhtml);
            }
            else
                $('#ddlProceso').html('<option value="0">NO SE ENCONTRARON PROCESOS RELACIONADOS AL PROYECTO SELECCIONADO</option>');

            $('#ddlProceso').trigger('change');
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function IniciarForm () {
    var idproyecto = window.top.idproyecto;
    var anho = window.top.anho;
    var mes = window.top.mes;
    // var escobrodiferenciado = window.top.escobrodiferenciado;
    
    $('#hdIdProyecto').val(idproyecto);
    $('#hdAnho').val(anho);
    $('#hdMes').val(mes);
    
    ListarArchivos();
}