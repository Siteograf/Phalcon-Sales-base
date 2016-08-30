{{ content() }}





<ul class="pager">
    <li class="previous">
        {{ link_to("client", "&larr; Go Back") }}
    </li>
    <li class="next">
        {{ link_to("client/new", "Create client") }}
    </li>
</ul>

{% for client in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Примечание</th>
            <th>Создан</th>
            <th>UID</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}

    <tr>
        <td>{{ client.id }}</td>
        <td><a href="/client/page/{{ client.id }}">{{ client.name }}</a></td>
        <td>{{ client.phone }}</td>
        <td>{{ client.email }}</td>
        <td>{{ client.description }}</td>
        <td> {{ client.created }}</td>
        <td> {{ client.uid }}</td>
        <td><a href="/client/edit/{{ client.id }}">Edit</a></td>

        {#<td width="7%">{{ link_to("client/edit/" ~ client.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>#}
        {#<td width="7%">{{ link_to("client/delete/" ~ client.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>#}
    </tr>
    {% if loop.last %}
        </tbody>
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("client/", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("client/?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("client/?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("client/?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        </tbody>
        </table>
    {% endif %}
{% else %}
    No clients are recorded
{% endfor %}