<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Busz menetrend</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/assets/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/assets/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/app.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <!--{* Datepicker *}-->
    <script src="/components/pickadate/lib/compressed/picker.js"></script>
    <script src="/components/pickadate/lib/compressed/picker.date.js"></script>
    <script src="/components/pickadate/lib/compressed/translations/hu_HU.js"></script>
    <link rel="stylesheet" href="/components/pickadate/lib/compressed/themes/default.css">
    <link rel="stylesheet" href="/components/pickadate/lib/compressed/themes/default.date.css">
    
    <!--{* Easy autocomplete *}-->
    <link rel="stylesheet" href="/components/EasyAutocomplete/easy-autocomplete.min.css">
    <script src="/components/EasyAutocomplete/jquery.easy-autocomplete.min.js"></script>
</head>
<body>
    @yield('body')

    <div id="loading-indicator" style="display: none;">
        <div id="loading-indicator-image">
            <div class='uil-cube-css' style='transform:scale(0.4)'><div></div><div></div><div></div><div></div></div>
        </div>
    </div>
</body>
</html>