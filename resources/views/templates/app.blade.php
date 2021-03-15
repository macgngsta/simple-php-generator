<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.6.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.6.0/highlight.min.js"></script>
    <!-- and it's easy to individually load additional languages -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.6.0/languages/go.min.js"></script>
    <!-- <script>hljs.highlightAll();</script> -->
</head>
<body>
<div class="flex flex-col h-screen">
@include('common.navigation')
<!-- end header -->
    <header class="bg-white shadow">
        @yield('header')
    </header>
    <main class="mb-auto">
        @yield('main')
    </main>
    @include('common.footer')
</div>
<!-- Load javascript last -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
