{{ content() }}
<script id="saleTemplate" type="text/x-handlebars-template">

    <table class="saleTable table table-bordered table-fixed-header">
        <thead>
        <th>id</th>
        <th>Тип</th>
        <th>Ц</th>
        <th>КЗ</th>
        <th>ДК</th>

        <th>П</th>
        <th>ЦП</th>
        <th>ЗП</th>
        <th>ДПП</th>

        <th>ПП</th>
        <th>ПФ</th>
        </thead>
        {{ "{{#each items}}" }}
            <tr>
                <td colspan="100%">
                    <h4>
                        {{ "{{ client.client_id }}" }}
                        <a href="/client/page/{{ "{{ client.client_id }}" }}">{{ "{{ client.client_name }}" }} </a>
                        {{ "{{ client.client_phone }}" }}
                    </h4>
                </td>
            </tr>

            {{ "{{#each sales}}" }}
                <tr>
                    <td>{{ "{{ id }}" }} <a href="/sale/edit/{{ "{{ id }}" }}">Edit</a></td>
                    <td>{{ "{{ saleType }}" }}</td>
                    <td>{{ "{{ price_base }}" }}</td>
                    <td>{{ "{{ price_client_paid }}" }}</td>
                    <td>{{ "{{ price_client_debt }}" }}</td>

                    <td>{{ "{{ partner_name }}" }}</td>
                    <td>{{ "{{ price_partner }}" }}</td>
                    <td>{{ "{{ price_partner_paid }}" }}</td>
                    <td>{{ "{{ price_partner_debt }}" }}</td>

                    <td>{{ "{{ price_profit_plan }}" }}</td>
                    <td>{{ "{{ price_profit_fact }}" }}</td>

                </tr>
            {{ "{{/each}}" }}

        {{ "{{/each}}" }}
    </table>

</script>


<div class="saleContainer"></div>




