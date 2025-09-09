<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Adresses;
use App\Models\Images_user;
use App\Models\User;


class ManagerUserController extends Controller
{
    public function index()
    {
        $users = User::with(['images_user', 'adresses'])->paginate(10);
        return view('manager.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:client,manager',
                'street' => 'nullable|string',
                'city' => 'nullable|string',
                'country' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Gestion de l'adresse
            if ($request->filled(['street', 'city', 'country'])) {
                Adresses::create([
                    'user_id' => $user->id,
                    'street' => $request->street,
                    'city' => $request->city,
                    'country' => $request->country,
                ]);
            }

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('users', 'public');
                Images_user::create([
                    'user_id' => $user->id,
                    'url' => $path,
                ]);
            }

            DB::commit();
            return redirect()->route('manager.users.index')->with('success', 'Utilisateur créé');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création');
        }
    }

    public function update(Request $request, User $user)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|in:client,manager',
                'street' => 'nullable|string',
                'city' => 'nullable|string',
                'country' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Mettre à jour l'utilisateur
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
            ]);

            // Mettre à jour l'adresse
            if ($request->filled(['street', 'city', 'country'])) {
                $address = Adresses::where('user_id', $user->id)->first();
                if ($address) {
                    $address->update([
                        'street' => $request->street,
                        'city' => $request->city,
                        'country' => $request->country,
                    ]);
                } else {
                    Adresses::create([
                        'user_id' => $user->id,
                        'street' => $request->street,
                        'city' => $request->city,
                        'country' => $request->country,
                    ]);
                }
            }

            // Mettre à jour la photo
            if ($request->hasFile('photo')) {
                $oldPhoto = Images_user::where('user_id', $user->id)->first();
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto->url);
                    $oldPhoto->delete();
                }

                $path = $request->file('photo')->store('users', 'public');
                Images_user::create([
                    'user_id' => $user->id,
                    'url' => $path,
                ]);
            }

            DB::commit();
            return redirect()->route('manager.users.index')->with('success', 'Utilisateur mis à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour');
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            // Supprimer la photo
            $photo = Images_user::where('user_id', $user->id)->first();
            if ($photo) {
                Storage::disk('public')->delete($photo->url);
                $photo->delete();
            }

            // Supprimer l'adresse
            Adresses::where('user_id', $user->id)->delete();

            // Supprimer l'utilisateur
            $user->delete();

            DB::commit();
            return redirect()->route('manager.users.index')->with('success', 'Utilisateur supprimé');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression');
        }
    }
}

?>