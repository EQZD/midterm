<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ── Public (guest) routes ──────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'handleLogin'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Super Admin ────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    Route::get('/roles',             [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{role}',      [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}',      [RoleController::class, 'update'])->name('roles.update');
});

// ── Manager ────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin,manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'manager'])->name('dashboard');
    Route::get('/reports',   fn () => view('manager.reports'))->name('reports');
});

// ── Staff ──────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin,manager,staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staff'])->name('dashboard');
});

// ── Member (own profile only) ──────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin,manager,staff,member'])->group(function () {
    Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
});

// ── Member CRUD ────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin,manager,staff'])->group(function () {
    Route::get('/members',          [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create',   [MemberController::class, 'create'])->name('members.create');
    Route::post('/members',         [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
});

Route::middleware(['auth', 'role:super_admin,manager'])->group(function () {
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}',      [MemberController::class, 'update'])->name('members.update');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
});

// ── Fallback landing ───────────────────────────────────────────────────────

Route::get('/main', [AuthController::class, 'showMain'])->name('main')->middleware('auth');

// ── File Upload ────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin,manager,staff'])->group(function () {
    Route::post('/members/{member}/files',   [\App\Http\Controllers\FileController::class, 'store'])->name('files.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/files/{file}/download',     [\App\Http\Controllers\FileController::class, 'download'])->name('files.download');
});

Route::middleware(['auth', 'role:super_admin,manager'])->group(function () {
    Route::delete('/files/{file}',           [\App\Http\Controllers\FileController::class, 'destroy'])->name('files.destroy');
});

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    return match (true) {
        $user->isSuperAdmin() => redirect()->route('admin.dashboard'),
        $user->isManager()    => redirect()->route('manager.dashboard'),
        $user->isStaff()      => redirect()->route('staff.dashboard'),
        default               => redirect()->route('member.profile'),
    };
})->middleware('auth');