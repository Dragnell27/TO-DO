<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <title>TO-DO</title>
</head>

<body>
    @auth
        <div class="d-none" id="user-id" data-id="{{Auth::user()->id}}"></div>
    @endauth

    @include('components.header')
    @include('components.alert')

    <div class="mt-2 mb-5 p-2">
        @yield('main')
    </div>

    <script>
        //Token @csrf para envió de peticiones POST
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    @yield('scripts')
</body>

</html>
