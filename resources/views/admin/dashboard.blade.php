<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hotel Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-100 min-h-screen flex">

    
    <aside class="w-64 bg-white h-screen fixed top-0 left-0 shadow-md flex flex-col p-6">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800">Hotel Admin</h1>
            <p class="text-sm text-gray-400">Management Portal</p>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-3 bg-yellow-100 text-yellow-700 font-semibold rounded-lg">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a href="/admin/adminroom"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded-lg">
                <i class="fa-solid fa-bed"></i> Rooms
            </a>
            <a href="/admin/reservation"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded-lg">
                <i class="fa-solid fa-calendar"></i> Reservations
            </a>
            <a href="/admin/comment"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded-lg">
                <i class="fa-solid fa-star"></i> Comments
            </a>
        </nav>

        <div class="mt-auto flex flex-col gap-2 border-t pt-4">
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-500 hover:text-gray-800">
                <i class="fa-solid fa-circle-question"></i> Support
            </a>
            
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2 text-red-400 hover:text-red-600 w-full">
                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    
    <main class="ml-64 flex-1">

        
        <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between sticky top-0 z-10">
            <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 border-l pl-4">
                    <div>
                        
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Master Moderator</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8 space-y-8">

            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 mb-1">Total Rooms</p>
                    <h3 class="text-4xl font-bold text-gray-800">{{ $totalRooms }}</h3>
                    <p class="text-xs text-green-500 mt-2"><i class="fa-solid fa-arrow-up"></i> Capacity maximized</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 mb-1">Active Reservations</p>
                    <h3 class="text-4xl font-bold text-gray-800">{{ $totalReservations }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Pending: {{ $pendingReservations }}</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 mb-1">Total Clients</p>
                    <h3 class="text-4xl font-bold text-gray-800">{{ $totalClients }}</h3>
                    <p class="text-xs text-green-500 mt-2"><i class="fa-solid fa-arrow-up"></i> Registered users</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 mb-1">Pending Comments</p>
                    <h3 class="text-4xl font-bold text-gray-800">{{ $totalComments }}</h3>
                    <p class="text-xs text-red-500 mt-2"><i class="fa-solid fa-triangle-exclamation"></i> Needs
                        moderation</p>
                </div>

            </div>

            
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Room Management</h2>
                        <p class="text-sm text-gray-400">Inventory and availability</p>
                    </div>
                    <a href="/admin/adminroom"
                        class="bg-yellow-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-yellow-600">
                        View All
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="p-3">Room Number</th>
                                <th class="p-3">Capacity</th>
                                <th class="p-3">Price / Night</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            @forelse($rooms as $room)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-semibold text-gray-800">Room {{ $room->numberRoom }}</td>
                                    <td class="p-3 text-gray-500">{{ $room->capacity }}</td>
                                    <td class="p-3 text-gray-800">${{ $room->prixRoom }}</td>
                                    <td class="p-3">
                                        <span class="
                                            text-xs px-2 py-1 rounded-full
                                            {{ $room->status === 'Available' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $room->status === 'Booked' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ $room->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        ">
                                            {{ $room->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-400">No rooms found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>

</html>