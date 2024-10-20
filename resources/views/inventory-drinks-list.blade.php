@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col">
            <div class="card-header">

                <h2 class="display-6 text-center">View Drinks List</h2>

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
                    <a href="/drinks/create" class="btn btn-primary px-2"><i class="fa fa-plus mx-1"
                            aria-hidden="true"></i>Add New</a>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="text-white">ID</th>
                                <th class="text-white">Name</th>
                                <th class="text-white">Quantity</th>
                                <th class="text-white">Price</th>
                                <th class="text-white">Total</th>
                                <th class="text-white">Date</th>
                                <th class="text-white">Time</th>
                                <th class="text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drinks as $index => $drink)
                                <tr>
                                    <td>{{ ($drinks->currentPage() - 1) * $drinks->perPage() + $index + 1 }}</td>
                                    <td>{{ $drink->item_name }}</td>
                                    <td>{{ $drink->quantity }}</td>
                                    <td>{{ $drink->price }}</td>
                                    <td>{{ $drink->total }}</td>
                                    <td>{{ $drink->date }}</td>
                                    <td>{{ $drink->time }}</td>
                                    <td>
                                        <a href="{{ route('drinks.edit', $drink->id) }}" class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                        </a>
                                        <form action="{{ route('drinks.destroy', $drink->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this drink?')">
                                                <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <h5>Total Price = {{ $totalPrice }}</h5>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            <li class="page-item {{ $drinks->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $drinks->previousPageUrl() }}">Previous</a>
                            </li>

                            <!-- Pagination Links -->
                            @foreach ($drinks->getUrlRange(1, $drinks->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $drinks->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <!-- Next Button -->
                            <li class="page-item {{ $drinks->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $drinks->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection