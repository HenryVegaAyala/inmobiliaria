$(function(){
	// $('.links-config ul').on('click', 'a', function () {
	// 	$('.links-config a').removeClass('active');
	// 	$(this).addClass('active');
	// 	navigateInFrame(this);
	// 	return false;
	// }).find('a:first').trigger('click');

	$('#navAccesos').on('click', 'a', function (event) {
		event.preventDefault();

		$(this).siblings('.btn-success').removeClass('btn-success').addClass('btn-primary');
		$(this).addClass('btn-success');
		
		navigateInFrame(this);
	}).find('a:first').trigger('click');
});

function navigateInFrame (alink) {	
	var url = alink.getAttribute('href');
	var tab = alink.getAttribute('data-tab');

	var tagIframe = '<iframe data-tab="' + tab + '" src="' + url + '" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>';

	$('.panels iframe').hide();
	
	if ($('.panels > iframe[data-tab="' + tab + '"]').length == 0){
		precargaExp("#pnlAccesosDirectos", true);
		
		$(tagIframe).appendTo('.panels').load(function () {
			precargaExp("#pnlAccesosDirectos", false);
			// navigateInPage(alink);
		});
	}
	else {
		$('.panels > iframe[data-tab="' + tab + '"]').show();
		// navigateInPage(alink);
	};
}

// function navigateInFrame (alink) {
// 	var url = '';
// 	var tab = '';
// 	var tagIframe = '';
	
// 	url = alink.getAttribute('href');
// 	tab = alink.getAttribute('data-tab');
// 	tagIframe = '<iframe data-tab="' + tab + '" src="' + url + '" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>';

// 	$('.panels iframe').hide();
// 	if ($('.panels > iframe[data-tab="' + tab + '"]').length == 0){
// 		precargaExp(".colTwoPanel2 .panels", true);
// 		$(tagIframe).appendTo('.panels').load(function () {
// 			precargaExp(".colTwoPanel2 .panels", false);
//             $(this).contents().find("body, body *").on('click', function(event) {
//                 window.top.hideAllSlidePanels();
//             });
// 		});
// 	}
// 	else
// 		$('.panels > iframe[data-tab="' + tab + '"]').show();
// }