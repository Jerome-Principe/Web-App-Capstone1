@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Machine Add</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('machines.update', $machineAdd->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name"
                                value="{{ $machineAdd->item_name}}" required>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ $machineAdd->quantity }}" required>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $machineAdd->date }}" required>
                        </div>

                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" class="form-control" id="time" name="time"
                                value="{{ $machineAdd->time }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                        <a href="/machines" class="btn btn-outline-dark mt-2">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection