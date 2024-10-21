@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="display-6 text-center">Edit Admin User</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin-users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                        <a href="/admin-users" class="btn btn-outline-dark mt-2">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection