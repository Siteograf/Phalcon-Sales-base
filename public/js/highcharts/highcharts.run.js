$(function () {

    console.log(statMode);

    // Не передается для некоторх графиков. Используется только для периодов
    // Задается в шаблоне
    // Если значения не пришли то ставим на 1 месяц период
    // Форматируем DD.MM.YYYY так как из шаблона приходит в таком формате
    if (typeof dateStart === 'undefined' || dateStart == "") {
        dateStart = moment().subtract(1, 'months').format("DD.MM.YYYY");
    }
    if (typeof dateFinish === 'undefined' || dateFinish == "") {
        dateFinish = moment().format("DD.MM.YYYY");
    }

    getJSONstatMonth(statMode, dateStart, dateFinish);

    function getJSONstatMonth(statMode, dateStart, dateFinish) {

        // Переформатируем так как SQL запрос принимает для фильтрации только так
        dateStart = moment(dateStart, "DD.MM.YYYY").format('YYYY.MM.DD');
        dateFinish = moment(dateFinish, "DD.MM.YYYY").format('YYYY.MM.DD');

        console.log("DS " + dateStart);
        console.log("DF " + dateFinish);

        $.ajax({
                url: "/stat/statjsnsales",
                method: "POST",
                data: {
                    statMode: statMode,
                    dateStart: dateStart,
                    dateFinish: dateFinish,
                },

                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=x-user-defined");
                }
            })
            .done(function (data) {

                //console.log(JSON.parse(data));
                // runHighcharts(JSON.parse(data));
                runHighcharts2(JSON.parse(data));

                //renderClientFastSearch(data);

            });
    }

    // Строим график
    function runHighcharts(data) {

        $('#container').highcharts({
            chart: {
                type: chartType
                //  type: 'area'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: data.period
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    formatter: function () {
                        return this.value; // clean, unformatted number

                        // return this.value / 1000 + 'k';
                    }
                }
            },
            tooltip: {
                pointFormat: '{series.name} - <b>{point.y:,.0f}</b><br/> --  {point.x}'
            },
            plotOptions: {
                area: {
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 2,
                        states: {
                            hover: {
                                enabled: true
                            }
                        }
                    }
                }
            },
            series: [
                {
                    name: 'Кол-во продаж',
                    data: data.sale_cnt
                },
                {
                    name: 'КЗ',
                    data: data.client_paid
                },
                {
                    name: 'ПФ',
                    data: data.profit_fact
                },
            ]
        });
    }

});


function runHighcharts2(data) {
    $('#container').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [
            {
                categories: data.period,
                crosshair: true
            }
        ],
        yAxis: [
            { // Primary yAxis
                labels: {
                    format: '{value}°C',
                    style: {
                        color: Highcharts.getOptions().colors[2]
                    }
                },
                title: {
                    text: 'Temperature',
                    style: {
                        color: Highcharts.getOptions().colors[2]
                    }
                },
                opposite: true,
                min: 0,
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }

            },
            { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: 'Rainfall',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value} руб',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: false

            },
            { // Tertiary yAxis
                gridLineWidth: 0,
                title: {
                    text: 'Sea-Level Pressure',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                labels: {
                    format: '{value} mb',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                opposite: true
            }
        ],
        tooltip: {
            shared: true
        },
        plotOptions: {
            column: {
                //  stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'gray',
                    style: {
                        textShadow: 'none'
                    }
                },
                grouping: false,
                shadow: false,
                borderWidth: 0
            }
        },

        legend: {
            layout: 'vertical',
            align: 'left',
            x: 80,
            verticalAlign: 'top',
            y: 55,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },

        series: [
            {
                name: 'КЗ',
                type: 'column',
                yAxis: 1,
                data: data.client_paid,
                tooltip: {
                    valueSuffix: ' руб'
                },
                pointPadding: 0.1,
                pointPlacement: 0
            },
            {
                name: 'ПП',
                type: 'column',
                yAxis: 1,
                data: data.profit_plan,
                color: 'orange',
                tooltip: {
                    valueSuffix: ' руб'
                },
                pointPadding: 0,
                pointPlacement: 0
            },
            {
                name: 'ПФ',
                type: 'column',
                yAxis: 1,
                data: data.profit_fact,
                color: '#5cb85c',
                tooltip: {
                    valueSuffix: ' руб'
                },
                pointPadding: 0,
                pointPlacement: 0,
            },

            {
                name: 'Кол-во продаж',
                type: 'spline',
                yAxis: 2,
                data: data.sale_cnt,
                marker: {
                    enabled: false
                },
                dashStyle: 'shortdot',
                tooltip: {
                    valueSuffix: ' '
                },
                visible: false,

            },

            //{
            //    name: 'Temperature',
            //    type: 'spline',
            //    data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            //    tooltip: {
            //        valueSuffix: ' °C'
            //    }
            //},
        ]
    });
};
