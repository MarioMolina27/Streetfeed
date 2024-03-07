<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STREETFEED</title>
    <link rel="icon" href="img/logo.svg">
    <link rel="shortcut icon" href="{{ asset('img/logo.svg') }}" type="image/x-icon">
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <main id="app">
        @yield('content')
    </main>
</body>
</html>