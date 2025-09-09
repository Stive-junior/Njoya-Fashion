<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

        <title>{{ config('app.name', 'Njoya') }}</title>

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
      
        @vite(['resources/js/app.js', 'resources/css/style.css','resources/css/app.css', 'resources/css/login.css','resources/css/styles.css','resources/css/categorie.css'])

        <script>
          
document.addEventListener('DOMContentLoaded', function() {
   

 
    if (window.performance) {
  
        if (performance.navigation.type === 2) { 
            window.location.reload();
        }
    }
});
</script>
    </head>
    
    <body class="body font-sans text-gray-900 " data-menu-version="v2" data-menu-responsive="true">
       
        @if(auth()->check())
            @include('layouts.navigation') 
        @else
            @include('layouts.navigation-guest')
        @endif

       
  
       <main>
@if ($errors->any())
  
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Erreur',
                    html: `<ul class="text-center">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            });
        </script>

@endif

@if(session('error'))

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Erreur',
                    html: `<h3 class="text-center">{{ session('error') }}</h3>`,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            });
        </script>

    @php session()->forget('error'); @endphp
@endif

@yield('content')


@include('partials.menu-btn')

       </main>

        <!-- Footer -->
        @include('layouts.footer')

<!-- Bootstrap JS (avec Popper.js inclus) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </body>
</html>


