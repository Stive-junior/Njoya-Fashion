<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Categories as Category;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('manager.categories.index', compact('categories'));
    }

    public function show(){

        return view('home');

    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
            ]);

            Category::create($request->only('name', 'description'));

            DB::commit();
            return redirect()->route('manager.categories.index')->with('success', 'Catégorie créée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création');
        }
    }

    public function update(Request $request, Category $category)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string',
            ]);

            $category->update($request->only('name', 'description'));

            DB::commit();
            return redirect()->route('manager.categories.index')->with('success', 'Catégorie mise à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour');
        }
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();

        try {
            $category->delete();
            DB::commit();
            return redirect()->route('manager.categories.index')->with('success', 'Catégorie supprimée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression');
        }
    }


    public function getSubcategories($parentId)
    {
        $categories = Categories::where('parent_id', $parentId)
            ->where('status', 1)
            ->orderBy('order')
            ->get();
            
        return response()->json($categories);
    }
}