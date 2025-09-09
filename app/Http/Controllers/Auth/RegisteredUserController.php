<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Adresses;
use App\Models\Categories;
use App\Models\Images_user;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Assure-toi que c'est bien importé
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
         $categories = Categories::with(['children' => function($query) {
            $query->where('status', 1)->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('order')
        ->get();

        return view('auth.register', compact('categories'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Initialise $imagePath à null pour le bloc catch
        $imagePath = null; 

        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'first_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', Rules\Password::defaults(), 'confirmed'],
                'phone' => ['required', 'string', 'max:15', 'regex:/^\+?[0-9]{7,15}$/'],
                'profile_picture' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:21048'],
                'street' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'sexe' => ['required', 'string','max:10'],
                'country' => ['required', 'string', 'max:255'],
            ]);

            $fullName = $validatedData['name'] . ' ' . $validatedData['first_name'];

            $user = User::create([
                'name' => $fullName,
                'email' => $validatedData['email'],
                'sexe' => $validatedData['sexe'],
                'password' => Hash::make($validatedData['password']),
                'number' => $validatedData['phone'],
            ]);

            if (!empty($validatedData['profile_picture'])) {
                $extension = $validatedData['profile_picture']->getClientOriginalExtension();
                $imageName = Str::slug($validatedData['name'].'-'.$validatedData['first_name']) 
                             . '-profile-' . time() . '.' . $extension;

                
                $imagePath = $validatedData['profile_picture']->storeAs(
                    'profile',
                    $imageName,
                    'public'
                );

                Images_user::create([
                    'user_id' => $user->id,
                    'url' => $imagePath,
                ]);
            }
           
            Adresses::create([
                'user_id' => $user->id,
                'street' => $validatedData['street'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
            ]);

            $clientRole = Role::firstOrCreate(['name' => 'client']);
        
            if (!method_exists($user, 'roles')) {
                throw new \Exception("La relation roles() n'existe pas dans le modèle User.");
            }
         
            $user->roles()->attach($clientRole->id);
      
            DB::commit();
          
            event(new Registered($user));
            Auth::login($user);

            if (session('cart')) {
                return redirect()->route('checkout')
                    ->with('success', 'Compte créé avec succès! Veuillez vérifier votre panier.');
            }

            return redirect()->route('client.dashboard');
            
        } catch (Throwable $e) {
            DB::rollBack();

            // Si l'image a été stockée avant l'erreur de transaction, supprime-la
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }
}