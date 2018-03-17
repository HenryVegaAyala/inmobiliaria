$(function(){
	var heightBody = 0;
	
	heightBody = $('#pnlNuevoModelo > .gp-body').height();
	heightBody = heightBody - 120;

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
        height : heightBody,
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
		
		var checkBox = $(this).find('input:checkbox');

		if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            
            if ($('#gvFiles .dato.selected').length == 0){
                $('#btnClearSelect, #btnInsertFiles').addClass('oculto');
            }
            else {
                if ($('#gvFiles .dato.selected').length == 1){
                    $('#btnClearSelect, #btnInsertFiles').removeClass('oculto');
                };
            };
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            $('#btnClearSelect, #btnInsertFiles').removeClass('oculto');
        };
	});

	$('#ddlTerminos').on('change', function(event) {
		event.preventDefault();
		insertarContenido($(this).val());
	});

	$('#btnAddTermino').on('click', function(event) {
		event.preventDefault();
		insertarContenido($('#ddlTerminos').val());
	});

	$('#btnShowFiles').on('click', function(event) {
		event.preventDefault();
		$('#pnlFiles').fadeIn(400, function() {
			var folder = document.getElementById('hdUsuario').value;
			document.getElementById('ifrFiles').setAttribute('src', '?pag=uploader&folder=' + folder + '&tipo=media');
			ListarArchivos(folder);
		});
	});

	$('#btnHideFiles').on('click', function(event) {
		event.preventDefault();
		$('#pnlFiles').fadeOut(400, function () {
			
		});
	});

	$('#btnClearSelect').on('click', function(event) {
		event.preventDefault();
		$('#btnClearSelect, #btnInsertFiles').addClass('oculto');
		$('#gvFiles .tile.selected').removeClass('selected');
		$('#gvFiles input:checkbox:checked').removeAttr('checked');
	});

	$('#btnInsertFiles').click(function () {
		var itemsfile;
		var url = [];
		var pathname = [];
		var rURL = '';
		var countfiles = 0;
		var i = 0;

		url =  window.location.href.split('/');
		pathname = window.location.pathname.split('/');
		rURL = url[0] + "//" + url[2] + '/' + pathname[1];
		itemsfile = $('#gvFiles .dato.selected');
		countfiles = itemsfile.length;

        if (countfiles > 0){
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
    });

    $('#btnGuardarModelo').on('click', function(event) {
    	event.preventDefault();
    	Registrar();
    });
});

function insertarContenido (termino) {
	var ed = tinyMCE.get('txtEstructura');
	ed.insertContent(termino);
}

function ListarArchivos (folder) {
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
            criterio: criterio
        }
    })
    .done(function(data) {
        var i = 0;
        var countdata = 0;
        var strhtml = '';
        var filename = '';
        var pathfile = '';

        countdata = data.length;
        
        precargaExp(selectorpreload, false);

        if (countdata > 0){
            while(i < countdata){
                filename = data[i].path;
                pathfile = data[i].file;

                strhtml += '<div class="tile dato" data-url="' + filename + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + filename + '" />';
                strhtml += '<div class="tile_true_content">';
                strhtml += '<div class="tile-content image">';
                strhtml += '<img src="' + filename + '" alt="" />';
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

function Registrar () {
	var data = new FormData();
	var input_data;

    precargaExp('#pnlNuevoModelo', true);
    tinymce.triggerSave();
	
	input_data = $('#pnlNuevoModelo :input').serializeArray();
    data.append('btnGuardar', 'btnGuardar');

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

	$.ajax({
		url: 'services/modelocarta/modelocarta-post.php',
		type: 'POST',
		dataType: 'json',
		data: data,
        cache: false,
        contentType:false,
        processData: false,
		success: function (data) {
            precargaExp('#pnlNuevoModelo', false);
			
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                	window.parent.paginaModelo = 1;
                    window.parent.ListarModelos('1');
                };
            });
		},
		error: function  (data) {
			console.log(data);
		}
	});
}