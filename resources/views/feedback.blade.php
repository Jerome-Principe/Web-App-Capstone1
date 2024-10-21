@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col">
            <div class="card-header">
                <h2 class="display-6 text-center">Feedback Data</h2>
            </div>
            <div class="card mt-5">

                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <tr class="bg-dark text-white">
                            <th class="text-white">ID</th>
                            <th class="text-white">Name</th>
                            <th class="text-white">Email</th>
                            <th class="text-white">Subject</th>
                            <th class="text-white">Message</th>
                            <th class="text-white">Action</th>
                        </tr>

                        @foreach ($feedback as $index => $feedbacks)
                            <tr>
                                <td>{{ $feedback->perPage() * ($feedback->currentPage() - 1) + $index + 1 }}</td>
                                <td>{{ $feedbacks->name }}</td>
                                <td>{{ $feedbacks->email }}</td>
                                <td>{{ $feedbacks->subject }}</td>
                                <td>{{ $feedbacks->message }}</td>
                                <td>
                                    <a href="/feedback/{{ $feedbacks->id }}/edit" class="btn btn-primary"><i
                                            class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update</a>
                                    <form action="{{ route('feedback.destroy', $feedbacks->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this feedback?')">
                                            <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>


                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4">
                            <!-- Previous Button -->
                            <li class="page-item {{ $feedback->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $feedback->previousPageUrl() }}">Previous</a>
                            </li>

                            <!-- Pagination Links -->
                            @foreach ($feedback->getUrlRange(1, $feedback->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $feedback->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <!-- Next Button -->
                            <li class="page-item {{ $feedback->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $feedback->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection