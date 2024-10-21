@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Walkin-Client Update</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('walkins.update', $walkin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" class="form-control" value="{{ $walkin->firstname }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="{{ $walkin->lastname }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middlename" class="form-control" value="{{ $walkin->middlename }}">
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $walkin->date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" name="time" class="form-control" value="{{ $walkin->time }}" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" value="{{ $walkin->amount }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="payment">Payment</label>
                            <input type="text" name="payment" class="form-control" value="{{ $walkin->payment }}"
                                required>
                        </div>
                        <div class="single_form">
                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                            <a href="/walkin-clients" class="btn btn-outline-dark mt-2">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection