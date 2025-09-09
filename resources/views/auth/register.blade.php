@extends('layouts.app')

@section('content')

@if(session('error'))
    @include('error', ['type' => 'error', 'message' => ''])
@endif

@if(session('success'))
    @include('error', ['type' => 'success', 'message' => session('success')])
@endif


<div class="register-section">


    <div class="marketing-section2">
  
        <div class="video-background">
            <video autoplay loop muted>
                <source src="{{ asset('images/boutique.mp4') }}" type="video/mp4">
                Votre navigateur ne supporte pas la vidéo.
            </video>
 
            <div class="video-overlay"></div>
        </div>

        <div class="marketing-content">
            <h1>Rejoignez Notre Monde Fashion !</h1>
            <p>Profitez d'offres exclusives et d'une expérience unique à travers une plateforme élégante et moderne.</p>
            <a href="{{ route('login') }}" ><button class="animated-button">Connectez Vous</button></a>
        </div>
    </div>


    <div class="form-section">
        <h2 class="text-start" style="color: #333; font-size: 28px; font-weight: bold; margin-bottom: 20px; animation: slideInRight 1s ease-in-out;">Inscription Client</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" style="width: 100%; max-width: 600px;">
            @csrf
            @method('POST')

          
            <div class="profile-picture-container">
                <div class="profile-picture-frame" onclick="document.getElementById('profile_picture').click();">
            
                    <i class="fas fa-camera camera-icon"></i>
                    
           
                    <img 
                        id="profile-preview" 
                        src="{{ asset('images/logo.png') }}" 
                        alt=" " 
                        class="profile-image" 
                    />
                    

                    <input 
                        id="profile_picture" 
                        type="file" 
                        name="profile_picture" 
                        accept="image/*" 
                        class="hidden-input" 
                        required 
                        onchange="previewProfilePicture(event)" 
                    />
                </div>
                <x-input-error :messages="$errors->get('profile_picture')" class="error-message" />
            </div>

    
            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label for="name">Nom</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus class="form-input" />
                    <x-input-error :messages="$errors->get('name')" class="error-message" />
                </div>
                <div style="flex: 1;">
                    <label for="first_name">Prénom</label>
                    <input id="first_name" type="text" name="first_name" :value="old('first_name')" required class="form-input" />
                    <x-input-error :messages="$errors->get('first_name')" class="error-message" />
                </div>
            </div>

        
            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required class="form-input" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>
                <div style="flex: 1;">
                    <label for="phone">Téléphone</label>
                    <input id="phone" type="tel" name="phone" :value="old('phone')" required class="form-input" />
                    <x-input-error :messages="$errors->get('phone')" class="error-message" />
                </div>
            </div>

          

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                
                <label for="gender">Sexe</label>
                <div class="justify-content-around" style="display: flex; gap: 10px;">
                    <div>
                        <input id="male" type="radio" name="sexe" value="M" required aria-selected="male" />
                        <label for="male">Homme</label>
                    </div>
                    <div>
        <input id="female" type="radio" name="sexe" value="F" required />
        <label for="female">Femme</label>
    </div>
</div>
        
                    <x-input-error :messages="$errors->get('sexe')" class="error-message" />
                </div>
                <div style="flex: 1;">

                <label for="country">Pays</label>
                    <select id="country" name="country" class="form-input">
                        <option value="Cameroun">Cameroun</option>
                    </select>
                    <x-input-error :messages="$errors->get('country')" class="error-message" />

                

                    
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                   <label for="city">Ville</label>
                    <select id="city" name="city" class="form-input" onchange="updateQuartiers()">
                        <option value="Douala">Douala</option>
                        <option value="Yaoundé">Yaoundé</option>
                        <option value="Bafoussam">Bafoussam</option>
                    
                    </select>
                    <x-input-error :messages="$errors->get('city')" class="error-message" />
                
                </div>
                <div style="flex: 1;">
                    
                 <label for="quartier">Quartier</label>
                    <select id="quartier" name="street" class="form-input">
                        <option value="">Selectionnez votre Quartier</option>
                      
                    </select>
                    <x-input-error :messages="$errors->get('street')" class="error-message" />

                   

                </div>
            </div>

           
            <div class="d-flex mb-3" style="gap: 20px;">
                <div style="flex: 1;">
                    <label for="password">Mot de Passe</label>
                    <input id="password" type="password" name="password" required class="form-input" />
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>
                <div style="flex: 1;">
                    <label for="password_confirmation">Confirmez le Mot de Passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input" oninput="validatePassword()" />
                    <div id="password-match-error" style="color: red; font-size: 12px; display: none;">Les mots de passe ne correspondent pas.</div>
                </div>
            </div>


      
            <div style="text-align: center;">
                <button type="submit" class="btn-primary">S'inscrire</button>
            </div>
        </form>

        <div style="margin-top: 20px; text-align: center;">
            <p style="color: var(--text-muted); font-size: 14px;">
              Déjà un compte ?
                <a href="{{ route('login') }}" style="color: var(--or-metallise); text-decoration: none;">Connectez-vous</a>
            </p>
        </div>
    </div>
</div>

<script>
    function previewProfilePicture(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }


    function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const errorDiv = document.getElementById('password-match-error');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        if (password !== confirmPassword) {
            errorDiv.style.display = 'block';
            confirmPasswordInput.setCustomValidity('Les mots de passe ne correspondent pas.');
        } else {
            errorDiv.style.display = 'none';
            confirmPasswordInput.setCustomValidity('');
        }
    }


    function updateQuartiers() {
        const city = document.getElementById('city').value;
        const quartierSelect = document.getElementById('quartier');
        quartierSelect.innerHTML = '';

        const quartiers = {
            Douala: ['Bonabéri', 'Bonamoussadi', 'Akwa', 'Deido'],
            Yaoundé: ['Bastos', 'Mokolo', 'Elig-Essono', 'Nkolbisson'],
            Bafoussam: ['Banengo', 'Bamendzi', 'Djeleng']
        };

        quartiers[city].forEach(quartier => {
            const option = document.createElement('option');
            option.value = quartier;
            option.textContent = quartier;
            quartierSelect.appendChild(option);
        });
    }

    updateQuartiers();
</script>

@endsection