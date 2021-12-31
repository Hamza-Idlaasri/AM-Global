<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <title>AM Global</title>
</head>
<body>
    
<div class="container p-4">
        
    <div class="card">
        <div class="card-header h2">
            Sites

            <a href="{{route('addSite')}}" class="btn btn-light text-primary float-right"><i class="fas fa-plus"></i></a>
        </div>

        <div class="card-body p-4 d-flex flex-wrap justify-content-center">
            @foreach ($sites as $site)
    
            @if (!$site->db_password)
                @php
                    $site->db_password = 'empty';
                @endphp
            @endif

                <a href="{{ route('switchDB', [$site->db_host,$site->db_port,$site->db_database,$site->db_username,$site->db_password]) }}" class="btn btn-primary w-25 p-4 shadow m-3">
                    <h3>{{ $site->db_database }}</h3>
                </a>
            @endforeach
        </div>
    </div>
       


</div>

</body>
</html>