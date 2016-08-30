{#  #}

<script>
    let statMode = 'month';
    let chartType = 'area';
</script>

{{ elements.getTabs() }}

<h1 class="">Продажи по месяцам</h1>

{#{% include "stat/part/statMenu.volt" %}#}

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
