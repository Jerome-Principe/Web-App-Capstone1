@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card-header">
                <h2 class="display-6 text-center">Defect Equipment List</h2>

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
                    <a href="/equipments/create" class="btn btn-primary px-4">Add New</a>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="text-white">ID</th>
                                <th class="text-white">Item Name</th>
                                <th class="text-white">Quantity</th>
                                <th class="text-white">Defect</th>
                                <th class="text-white">Date</th>
                                <th class="text-white">Time</th>
                                <th class="text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipmentDefects as $index => $equipmentDefect)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $equipmentDefect->equipment->item_name }}</td>
                                    <td>{{ $equipmentDefect->quantity }}</td>
                                    <td>{{ $equipmentDefect->defect }}</td>
                                    <td>{{ $equipmentDefect->date }}</td>
                                    <td>{{ $equipmentDefect->time }}</td>
                                    <td>

                                        <a href="{{ route('equipments.edit', $equipmentDefect->id) }}"
                                            class="btn btn-primary mx-2">Edit</a>

                                        <form action="{{ route('equipments.destroy', $equipmentDefect->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mx-2"
                                                onclick="return confirm('Are you sure you want to delete this equipment?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection