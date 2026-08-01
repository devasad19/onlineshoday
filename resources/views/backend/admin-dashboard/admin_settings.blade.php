@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    

    <!-- Main Content -->
    <div class="flex-1 flex flex-col p-2 md:p-6">
        @include('backend.patrials.top_bar')

        <!-- Page Title -->
        <h2 class="text-2xl font-bold text-green-700 mb-6">⚙️ Admin Settings</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Profile Info -->
            <div class="bg-white rounded-2xl shadow p-3">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Profile Information</h3>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Phone</label>
                        <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <button type="submit" class="bg-green-600 text-white w-full py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                        Update Profile
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl shadow p-3">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Change Password</h3>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Current Password</label>
                        <input type="password" name="current_password" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">New Password</label>
                        <input type="password" name="new_password" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <button type="submit" class="bg-green-600 text-white w-full py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                        Update Password
                    </button>
                </form>
            </div>

            <!-- Site Settings -->
            <div class="bg-white rounded-2xl shadow p-3 md:col-span-2">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Site Settings</h3>
                <form action="#" method="POST" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Site Name</label>
                        <input type="text" name="site_name" value="My Bazar" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Logo</label>
                        <input type="file" name="logo" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-600 mb-1">Footer Text</label>
                        <input type="text" name="footer_text" value="© 2025 My Bazar" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <button type="submit" class="bg-green-600 text-white w-full py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                        Save Site Settings
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Optional: add JS for preview logo, form validations etc.
</script>
@endsection
