@extends('apps.front_master')
@section('title', 'লগইন করুন')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-100 via-emerald-50 to-white px-4">
  <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-8 space-y-6">
    
    <!-- Logo -->
    <div class="text-center">
      <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" alt="Logo" class="w-16 mx-auto mb-3">
      <h2 class="text-3xl font-extrabold text-green-700">eBazar Login</h2>
      <p class="text-gray-500 text-sm mt-1">আপনার একাউন্টে লগইন করুন</p>
    </div>

@include('alerts.alert')
    <!-- Login Form -->
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Email / Phone -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">আপনার ফোন নম্বর</label>
        <input type="number" name="phone" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 outline-none" placeholder="example@mail.com" required>
      </div>

      <!-- Password -->
      <div class="relative">
        <label class="block text-gray-700 font-medium mb-1">পাসওয়ার্ড</label>
        <input type="password" name="password" id="password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 outline-none" placeholder="******" required>
        <button type="button" id="togglePassword" class="absolute right-3 top-9 text-gray-500 hover:text-green-600">
          👁️
        </button>
      </div>

      <!-- Remember & Forgot -->
      <div class="flex items-center justify-between text-sm text-gray-600">
        <label class="flex items-center gap-2">
          <input type="checkbox" name="remember" class="text-green-600 rounded">
          মনে রাখুন
        </label>
        <a href="{{ route('password.request') }}" class="text-green-600 hover:underline">পাসওয়ার্ড ভুলে গেছেন?</a>
      </div>

      <!-- Login Button -->
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg font-semibold shadow-md transition">
        🔓 লগইন করুন
      </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center my-4">
      <div class="flex-grow border-t border-gray-300"></div>
      <span class="px-3 text-gray-500 text-sm">অথবা</span>
      <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Register Link -->
    <p class="text-center text-gray-600">
      একাউন্ট নেই? 
      <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">রেজিস্টার করুন</a>
    </p>
  </div>
</div>

<!-- Password Toggle Script -->

@endsection
@section('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>
@endsection
