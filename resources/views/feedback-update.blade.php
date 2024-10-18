@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Feedback Update</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('feedback.update', $data->id) }}" method="POST">
                        @csrf
                        <div class="single_form">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Name" value={{$data->name}} class="form-control"
                                class="form-control" required>
                        </div>
                        <div class="single_form">
                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="Mobile number or email" value={{$data->email}}
                                class="form-control" required>
                        </div>
                        <div class="single_form">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" placeholder="Subject" value={{$data->subject}}
                                class="form-control" required>
                        </div>
                        <div class="single_form">
                            <label for="message">Message</label>
                            <input type="text" name="message" placeholder="Message" value={{$data->message}}
                                class="form-control" required>
                        </div>
                        <p class="form-message"></p>
                        <div class="single_form">
                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                            <a href="/feedback" class="btn btn-outline-dark mt-2">Back</a>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection