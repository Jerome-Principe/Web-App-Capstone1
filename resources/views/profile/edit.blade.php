<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        function previewImage(event) {
            const output = document.getElementById('profile_preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = () => URL.revokeObjectURL(output.src);
        }
    </script>
</head>

<body>
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto">
            <h2 class="font-semibold text-xl">Profile</h2>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if(session('success'))
                        <div
                            class="custom-alert-message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const alert = document.querySelector('.custom-alert-message');
                            if (alert) {
                                setTimeout(function () {
                                    alert.style.transition = "opacity 0.5s ease";
                                    alert.style.opacity = "0";
                                    setTimeout(function () {
                                        alert.remove();
                                    }, 500); // Wait for fade-out before removing
                                }, 3000); // Display for 3 seconds
                            }
                        });
                    </script>


                    <!-- Profile Picture -->
                    <div class="relative w-32 h-32 mx-auto mb-6">
                        <label for="profile_picture" class="cursor-pointer">
                            <img id="profile_preview"
                                src="{{ asset($user->profile_picture ?? 'https://via.placeholder.com/150') }}"
                                alt="Profile Picture"
                                class="w-full h-full rounded-full border-4 border-white shadow-md object-cover">
                            <div class="absolute bottom-0 right-0 bg-gray-300 p-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 5c-3.86 0-7 3.14-7 7s3.14 7 7 7 7-3.14 7-7-3.14-7-7-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm4-5h-3v3h-2v-3H8v-2h3V8h2v3h3v2z" />
                                </svg>
                            </div>
                            <input type="file" id="profile_picture" name="profile_picture" class="hidden"
                                accept="image/*" onchange="previewImage(event)">
                        </label>
                    </div>

                    <!-- Name and Email -->
                    <label for="name" class="block text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg p-2 mb-2"
                        value="{{ old('name', $user->name) }}" placeholder="Enter your name">
                    @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                    <label for="email" class="block text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" class="w-full border-gray-300 rounded-lg p-2 mb-2"
                        value="{{ old('email', $user->email) }}" placeholder="Enter your email">
                    @error('email')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                    <!-- Save Button -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Save Profile</button>
                </form>
            </div>


            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form action="{{ route('profile.updatePassword') }}" method="POST">

                    @csrf
                    @method('PUT')
                    <label for="current_password" class="block text-gray-700">Current Password:</label>
                    <input type="password" id="current_password" name="current_password"
                        class="w-full border-gray-300 rounded-lg p-2 mb-2" placeholder="Enter current password">
                    @error('current_password')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                    <label for="new_password" class="block text-gray-700">New Password:</label>
                    <input type="password" id="new_password" name="new_password"
                        class="w-full border-gray-300 rounded-lg p-2 mb-2" placeholder="Enter new password">
                    @error('new_password')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                    <label for="confirm_password" class="block text-gray-700">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password"
                        class="w-full border-gray-300 rounded-lg p-2 mb-2" placeholder="Confirm new password">
                    @error('confirm_password')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Change Password</button>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form action="{{ route('profile.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <label for="password" class="block text-gray-700">Password:</label>
                    <input type="password" id="password" name="password"
                        class="w-full border-gray-300 rounded-lg p-2 mb-2" placeholder="Enter your password">
                    @error('password')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete Account</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>