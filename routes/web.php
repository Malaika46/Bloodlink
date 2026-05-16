<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/',       [HomeController::class, 'index'])->name('home');
Route::get('/about',  fn() => view('about.index'))->name('about');

// Donor routes
Route::get('/find-donor', [DonorController::class, 'find'])->name('donor.find');

// Emergency routes
Route::get('/emergency',          [EmergencyController::class, 'form'])->name('emergency.form');
Route::post('/emergency',         [EmergencyController::class, 'submit'])->name('emergency.submit');
Route::get('/emergency/requests', [EmergencyController::class, 'index'])->name('emergency.index');

// Auth routes
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);

Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Donor Question (shown right after registration)
    Route::get('/donor-question',  [AuthController::class, 'showDonorQuestion'])->name('donor.question');
    Route::post('/donor-question', [AuthController::class, 'handleDonorQuestion'])->name('donor.question.submit');

    // Dashboard
    Route::get('/dashboard',        [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/become-donor',    [DashboardController::class, 'becomeDonor'])->name('donor.become');

    // Donor toggle
    Route::post('/donor/toggle-availability', [DonorController::class, 'toggleAvailability'])->name('donor.toggle');

    // Accept emergency
    Route::post('/emergency/{emergencyRequest}/accept', [EmergencyController::class, 'accept'])->name('emergency.accept');
});
