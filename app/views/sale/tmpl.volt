<script id="saleTemplate" type="text/x-handlebars-template">
     <table class="menuTable" width="100%" border="0" cellspacing="0" cellpadding="0">
        {{#each items}}
        <tr class="menu__item" itemId="{{ id }}">
            <td class="ico"><img id="ico" width="32px" height="32px" src="{{url}}/favicon.ico"></td>
            <td class="title"><span class="titleText">{{url}}</span></td>
            <td class="control">
                <button type="button" id="{{ id }}" class="btn btn-danger-outline delete">Delete</button>
            </td>
        </tr>
        {{/each}}
    </table>
</script>