$(document).ready(function () {

    $(".startToPartner").click(function () {
        let saleId = this.getAttribute('saleId');
        ajaxSend(saleId)
    });

});

function ajaxSend(saleId) {
    $.ajax({
            url: '/sale/startToPartner',
            type: 'POST',
            data: {saleId: saleId},
        })
        .done(function (data) {
            getResult(JSON.parse(data));
        });
}

function getResult(data) {
    console.log(data);
    console.log('price_base', data.price_base);



}

