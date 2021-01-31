<!doctype html>
<html>
    <head>
        <title>Test Index</title>
        <meta charset=UTF-8>
    </head>
    <body></body>
        <div>
            <h1>CE.D Index</h1>
            <div id=content>
            C'est ici que j'insèrerai ta maquette @esteban<br>
            @if (Route::has('login'))
                @auth
                    Là t'es connecté donc tu peux aller sur ton <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    Tu peux te connecter au backend <a href="{{ route('login') }}">ici</a>
                @endauth
            @endif
            </div>
        </div>
    </body>
</html>