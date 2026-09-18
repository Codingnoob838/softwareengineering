<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MemberDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('auth.login'));

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/dashboard', [MemberDashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('/admin/members', [AdminDashboardController::class, 'members'])->middleware(['auth', 'admin'])->name('admin.members');
Route::get('/admin/check-ins', [AdminDashboardController::class, 'checkIns'])->middleware(['auth', 'admin'])->name('admin.check-ins');
Route::get('/admin/memberships', [AdminDashboardController::class, 'memberships'])->middleware(['auth', 'admin'])->name('admin.memberships');
Route::patch('/admin/members/{user}/approve', [AdminDashboardController::class, 'approve'])->middleware(['auth', 'admin'])->name('admin.members.approve');
Route::get('/admin/members/{user}/edit', [AdminDashboardController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.members.edit');
Route::put('/admin/members/{user}', [AdminDashboardController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.members.update');
Route::delete('/admin/members/{user}', [AdminDashboardController::class, 'remove'])->middleware(['auth', 'admin'])->name('admin.members.remove');
