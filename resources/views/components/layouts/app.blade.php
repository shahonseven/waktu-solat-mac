<!doctype html>
<html lang="{{ config('app.locale') }}" data-bs-theme="{{ option('theme', 'light')  }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </head>
    <body class="mt-3 mx-1">
        <div class="container-xxl">
            {{ $slot }}
        </div>
    </body>
</html>
