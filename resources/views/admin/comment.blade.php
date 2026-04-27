<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reviews & Moderation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">


    <aside class="w-64 h-screen bg-white fixed top-0 left-0 shadow p-6 flex flex-col">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800">Hotel Admin</h1>
            <p class="text-xs text-gray-400">Admin Portal</p>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded">
                Dashboard
            </a>
            <a href="/admin/adminroom"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded">
                Room Management
            </a>
            <a href="/admin/reservation"
                class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-100 rounded">
                Reservations
            </a>
            <a href="/admin/comment"
                class="flex items-center gap-3 px-4 py-3 bg-yellow-100 text-yellow-700 font-semibold rounded">
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
            <div class="flex items-center gap-6">
                <h2 class="text-lg font-bold text-gray-800">Moderation Panel</h2>
            </div>
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


            <div class="flex items-end justify-between mb-8 border-b border-gray-200 pb-6">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">Customer Reviews</h3>
                    <p class="text-xs text-gray-400 uppercase">Curation and Guest Feedback Management</p>
                </div>

                <div class="flex gap-10">
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Total Reviews</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $comments->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase mb-1">Pending</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $comments->where('status', 'Pending')->count() }}
                        </p>
                    </div>
                </div>
            </div>


            <div class="flex flex-col gap-6">


                @forelse($comments as $comment)

                    <div
                        class="bg-white shadow p-6 border
                            {{ $comment->status === 'Pending' ? 'border-l-4 border-yellow-500' : 'border border-gray-100' }}">

                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-bold text-gray-800 text-lg">{{ $comment->user->name }}</h4>

                                    @if($comment->status === 'Pending')
                                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-0.5 rounded font-semibold">
                                            PENDING
                                        </span>
                                    @elseif($comment->status === 'Approved')
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded font-semibold">
                                            APPROVED
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400">
                                    Room {{ $comment->room->numberRoom }} — {{ $comment->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-yellow-600">
                                    {{ $comment->rankCom }}/5 Stars ⭐
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-600 italic mb-6">
                            "{{ $comment->contentCom }}"
                        </p>

                        <div class="flex gap-3">


                            @if($comment->status !== 'Approved')
                                <form action="/admin/comment/{{ $comment->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Approved" />
                                    <button type="submit" class="{{ $comment->status === 'Pending' ? 'bg-yellow-600 text-white' : 'bg-green-100 text-green-700' }}
                                                px-4 py-2 text-xs font-bold uppercase rounded hover:opacity-90">
                                        APPROVE
                                    </button>
                                </form>
                            @endif


                            <form action="/admin/comment/{{ $comment->id }}" method="POST"
                                onsubmit="return confirm('Delete this comment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-100 text-red-700 px-4 py-2 text-xs font-bold uppercase rounded hover:bg-red-200">
                                    DELETE
                                </button>
                            </form>

                        </div>
                    </div>

                @empty
                    <div class="bg-white shadow p-8 text-center text-gray-400">
                        No comments found.
                    </div>
                @endforelse

            </div>


            <div class="flex justify-between items-center mt-8 border-t border-gray-200 pt-6">
                <p class="text-xs text-gray-400">Showing {{ $comments->count() }} reviews</p>
            </div>

        </div>
    </main>

</body>

</html>