<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

      <div class="pt-10 pb-6 px-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
        <p class="text-gray-500 mt-2">Please enter your details to sign in</p>
      </div>

      <div class="px-8 pb-8">


        @if($errors->any())
          <ul class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            @foreach($errors->all() as $error)
              <li> {{ $error }}</li>
            @endforeach
          </ul>
        @endif


        @if(session('success'))
          <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
            {{ session('success') }}
          </p>
        @endif


        <form action="/auth/login" method="POST">
          @csrf

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address</label>
            <input
              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@gmail.com" required />
          </div>

          <div class="mb-6">
            <div class="flex justify-between items-center mb-1">
              <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
            </div>
            <input
              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              type="text" id="password" name="password" placeholder="password" required />
          </div>

          <button
            class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors"
            type="submit">
            Sign In
          </button>

        </form>

        <div class="flex items-center gap-3 my-6">
          <div class="flex-1 border-t border-gray-200"></div>
          <span class="text-xs text-gray-400 uppercase font-medium">Or continue with</span>
          <div class="flex-1 border-t border-gray-200"></div>
        </div>

      </div>

      <div class="bg-gray-50 border-t border-gray-100 py-6 px-8 text-center">
        <p class="text-sm text-gray-500">
          Don't have an account?
          <a class="font-semibold text-blue-600 hover:text-blue-700" href="/auth/signup">Sign up for free</a>
        </p>
      </div>

    </div>
  </div>

</body>

</html>