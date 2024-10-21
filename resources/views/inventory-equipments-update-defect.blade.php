@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Equipment</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name"
                                value="{{ $equipment->equipment->item_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ $equipment->quantity }}" required>
                        </div>

                        <div class="form-group">
                            <label for="defect">Defect</label>
                            <select name="defect" id="defect" class="form-control">
                                <option value="None" {{ $equipment->defect == 'None' ? 'selected' : '' }}>None</option>
                                <option value="Broken" {{ $equipment->defect == 'Broken' ? 'selected' : '' }}>Broken
                                </option>
                                <option value="Very Rusty" {{ $equipment->defect == 'Very Rusty' ? 'selected' : '' }}>Very
                                    Rusty
                                </option>
                                <option value="Loose Bearings" {{ $equipment->defect == 'Loose Bearings' ? 'selected' : '' }}>Loose Bearings
                                </option>
                                <option value="Torn Bands" {{ $equipment->defect == 'Torn Bands' ? 'selected' : '' }}>Torn
                                    Bands
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $equipment->date }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time" name="time" value="{{ $equipment->time }}"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                        <a href="/equipments" class="btn btn-outline-dark mt-2">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection