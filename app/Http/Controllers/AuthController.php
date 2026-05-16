<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Donor;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'blood_type' => 'required|string',
            'city'       => 'required|string',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name'      => $validated['first_name'],
            'last_name'       => $validated['last_name'],
            'name'            => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'           => $validated['email'],
            'blood_type'      => $validated['blood_type'],
            'city'            => $validated['city'],
            'phone'           => $validated['phone'],
            'password'        => Hash::make($validated['password']),
            'is_available'    => false,
            'donations_count' => 0,
        ]);

        Auth::login($user);

        // Redirect to donor question page FIRST
        return redirect()->route('donor.question');
    }

    public function showDonorQuestion()
    {
        if (!auth()->check()) return redirect()->route('login');
        return view('auth.donor-question');
    }

    public function handleDonorQuestion(Request $request)
    {
        $user = auth()->user();
        $wants = $request->input('wants_donate') === 'yes';

        if ($wants) {
            // Update user as available donor
            $user->is_available = true;
            $user->save();

            // Create donor record
            Donor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'blood_type'      => $user->blood_type,
                    'city'            => $user->city,
                    'phone'           => $user->phone,
                    'is_available'    => true,
                    'donations_count' => 0,
                ]
            );

            return redirect()->route('dashboard')
                ->with('success', '🩸 You are now listed as a Blood Donor! People in need can find you.');
        } else {
            return redirect()->route('dashboard')
                ->with('success', '✅ Welcome to BloodLink! You can enable donor status anytime from your dashboard.');
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
