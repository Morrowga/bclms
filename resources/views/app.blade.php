<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>{{ env('APP_NAME')}}</title>
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<style>
    *,
    html,
    body {
        margin: 0;
        padding: 0;
    }
</style>

<body>
    @inertia
</body>

</html>
