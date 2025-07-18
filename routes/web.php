<?php

use Cone\Laravel\Auth\Http\Controllers\ConfirmPasswordController;
use Cone\Laravel\Auth\Http\Controllers\ForgotPasswordController;
use Cone\Laravel\Auth\Http\Controllers\LoginController;
use Cone\Laravel\Auth\Http\Controllers\RegisterController;
use Cone\Laravel\Auth\Http\Controllers\ResetPasswordController;
use Cone\Laravel\Auth\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Reset
Route::get('/password/reset', [ForgotPasswordController::class, 'show'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'send'])->name('password.email');
Route::get('/password/reset/{token}/{email}', [ResetPasswordController::class, 'show'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Verify
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.show');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Confirm
Route::get('/password/confirm', [ConfirmPasswordController::class, 'show'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);
