$(function(){
    ListarModelo();

    $('#ddlPlantilla').on('change', function(event) {
        event.preventDefault();
        var _val = $(this).val();

        if (_val == '0') {
            var ed = tinyMCE.get('txtEstructura');
            ed.setContent('');
        }
        else
            getModelo(_val);
    });

	tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",
        autosave_ask_before_unload: false,
        min_height: 160,
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        menubar: "tools edit table format view insert",
        setup: function(editor) {
            /*editor.addButton('mybutton', {
                type: 'listbox',
                text: 'Propiedad',
                icon: false,
                onselect: function(e) {
                    editor.insertContent(this.value());
                },
                values: [
                	{text: 'Propiedad', value: ':Propiedad:'},
                    {text: 'Apellidos y nombres', value: ':ApeNom:'},
                    {text: 'Fecha de hoy', value: ':FechaHoy:'}
                ],
                onPostRender: function() {
                    // Select the second item by default
                    this.value(':Propiedad:');
                }
            });*/
        }
    });
    
    $('#gvFiles').on('click', '.dato', function(event) {
        event.preventDefault();
        
        var tipoarchivo = $('.btn-header.success').attr('data-tipo');
        var checkBox = $(this).find('input:checkbox');

        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            
            if ($('#gvFiles .dato.selected').length == 0){
                $('#btnClearSelect, #btnInsertFiles, #btnAttachFiles').addClass('oculto');
            }
            else {
                if ($('#gvFiles .dato.selected').length == 1){
                    $('#btnClearSelect, #btnAttachFiles').removeClass('oculto');
                    if (tipoarchivo == 'media') {
                        $('#btnInsertFiles').removeClass('oculto');
                    };
                };
            };
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            $('#btnClearSelect, #btnAttachFiles').removeClass('oculto');
            if (tipoarchivo == 'media') {
                $('#btnInsertFiles').removeClass('oculto');
            };
        };
    });

    $('.btn-header').on('click', function(event) {
        event.preventDefault();

        var folder = document.getElementById('hdUsuario').value;
        var tipo = this.getAttribute('data-tipo');

        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');

        if (tipo == 'media') {
            $('#btnInsertFiles').addClass('oculto');
        };

        document.getElementById('ifrFiles').setAttribute('src', '?pag=uploader&folder=' + folder + '&tipo=' + tipo);
        ListarArchivos(folder, tipo);
    });

    $('#btnShowFiles').on('click', function(event) {
        event.preventDefault();
        $('#pnlFiles').fadeIn(400, function() {
            var activeType = $('.btn-header.success');
            activeType.trigger('click');
        });
    });

    $('#btnHideFiles').on('click', function(event) {
        event.preventDefault();
        $('#pnlFiles').fadeOut(400, function () {
            
        });
    });

    $('#btnClearSelect').on('click', function(event) {
        event.preventDefault();
        $('#btnClearSelect, #btnInsertFiles, #btnAttachFiles').addClass('oculto');
        $('#gvFiles .tile.selected').removeClass('selected');
        $('#gvFiles input:checkbox:checked').removeAttr('checked');
    });

    $('#btnInsertFiles').click(function (event) {
        event.preventDefault();
        InsertarImagenes();
    });

    $('#btnAttachFiles').on('click', function(event) {
        event.preventDefault();
        AdjuntarArchivos();
    });

    $('#attach-files').on('click', 'a', function(event) {
        event.preventDefault();
        var action = this.getAttribute('data-action');
        if (action == 'delete') {
            $(this).parent().fadeOut(400, function() {
                this.remove();
                if ($('#attach-files .file-attach').length == 0)
                    $('#attach-files').html('No se han adjuntado archivos');
            });
        };
    });

    $('#btnEnviarEmail').on('click', function(event) {
        event.preventDefault();
        EnviarEmail();
    });
});

function LimnpiarForm () {
    $('#ddlPlantilla')[0].selectedIndex = 0;
    
    var ed = tinyMCE.get('txtEstructura');
    ed.setContent('');

    $('#txtAsunto').val('').focus();
}

function EnviarEmail () {
    var data = new FormData();
    data.append('btnEnviarEmail', 'btnEnviarEmail');

    precargaExp('#form1', true);
    tinymce.triggerSave();
    
    var input_data = $('#form1 :input').serializeArray();
    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/email/email-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#form1', false);
            
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    LimnpiarForm();
                };
            });
        },
        error: function  (data) {
            console.log(data);
        }
    });
}

function InsertarImagenes () {
    var url =  window.location.href.split('/');
    var pathname = window.location.pathname.split('/');
    var rURL = url[0] + "//" + url[2] + '/' + pathname[1];
    var itemsfile = $('#gvFiles .selected');
    var countfiles = itemsfile.length;

    if (countfiles > 0){
        var i = 0;
        var ed = tinyMCE.get('txtEstructura');
        var range = ed.selection.getRng();

        while(i < countfiles){
            var newNode = ed.getDoc().createElement( "img" );

            newNode.src = rURL + '/' + itemsfile[i].getAttribute('data-url');
            range.insertNode(newNode);
            ++i;
        };

        $('#btnHideFiles').trigger('click');
        $('#btnClearSelect').trigger('click');
    };
}

function AdjuntarArchivos () {
    var selected = $('#gvFiles .selected');
    var countdata = selected.length;

    if (countdata > 0) {
        var strhtml = '';
        var i = 0;

        while(i < countdata){
            var filename = selected[i].getAttribute('data-name');
            strhtml += '<div class="file-attach float-left bg-darkCyan fg-white padding10 margin10"><input type="hidden" name="attachFiles[]" value="' + filename + '" />' + filename + '&nbsp;<a href="#" data-action="delete" class="float-right fg-white"><i class="icon-cancel-2"></i></a></div>';
            ++i;
        };

        if ($('#attach-files .file-attach').length == 0)
            $('#attach-files').html('');
        
        $('#attach-files').append(strhtml);
        $('#btnHideFiles').trigger('click');
        $('#btnClearSelect').trigger('click');
    };
}

function insertarContenido (termino) {
    var ed = tinyMCE.get('txtEstructura');
    ed.insertContent(termino);
}

function ListarArchivos (folder, tipo) {
    var selector = '';
    var selectorpreload = '';
    var criterio = '';

    selector = '#gvFiles .gridview';
    selectorpreload = '#moduloFiles .colTwoPanel2';
    //criterio = document.getElementById('txtSearchFiles').value;

    precargaExp(selectorpreload, true);

    $.ajax({
        url: 'services/files/files-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            folder: folder,
            tipo: tipo,
            criterio: criterio
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = data.length;
        var strhtml = '';
        
        precargaExp(selectorpreload, false);

        if (countdata > 0){
            while(i < countdata){
                var filename = data[i].path;
                var pathfile = data[i].file;
                var extension = data[i].ext;

                var csscontent = '';
                var icon = '';

                if (tipo == 'documents')
                    csscontent = 'icon';
                else
                    csscontent = 'image';

                strhtml += '<div class="tile dato" data-name="' + pathfile + '" data-url="' + filename + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + filename + '" />';
                strhtml += '<div class="tile_true_content">';
                strhtml += '<div class="tile-content ' + csscontent + '">';

                if (tipo == 'media')
                    strhtml += '<img src="' + filename + '" alt="" />';
                else {
                    if (extension == 'doc' || extension == 'docx')
                        icon = 'file-word';
                    else if (extension == 'xls' || extension == 'xlsx')
                        icon = 'file-excel';
                    else if (extension == 'ppt' || extension == 'pptx')
                        icon = 'file-powerpoint';
                    else if (extension == 'pdf')
                        icon = 'file-pdf';
                    else if (extension == 'zip' || extension == 'rar' || extension == '7z')
                        icon = 'file-zip';
                    else if (extension == 'html' || extension == 'htm')
                        icon = 'html5';
                    else
                        icon = 'file';

                    strhtml += '<i class="icon-' + icon + ' fg-black"></i>';
                };

                strhtml += '</div>';
                strhtml += '<div class="tile-status bg-dark opacity">';
                strhtml += '<span class="label">' + pathfile + '</span>';
                strhtml += '</div>';
                strhtml += '</div>';
                strhtml += '</div>';

                ++i;
            };
        };

        $(selector).html(strhtml);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function ListarModelo () {
    $.ajax({
        url: 'services/modelocarta/modelocarta-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: '1',
            tipobusqueda: '3',
            criterio: ''
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<option value="' + data[i].idmodelocarta + '">' + data[i].nombre + '</option>';
                    ++i;
                };
                $('#ddlPlantilla').append(strhtml);
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function getModelo (idmodelocarta) {
    $.ajax({
        url: 'services/modelocarta/modelocarta-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: '1',
            tipobusqueda: '2',
            id: idmodelocarta
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                var termino = data[0].contenido;

                insertarContenido(termino);
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}