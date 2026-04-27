<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Profile | SAFI LUXE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow px-8 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold">SAFI LUXE</div>
        <div class="flex gap-4">
            <a href="/client/rooms"
                class="px-6 py-2 text-sm font-bold text-yellow-700 border border-yellow-700 hover:bg-yellow-50">
                Rooms
            </a>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 text-sm font-bold bg-yellow-700 text-white hover:bg-yellow-800">
                    Log Out
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-16 px-4 space-y-8">

        
        @if(session('success'))
            <p class="bg-green-100 text-green-700 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </p>
        @endif
        @if($errors->any())
            <ul class="bg-red-100 text-red-700 px-4 py-3 rounded text-sm">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        
        <div class="bg-white shadow border p-8">
            <h2 class="text-xl font-bold mb-6">Account Information</h2>

            <form action="{{ route('client.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="text-xs text-gray-400 uppercase mb-1 block">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-yellow-500" />
                </div>

                <div class="mb-6">
                    <label class="text-xs text-gray-400 uppercase mb-1 block">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-yellow-500" />
                </div>

                <button type="submit"
                    class="w-full bg-yellow-700 text-white py-3 text-sm font-bold uppercase hover:bg-yellow-800">
                    Save Changes
                </button>
            </form>
        </div>

        
        <div class="bg-white shadow border p-8">
            <h2 class="text-xl font-bold mb-6">Change Password</h2>

            <form action="{{ route('client.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="text-xs text-gray-400 uppercase mb-1 block">Current Password</label>
                    <input type="password" name="current_password"
                        class="w-full border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-yellow-500" />
                </div>

                <div class="mb-4">
                    <label class="text-xs text-gray-400 uppercase mb-1 block">New Password</label>
                    <input type="password" name="new_password"
                        class="w-full border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-yellow-500" />
                </div>

                <div class="mb-6">
                    <label class="text-xs text-gray-400 uppercase mb-1 block">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation"
                        class="w-full border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-yellow-500" />
                </div>

                <button type="submit"
                    class="w-full bg-yellow-700 text-white py-3 text-sm font-bold uppercase hover:bg-yellow-800">
                    Update Password
                </button>
            </form>
        </div>

        
        <div class="bg-white shadow border p-8">
            <h2 class="text-xl font-bold mb-2 text-red-600">Delete Account</h2>
            <p class="text-sm text-gray-400 mb-6">This action is permanent and cannot be undone.</p>

            <form action="{{ route('client.profile.destroy') }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete your account?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-full border border-red-500 text-red-600 py-3 text-sm font-bold uppercase hover:bg-red-50">
                    Delete My Account
                </button>
            </form>
        </div>

    </div>

</body>

</html>