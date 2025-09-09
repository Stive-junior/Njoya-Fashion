<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Models\Livreur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


    class ManagerLivreurController extends Controller
{
    public function index()
    {
        $livreurs = Livreur::paginate(10);
        return view('admin.livreurs.index', compact('livreurs'));
    }

    public function store(StoreLivreurRequest $request)
    {
        DB::beginTransaction();

        try {
            $livreur = Livreur::create($request->validated());

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('livreurs', 'public');
                $livreur->update(['photo' => $path]);
            }

            DB::commit();
            return redirect()->route('admin.livreurs.index')->with('success', 'Livreur ajouté');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création');
        }
    }

    public function update(UpdateLivreurRequest $request, Livreur $livreur)
    {
        DB::beginTransaction();

        try {
            $oldPhoto = $livreur->photo;
            $livreur->update($request->validated());

            if ($request->hasFile('photo')) {
                Storage::disk('public')->delete($oldPhoto);
                $path = $request->file('photo')->store('livreurs', 'public');
                $livreur->update(['photo' => $path]);
            }

            DB::commit();
            return back()->with('success', 'Livreur mis à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur de mise à jour');
        }
    }

    public function destroy(Livreur $livreur)
    {
        DB::beginTransaction();

        try {
            if ($livreur->photo) {
                Storage::disk('public')->delete($livreur->photo);
            }
            
            $livreur->delete();
            DB::commit();
            return back()->with('success', 'Livreur supprimé');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Impossible de supprimer un livreur avec des livraisons');
        }
    }
}
