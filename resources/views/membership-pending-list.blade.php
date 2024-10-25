@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card-header">
                <h2 class="display-6 text-center">Pending Membership Approvals</h2>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="text-white">ID</th>
                                <th class="text-white">First Name</th>
                                <th class="text-white">Last Name</th>
                                <th class="text-white">Email</th>
                                <th class="text-white">Password</th>
                                <th class="text-white">Membership Plan</th>
                                <th class="text-white">Status</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingMemberships as $membership)
                                <tr>
                                    <td>{{ $membership->id }}</td>
                                    <td>{{ $membership->first_name }}</td>
                                    <td>{{ $membership->last_name }}</td>
                                    <td>{{ $membership->email }}</td>
                                    <td>{{ $membership->password }}</td>
                                    <td>{{ $membership->membership_plan }}</td>
                                    <td>{{ $membership->status }}</td>
                                    <td>
                                        @if($membership->status === 'Pending')
                                            <form action="{{ route('membership-pendings.approve', $membership->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>

                                            <form action="{{ route('membership-pendings.decline', $membership->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Decline</button>
                                            </form>
                                        @else
                                            {{ $membership->status }}
                                        @endif
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