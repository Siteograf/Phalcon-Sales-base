<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        {{ get_title() }}
        {{ stylesheet_link('css/style.css') }}
        {{ assets.outputCss() }}

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your invoices">
        <meta name="author" content="Phalcon Team">
    </head>
    <body>
        {{ content() }}

        {{ assets.outputJs() }}
    </body>
</html>