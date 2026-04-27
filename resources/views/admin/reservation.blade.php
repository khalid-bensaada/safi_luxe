<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservation Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">

    
    <aside class="w-64 h-screen bg-white fixed top-0 left-0 shadow p-6 flex flex-col">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800">Hotel Admin</h1>
            <p class="text-xs text-gray-400">Management Portal</p>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded">
                Dashboard
            </a>
            <a href="/admin/adminroom"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded">
                Rooms
            </a>
            <a href="/admin/reservation"
                class="flex items-center gap-3 px-4 py-3 bg-yellow-100 text-yellow-700 font-semibold rounded">
                Reservations
            </a>
            <a href="/admin/comment" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded">
                Comments
            </a>
        </nav>

        <div class="mt-auto pt-4 border-t">
            
            <form action="/logout" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 text-white py-3 font-bold text-sm rounded hover:bg-red-600">
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    
    <main class="ml-64 flex-1">

        
        <header class="bg-white shadow px-8 py-4 flex items-center justify-between sticky top-0">
            <h2 class="text-xl font-bold text-gray-800">Reservation Management</h2>
            <div class="flex items-center gap-3">
                
                <p class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</p>
                <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="p-8">

            
            @if(session('success'))
                <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </p>
            @endif

            <div class="w-12 h-1 bg-yellow-600 mb-8"></div>

            
            <div class="grid grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 shadow border-l-4 border-yellow-600">
                    <p class="text-xs text-gray-500 uppercase mb-1">Pending Requests</p>
                    <p class="text-4xl font-bold text-gray-800">
                        {{ $reservations->where('status', 'Pending')->count() }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow border-l-4 border-green-600">
                    <p class="text-xs text-gray-500 uppercase mb-1">Confirmed</p>
                    <p class="text-4xl font-bold text-gray-800">
                        {{ $reservations->where('status', 'Confirmed')->count() }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow border-l-4 border-gray-800">
                    <p class="text-xs text-gray-500 uppercase mb-1">Total Reservations</p>
                    <p class="text-4xl font-bold text-gray-800">
                        {{ $reservations->count() }}
                    </p>
                </div>

            </div>

            <!-- Table -->
            <div class="bg-white shadow overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs text-gray-500 uppercase">Guest Details</th>
                            <th class="px-6 py-4 text-xs text-gray-500 uppercase">Room Info</th>
                            <th class="px-6 py-4 text-xs text-gray-500 uppercase">Stay Dates</th>
                            <th class="px-6 py-4 text-xs text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs text-gray-500 uppercase text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        
                        @forelse($reservations as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5">
                                    <p class="font-bold text-gray-800">{{ $reservation->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $reservation->user->email }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="font-medium text-gray-800">Room {{ $reservation->room->numberRoom }}</p>
                                    <p class="text-xs text-gray-400">{{ $reservation->room->capacity }}</p>
                                </td>
                                <td class="px-6 py-5 text-gray-600">
                                    {{ $reservation->start_Reserve }} - {{ $reservation->end_Reserv }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="
                                        text-xs px-3 py-1 rounded font-semibold
                                        {{ $reservation->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $reservation->status === 'Confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $reservation->status === 'Cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    ">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center gap-2">

                                        
                                        @if($reservation->status !== 'Confirmed')
                                            <form action="/admin/reservation/{{ $reservation->id }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Confirmed" />
                                                <button type="submit"
                                                    class="bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700">
                                                    Confirm
                                                </button>
                                            </form>
                                        @else
                                            <span
                                                class="bg-green-600 text-white text-xs px-3 py-1 rounded opacity-50 cursor-not-allowed">
                                                Confirm
                                            </span>
                                        @endif

                                        
                                        @if($reservation->status !== 'Cancelled')
                                            <form action="/admin/reservation/{{ $reservation->id }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Cancelled" />
                                                <button type="submit"
                                                    class="bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700">
                                                    Cancel
                                                </button>
                                            </form>
                                        @else
                                            <button
                                                class="bg-red-600 text-white text-xs px-3 py-1 rounded opacity-50 cursor-not-allowed">
                                                Cancel
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400">No reservations found.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            
            <div class="flex justify-between items-center mt-6 text-gray-400 text-xs">
                <p>Showing {{ $reservations->count() }} reservations</p>
            </div>

        </div>
    </main>

</body>

</html>