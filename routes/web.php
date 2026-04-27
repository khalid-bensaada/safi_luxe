<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\RoomController as ClientRoomController;
use App\Http\Controllers\Client\ReservationController as ClientReservationController;
use App\Http\Controllers\Client\CommentController as ClientCommentController;


// Public Routes

Route::get('/', function () {
    $rooms = \App\Models\Room::where('status', 'Available')->get();
    return view('welcome', compact('rooms'));
});

// Auth Routes

Route::get('/auth/signup', [AuthController::class, 'showRegister'])->name('register');
Route::post('/auth/signup', [AuthController::class, 'register']);

Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Client Routes 

Route::middleware(['auth'])->group(function () {
    Route::get('/client/rooms', [ClientRoomController::class, 'index'])->name('client.rooms');
    Route::get('/client/details/{id}', [ClientRoomController::class, 'details'])->name('client.details');
    Route::get('/client/reservations', [ClientReservationController::class, 'index'])->name('client.reservations');
    Route::post('/client/reservations', [ClientReservationController::class, 'store'])->name('client.reservations.store');
    Route::get('/client/pay', function () {
        return view('client.pay');
    })->name('client.pay');
    Route::post('/client/comment', [ClientCommentController::class, 'store'])->name('client.comment.store');
    Route::put('/client/reservations/{id}/cancel', [ClientReservationController::class, 'cancel'])->name('client.reservations.cancel');

    Route::get('/client/payments',                [PaymentController::class, 'index'])->name('client.payments.index');
    Route::get('/client/payments/{reservation}',  [PaymentController::class, 'show'])->name('client.payments.show');
    Route::post('/client/payments',               [PaymentController::class, 'store'])->name('client.payments.store');
    Route::delete('/client/payments/{id}',        [PaymentController::class, 'destroy'])->name('client.payments.destroy');

    Route::get('/client/profile',                  [ProfileController::class, 'index'])->name('client.profile');
    Route::put('/client/profile',                  [ProfileController::class, 'update'])->name('client.profile.update');
    Route::put('/client/profile/password',         [ProfileController::class, 'updatePassword'])->name('client.profile.password');
    Route::delete('/client/profile',               [ProfileController::class, 'destroy'])->name('client.profile.destroy');
});


// Admin Routes 

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Rooms
    Route::get('/adminroom', [AdminRoomController::class, 'index'])->name('admin.rooms');
    Route::post('/adminroom', [AdminRoomController::class, 'store'])->name('admin.rooms.store');
    Route::get('/adminroom/{id}/edit', [AdminRoomController::class, 'edit'])->name('admin.rooms.edit');
    Route::put('/adminroom/{id}', [AdminRoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('/adminroom/{id}', [AdminRoomController::class, 'destroy'])->name('admin.rooms.destroy');

    // Reservations
    Route::get('/reservation', [AdminReservationController::class, 'index'])->name('admin.reservations');
    Route::put('/reservation/{id}', [AdminReservationController::class, 'updateStatus'])->name('admin.reservations.status');

    // Comments
    Route::get('/comment', [AdminCommentController::class, 'index'])->name('admin.comments');
    Route::delete('/comment/{id}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');
    Route::put('/comment/{id}', [AdminCommentController::class, 'updateStatus'])->name('admin.comments.status');
});
