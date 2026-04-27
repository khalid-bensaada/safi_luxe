<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SAFI LUXE - Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-[Manrope]">

    <header class="fixed top-0 left-0 w-full bg-white shadow-sm h-16 flex items-center justify-between px-10">
        <h1 class="text-lg font-bold tracking-widest">SAFI LUXE</h1>
        <a href="/client/reservations" class="text-yellow-700 font-bold text-xl">X</a>
    </header>

    <main class="min-h-screen flex items-center justify-center pt-24 px-4">
        <div class="bg-white w-full max-w-lg shadow-md border">

            
            <div class="relative">
                <img src="{{ $reservation->room->imageRoom ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&h=400&fit=crop' }}"
                    alt="Room Image" class="w-full h-60 object-cover" />
                <div class="absolute inset-0 bg-black/30"></div>
            </div>

            <div class="p-8 space-y-6">

                
                <div>
                    <p class="text-xs uppercase tracking-widest text-yellow-700 font-semibold">
                        Accommodation Selection
                    </p>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Room {{ $reservation->room->numberRoom }}
                    </h2>
                </div>

                
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider">Check-In</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ \Carbon\Carbon::parse($reservation->start_Reserve)->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider">Check-Out</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ \Carbon\Carbon::parse($reservation->end_Reserv)->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                
                @php
                    $days = \Carbon\Carbon::parse($reservation->start_Reserve)
                        ->diffInDays($reservation->end_Reserv);
                    $total = $days * $reservation->room->prixRoom;
                @endphp

                <div class="border-t pt-4">
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Stay Duration</p>
                    <p class="font-bold text-gray-800 mt-1">{{ $days }} Night{{ $days > 1 ? 's' : '' }}</p>
                </div>

                
                <div class="bg-gray-100 p-6 text-center">
                    <p class="text-xs uppercase tracking-widest text-gray-500">Total Investment</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2">
                        ${{ number_format($total, 2) }}
                    </h3>
                    <p class="text-xs text-gray-400 italic mt-1">
                        Inclusive of all concierge fees & taxes
                    </p>
                </div>

                
                @if(session('success'))
                    <p class="bg-green-100 text-green-700 text-sm px-4 py-2 rounded text-center">
                        {{ session('success') }}
                    </p>
                @endif

                
                <div class="space-y-3">
                    <form action="/client/payments" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}" />
                        <button type="submit"
                            class="w-full bg-yellow-400 h-12 font-bold text-blue-900 rounded hover:bg-yellow-300 transition">
                            Pay with PayPal
                        </button>
                    </form>

                    <form action="/client/payments" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}" />
                        <button type="submit"
                            class="w-full border h-12 text-xs uppercase tracking-widest text-gray-600 hover:bg-gray-200 transition">
                            Pay with Credit Card
                        </button>
                    </form>
                </div>

                <p class="text-center text-xs text-gray-500 uppercase tracking-widest">
                    Encrypted Secure Checkout
                </p>

            </div>
        </div>
    </main>

</body>

</html>