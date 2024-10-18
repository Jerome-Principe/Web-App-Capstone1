@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card-header">
                <h2 class="display-6 text-center">View Supplement List</h2>

                @if(session('success'))
                    <div class="custom-alert-message">
                        {{ session('success') }}
                    </div>
                @endif

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        setTimeout(function () {
                            const alert = document.querySelector('.custom-alert-message');
                            if (alert) {
                                alert.classList.add('fade-out');
                            }
                        }, 3000); // 3000ms = 3 seconds
                    });
                </script>

            </div>

            <div>
                <div class="d-flex justify-content-end position-relative">
                    <a href="/supplements/create" class="btn btn-primary px-4">Add New</a>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-dark">
                                <th class="text-white">ID</th>
                                <th class="text-white">Name</th>
                                <th class="text-white">Quantity</th>
                                <th class="text-white">Price </th>
                                <th class="text-white">Total</th>
                                <th class="text-white">Date</th>
                                <th class="text-white">Time</th>

                                <th class="text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplements as $index => $supplement)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $supplement->name }}</td>
                                    <td>{{ $supplement->quantity }}</td>
                                    <td>{{ $supplement->price }}</td>
                                    <td>{{ $supplement->total }}</td>
                                    <td>{{ $supplement->date }}</td>
                                    <td>{{ $supplement->time }}</td>

                                    <td>
                                        <a href="{{ route('supplements.edit', $supplement->id) }}"
                                            class="btn btn-primary mx-2">Edit</a>

                                        <form action="{{ route('supplements.destroy', $supplement->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mx-2"
                                                onclick="return confirm('Are you sure you want to delete this walk-in client?')">Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <h5>Total Price : {{ $totalPrice }}</h5>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection