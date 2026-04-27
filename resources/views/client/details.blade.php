<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Room Details | SAFI LUXE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800">

    <nav class="bg-white shadow px-8 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold">SAFI LUXE</div>
        <div class="flex gap-4">
            <a href="/client/rooms"
                class="px-6 py-2 text-sm font-bold text-yellow-700 border border-yellow-700 hover:bg-yellow-50">
                Back to Rooms
            </a> 
            
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 text-sm font-bold bg-yellow-700 text-white hover:bg-yellow-800">
                    Log Out
                </button>
            </form>
        </div>
    </nav>

    
    <div class="relative h-96">
        <img src="{{ $room->imageRoom ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200&h=400&fit=crop' }}"
            class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="absolute bottom-8 left-8">
    
            <h1 class="text-white text-5xl font-bold">Room {{ $room->numberRoom }}</h1>
        </div>
    </div>

    <div class="px-8 py-16 flex flex-col lg:flex-row gap-12">

        <div class="w-full lg:w-2/3">

            
            <div class="mb-10">
                <p class="text-yellow-700 text-xs uppercase font-bold mb-4">The Experience</p>
                <h2 class="text-3xl font-bold mb-6">{{ $room->description ?? 'A luxury experience awaits you.' }}</h2>
                <div class="flex gap-6 mt-4">
                    <span class="
                        text-xs font-bold px-3 py-1 rounded-full
                        {{ $room->status === 'Available' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $room->status === 'Booked' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $room->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    ">
                        {{ $room->status }}
                    </span>
                    
                </div>
            </div>

            
            @if(session('success'))
                <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 text-sm">{{ session('success') }}</p>
            @endif
            @if($errors->any())
                <ul class="bg-red-100 text-red-700 px-4 py-2 rounded mb-6 text-sm">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            
            <div class="mb-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-bold">Guest Testimonials</h3>
                    <p class="text-yellow-700 font-bold text-xl">
                        @if($comments->count() > 0)
                            {{ number_format($comments->avg('rankCom'), 1) }} ★
                        @else
                            No ratings yet
                        @endif
                    </p>
                </div>

                <div class="flex flex-col gap-6">
                    @forelse($comments as $comment)
                        <div class="bg-white border border-gray-200 p-8">
                            <p class="text-yellow-500 mb-4">
                                @for($i = 1; $i <= $comment->rankCom; $i++) ★ @endfor
                            </p>
                            <p class="text-gray-500 italic mb-6">"{{ $comment->contentCom }}"</p>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs uppercase font-bold tracking-widest">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $comment->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-50 p-8 text-center text-gray-400">
                            <p>No reviews yet. Be the first to share your experience!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            
            <div class="border border-gray-200 p-8 mb-10">
                <h3 class="text-xl font-bold mb-6">Share Your Experience</h3>

                <form action="/client/comment" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}" />

                    <div class="mb-6">
                        <label class="text-xs text-gray-400 uppercase mb-2 block">Your Comment</label>
                        <textarea name="contentCom" rows="4" placeholder="Share your experience..."
                            class="w-full border border-gray-300 rounded px-4 py-2 text-sm resize-none focus:outline-none focus:border-yellow-500"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-700 text-white py-3 text-sm font-bold uppercase hover:bg-yellow-800">
                        Submit Review
                    </button>

                    <p class="text-center text-xs text-gray-400 mt-2">
                         Only available for confirmed reservations
                    </p>
                </form>
            </div>

        </div>

        
        <div class="w-full lg:w-1/3">
            <div class="border border-gray-200 p-8 sticky top-8">
                <p class="text-xs text-gray-400 uppercase mb-1">Starting from</p>
                <p class="text-4xl font-bold mb-1">${{ $room->prixRoom }}</p>
                <p class="text-sm text-gray-400 mb-8">/ Night</p>

                @if($room->status === 'Available')
                    <form action="/client/reservations" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}" />

                        <div class="mb-4 border-b border-gray-200 pb-4">
                            <label class="text-xs text-gray-400 uppercase mb-1 block">Check-in</label>
                            <input type="date" name="start_Reserve" class="text-sm w-full outline-none bg-transparent"
                                required />
                        </div>

                        <div class="mb-6 border-b border-gray-200 pb-4">
                            <label class="text-xs text-gray-400 uppercase mb-1 block">Check-out</label>
                            <input type="date" name="end_Reserv" class="text-sm w-full outline-none bg-transparent"
                                required />
                        </div>

                        <button type="submit"
                            class="w-full bg-yellow-700 text-white py-4 text-sm font-bold uppercase hover:bg-yellow-800 mb-4">
                            Confirm Booking
                        </button>
                        <p class="text-center text-xs text-gray-400">No charges will be applied yet</p>
                    </form>
                @else
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded text-center">
                        This room is not available for booking.
                    </div>
                @endif

            </div>
        </div>

    </div>

    <footer class="bg-gray-50 py-12 text-center border-t border-gray-200">
        <p class="text-xl font-bold mb-6">SAFI LUXE</p>
        <div class="flex justify-center gap-8 mb-4">
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Privacy Policy</a>
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Terms of Service</a>
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Press Enquiries</a>
            <a href="#" class="text-xs text-gray-500 uppercase hover:text-yellow-700">Careers</a>
        </div>
        <p class="text-xs text-gray-400 uppercase">2027 SAFI LUXE HOTELS & RESORTS. ALL RIGHTS RESERVED.</p>
    </footer>

</body>

</html>