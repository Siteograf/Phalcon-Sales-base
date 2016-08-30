$(document).ready(function () {

    $('#dtTable').DataTable( {
       //  "order": [[ 1, "asc" ]],
        paging: false,
        "language": {
            "url": "../../lib/DataTable/translation/Russian.json"
        },
        fixedHeader: {
            header: true,
            footer: true
        },
        "initComplete": function (settings, json) {
            this.api().columns('.sum').every(function () {
                var column = this;

                var intVal = function (i) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                var sum = column
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    });

                $(column.footer()).html(sum);
            });
        }
    });

});