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
    <form action="/cse451-tranhuq-web/app1/public/data" method="post">
        <input type="input" id="title" name="title"><br>
        <label for="title">Title:</label><br>
        <input type="input" id="author" name="author"><br>
        <label for="title">Author:</label><br>
    </form>
    </body>
</html>
