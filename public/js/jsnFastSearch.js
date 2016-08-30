'use strict';

$(document).ready(function () {

    let delay = (function () {
        let timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $("#searchInput").keyup(function () {
        // Ставим задержку 500 мс
        delay(function () {

            let searchInput = document.getElementById('searchInput').value;

            // принимаем не меньше 2х символов
            if (searchInput.length >= 2) {
                getSearchClients(searchInput);
            } else {
                closeDropdown();
            }

        }, 500);
    });
});

$(document).keydown(function (e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
        closeDropdown();
    }
});

function closeDropdown() {
    $('.dropdown').removeClass('open');
}

function getSearchClients(searchInput) {
    $.ajax({
            method: "POST",
            url: "/client/jsnFastSearch/",
            data: {search: searchInput},

            beforeSend: function (xhr) {
                xhr.overrideMimeType("text/plain; charset=x-user-defined");
            }
        })
        .done(function (data) {
            console.log(data);
            renderClientFastSearch(data);

            // Открваем меню
            $('.dropdown').addClass("open");
        });
}

function renderClientFastSearch(data) {
    let clientFsContainer = document.querySelector('.clientFsContainer');
    let clientFsTemplate = document.getElementById('clientFsTemplate');

    // Compile the template
    let theTemplate = Handlebars.compile(clientFsTemplate.innerHTML);
    // Add the compiled html to the page
    clientFsContainer.innerHTML = theTemplate(JSON.parse(data));
}


//let searchInput = document.getElementById('searchInput').value;

//console.log('ww' + searchInput);


