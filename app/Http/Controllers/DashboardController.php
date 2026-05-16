<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyRequest;
use App\Models\Donor;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch REAL incoming requests matching donor's blood type and city
        $requests = EmergencyRequest::where('blood_type', $user->blood_type)
            ->where('city', $user->city)
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        // All pending requests for this city (for donors to respond)
        $allCityRequests = EmergencyRequest::where('city', $user->city)
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $isDonor = Donor::where('user_id', $user->id)->exists();

        return view('dashboard.index', compact('requests', 'allCityRequests', 'isDonor'));
    }

    public function becomeDonor()
    {
        $user = auth()->user();
        $user->is_available = true;
        $user->save();

        Donor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'blood_type'   => $user->blood_type,
                'city'         => $user->city,
                'phone'        => $user->phone,
                'is_available' => true,
                'donations_count' => 0,
            ]
        );

        return redirect()->route('dashboard')->with('success', '🩸 You are now listed as a donor!');
    }
}
