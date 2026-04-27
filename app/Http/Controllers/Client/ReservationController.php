<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    
    public function index()
    {
        $reservations = Reservation::with('room')
            ->where('user_id', Auth::id())
            ->get();

        return view('client.reservations', compact('reservations'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'room_id'       => 'required|exists:rooms,id',
            'start_Reserve' => 'required|date|after_or_equal:today',
            'end_Reserv'    => 'required|date|after:start_Reserve',
        ]);

    
        $room = Room::findOrFail($request->room_id);

        if ($room->status !== 'Available') {
            return back()->withErrors(['room_id' => 'This room is not available.']);
        }

        
        Reservation::create([
            'user_id'       => Auth::id(),
            'room_id'       => $request->room_id,
            'start_Reserve' => $request->start_Reserve,
            'end_Reserv'    => $request->end_Reserv,
            'status'        => 'Pending',
        ]);

        
        $room->update(['status' => 'Booked']);

        return redirect()->route('client.reservations')->with('success', 'Reservation created successfully!');
    }

    
    public function cancel($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->update(['status' => 'Cancelled']);

        
        $reservation->room->update(['status' => 'Available']);

        return redirect()->route('client.reservations')->with('success', 'Reservation cancelled!');
    }
}
