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
    {{ sale.top }}
    {% if loop.first %}
        <table id="dtTable" class="table table-bordered table-striped edt" align="center">
        <thead>
        <tr>
            <th>Id</th>
            {#<th>Pos</th>#}
            <th>Услуга</th>

            {#<th>Клиент</th>#}

            <th class="sum">Ц</th>
            <th class="sum">КЗ</th>
            <th class="sum">ДК</th>

            <th>П</th>
            <th>Отпр</th>
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
        {#<td class="position">{{ sale.position }}</td>#}
        <td class="saleTypeName">{{ sale.saleType.name }}</td>

        {#<td class="clientName">{{ sale.client.name }}</td>#}

        <td class="price_base">{{ sale.price_base }}</td>
        <td class="price_client_paid">{{ sale.price_client_paid }}</td>
        <td class="price_client_debt">{{ sale.price_client_debt }}

            {% if sale.price_client_debt is not empty %}
                {% set clientDebtBtnClass = 'btn-success' %}
            <span class="clientDebtBtn btn btn-outline-success btn-sm" saleId="{{ sale.id }}" title="{{ sale.date_partner_paid }}">КПД</span>
            {% endif %}

        </td>

        <td class="salePartnerName">{{ sale.salePartner.name }} </td>

        <td>
            {% if sale.date_start is not empty %}
                {% set startBtnClass = 'btn-success' %}
            {% else %}
                {% set startBtnClass = 'btn-outline-secondary' %}
            {% endif %}
            <span class="startBtn btn {{ startBtnClass }} btn-sm" saleId="{{ sale.id }}" title="{{ sale.date_start }}">Отпр</span>

            {% if sale.date_done is not empty %}
                {% set doneBtnClass = 'btn-success' %}
            {% else %}
                {% set doneBtnClass = 'btn-outline-secondary' %}
            {% endif %}
            <span class="doneBtn btn {{ doneBtnClass }} btn-sm" saleId="{{ sale.id }}" title="{{ sale.date_done }}">Получ</span>

            {% if sale.date_partner_paid is not empty %}
                {% set partnerPaidBtnClass = 'btn-success' %}
            {% else %}
                {% set partnerPaidBtnClass = 'btn-outline-secondary' %}
            {% endif %}
            <span class="partnerPaidBtn btn {{ partnerPaidBtnClass }} btn-sm" saleId="{{ sale.id }}" title="{{ sale.date_partner_paid }}">ЗП</span>

            {% if sale.date_client_notice is not empty %}
                {% set clientNoticeBtnClass = 'btn-success' %}
            {% else %}
                {% set clientNoticeBtnClass = 'btn-outline-secondary' %}
            {% endif %}
            <span class="clientNoticeBtn btn {{ clientNoticeBtnClass }} btn-sm" saleId="{{ sale.id }}" title="{{ sale.date_partner_paid }}">Увед</span>

            {% if sale.date_client_service_get is not empty %}
                {% set clientServiceGetBtnClass = 'btn-success' %}
            {% else %}
                {% set clientServiceGetBtnClass = 'btn-outline-secondary' %}
            {% endif %}
            <span class="clientServiceGetBtn btn {{ clientServiceGetBtnClass }} btn-sm" saleId="{{ sale.id }}" title="{{ sale.date_partner_paid }}">Клиент</span>


        </td>

        <td class="price_partner">{{ sale.price_partner }} </td>
        <td class="price_partner_paid">{{ sale.price_partner_paid }}</td>
        <td class="price_partner_debt">{{ sale.price_partner_debt }}</td>

        <td class="price_profit_plan">{{ sale.price_profit_plan }}</td>
        <td class="price_profit_fact">{{ sale.price_profit_fact }}</td>

        <td class="date_start">{{ sale.date_start }}</td>
        <td class="date_expectation">{{ sale.date_expectation }}</td>

        {#<td width="7%">{{ link_to("sales/edit/" ~ sale.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>#}
        {#<td width="7%">{{ link_to("sales/delete/" ~ sale.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>#}
    </tr>
    {% if loop.last %}
        </tbody>

        <tfoot>
        <th></th>
        {#<th></th>#}
        {#<th></th>#}
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
