<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <form class="form-inline pull-xs-left" action="/sale/list" method="post">
        <div class="form-group">
            <input class="form-control" id="searchInput" name="search" type="text" placeholder="Имя клиента">

            <script id="clientFsTemplate" type="text/x-handlebars-template">
                <div class="dropdown">
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        {{ "{{#each this}}" }}
                        <a href="/client/page/{{ "{{ id }}" }}" class="dropdown-item">{{ "{{ id }}" }} {{ "{{ name }}" }} </a>
                        {{ "{{/each}}" }}
                    </div>
                </div>
            </script>

            <div class="clientFsContainer"></div>
        </div>
        {{ submit_button("Найти", "class": "btn btn-outline-success") }}

    </form>
    {{ elements.getMenu() }}
    {{ link_to("client/new", "Create client", 'class': 'btn btn-primary') }}
</nav>

<div class="container-fluid">
    {{ flash.output() }}
    {{ content() }}
    <hr>
    <footer>
        <p>&copy; Company 2016</p>
    </footer>
</div>



