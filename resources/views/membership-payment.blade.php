@extends('layouts.app')

@section('title', 'Payment')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-yellow-400 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('membership.renewal') }}" class="text-black hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </a>
                        <h1 class="ml-4 text-xl font-bold text-black">Payment</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-md mx-auto mt-8 px-4">
            <div class="bg-yellow-400 rounded-lg shadow-lg p-6">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-32 h-32 bg-black rounded-lg flex items-center justify-center relative">
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        <div
                            class="absolute -top-2 -right-2 w-8 h-8 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-black text-center mb-4">Payment Process</h2>

                <!-- Description -->
                <p class="text-black text-center mb-6 text-sm">
                    Renew during business hours for faster processing.
                </p>

                <!-- Payment Method Selection -->
                <div class="mb-6">
                    <label class="block text-black font-medium mb-2">Payment Method:</label>
                    <select id="paymentMethod"
                        class="w-full p-3 border border-gray-300 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="Cash">Cash</option>
                        <option value="GCash">GCash</option>
                    </select>
                </div>

                <!-- Cash Payment Details -->
                <div id="cashDetails" class="bg-gray-200 rounded-lg p-4 mb-6">
                    <p class="text-black text-sm mb-3">Pay the amount below at the gym counter.</p>
                    <div class="space-y-2">
                        <p class="text-black text-sm">
                            Membership Type: <span id="cashMembershipType"
                                class="font-bold">{{ request('type', 'Gold') }}</span>
                        </p>
                        <p class="text-black text-sm">
                            Amount to pay: <span id="cashAmount" class="font-bold">₱
                                {{ number_format(request('amount', 3500)) }}</span>
                        </p>
                    </div>
                </div>

                <!-- GCash Payment Details -->
                <div id="gcashDetails" class="bg-gray-200 rounded-lg p-4 mb-6 hidden">
                    <p class="text-black text-sm mb-3">GCash No. 0969-091-8489</p>
                    <div class="space-y-2 mb-4">
                        <p class="text-black text-sm">
                            Membership Type: <span id="gcashMembershipType"
                                class="font-bold">{{ request('type', 'Gold') }}</span>
                        </p>
                        <p class="text-black text-sm">
                            Amount to pay: <span id="gcashAmount" class="font-bold">₱
                                {{ number_format(request('amount', 3500)) }}</span>
                        </p>
                    </div>

                    <!-- GCash Form Fields -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-black font-medium mb-2 text-sm">Account Name:</label>
                            <input type="text" id="gcashAccountName" placeholder="e.g., Juan Dela Cruz"
                                class="w-full p-3 border border-gray-300 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label class="block text-black font-medium mb-2 text-sm">Account Number:</label>
                            <input type="text" id="gcashAccountNumber" placeholder="e.g., 09171234567"
                                class="w-full p-3 border border-gray-300 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label class="block text-black font-medium mb-2 text-sm">Upload Proof of Payment:</label>
                            <input type="file" id="proofOfPayment" accept="image/*"
                                class="w-full p-3 border border-gray-300 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <div id="imagePreview" class="mt-2 hidden">
                                <img id="previewImage" class="w-full h-32 object-cover rounded-lg" alt="Proof of Payment">
                                <button id="removeImage" class="mt-2 text-red-600 text-sm">Remove Image</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proceed Button -->
                <button id="proceedBtn"
                    class="w-full bg-black text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                    Proceed to Payment
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethodSelect = document.getElementById('paymentMethod');
            const cashDetails = document.getElementById('cashDetails');
            const gcashDetails = document.getElementById('gcashDetails');
            const proceedBtn = document.getElementById('proceedBtn');
            const proofOfPaymentInput = document.getElementById('proofOfPayment');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const removeImageBtn = document.getElementById('removeImage');

            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const membershipType = urlParams.get('type') || 'Gold';
            const amount = urlParams.get('amount') || '3500';

            // Update all membership type and amount displays
            document.querySelectorAll('[id$="MembershipType"]').forEach(el => el.textContent = membershipType);
            document.querySelectorAll('[id$="Amount"]').forEach(el => el.textContent = `₱ ${parseInt(amount).toLocaleString()}`);

            function togglePaymentDetails() {
                const selectedMethod = paymentMethodSelect.value;
                if (selectedMethod === 'Cash') {
                    cashDetails.classList.remove('hidden');
                    gcashDetails.classList.add('hidden');
                } else {
                    cashDetails.classList.add('hidden');
                    gcashDetails.classList.remove('hidden');
                }
            }

            paymentMethodSelect.addEventListener('change', togglePaymentDetails);

            // Handle file upload
            proofOfPaymentInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle image removal
            removeImageBtn.addEventListener('click', function () {
                proofOfPaymentInput.value = '';
                imagePreview.classList.add('hidden');
            });

            // Handle proceed button
            proceedBtn.addEventListener('click', function () {
                const selectedMethod = paymentMethodSelect.value;

                if (selectedMethod === 'GCash') {
                    const accountName = document.getElementById('gcashAccountName').value;
                    const accountNumber = document.getElementById('gcashAccountNumber').value;
                    const proofFile = proofOfPaymentInput.files[0];

                    if (!accountName || !accountNumber || !proofFile) {
                        alert('Please complete all GCash payment fields.');
                        return;
                    }
                }

                // Show confirmation dialog
                if (confirm(`Proceed with ${selectedMethod} payment for ₱ ${parseInt(amount).toLocaleString()}?`)) {
                    // Here you would typically submit the form to your backend
                    alert('Payment request submitted successfully!');
                    // Redirect back to membership list
                    window.location.href = '{{ route("membership.list") }}';
                }
            });

            // Initialize payment details
            togglePaymentDetails();
        });
    </script>
@endsection