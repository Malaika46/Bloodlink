<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;

class DonorController extends Controller
{
    public function find(Request $request)
    {
        $bloodType = $request->get('blood_type');
        $city      = $request->get('city');
        $available = $request->get('available');

        $donors = Donor::with('user')
            ->when($bloodType, fn($q) => $q->where('blood_type', $bloodType))
            ->when($city,      fn($q) => $q->where('city', $city))
            ->when($available, fn($q) => $q->where('is_available', true))
            ->latest()
            ->get();

        return view('donor.find', compact('donors'));
    }

    public function toggleAvailability(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->is_available = $request->available;
            $user->save();

            // Update donor table too
            $donor = Donor::where('user_id', $user->id)->first();
            if ($donor) {
                $donor->is_available = $request->available;
                $donor->save();
            }

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }
}
