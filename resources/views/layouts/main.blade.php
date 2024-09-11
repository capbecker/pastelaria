<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title');</title>

        <link rel='stylesheet' href='../css/styles.css'>
        <link rel='stylesheet' href='../css/header.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'>        
        <script src='/js/scripts.js'></script>
    </head>
    <body >
        <header>
        
            <nav>
                <a href="/cliente">Cliente</a>
                <a href="/produto">Produto</a>
                <a href="/pedido">Pedido</a>
            </nav>
       </header>
       @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
       @endif
       @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
       @endif
       @yield('content')
    </body>
</html>
