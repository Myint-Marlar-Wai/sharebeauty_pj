$(document).ready(function () {
    //---------------QRcode-----------
    $('.alert_modal__popup').qrcode({
        width: 120,
        height: 120,
        render: "table",
        text: "http://jetienne.com"
    });
    $('#pop,#popup,#pop1,#popup1,#detail,#list1,#list2').on('click', function () {
        $($(this).data('target')).fadeIn('slow');
    });

});