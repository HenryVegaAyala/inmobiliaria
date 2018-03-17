$(function () {
    $('.sidebar-menu').on('click', 'a', function(event){
        event.preventDefault();
        
        $('.sidebar-menu li').removeClass('active');
        $(this).parent().addClass('active');

        navigateInFrame(this);
    }).find('a:first').trigger('click');
});

var idproyecto = 0;
var anho = 0;
var mes = 0;
var escobrodiferenciado = 0;
var estadoproceso = 0;

function navigateInFrame(_link) {
    var page = _link.getAttribute('href');
    var dataId = _link.getAttribute('data-id');
    var title_link = (function () {
        var _label = _link.getElementsByTagName('span')[0];
        return _label.textContent || _label.innerText;
    });

    // console.log(title_link);

    $('#title_app').text(title_link);

    $('.content-wrapper iframe').hide();

    if ($('.content-wrapper #ifr' + dataId).length == 0){
        precargaExp('body', true);

        var panel = document.getElementsByClassName('content-wrapper')[0];
        var _frame = document.createElement('iframe');

        _frame.setAttribute('id', 'ifr' + dataId);
        _frame.setAttribute('scrolling', 'no');
        _frame.setAttribute('marginwidth', '0');
        _frame.setAttribute('marginheight', '0');
        _frame.setAttribute('width', '100%');
        _frame.setAttribute('height', '100%');
        _frame.setAttribute('frameborder', 'no');
        _frame.setAttribute('src', page);

        _frame.onload = function(event){
            // var fd = this.document || this.contentWindow;
            precargaExp('body', false);
        };

        panel.appendChild(_frame);
    }
    else
        $('.content-wrapper #ifr' + dataId).show();
}