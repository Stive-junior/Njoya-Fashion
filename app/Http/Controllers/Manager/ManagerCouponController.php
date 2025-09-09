<?php 
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Coupons as Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('manager.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'code' => 'required|string|max:20|unique:coupons,code',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after:valid_from',
                'max_uses' => 'nullable|integer|min:1',
            ]);

            Coupon::create($request->all());

            DB::commit();
            return redirect()->route('manager.coupons.index')->with('success', 'Coupon créé');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création');
        }
    }

    public function update(Request $request, Coupon $coupon)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'code' => 'required|string|max:20|unique:coupons,code,' . $coupon->id,
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after:valid_from',
                'max_uses' => 'nullable|integer|min:1',
            ]);

            $coupon->update($request->all());

            DB::commit();
            return redirect()->route('manager.coupons.index')->with('success', 'Coupon mis à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour');
        }
    }

    public function destroy(Coupon $coupon)
    {
        DB::beginTransaction();

        try {
            $coupon->delete();
            DB::commit();
            return redirect()->route('manager.coupons.index')->with('success', 'Coupon supprimé');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression');
        }
    }
}
?>