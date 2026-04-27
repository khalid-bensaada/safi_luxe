<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Reservations | SAFI LUXE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
</head>

<body class="bg-slate-50 text-slate-800 font-[Inter]">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-16 flex justify-between items-center">
            <h1 class="text-xl tracking-widest font-bold text-yellow-800 font-[Playfair_Display]">
                SAFI LUXE
            </h1>

            <div class="hidden md:flex gap-8 text-sm font-medium">
                <a href="/client/rooms" class="text-gray-500 hover:text-yellow-700 transition">Rooms</a>
                <a href="/client/reservations" class="text-yellow-700 border-b-2 border-yellow-700 pb-1">
                    My Reservations
                </a>

                <a href="/client/profile" class="text-gray-500 hover:text-yellow-700 transition">
                    My Profile
                </a>
            </div>


            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-400 hover:text-red-500 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6 md:py-10">

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 font-[Playfair_Display]">
                My Reservations
            </h1>
            <p class="text-slate-500 mt-1">
                Manage your upcoming and past stays with us.
            </p>
        </header>


        @if(session('success'))
            <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 text-sm">
                {{ session('success') }}
            </p>
        @endif

        <div class="space-y-4">


            @forelse($reservations as $reservation)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row">


                        <div class="sm:w-48 h-48 sm:h-auto">
                            <img src="{{ $reservation->room->imageRoom ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=400&q=80' }}"
                                alt="Room {{ $reservation->room->numberRoom }}" class="w-full h-full object-cover" />
                        </div>

                        <div class="p-5 flex-1">

                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold font-[Playfair_Display]">
                                        Room {{ $reservation->room->numberRoom }}
                                    </h2>
                                    <p class="text-xs font-medium text-yellow-600 uppercase tracking-wider mb-3">
                                        {{ $reservation->room->capacity }}
                                    </p>
                                </div>


                                <span class="
                                        px-3 py-1 rounded-full text-xs font-bold border
                                        {{ $reservation->status === 'Confirmed' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : '' }}
                                        {{ $reservation->status === 'Pending' ? 'bg-amber-50 text-amber-700 border-amber-100' : '' }}
                                        {{ $reservation->status === 'Cancelled' ? 'bg-red-50 text-red-700 border-red-100' : '' }}
                                    ">
                                    {{ $reservation->status }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-5 bg-gray-50 p-3 rounded-lg">

                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Dates</p>
                                    <p class="text-sm font-semibold text-gray-700">
                                        {{ \Carbon\Carbon::parse($reservation->start_Reserve)->format('M d') }}
                                        -
                                        {{ \Carbon\Carbon::parse($reservation->end_Reserv)->format('M d, Y') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Duration</p>
                                    <p class="text-sm font-semibold text-gray-700">
                                        {{ \Carbon\Carbon::parse($reservation->start_Reserve)->diffInDays($reservation->end_Reserv) }}
                                        Nights
                                    </p>
                                </div>

                                <div
                                    class="col-span-2 md:col-span-1 border-t md:border-t-0 md:border-l border-gray-200 pt-2 md:pt-0 md:pl-4">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Price / Night</p>
                                    <p class="text-sm font-bold text-slate-900">${{ $reservation->room->prixRoom }}</p>
                                </div>

                            </div>

                            <div class="flex gap-3">

                                <a href="/client/details/{{ $reservation->room->idRoom }}"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 transition">
                                    View Details
                                </a>


                                @if($reservation->status !== 'Cancelled')
                                    <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="text-gray-400 hover:text-red-500 text-sm font-medium transition">
                                            Cancel Stay
                                        </button>
                                    </form>
                                @else
                                    <span class="text-red-500 text-sm font-medium">Cancelled</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            @empty

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <p class="text-gray-400 text-lg mb-4">You have no reservations yet.</p>
                    <a href="/client/rooms"
                        class="bg-yellow-700 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-yellow-800 transition">
                        Browse Rooms
                    </a>
                </div>
            @endforelse

        </div>
    </main>

    <footer class="mt-12 py-10 border-t border-gray-200">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <p class="text-[10px] tracking-[0.2em] text-gray-400 font-bold mb-4 uppercase">
                © 2027 SAFI LUXE HOTELS & RESORTS
            </p>
            <div class="flex justify-center gap-6 text-xs font-medium text-gray-500">
                <a href="#" class="hover:text-yellow-800 transition">Privacy</a>
                <a href="#" class="hover:text-yellow-800 transition">Terms</a>
                <a href="#" class="hover:text-yellow-800 transition">Contact</a>
            </div>
        </div>
    </footer>

</body>

</html>