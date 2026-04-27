<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Comment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms          = Room::count();
        $totalReservations   = Reservation::count();
        $pendingReservations = Reservation::where('status', 'Pending')->count();
        $totalClients        = User::where('role', 'client')->count();
        $totalComments       = Comment::count(); // ✅
        $rooms               = Room::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'totalReservations',
            'pendingReservations',
            'totalClients',
            'totalComments',
            'rooms'
        ));
    }
}
