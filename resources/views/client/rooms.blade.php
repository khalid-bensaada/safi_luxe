<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-16 flex justify-between items-center">
            <h1 class="text-xl tracking-widest font-bold text-yellow-800 font-[Playfair_Display]">
                SAFI LUXE
            </h1>

            <div class="hidden md:flex gap-8 text-sm font-medium">
                <a href="/client/rooms" class="text-yellow-700 border-b-2 border-yellow-700 pb-1">Rooms</a>
                <a href="/client/reservations" class="text-gray-500 hover:text-yellow-700 transition">
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


    <div class="text-center py-16 px-8">
        <h1 class="text-5xl font-bold mb-4">Suites & Sanctuaries</h1>
        <p class="text-gray-500 text-lg max-w-xl mx-auto">
            A curated collection of architectural retreats where Moroccan heritage meets modern minimalism.
        </p>
    </div>


    <div class="px-8 mb-20">
        <div class="flex flex-wrap gap-10 justify-center">


            @forelse($rooms as $room)
                <div class="w-72 border border-gray-200 hover:shadow-lg">
                    <div class="relative">
                        <img src="{{ $room->imageRoom ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&h=300&fit=crop' }}"
                            class="w-full h-64 object-cover" />
                        <div class="absolute top-4 right-4 bg-white px-3 py-1">
                            <span class="text-yellow-700 text-xs font-bold">${{ $room->prixRoom }} / NIGHT</span>
                        </div>

                        <div class="absolute top-4 left-4">
                            <span class="
                                        text-xs font-bold px-2 py-1 rounded
                                        {{ $room->status === 'Available' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $room->status === 'Booked' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $room->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    ">
                                {{ $room->status }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-1">Room {{ $room->numberRoom }}</h3>
                        <p class="text-xs text-gray-400 uppercase mb-2">{{ $room->capacity }}</p>
                        <p class="text-xs text-gray-500 mb-4">{{ Str::limit($room->description, 60) }}</p>

                        <a href="/client/details/{{ $room->id }}"
                            class="text-xs text-gray-500 underline hover:text-yellow-700">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-16">
                    <p class="text-xl">No rooms found.</p>
                </div>
            @endforelse

        </div>
    </div>

    <footer class="bg-gray-50 py-12 text-center border-t border-gray-200">
        <p class="text-xl font-bold mb-6">SAFI LUXE</p>
        <div class="flex justify-center gap-8 mb-4">
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Privacy Policy</a>
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Terms of Service</a>
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Sustainability</a>
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Contact</a>
        </div>
        <p class="text-xs text-gray-400 uppercase">2027 SAFI LUXE. THE SILENT CONCIERGE.</p>
    </footer>

</body>

</html>