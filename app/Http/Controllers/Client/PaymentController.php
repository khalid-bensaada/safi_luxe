<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('reservation.room')
            ->whereHas('reservation', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('client.payments', compact('payments'));
    }

    public function show($reservationId)
    {
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->with('room')
            ->firstOrFail();

        return view('client.payment', compact('reservation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();


        $days  = $reservation->start_Reserve->diffInDays($reservation->end_Reserv);
        $price = $days * $reservation->room->prixRoom;

        Payment::create([
            'reservation_id' => $reservation->id,
            'prixP'          => $price,
        ]);

        return back()->with('success', 'Payment of $' . $price . ' confirmed!');
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return back()->with('success', 'Payment deleted.');
    }
}
