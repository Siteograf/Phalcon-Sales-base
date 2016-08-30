$(document).ready(function () {

    /*-------------------------------------------------------------------------*/

    var currentYear = moment().format('YYYY');
    var minBirthYear = currentYear - 100;

    /*-------------------------------------------------------------------------*/

    // Профиль. Основные данные

    $('#profilesMain').formValidation({
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
        live: 'enabled',
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Имя обязательно нужно написать'
                    },
                    regexp: {
                        regexp: /^[а-яА-ЯёЁa-zA-Z0-9]+$/,
                        message: 'Напишите настоящее имя'
                    }
                }
            },

            surname: {
                validators: {
                    notEmpty: {
                        message: 'Фамилию обязательно нужно написать'
                    },
                    regexp: {
                        regexp: /^[а-яА-ЯёЁa-zA-Z0-9]+$/,
                        message: 'Напишите настоящую фамилию'
                    }
                }
            },

            gender: {
                validators: {
                    notEmpty: {
                        message: 'Укажите пол'
                    },
                }
            },

            day: {
                validators: {
                    notEmpty: {
                        message: 'Напишите день рождения'
                    },
                    between: {
                        min: 1,
                        max: 31,
                        message: 'Только цифры от 1 до 31'
                    }
                }
            },

            month: {
                validators: {
                    notEmpty: {
                        message: 'Напишите месяц рождения'
                    },
                    between: {
                        min: 1,
                        max: 31,
                        message: 'Только цифры от 1 до 12'
                    }
                }
            },

            year: {
                validators: {
                    notEmpty: {
                        message: 'Напишите год рождения'
                    },
                    between: {
                        min: minBirthYear,
                        max: currentYear,
                        message: 'От ' + minBirthYear + ' до ' + currentYear,
                    }
                }
            },

            countriesId: {
                validators: {
                    notEmpty: {
                        message: 'Выберите страну, потом город'
                    },
                }
            },

            citiesId: {
                validators: {
                    notEmpty: {
                        message: 'Выберите ваш город или ближайший к вам'
                    },
                }
            },

            phone: {
                validators: {
                    notEmpty: {
                        message: 'Напишите ваш телефон'
                    },
                }
            },


            social_vk: {
                validators: {
                    regexp: {
                        regexp: /^(http:\/\/|https:\/\/)?(www.)?(vk\.com|vkontakte\.ru)\/(id\d|[a-zA-Z0-9_.])+$/,
                        message: 'Это не ссылка на профиль VK'
                    }
                }
            },

            webSite: {
                validators: {
                    uri: {
                        message: 'Это не корректный адрес сайта'
                    }
                }
            },

        }
    });


    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/


});
