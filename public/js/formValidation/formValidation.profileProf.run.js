$(document).ready(function () {


    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/

    // Прифиль. Профессиональные данные

    $('#profilesProf').formValidation({
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

            specializationsId: {
                validators: {
                    notEmpty: {
                        message: 'Выберите специализацию'
                    },
                }
            },

            /*
             aboutMe: {
             validators: {
             notEmpty: {
             message: 'Напишите кто вы и чем занимаетесь'
             },
             }
             },

             experience: {
             validators: {
             notEmpty: {
             message: 'Напишите о опыте в своей специализации. Если нет - пишите \'нет\''
             },
             }
             },

             education: {
             validators: {
             notEmpty: {
             message: 'Если есть - пишите. Если нет - пишите \'нет\''
             },
             }
             },

             languageSkills: {
             validators: {
             notEmpty: {
             message: 'Напишите все языки, на которых говорите'
             },
             }
             },

             hobby: {
             validators: {
             notEmpty: {
             message: 'Что нет хобби?'
             },
             }
             },*/


        }
    });


    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/
    /*-------------------------------------------------------------------------*/


});
