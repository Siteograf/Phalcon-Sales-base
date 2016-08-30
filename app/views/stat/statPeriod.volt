{#  #}

<script>
    let statMode = 'period';
    let chartType = 'area';

    let dateStart = "{{ dateStart }}";
    let dateFinish = "{{ dateFinish }}";
</script>

{{ elements.getTabs() }}

<h1 class="">Продажи в период c <span class="dateStart hide-">{{ dateStart }}</span> по <span class="dateFinish hide-">{{ dateFinish }}</span></h1>
<div class="row">

    <div class='col-md-3'>

        <div class="form-group">
            <div class='input-group date-'>
                <input type='text' id='datetimepickerStatDateStart' class="form-control"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-md-3'>
        <div class="form-group">
            <div class='input-group date'>
                <input type='text' id='datetimepickerStatDateFinish' class="form-control"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>

    <div class='col-md-3'>
        <a href="/" class="btn btn-success getlink">Показать</a>
    </div>

</div>

{#{% include "stat/part/statMenu.volt" %}#}

<div id="container" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
