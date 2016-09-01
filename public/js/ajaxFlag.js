$(document).ready(function () {

    $(".startBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        startBtnAjaxSend(saleId)
    });

    $(".doneBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        doneBtnAjaxSend(saleId);
    });


    $(".partnerPaidBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        partnerPaidAjaxSend(saleId);
    });


});

function startBtnAjaxSend(saleId) {
    $.ajax({
            url: '/sale/start',
            type: 'POST',
            data: {saleId: saleId},
        })
        .done(function (data) {
            let rowData = JSON.parse(data);
            refreshRow(rowData, rowData.date_start, '.startBtn');

        });
}

function doneBtnAjaxSend(saleId) {
    $.ajax({
            url: '/sale/done',
            type: 'POST',
            data: {saleId: saleId},
        })
        .done(function (data) {
            let rowData = JSON.parse(data);
            refreshRow(rowData, rowData.date_done, '.doneBtn');
        });
}

function partnerPaidAjaxSend(saleId) {
    $.ajax({
            url: '/sale/partnerPaid',
            type: 'POST',
            data: {saleId: saleId},
        })
        .done(function (data) {
            let rowData = JSON.parse(data);
            refreshRow(rowData, rowData.date_partner_paid, '.partnerPaidBtn');
        });
}


function refreshRow(rowData, buttonData, buttonClass) {

    var table = $('#dtTable').DataTable();
    var tr = $('#dtTable tbody tr.' + rowData.id);

    tr.find('td.price_base').html(rowData.price_base);
    tr.find('td.date_start').html(rowData.date_start);
    tr.find('td.price_partner_paid').html(rowData.price_partner_paid);
    tr.find('td.price_partner_debt').html(rowData.price_partner_debt);

    // Change button color
    if (buttonData) {
        tr.find(buttonClass).removeClass('btn-outline-secondary').addClass('btn-success');
    } else {
        tr.find(buttonClass).removeClass('btn-success').addClass('btn-outline-secondary');
    }

    table
        .row(tr)
        .invalidate()
        .draw();

}



