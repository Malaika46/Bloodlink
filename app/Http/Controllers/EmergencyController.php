<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyRequest;
use App\Models\Donor;

class EmergencyController extends Controller
{
    public function index(Request $request)
    {
        $status    = $request->get('status', 'pending');
        $bloodType = $request->get('blood_type');
        $city      = $request->get('city');

        $requests = EmergencyRequest::query()
            ->when($status,    fn($q) => $q->where('status', $status))
            ->when($bloodType, fn($q) => $q->where('blood_type', $bloodType))
            ->when($city,      fn($q) => $q->where('city', $city))
            ->latest()
            ->get();

        return view('emergency.index', compact('requests'));
    }

    public function form()
    {
        return view('emergency.form');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'patient_name'  => 'required|string|max:255',
            'blood_type'    => 'required|string',
            'units'         => 'required|integer|min:1',
            'urgency'       => 'required|in:critical,urgent,normal',
            'hospital_name' => 'required|string|max:255',
            'city'          => 'required|string',
            'contact_name'  => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'age'           => 'nullable|integer',
            'ward'          => 'nullable|string|max:100',
            'notes'         => 'nullable|string|max:1000',
        ]);

        EmergencyRequest::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('emergency.form')
            ->with('success', '🚨 Emergency request broadcast to all donors in ' . $validated['city'] . '!');
    }

    public function accept(Request $request, EmergencyRequest $emergencyRequest)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $emergencyRequest->status = 'fulfilled';
        $emergencyRequest->save();

        return response()->json(['success' => true]);
    }
}
