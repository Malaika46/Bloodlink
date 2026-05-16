<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyRequest;
use App\Models\Donor;

class HomeController extends Controller
{
    public function index()
    {
        $totalDonors    = Donor::where('is_available', true)->count();
        $totalRequests  = EmergencyRequest::count();
        $latestRequests = EmergencyRequest::where('status', 'pending')
            ->latest()->take(3)->get();

        return view('home.index', compact('totalDonors', 'totalRequests', 'latestRequests'));
    }
}
