<form id="formSale" action="/sale/save/" method="post" role="form">

    <fieldset>
        {{ form.client_id }}

        <div class="row">
            {% for element in form %}
                {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                    {{ element }}
                {% else %}
                    <div class="col-md-2 form-group">
                        {{ element.label() }}
                        {{ element.render(['class': 'form-control']) }}
                    </div>
                {% endif %}
            {% endfor %}

        </div>
    </fieldset>


    <div class="pull-right">
        {{ submit_button("Save sale", "class": "btn btn-success") }}
    </div>

</form>
