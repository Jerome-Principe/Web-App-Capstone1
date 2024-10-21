@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Equipment Add</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('equipmentsadd.update', $equipment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name"
                                placeholder="Enter Item Name" value="{{ $equipment->item_name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity"
                                name="quantity" value="{{ $equipment->quantity }}" required>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Enter the date"
                                value="{{ $equipment->date }}" required>
                        </div>

                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" class="form-control" id="time" name="time" placeholder="Enter the time"
                                value="{{ $equipment->time }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                        <a href="/equipmentsadd" class="btn btn-outline-dark mt-2">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection