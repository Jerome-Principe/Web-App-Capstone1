<!DOCTYPE html>
<html lang="en">

<head>
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .minimalist-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .profile-picture-container {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 0 auto 3rem;
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #fff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
        }

        .profile-picture:hover {
            transform: scale(1.05) rotate(2deg);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .camera-overlay {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            border: 3px solid #fff;
        }

        .camera-overlay:hover {
            transform: scale(1.15);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .form-input {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.05);
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            display: block;
            font-size: 15px;
            letter-spacing: 0.025em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            font-size: 15px;
            letter-spacing: 0.025em;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            font-size: 15px;
            letter-spacing: 0.025em;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
            font-size: 15px;
            letter-spacing: 0.025em;
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.4);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
            letter-spacing: -0.025em;
        }

        .section-subtitle {
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .alert {
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 32px;
            font-weight: 500;
            animation: slideIn 0.4s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid #10b981;
            color: #065f46;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #ef4444;
            color: #991b1b;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 24px;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .error-message::before {
            content: "⚠";
            margin-right: 6px;
            font-size: 14px;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 24px;
            height: 24px;
            margin: -12px 0 0 -12px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .password-strength-weak {
            color: #ef4444;
        }

        .password-strength-fair {
            color: #f59e0b;
        }

        .password-strength-good {
            color: #3b82f6;
        }

        .password-strength-strong {
            color: #10b981;
        }

        .profile-picture-actions {
            margin-top: 1rem;
            text-align: center;
        }

        .remove-picture-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .remove-picture-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .nav-button {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 1);
        }

        .page-title {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    <script>
        // Session timeout warning
        let sessionTimeout;
        const SESSION_WARNING_TIME = 10 * 60 * 1000; // 10 minutes before session expires
        const SESSION_TIMEOUT = 120 * 60 * 1000; // 2 hours session timeout

        function initSessionTimeout() {
            sessionTimeout = setTimeout(() => {
                if (confirm('Your session will expire soon. Would you like to stay logged in?')) {
                    // Refresh the page to extend session
                    window.location.reload();
                }
            }, SESSION_WARNING_TIME);
        }

        function resetSessionTimeout() {
            clearTimeout(sessionTimeout);
            initSessionTimeout();
        }

        // Reset timeout on user activity
        document.addEventListener('mousemove', resetSessionTimeout);
        document.addEventListener('keypress', resetSessionTimeout);
        document.addEventListener('click', resetSessionTimeout);

        // Initialize session timeout
        initSessionTimeout();

        function previewImage(event) {
            const output = document.getElementById('profile_preview');
            const file = event.target.files[0];

            if (file) {
                // Validate file size
                if (file.size > 2 * 1024 * 1024) { // 2MB limit
                    alert('File size must be less than 2MB');
                    event.target.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    output.src = e.target.result;
                    output.style.opacity = '0';
                    setTimeout(() => {
                        output.style.opacity = '1';
                    }, 100);
                };
                reader.readAsDataURL(file);
            }
        }

        function showLoading(form) {
            const button = form.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            button.classList.add('loading');
            button.disabled = true;

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('loading');
                button.disabled = false;
            }, 2000);
        }

        function showPasswordLoading(form) {
            const button = form.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            button.classList.add('loading');
            button.disabled = true;

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('loading');
                button.disabled = false;
            }, 2000);
        }

        function showDeleteLoading(form) {
            const button = form.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
            button.classList.add('loading');
            button.disabled = true;

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('loading');
                button.disabled = false;
            }, 2000);
        }

        function validatePasswordStrength(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            let strength = 0;
            if (password.length >= minLength) strength++;
            if (hasUpperCase) strength++;
            if (hasLowerCase) strength++;
            if (hasNumbers) strength++;
            if (hasSpecialChar) strength++;

            return strength;
        }

        function updatePasswordStrength(password) {
            const strengthMeter = document.getElementById('password-strength');
            if (!strengthMeter) return;

            const strength = validatePasswordStrength(password);
            const strengthText = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
            const strengthColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-blue-500', 'text-green-500'];

            strengthMeter.textContent = strengthText[strength - 1] || 'Very Weak';
            strengthMeter.className = `text-sm font-medium ${strengthColors[strength - 1] || 'text-red-500'}`;
        }

        // Auto-hide success messages
        document.addEventListener("DOMContentLoaded", function () {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(function () {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(function () {
                        alert.remove();
                    }, 500);
                }, 5000);
            }

            // Add form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    }
                });
            });

            // Add password confirmation validation
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');

            if (newPasswordInput && confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', function () {
                    if (this.value !== newPasswordInput.value) {
                        this.setCustomValidity('Passwords do not match');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });

        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.history.url);
        }
    </script>
</head>

<body>
    <div class="minimalist-bg py-12">
        <!-- Home/Dashboard Button - Top Right Corner -->
        <div class="absolute top-6 right-6 z-10">
            <a href="{{ route('dashboard') }}"
                class="nav-button inline-flex items-center px-6 py-3 text-gray-700 rounded-2xl transition-all duration-200">
                <i class="fas fa-home mr-3 text-lg"></i>
                <span class="hidden sm:inline font-semibold">Home / Dashboard</span>
                <span class="sm:hidden font-semibold">Home</span>
            </a>
        </div>

        <div class="max-w-5xl mx-auto px-6 sm:px-8 lg:px-10">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="page-title text-4xl font-bold mb-3">Profile Settings</h1>
                <p class="text-gray-600 text-lg">Manage your account information and preferences</p>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Information Section -->
            <div class="glass-card rounded-3xl p-10 mb-8">
                <div class="text-center mb-8">
                    <h2 class="section-title">Profile Information</h2>
                    <p class="section-subtitle">Update your personal details and profile picture</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="showLoading(this)">
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture -->
                    <div class="profile-picture-container">
                        <img id="profile_preview"
                            src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/150/667eea/ffffff?text=' . substr($user->name, 0, 1) }}"
                            alt="Profile Picture" class="profile-picture">
                        <label for="profile_picture" class="camera-overlay">
                            <i class="fas fa-camera text-lg"></i>
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*"
                            onchange="previewImage(event)">

                        @if($user->profile_picture)
                            <div class="text-center mt-4">
                                <form action="{{ route('profile.removePicture') }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to remove your profile picture?')">
                                    @csrf
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-trash mr-2"></i>Remove Picture
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Name and Email -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user mr-2 text-blue-500"></i>Full Name
                            </label>
                            <input type="text" id="name" name="name" class="form-input"
                                value="{{ old('name', $user->name) }}" placeholder="Enter your full name">
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope mr-2 text-blue-500"></i>Email Address
                            </label>
                            <input type="email" id="email" name="email" class="form-input"
                                value="{{ old('email', $user->email) }}" placeholder="Enter your email address">
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="text-center mt-10">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-3"></i>Save Profile
                        </button>

                        <div class="mt-4">
                            <a href="{{ route('profile.exportData') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 text-sm font-medium">
                                <i class="fas fa-download mr-2"></i>Export My Data
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Password Change Section -->
            <div class="glass-card rounded-3xl p-10 mb-8">
                <div class="mb-8">
                    <h2 class="section-title">
                        <i class="fas fa-lock mr-3 text-green-500"></i>Change Password
                    </h2>
                    <p class="section-subtitle">Update your password to keep your account secure</p>
                </div>

                <form action="{{ route('profile.updatePassword') }}" method="POST" onsubmit="showPasswordLoading(this)">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="form-group">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-key mr-2 text-green-500"></i>Current Password
                            </label>
                            <input type="password" id="current_password" name="current_password" class="form-input"
                                placeholder="Enter your current password">
                            @error('current_password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="form-label">
                                <i class="fas fa-shield-alt mr-2 text-green-500"></i>New Password
                            </label>
                            <input type="password" id="new_password" name="new_password" class="form-input"
                                placeholder="Enter your new password" onkeyup="updatePasswordStrength(this.value)">
                            <div class="mt-2">
                                <span class="text-sm text-gray-500">Password strength: </span>
                                <span id="password-strength" class="text-sm font-medium text-red-500">Very Weak</span>
                            </div>
                            @error('new_password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>Confirm New Password
                        </label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-input" placeholder="Confirm your new password">
                        @error('new_password_confirmation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center mt-10">
                        <button type="submit" class="btn-success">
                            <i class="fas fa-key mr-3"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account Section -->
            <div class="glass-card rounded-3xl p-10">
                <div class="mb-8">
                    <h2 class="section-title text-red-600">
                        <i class="fas fa-exclamation-triangle mr-3"></i>Delete Account
                    </h2>
                    <p class="section-subtitle">Permanently delete your account and all associated data</p>
                </div>

                <form action="{{ route('profile.delete') }}" method="POST"
                    onsubmit="if(confirm('Are you sure you want to delete your account? This action cannot be undone.')) { showDeleteLoading(this); return true; } else { return false; }">
                    @csrf
                    @method('DELETE')

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock mr-2 text-red-500"></i>Confirm Password
                        </label>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter your password to confirm deletion">
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center mt-10">
                        <button type="submit" class="btn-danger">
                            <i class="fas fa-trash mr-3"></i>Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide success messages
        document.addEventListener("DOMContentLoaded", function () {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(function () {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(function () {
                        alert.remove();
                    }, 500);
                }, 5000);
            }

            // Add form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    }
                });
            });

            // Add password confirmation validation
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');

            if (newPasswordInput && confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', function () {
                    if (this.value !== newPasswordInput.value) {
                        this.setCustomValidity('Passwords do not match');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });

        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.history.url);
        }
    </script>
</body>

</html>