<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <title>AM Global</title>

    <style>
        body
        {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #header {
            background-color: rgb(0, 151, 211);

        }
    </style>

</head>
<body>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-4 bg-white shadow rounded p-0">

            <div class="text-center" id="header">
                <img src="{{ asset('images/AlarmManager.png') }}" alt="AlarmManager">
            </div>

            <form action="{{ route('addSite') }}" method="post" class="p-3">
                
                @csrf

                {{-- <div class="form-group">
                    <input type="text" name="db_connection" class="form-control @error('db_connection') border-danger @enderror" placeholder="Connection" pattern="[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]{3,15}" title="Connection must be between 3 & 15 charcarters in length and containes only letters, numbers, and these symbols -_()">
                    @error('db_connection')
                        <div class="text-danger">
                                {{ $message }}
                        </div>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <input type="text" name="db_host" class="form-control @error('db_host') border-danger @enderror" placeholder="Host" pattern="[a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]{3,15}" title="Host must be between 3 & 15 charcarters in length and containes only letters, numbers, and these symbols -_()">
                    @error('db_host')
                        <div class="text-danger">
                                {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="db_port" class="form-control @error('db_port') border-danger @enderror" placeholder="Port" pattern="[a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]{3,15}" title="Port must be between 3 & 15 charcarters in length and containes only letters, numbers, and these symbols -_()">
                    @error('db_port')
                        <div class="text-danger">
                                {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="db_database" class="form-control @error('db_database') border-danger @enderror" placeholder="DB Name" pattern="[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]{3,15}" title="DB Name must be between 3 & 15 charcarters in length and containes only letters, numbers, and these symbols -_()">
                    @error('db_database')
                        <div class="text-danger">
                                {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="db_username" class="form-control @error('db_username') border-danger @enderror" placeholder="DB Username" pattern="[a-zA-Z][a-zA-Z0-9-_(). ÀÂÇÉÈÊÎÔÛÙàâçéèêôûù]{3,15}" title="DB Username must be between 3 & 15 charcarters in length and containes only letters, numbers, and these symbols -_()">
                    @error('db_username')
                        <div class="text-danger">
                                {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="db_password" class="form-control @error('db_password') border-danger @enderror" placeholder="Password"  title="Password must be between 3 & 15 charcarters in length and containes only letters, numbers, and these symbols -_()">
                    @error('db_password')
                        <div class="text-danger">
                                {{ $message }}
                        </div>
                    @enderror
                </div>
                
                
                <div>
                    <button type="submit" class="btn btn-primary w-100"><strong>Add</strong></button>
                </div>

            </form>

        </div>
    </div>
</div>


</body>
</html>