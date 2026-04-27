<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.adminroom', compact('rooms'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'numberRoom'  => 'required|integer',
            'prixRoom'    => 'required|numeric',
            'status'      => 'required|in:Available,Booked,Maintenance',
            'imageRoom'   => 'nullable|image',
            'description' => 'nullable|string',
        ]);

        $data = $request->only('numberRoom', 'prixRoom', 'status', 'description');


        if ($request->hasFile('imageRoom')) {
            $path = $request->file('imageRoom')->store('rooms', 'public');
            $data['imageRoom'] = asset('storage/' . $path);
        }

        Room::create($data);

        return redirect()->route('admin.rooms')->with('success', 'Room added successfully!');
    }


    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.Updateroom', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $data = $request->only(['numberRoom', 'prixRoom', 'status', 'description']);

        if ($request->hasFile('imageRoom')) {
            $path = $request->file('imageRoom')->store('rooms', 'public');
            $data['imageRoom'] = asset('storage/' . $path);
        }

        $room->update($data);
        return redirect('/admin/adminroom')->with('success', 'Room updated successfully!');
    }


    public function destroy($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route('admin.rooms')->with('success', 'Room deleted successfully!');
    }
}
