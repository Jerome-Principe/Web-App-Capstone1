@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card-header">
                <h1 class="display-6 text-center"><b>Admin User Information</b></h1>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div>
                <div class="d-flex justify-content-end position-relative">
                    <a href="/register" class="btn btn-primary px-4">Add New</a>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <tr class="bg-dark text-white">
                            <td>ID</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Created_At</td>
                            <td>Updated_At</td>
                            <td>Action</td>
                        </tr>

                        @foreach ($users as $user)
                            <tr>
                                <th>{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->updated_at}}</td>
                                <td>
                                    <a href="#" class="btn btn-primary mx-2">Edit</a>

                                    <form action="#" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-2"
                                            onclick="return confirm('Are you sure you want to delete this user account?')">Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection