$(document).ready(function () {
    // Включает выпадающий календарь

    // Примеры смотри на http://eonasdan.github.io/bootstrap-datetimepicker/
    // http://momentjs.com/docs/#/manipulating/

    //=== ДЛЯ СТАТИСТИКИ ===============================================/

    // Если пустой финиш то пишем туда текущую дату
    function setDates() {

        if ($('#datetimepickerStatDateStart').val() === '') {
            //  var currentDate = moment().format('DD.MM.YYYY');
            $('#datetimepickerStatDateStart').val(getCurrentDateStart());
        }

        if ($('#datetimepickerStatDateFinish').val() === '') {
            //  var currentDate = moment().format('DD.MM.YYYY');
            $('#datetimepickerStatDateFinish').val(getCurrentDateFinish());
        }
    }
    setDates();

    function getCurrentDateStart() {
        return $('.dateStart').html();
    }

    function getCurrentDateFinish() {
        return $('.dateFinish').html();
    }

    function getDateStart() {
        return $('#datetimepickerStatDateStart').val();
    }

    function getDateFinish() {
        return $('#datetimepickerStatDateFinish').val();
    }

    // Получаем дату старта
    function generateLink() {
        var link = '/stat/statPeriod/' + getDateStart() + '/' + getDateFinish();
        return link;
    }

    $('.btn.getlink').hover(function () {
        var link = generateLink();
        $(this).attr('href', link);
        console.log(link);
    });


    // Настройки для стартовой даты
    $('#datetimepickerStatDateStart').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        minDate: moment(['2014', '00', '01']),

    });

    // Настройки для финишной даты
    $('#datetimepickerStatDateFinish').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        maxDate: moment(),
        useCurrent: false //Important! See issue #1075
    });

    // Поля зависимые
    // Не позаоляет выбрать несуществующий диапазон
    $("#datetimepickerStatDateStart").on("dp.change", function (e) {
        $('#datetimepickerStatDateFinish').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerStatDateFinish").on("dp.change", function (e) {
        $('#datetimepickerStatDateStart').data("DateTimePicker").maxDate(e.date);
    });


});
