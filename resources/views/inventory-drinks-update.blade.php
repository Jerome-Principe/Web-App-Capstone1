@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Drinks Update</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('drinks.update', $drink->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name"
                                value="{{ $drink->item_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ $drink->quantity }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ $drink->price }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $drink->date }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time" name="time" value="{{ $drink->time }}"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Save</button>
                        <a href="/drinks" class="btn btn-outline-dark mt-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection