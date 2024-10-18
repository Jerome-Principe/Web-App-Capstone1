@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Supplement</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('supplements.update', $supplement->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Item Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $supplement->name }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control"
                                value="{{ $supplement->quantity }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" value="{{ $supplement->price }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $supplement->date }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" name="time" class="form-control" value="{{ $supplement->time }}"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                        <a href="/supplements" class="btn btn-outline-dark mt-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection