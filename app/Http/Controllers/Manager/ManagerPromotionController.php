<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Promotions as Promotion;
use App\Models\Categories as Category; // Si les promotions s'appliquent à des catégories
use App\Models\Article;  // Si les promotions s'appliquent à des produits
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;

class ManagerPromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('target')->paginate(10);
        return view('manager.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $categories = Category::all(); // Si les promotions s'appliquent à des catégories
        $articles = Article::all();   // Si les promotions s'appliquent à des produits
        return view('manager.promotions.create', compact('categories', 'articles'));
    }

    public function store(StorePromotionRequest $request)
    {
        DB::beginTransaction();

        try {
            $promotion = Promotion::create($request->validated());

            // Associer la promotion à une cible (catégorie ou produit)
            if ($request->applies_to !== 'all') {
                if ($request->applies_to === 'category') {
                    $target = Category::findOrFail($request->target_id);
                } elseif ($request->applies_to === 'product') {
                    $target = Article::findOrFail($request->target_id);
                }

                if ($target) {
                    $promotion->target()->associate($target);
                    $promotion->save();
                }
            }

            DB::commit();
            return redirect()->route('manager.promotions.index')->with('success', 'Promotion créée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function edit(Promotion $promotion)
    {
        $categories = Category::all(); // Si les promotions s'appliquent à des catégories
        $articles = Article::all();   // Si les promotions s'appliquent à des produits
        return view('manager.promotions.edit', compact('promotion', 'categories', 'articles'));
    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        DB::beginTransaction();

        try {
            // Vérifier si la promotion est active
            if ($promotion->isActive()) {
                return back()->with('error', 'Modification interdite pendant la période active');
            }

            $promotion->update($request->validated());

            // Mettre à jour la cible de la promotion
            if ($request->applies_to !== 'all') {
                if ($request->applies_to === 'category') {
                    $target = Category::findOrFail($request->target_id);
                } elseif ($request->applies_to === 'product') {
                    $target = Article::findOrFail($request->target_id);
                }

                if ($target) {
                    $promotion->target()->associate($target);
                    $promotion->save();
                }
            } else {
                // Si la promotion s'applique à tous, dissocier la cible
                $promotion->target()->dissociate();
                $promotion->save();
            }

            DB::commit();
            return redirect()->route('manager.promotions.index')->with('success', 'Promotion mise à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy(Promotion $promotion)
    {
        DB::beginTransaction();

        try {
            // Vérifier si la promotion est active
            if ($promotion->isActive()) {
                return back()->with('error', 'Impossible de supprimer une promotion active');
            }

            $promotion->delete();
            DB::commit();
            return redirect()->route('manager.promotions.index')->with('success', 'Promotion supprimée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}