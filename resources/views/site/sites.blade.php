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
    
<div class="container p-4 w-50">
        
    <div class="container my-3">
        <div class="container w-50">
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header h2">
            Sites

            <a href="{{route('addSite')}}" class="btn btn-light text-primary float-right"><i class="fas fa-plus"></i></a>
        </div>

        <div class="card-body p-4">
            @forelse ($sites as $site)
    
            @if (!$site->db_password)
                @php
                    $site->db_password = 'empty';
                @endphp
            @endif

            <ul class="list-group">
                
                <li class="list-group-item d-flex justify-content-center align-items-center">

                    <div class="w-75">

                        <a href="{{ route('switchDB', [$site->id,$site->db_host,$site->db_port,$site->db_database,$site->db_username,$site->db_password]) }}" >
                            <h4><i class="fas fa-map-marker-alt mr-2"></i> {{ $site->site_name }}</h4>
                        </a>
                    </div>
                        
                    <div class="w-25">

                        <form action="{{ route('delete-site', [$site->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-light text-danger float-right" style="opacity: 0.5" onMouseOut="this.style.opacity='.5'" onMouseOver="this.style.opacity='1'" ><i class="far fa-trash-alt"></i></button>
                        </form>
                    </div>
                </li>
            </ul>
            @empty
                <p class=""><i>No sites found</i></p>
            @endforelse
        </div>
    </div>


</div>

</body>
</html>