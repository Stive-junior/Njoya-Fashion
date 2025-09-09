<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payement_methods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;




class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = Payement_methods::paginate(10);
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function store(StorePaymentMethodRequest $request)
    {
        DB::beginTransaction();

        try {
            $paymentMethod = Payement_methods::create($request->validated());

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('payment-methods', 'public');
                $paymentMethod->update(['logo' => $path]);
            }

            DB::commit();
            return redirect()->route('admin.payment-methods.index')->with('success', 'Méthode ajoutée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création');
        }
    }

    public function update(UpdatePaymentMethodRequest $request, Payement_methods $paymentMethod)
    {
        DB::beginTransaction();

        try {
            $oldLogo = $paymentMethod->logo;
            $paymentMethod->update($request->validated());

            if ($request->hasFile('logo')) {
                Storage::disk('public')->delete($oldLogo);
                $path = $request->file('logo')->store('payment-methods', 'public');
                $paymentMethod->update(['logo' => $path]);
            }

            DB::commit();
            return back()->with('success', 'Méthode mise à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur de mise à jour');
        }
    }

    public function destroy(Payement_methods $paymentMethod)
    {
        DB::beginTransaction();

        try {
            if ($paymentMethod->logo) {
                Storage::disk('public')->delete($paymentMethod->logo);
            }
            
            $paymentMethod->delete();
            DB::commit();
            return back()->with('success', 'Méthode supprimée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Impossible de supprimer une méthode utilisée');
        }
    }
}