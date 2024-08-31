<header class="container position-sticky top-0 py-3" style="background: #fff">
    <div class="position-relative">
        <div class="p-0">
            <h1 cl>TO-DO</h1>
        </div>
        @auth
        <div class="position-absolute end-0 top-0 px-2">
            <a href="{{route('logout')}}" class="text-decoration-underline text-black">Cerrar sesión</a>
        </div>
        @endauth
    </div>
</header>
