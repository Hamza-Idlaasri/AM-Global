<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/commun.css') }}">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vis.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sidebar.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/jquery-1.7.1.min.js') }}"></script>

    <title>AM Global</title>

    @livewireStyles
</head>
<body>
    
    <div class="grid-container">
        <div class="topbar">
            @livewire('grid.topbar')
        </div>
       
        <div class="sidebar">
            @livewire('grid.sidebar')
        </div>

        <div class="main">

            {{-- main content  --}}

            @yield('content')

            {{-- Toggle butoon  --}}

            <div class="toggle-off">
                <button class="tg-btn-off"><i class="fa fa-bars"></i></button>
            </div>

        </div>
    </div>

    @livewireScripts

    {{-- <script type="module">
        import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
    </script>

<script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script> --}}
</body>
</html>