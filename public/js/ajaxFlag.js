$(document).ready(function () {

    $(".startBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        buttonSendToActionAjax (saleId, 'start', 'date_start', '.startBtn')
    });

    $(".doneBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        buttonSendToActionAjax (saleId, 'done', 'date_done', '.doneBtn')
    });

    $(".partnerPaidBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        buttonSendToActionAjax (saleId, 'partnerPaid', 'date_partner_paid', '.partnerPaidBtn')
    });

    $(".clientDebtBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        buttonSendToActionAjax (saleId, 'clientDebt', 'price_client_debt', '.clientDebtBtn')
    });

    $(".clientNoticeBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        buttonSendToActionAjax (saleId, 'clientNotice', 'date_client_notice', '.clientNoticeBtn')
    });

    $(".clientServiceGetBtn").click(function () {
        let saleId = this.getAttribute('saleId');
        buttonSendToActionAjax (saleId, 'clientServiceGet', 'date_client_service_get', '.clientServiceGetBtn')
    });

});

// Send request to action and recieve changed sale - one row
function buttonSendToActionAjax (saleId, actionName, buttonName, buttonClass){
    $.ajax({
            url: '/sale/' + actionName,
            type: 'POST',
            data: {saleId: saleId},
        })
        .done(function (data) {
            let rowData = JSON.parse(data);
            refreshRow(rowData, rowData[buttonName], buttonClass);

        });
}

// Refresh sale
function refreshRow(rowData, buttonData, buttonClass) {

    var table = $('#dtTable').DataTable();
    var tr = $('#dtTable tbody tr.' + rowData.id);

    tr.find('td.price_base').html(rowData.price_base);
    tr.find('td.price_client_paid').html(rowData.price_client_paid);
    tr.find('td.price_client_debt').html(rowData.price_client_debt);

    tr.find('td.price_partner_paid').html(rowData.price_partner_paid);
    tr.find('td.price_partner_debt').html(rowData.price_partner_debt);

    tr.find('td.price_profit_plan').html(rowData.price_profit_plan);
    tr.find('td.price_profit_fact').html(rowData.price_profit_fact);

    tr.find('td.date_start').html(rowData.date_start);

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



