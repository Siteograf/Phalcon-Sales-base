{{ content() }}


<ul class="pager">
    <li class="previous">
        {{ link_to("sale", "&larr; Go Back") }}
    </li>
    <li class="next">
        {{ link_to("sale/new", "Create sale") }}
    </li>
</ul>

{% for sale in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Услуга</th>

            <th>Клиент</th>

            <th>Ц</th>
            <th>КЗ</th>
            <th>ДК</th>

            <th>П</th>
            <th>ЦП</th>
            <th>ЗП</th>
            <th>ДПП</th>

            <th>ПП</th>
            <th>ПФ</th>

            <th>ДН</th>
            <th>ДОГ</th>
            <th>Edit</th>

        </tr>
        </thead>
        <tbody>
    {% endif %}

    <tr>
        <td>{{ sale.id }}</td>
        <td>{{ sale.saleType.name }}</td>

        <td>{{ sale.client.name }}</td>

        <td>{{ sale.price_base }}</td>
        <td>{{ sale.price_client_paid }}</td>
        <td>{{ sale.price_client_debt }}</td>

        <td>{{ sale.salePartner.name }}</td>
        <td>{{ sale.price_partner }}</td>
        <td>{{ sale.price_partner_paid }}</td>
        <td>{{ sale.price_partner_debt }}</td>

        <td>{{ sale.price_profit_plan }}</td>
        <td>{{ sale.price_profit_fact }}</td>

        <td>{{ sale.date_start }}</td>
        <td>{{ sale.date_expectation }}</td>

        <td><a href="/sale/edit/{{ sale.id }}">Edit</a></td>
        
        {#<td width="7%">{{ link_to("sale/edit/" ~ sale.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>#}
        {#<td width="7%">{{ link_to("sale/delete/" ~ sale.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>#}
    </tr>
    {% if loop.last %}
        </tbody>
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("sale/", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("sale/?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("sale/?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("sale/?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        </tbody>
        </table>
    {% endif %}
{% else %}
    No sale are recorded
{% endfor %}