{{ content() }}

<h1>{{ client.name }} - {{ client.phone }}</h1>

<a href="/sale/new/{{ client.id }}" class="btn btn-primary">Create sale</a>

<hr>

<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Id</th>
        <th>Email</th>
        <th>Примечание</th>
        <th>Создан</th>
        <th>UID</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ client.id }}</td>
        <td>{{ client.email }}</td>
        <td>{{ client.description }}</td>
        <td>{{ client.created }}</td>
        <td>{{ client.uid }}</td>
    </tr>
    </tbody>
    <tbody>

    </tbody>
</table>


{% for sale in sales %}
    {% if loop.first %}
        <table id="dtTable" class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Pos</th>
            <th>Услуга</th>

            <th>Клиент</th>

            <th class="sum">Ц</th>
            <th class="sum">КЗ</th>
            <th class="sum">ДК</th>

            <th>П</th>
            <th>П</th>
            <th class="sum">ЦП</th>
            <th class="sum">ЗП</th>
            <th class="sum">ДПП</th>

            <th class="sum">ПП</th>
            <th class="sum">ПФ</th>

            <th>ДН</th>
            <th>ДОГ</th>

        </tr>
        </thead>
        <tbody>
    {% endif %}

    <tr class="{{ sale.id }}">
        <td>{{ sale.id }}
            <a href="/sale/delete/{{ sale.id }}?destination=/client/page/{{ client.id }}">Del</a>
            <a href="/sale/edit/{{ sale.id }}/{{ client.id }}">Edit</a>
        </td>
        <td>{{ sale.position }}</td>
        <td>{{ sale.saleType.name }}</td>

        <td>{{ sale.client.name }}</td>

        <td>{{ sale.price_base }}</td>
        <td>{{ sale.price_client_paid }}</td>
        <td>{{ sale.price_client_debt }}</td>

        <td>{{ sale.salePartner.name }} </td>
        <td><span class="startToPartner btn btn-primary btn-sm" saleId="{{ sale.id }}">Send</span></td>
        <td>{{ sale.price_partner }} </td>
        <td>{{ sale.price_partner_paid }}</td>
        <td>{{ sale.price_partner_debt }}</td>

        <td>{{ sale.price_profit_plan }}</td>
        <td>{{ sale.price_profit_fact }}</td>

        <td>{{ sale.date_start }}</td>
        <td>{{ sale.date_expectation }}</td>

        {#<td width="7%">{{ link_to("sales/edit/" ~ sale.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>#}
        {#<td width="7%">{{ link_to("sales/delete/" ~ sale.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>#}
    </tr>
    {% if loop.last %}
        </tbody>

        <tfoot>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        </tfoot>

        </table>
    {% endif %}
{% else %}
    No sales are recorded
{% endfor %}


{% include "/sale/new.volt" %}
