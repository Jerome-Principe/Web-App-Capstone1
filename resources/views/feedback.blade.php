@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
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


                        @for ($i = 0; $i < count($feedback); $i++)
                            <tr>
                                <th>{{$i + 1}}</th>
                                <td>{{$feedback[$i]->name}}</td>
                                <td>{{$feedback[$i]->email}}</td>
                                <td>{{$feedback[$i]->subject}}</td>
                                <td>{{$feedback[$i]->message}}</td>
                                <td>
                                    <a href="/feedback/{{$feedback[$i]->id}}/edit" class="btn btn-primary mx-2">Edit</a>
                                    <form action="{{ route('feedback.destroy', $feedback[$i]->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-2"
                                            onclick="return confirm('Are you sure you want to delete this feedback?')">Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endfor

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection