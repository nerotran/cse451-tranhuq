<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
    my 451 page
    <br>
    <a href="{{ url('/') }}">home page</a>
    <div>
    	<h2>Server Info from php</h2>
    <form action="/cse451-tranhuq-web/app1/public/key/update" method="get">
        <label for="key">Key:</label><br>
        <input type="input" id="key" name="key"><br>
        <label for="value">value:</label><br>
        <input type="input" id="value" name="value"><br><br>
        <input type="submit" value="Submit">
    </form>
    </body>
</html>
