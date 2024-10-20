<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Juara Ticket</title>
    @vite('resources/css/app.css')
    @include('front.layouts.includes.styles')
</head>

<body>
    <div class="relative flex flex-col w-full min-h-screen max-w-[640px] mx-auto bg-white">
        @yield('content')
    </div>
        @include('front.layouts.includes.scripts')
</body>

</html>
