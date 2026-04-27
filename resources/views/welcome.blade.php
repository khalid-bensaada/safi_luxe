<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Safi Luxe Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800">

    <nav class="fixed top-0 w-full z-50 bg-white shadow px-8 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold tracking-widest">SAFI LUXE</div>
        <div class="flex gap-4">
            <a href="/auth/login"
                class="px-6 py-2 text-sm uppercase font-bold text-yellow-700 border border-yellow-700 hover:bg-yellow-50">
                Login
            </a>
            <a href="/auth/signup"
                class="px-6 py-2 text-sm uppercase font-bold bg-yellow-700 text-white hover:bg-yellow-800">
                Sign Up
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="pt-20 text-center py-16 px-8 bg-gray-50 border-b border-gray-200">
        <h1 class="text-5xl font-bold mb-4">Suites & Sanctuaries</h1>
        <p class="text-gray-500 text-lg max-w-xl mx-auto">
            A curated collection of architectural retreats where Moroccan heritage meets modern minimalism.
        </p>
        <div class="flex justify-center gap-4 mt-8">
            <a href="/auth/signup"
                class="px-8 py-3 bg-yellow-700 text-white text-sm font-bold uppercase hover:bg-yellow-800">
                Book Now
            </a>
            <a href="/auth/login"
                class="px-8 py-3 border border-yellow-700 text-yellow-700 text-sm font-bold uppercase hover:bg-yellow-50">
                Login
            </a>
        </div>
    </div>

    {{-- Rooms Section --}}
    <div class="px-8 py-16">

        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold mb-2">Available Rooms</h2>
            <p class="text-gray-400 text-sm">Login to reserve your stay</p>
        </div>

        <div class="flex flex-wrap gap-8 justify-center">

            {{-- ✅ Loop rooms from DB --}}
            @forelse($rooms as $room)
                <div class="w-72 border border-gray-200 hover:shadow-lg transition">
                    <div class="relative">
                        <img src="{{ $room->imageRoom ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&h=300&fit=crop' }}"
                            class="w-full h-64 object-cover" />

                        {{-- Price badge --}}
                        <div class="absolute top-4 right-4 bg-white px-3 py-1 shadow">
                            <span class="text-yellow-700 text-xs font-bold">${{ $room->prixRoom }} / NIGHT</span>
                        </div>

                        {{-- Status badge --}}
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
                        <h3 class="text-lg font-bold mb-1">Room {{ $room->numberRoom }}</h3>
                        <p class="text-xs text-gray-400 uppercase mb-1">{{ $room->capacity }}</p>
                        <p class="text-xs text-gray-500 mb-4">{{ Str::limit($room->description, 50) }}</p>

                        {{-- ✅ Visitor cannot see details - must login --}}
                        <a href="/auth/login"
                            class="block text-center w-full bg-yellow-700 text-white text-xs font-bold uppercase py-2 hover:bg-yellow-800 transition">
                            Login to Book
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-16">
                    <p class="text-xl">No rooms available at the moment.</p>
                </div>
            @endforelse

        </div>
    </div>

    <footer class="bg-gray-50 py-16 px-10 text-center border-t border-gray-200">
        <p class="text-xl font-bold italic mb-6">SAFI LUXE</p>
        <div class="flex justify-center gap-8 mb-6">
            <a href="#" class="text-xs uppercase text-gray-500 hover:text-yellow-700">Privacy</a>
            <a href="#" class="text-xs uppercase text-gray-500 hover:text-yellow-700">Terms</a>
            <a href="#" class="text-xs uppercase text-gray-500 hover:text-yellow-700">Contact</a>
            <a href="#" class="text-xs uppercase text-gray-500 hover:text-yellow-700">Press</a>
        </div>
        <p class="text-xs text-gray-400 uppercase tracking-widest">2027 Safi Luxe. The Silent Concierge.</p>
    </footer>

</body>

</html>