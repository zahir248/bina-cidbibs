<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - BINA Community</title>
    <link rel="icon" href="{{ asset('favicon-client.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon-client.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @include('client.community.layouts.styles')
    @yield('styles')
</head>
<body>
    @include('client.community.layouts.partials.navbar')
    
    <main>
        @yield('content')
    </main>

    @include('client.community.layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('client.community.layouts.scripts')
    @yield('scripts')
</body>
</html> 