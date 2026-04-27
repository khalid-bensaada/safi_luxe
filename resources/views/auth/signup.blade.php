<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">

    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Create Account</h1>
    <p class="text-center text-gray-500 text-sm mb-6">Join our community today.</p>

   
    @if($errors->any())
      <ul class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
        @foreach($errors->all() as $error)
          <li>• {{ $error }}</li>
        @endforeach
      </ul>
    @endif

    
    <form action="/auth/signup" method="POST">
      @csrf

      <label class="block text-sm font-medium text-gray-700 mb-1" for="fullname">Full Name</label>
      <input
        class="w-full px-4 py-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
        type="text" id="fullname" name="name" value="{{ old('name') }}" placeholder="khalid" required />

      <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address</label>
      <input
        class="w-full px-4 py-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
        type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@gmail.com" required />

      <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
      <input
        class="w-full px-4 py-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
        type="text" id="password" name="password" placeholder="password" required />

      <label class="block text-sm font-medium text-gray-700 mb-1" for="confirm-password">Confirm Password</label>
      <input
        class="w-full px-4 py-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
        type="text" id="confirm-password" name="password_confirmation" placeholder="confirm-password" required />

      <button class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-3 rounded-lg transition-colors"
        type="submit">
        Create Account
      </button>

    </form>

    <div class="flex items-center gap-3 my-6">
      <div class="flex-1 border-t border-gray-200"></div>
      <span class="text-sm text-gray-400">Or sign up with</span>
      <div class="flex-1 border-t border-gray-200"></div>
    </div>

    <p class="text-center text-sm text-gray-500">
      Already have an account? <a class="text-indigo-600 font-semibold hover:underline" href="/auth/login">Log in</a>
    </p>

  </div>

</body>

</html>