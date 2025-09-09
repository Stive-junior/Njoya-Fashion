@extends('layouts.app')

@section('content')

<div class="login-section">
 
    <div class="marketing-section2 content">
        
        <div class="marketing-content">
            <h1 class="text-center mb-3">Nouveau ?</h1>
            <h1>Rejoignez Notre Monde Doré !</h1>
            <p>Profitez d'offres exclusives et d'une expérience unique à travers une plateforme élégante et moderne.</p>
            <a href="{{ route('register') }}" > <button  class="animated-button">Inscrivez-vous</button></a>
        </div>
    </div>
    
   
    <div class="form-section">

    <img src="{{ asset('images/logo.webp') }}" alt="Logo" style="width: 100px; height: 100px; margin-bottom: 20px;">

        <h2 class="slide-in-right" style="color: var(--primary-dark); font-size: 28px; font-weight: bold;">Connexion</h2>
        <form method="POST" action="{{ route('login') }}" style="width: 100%;  max-width: 400px;">
            @csrf
        <!-- Email -->
            <div style="margin-bottom: 20px;">
                <label for="email" >Email</label>
                <input id="email" type="email" name="email" required class="form-input" />
                @if ($errors->has('email'))
                    <div class="validation-message" style="display: block;">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <div class="validation-message">Veuillez entrer un email valide.</div>
            </div>
            
            <!-- Mot de Passe -->
            <div style="margin-bottom: 20px;">
                <label for="password" >Mot de Passe</label>
                <input id="password" type="password" name="password" required class="form-input" />
                @if ($errors->has('password'))
                    <div class="validation-message" style="display: block;">
                        {{ $errors->first('password') }}
                    </div>
                @endif

                <div class="validation-message">Le mot de passe est requis.</div>
            </div>
            <!-- Se Souvenir de Moi -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <label for="remember_me" style="display: flex; align-items: center; font-size: 14px; color: var(--text-muted);">
                    <input id="remember_me" type="checkbox" name="remember" style="margin-right: 5px;">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: var(--or-metallise); text-decoration: none; font-size: 14px;">Mot de passe oublié ?</a>
                @endif
            </div>
            <!-- Bouton de Connexion -->
             <div style="text-align: center;">
            <button type="submit" class="btn-primary">
                Se Connecter
            </button>
             </div>
        </form>
        <!-- Connexion via Google -->
        <div style="margin-top: 20px; text-align: center;">
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 10px;">Ou connectez-vous avec</p>
            <a href="#" class="animated-button" style="background-color: #FF4D4D; color: #FFFFFF;">
                <i class="fab fa-google" style="margin-right: 5px;"></i> Google
            </a>
        </div>
        <!-- Lien vers l'Inscription -->
        <div style="margin-top: 20px; text-align: center;">
            <p style="color: var(--text-muted); font-size: 14px;">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" style="color: var(--or-metallise); text-decoration: none;">Inscrivez-vous</a>
            </p>
        </div>
    </div>
</div>


@endsection