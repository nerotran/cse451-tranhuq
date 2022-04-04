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
    <table>

	@foreach (array_keys($server) as $s)
	<tr><td>{{ $s }}</td><td> {{$server[$s] }} </td></tr>
	@endforeach

    </table>
    </body>
</html>
