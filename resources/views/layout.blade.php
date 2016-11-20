<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forex - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div id="app">
    @yield('content')
</div>


<!-- Scripts -->
<script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
</script>
<script src="{{ elixir('js/app.js') }}"></script>

</body>
</html>
