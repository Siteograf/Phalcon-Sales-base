$.ajax({
        //method: "POST",
        url: "/sale/jsn/",
        //data: {search: searchInput},

        beforeSend: function (xhr) {
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
        }
    })
    .done(function (data) {

        let saleContainer = document.querySelector('.saleContainer');
        let saleTemplate = document.getElementById('saleTemplate');

        // Compile the template
        let theTemplate = Handlebars.compile(saleTemplate.innerHTML);
        // Add the compiled html to the page
        saleContainer.innerHTML = theTemplate(JSON.parse(data));

    });