@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Machine Defect</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('machine-defects.update', $machineDefect->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" name="item_name" class="form-control" value="{{ $machineDefect->name }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control"
                                value="{{ $machineDefect->quantity }}" required>
                        </div>

                        <div class="form-group">
                            <label for="defect">Defect</label>
                            <select name="defect" class="form-control" id="defect">
                                <option value="None" {{ $machineDefect->defect == 'None' ? 'selected' : '' }}>None
                                </option>
                                <option value="Loose Cables" {{ $machineDefect->defect == 'Loose Cables' ? 'selected' : '' }}>
                                    Loose Cables</option>
                                <option value="Treadmill No Safety Keys" {{ $machineDefect->defect == 'Treadmill No Safety Keys' ? 'selected' : '' }}>Treadmill no safety keys</option>
                                <option value="Damaged Cables" {{ $machineDefect->defect == 'Damaged Cables' ? 'selected' : '' }}>Damaged Cables</option>
                                <option value="Missing Bearing" {{ $machineDefect->defect == 'Missing Bearing' ? 'selected' : '' }}>Missing Bearing</option>
                                <option value="Broke Belt" {{ $machineDefect->defect == 'Broke Belt' ? 'selected' : '' }}>
                                    Broke
                                    Belt</option>
                                <option value="Inflated Balloons" {{ $machineDefect->defect == 'Inflated Balloons' ? 'selected' : '' }}>Inflated Balloons</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $machineDefect->date }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" name="time" class="form-control" value="{{ $machineDefect->time }}"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                        <a href="/machine-defects" class="btn btn-outline-dark mt-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection