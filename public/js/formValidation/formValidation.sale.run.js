$(document).ready(function () {


    // Преодложение. Создание, редактирование

    $('#formSale')

        .find('[name="service_tid"]')
        .select2()
        .end()

        .formValidation({

            // Indicate the framework
            // Can be bootstrap, foundation, pure, semantic, uikit
            framework: 'bootstrap',
            // Feedback icons

            message: 'This value is not valid',
            trigger: null,
            fields: {

                service_tid: {
                    validators: {
                        callback: {
                            message: 'Выберите',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = validator.getFieldElements('service_tid').val();
                                return (options != null && options.length >= 1);
                            }
                        }
                    }
                },

                price_base: {
                    validators: {
                        notEmpty: {
                            message: 'Обязательно заполнить'
                        },
                        integer: {
                            message: 'Только цифры'
                        }
                    }
                },

                price_client_paid: {
                    validators: {
                        notEmpty: {
                            message: 'Обязательно заполнить'
                        },
                        integer: {
                            message: 'Только цифры'
                        }
                    }
                },

                price_partner: {
                    validators: {
                        integer: {
                            message: 'Только цифры'
                        }
                    }
                },

                price_partner_paid: {
                    validators: {
                        integer: {
                            message: 'Только цифры'
                        }
                    }
                },


            }
        });


    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/


});
