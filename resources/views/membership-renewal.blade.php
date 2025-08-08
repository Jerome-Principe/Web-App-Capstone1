@extends('layouts.app')

@section('title', 'Membership Renewal')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-yellow-400 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('membership.list') }}" class="text-black hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </a>
                        <h1 class="ml-4 text-xl font-bold text-black">Membership</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-md mx-auto mt-8 px-4">
            <div class="bg-yellow-400 rounded-lg shadow-lg p-6">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-32 h-32 bg-black rounded-lg flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-black text-center mb-4">Membership Renewal</h2>

                <!-- Description -->
                <p class="text-black text-center mb-6 text-sm">
                    We encourage you to renew during business hours to ensure early processing of your membership.
                </p>

                <!-- Membership Type Selection -->
                <div class="mb-6">
                    <label class="block text-black font-medium mb-2">Membership Type:</label>
                    <select id="membershipType"
                        class="w-full p-3 border border-gray-300 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="Gold">Gold</option>
                        <option value="Silver">Silver</option>
                        <option value="Bronze">Bronze</option>
                    </select>
                </div>

                <!-- Amount Display -->
                <div class="bg-white rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-black font-medium">Amount:</span>
                        <span id="amount" class="text-black font-bold text-lg">₱ 3,500</span>
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
            const membershipTypeSelect = document.getElementById('membershipType');
            const amountDisplay = document.getElementById('amount');
            const proceedBtn = document.getElementById('proceedBtn');

            const membershipAmounts = {
                'Gold': 3500,
                'Silver': 2000,
                'Bronze': 800
            };

            function updateAmount() {
                const selectedType = membershipTypeSelect.value;
                const amount = membershipAmounts[selectedType];
                amountDisplay.textContent = `₱ ${amount.toLocaleString()}`;
            }

            membershipTypeSelect.addEventListener('change', updateAmount);

            proceedBtn.addEventListener('click', function () {
                const selectedType = membershipTypeSelect.value;
                const amount = membershipAmounts[selectedType];

                // Redirect to payment page with parameters
                window.location.href = `{{ route('membership.payment') }}?type=${selectedType}&amount=${amount}`;
            });

            // Initialize amount
            updateAmount();
        });
    </script>
@endsection