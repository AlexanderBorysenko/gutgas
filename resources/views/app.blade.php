<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <title inertia>{{ config('app.name', 'Laravel') }}</title> --}}
    <meta name="google-site-verification" content="Ul9Uz2ZUtv3wLZlr4YFWO_jKwt8MtdyluHt1vQimpqI">

    <meta name="robots" content="noindex">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    @if (Request::is('admin*'))
        @php($__inertiaSsrDispatched = true)
        @php($__inertiaSsrResponse = null)
    @endif

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])

    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
