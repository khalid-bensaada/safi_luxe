<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Room Inventory | Hotel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-100 min-h-screen flex">

    
    <aside class="w-64 bg-white h-screen fixed top-0 left-0 shadow-md flex flex-col p-6">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800">Hotel Admin</h1>
            <p class="text-xs text-gray-400">Management Portal</p>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded-lg">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a href="/admin/adminroom"
                class="flex items-center gap-3 px-4 py-3 bg-yellow-100 text-yellow-700 font-semibold rounded-lg">
                <i class="fa-solid fa-bed"></i> Room Management
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
            <h2 class="text-xl font-bold text-gray-800">Room Inventory</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
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

            <div class="flex justify-end mb-6">
                <button onclick="openModal()"
                    class="bg-yellow-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-yellow-700 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add New Room
                </button>
            </div>

            <div class="bg-white rounded-xl shadow overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">Preview</th>
                            <th class="px-6 py-4">Room Number</th>
                            <th class="px-6 py-4 text-right">Price / Night</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse($rooms as $room)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <img src="{{ $room->imageRoom ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=80&h=60&fit=crop' }}"
                                        class="w-16 h-12 object-cover rounded-lg" />
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">Room {{ $room->numberRoom }}</p>
                                    <p class="text-xs text-gray-400">{{ $room->description ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-800">${{ $room->prixRoom }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="
                                                    text-xs px-3 py-1 rounded-full font-semibold
                                                    {{ $room->status === 'Available' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $room->status === 'Booked' ? 'bg-red-100 text-red-700' : '' }}
                                                    {{ $room->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                ">
                                        {{ $room->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">


                                        <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                            class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-semibold">
                                            UPDATE
                                        </a>


                                        <form action="/admin/adminroom/{{ $room->id }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-semibold">
                                                DELETE
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400">No rooms found.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </main>

    
    <div id="modal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden">

            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-800">Add New Room</h3>
            </div>

            <form action="/admin/adminroom" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-4">

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm font-semibold text-gray-700">Room Number :</label>
                        <input type="number" name="numberRoom" placeholder="e.g. 501"
                            class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm font-semibold text-gray-700">Price :</label>
                        <input type="number" name="prixRoom" placeholder="e.g. 750.00" step="0.01"
                            class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm font-semibold text-gray-700">Status :</label>
                        <select name="status"
                            class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Select --</option>
                            <option value="Available">Available</option>
                            <option value="Booked">Booked</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 items-start gap-4">
                        <label class="text-sm font-semibold text-gray-700 mt-2">Room Image :</label>
                        <div class="col-span-2">
                            <input type="file" name="imageRoom" accept="image/*"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white" />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 items-start gap-4">
                        <label class="text-sm font-semibold text-gray-700 mt-2">Description :</label>
                        <textarea name="description" placeholder="Write room description..."
                            class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm h-24 resize-none focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                    </div>

                </div>

                <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 rounded-md text-sm font-semibold bg-gray-300 text-gray-800 hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-md text-sm font-semibold bg-yellow-500 text-white hover:bg-yellow-600 shadow">
                        Add Room
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>

</body>

</html>