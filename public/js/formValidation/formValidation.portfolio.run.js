$(document).ready(function () {


    // Портфолио. Создание и редактирование

    $('.portfolioForm').formValidation({
        // Indicate the framework
        // Can be bootstrap, foundation, pure, semantic, uikit
        framework: 'bootstrap',
        // Feedback icons
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        message: 'This value is not valid',
        trigger: null,
        fields: {

            title: {
                validators: {
                    notEmpty: {
                        message: 'Как же без названия?'
                    },
                }
            },


        }
    });



    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/


});
