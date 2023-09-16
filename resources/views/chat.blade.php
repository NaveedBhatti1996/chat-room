<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite('resources/sass/app.scss')

</head>
<body>
    <div class="container">
        <div class="row" id="app">
            <chat-room></chat-room>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
