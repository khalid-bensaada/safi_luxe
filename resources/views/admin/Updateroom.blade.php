<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Room | Hotel Admin</title>
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
            <div class="flex items-center gap-3">
                <a href="/admin/adminroom" class="text-gray-400 hover:text-gray-700">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-xl font-bold text-gray-800">Edit Room #{{ $room->numberRoom }}</h2>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="p-8 max-w-3xl">

            @if(session('success'))
                <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </p>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-8">

                <form action="/admin/adminroom/{{ $room->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        <div class="grid grid-cols-3 items-center gap-4">
                            <label class="text-sm font-semibold text-gray-700">Room Number :</label>
                            <input type="number" name="numberRoom" value="{{ old('numberRoom', $room->numberRoom) }}"
                                class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                        </div>

                        <div class="grid grid-cols-3 items-center gap-4">
                            <label class="text-sm font-semibold text-gray-700">Price :</label>
                            <input type="number" name="prixRoom" step="0.01"
                                value="{{ old('prixRoom', $room->prixRoom) }}"
                                class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                        </div>

                        <div class="grid grid-cols-3 items-center gap-4">
                            <label class="text-sm font-semibold text-gray-700">Status :</label>
                            <select name="status"
                                class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="Available" {{ $room->status === 'Available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="Booked" {{ $room->status === 'Booked' ? 'selected' : '' }}>Booked</option>
                                <option value="Maintenance" {{ $room->status === 'Maintenance' ? 'selected' : '' }}>
                                    Maintenance</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-3 items-start gap-4">
                            <label class="text-sm font-semibold text-gray-700 mt-2">Room Image :</label>
                            <div class="col-span-2 space-y-2">
                                @if($room->imageRoom)
                                    <img src="{{ $room->imageRoom }}" class="w-32 h-24 object-cover rounded-lg border" />
                                    <p class="text-xs text-gray-400">Upload a new image to replace the current one.</p>
                                @endif
                                <input type="file" name="imageRoom" accept="image/*"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 items-start gap-4">
                            <label class="text-sm font-semibold text-gray-700 mt-2">Description :</label>
                            <textarea name="description" rows="4"
                                class="col-span-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('description', $room->description) }}</textarea>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                        <a href="/admin/adminroom"
                            class="px-5 py-2 rounded-md text-sm font-semibold bg-gray-300 text-gray-800 hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-md text-sm font-semibold bg-blue-500 text-white hover:bg-blue-600 shadow">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

</body>

</html>