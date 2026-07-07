<?php

namespace App\Http\Controllers\Web\Coupon;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class CouponController extends Controller
{
    public function create()
    {
        return view('coupon.coupon-create');
    }
    // Store new coupon
    public function store(Request $request)
    {
        // Defensive check: if the coupons table is missing, return helpful message
        if (!Schema::hasTable('coupons')) {
            return back()->withErrors(['migration' => 'Database table `coupons` not found. Run `php artisan migrate` to create it.']);
        }
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:0',
            'per_user_limit' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',

        ]);

        Coupon::create(array_merge(
            $request->only([
                'code',
                'description',
                'type',
                'value',
                'min_amount',
                'max_discount',
                'usage_limit',
                'per_user_limit',
                'start_date',
                'end_date',
                'start_time',
                'end_time',
                'status'
            ]),
            ['created_by' => Auth::id()]
        ));

        return redirect()->route('coupon.table')->with('success', 'Coupon created successfully!');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);

        // Toggle 1 ↔ 0
        $coupon->status = $coupon->status == 1 ? 0 : 1;
        $coupon->save();
        return redirect()->route('coupon.table')->with('success', 'Coupon status updated successfully!');

    }

    public function view($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('coupon.coupon-view', compact('coupon'));
    }

    public function delete($id)
    {
        // Find and delete the customer directly
        Coupon::destroy($id); // This deletes the customer by ID
        return redirect()->route('coupon.table')->with('success', 'Coupon deleted successfully!');
    }
    public function table(Request $request)
    {
        // ✅ Auto-deactivate expired coupons before displaying
        $now = now('Asia/Kolkata');

        // Get all active coupons that might be expired
        $activeCoupons = Coupon::where('status', 1)->get();
        foreach ($activeCoupons as $coupon) {
            $isExpired = false;

            if ($coupon->end_date) {
                // Get end_date as Y-m-d string
                $endDateStr = $coupon->end_date instanceof \Carbon\Carbon
                    ? $coupon->end_date->format('Y-m-d')
                    : date('Y-m-d', strtotime($coupon->end_date));

                // Build full end datetime string
                $endTimeStr = $coupon->end_time ? date('H:i:s', strtotime($coupon->end_time)) : '23:59:59';
                $endDateTimeStr = $endDateStr . ' ' . $endTimeStr;

                $endDateTime = \Carbon\Carbon::parse($endDateTimeStr, 'Asia/Kolkata');

                // If current time is past the end datetime, mark as expired
                if ($now->gt($endDateTime)) {
                    $isExpired = true;
                }
            }

            // Auto set to inactive if expired - use direct DB update
            if ($isExpired) {
                \DB::table('coupons')->where('id', $coupon->id)->update(['status' => 0]);
            }
        }

        $query = Coupon::latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('code', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination with 10 items per page
        $coupons = $query->paginate(10);

        // Send to view with correct variable name
        return view('coupon.coupon-table', [
            'coupons' => $coupons,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    // CouponController.php



    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('coupon.coupon-edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        // Backend validation
        $request->validate([
            'code' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $coupon = Coupon::findOrFail($id);

        $coupon->update([
            'code' => $request->code,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_amount' => $request->min_amount,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'per_user_limit' => $request->per_user_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // ✅ Auto-activate if new end_date/time is still in the future
        $now = now('Asia/Kolkata');
        if ($request->end_date) {
            $endDateStr = date('Y-m-d', strtotime($request->end_date));
            $endTimeStr = $request->end_time ? date('H:i:s', strtotime($request->end_time)) : '23:59:59';
            $endDateTime = \Carbon\Carbon::parse($endDateStr . ' ' . $endTimeStr, 'Asia/Kolkata');

            if ($now->lt($endDateTime)) {
                \DB::table('coupons')->where('id', $coupon->id)->update(['status' => 1]);
            }
        }

        return redirect()->route('coupon.table')->with('success', 'Coupon updated successfully!');
    }


    public function apply(Request $request)
    {
        $code = $request->code;

        $coupon = Coupon::where('code', $code)
            ->where('status', 1)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.']);
        }

        // Check time validity (start_time and end_time)
        $currentTime = now()->format('H:i:s');
        if ($coupon->start_time && $coupon->end_time) {
            $startTime = date('H:i:s', strtotime($coupon->start_time));
            $endTime = date('H:i:s', strtotime($coupon->end_time));

            if ($currentTime < $startTime || $currentTime > $endTime) {
                return response()->json(['success' => false, 'message' => 'Coupon is not active at this time. Valid hours: ' . date('h:i A', strtotime($coupon->start_time)) . ' - ' . date('h:i A', strtotime($coupon->end_time))]);
            }
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'Coupon usage limit reached.']);
        }
        // ----------------------------
// 👉 PER USER LIMIT CHECK 
// ----------------------------
        $userId = auth()->check() ? auth()->id() : null;

        if ($coupon->per_user_limit) {
            $userUsage = \DB::table('coupon_user')->where([
                'coupon_id' => $coupon->id,
                'user_id' => $userId
            ])->count();

            if ($userUsage >= $coupon->per_user_limit) {
                return response()->json(['success' => false, 'message' => 'You already used this coupon.']);
            }
        }

        // Calculate discount based on type
        $cart_total = session('cart_total', 0); // get cart total
        if ($coupon->type == 'percentage') {
            $discount = ($cart_total * $coupon->value) / 100;
            if ($coupon->max_discount && $discount > $coupon->max_discount) {
                $discount = $coupon->max_discount;
            }
        } else {
            $discount = $coupon->value;
        }

        // Ensure min_amount requirement
        if ($coupon->min_amount && $cart_total < $coupon->min_amount) {
            return response()->json(['success' => false, 'message' => 'Cart total not enough for this coupon.']);
        }

        // Store discount info in session
        session(['applied_coupon' => $coupon->id, 'discount_amount' => $discount]);

        return response()->json(['success' => true, 'discount' => $discount]);
    }

}