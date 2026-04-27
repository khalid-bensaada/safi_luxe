<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationController extends Controller
{
    
    public function index()
    {
        $reservations = Reservation::with(['user', 'room'])->get();
        return view('admin.reservation', compact('reservations'));
    }

    
    public function updateStatus($id, \Illuminate\Http\Request $request)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Confirmed,Cancelled',
        ]);

        $reservation->update(['status' => $request->status]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation updated!');
    }
}
