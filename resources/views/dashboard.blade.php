@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrapper row">
            <div class="col-12 col-lg-3 col-md-6">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-12 col-lg-9 col-md-6">
                <ol class="breadcrumb float-right">
                    <li><a href="/dashboard">Home</a></li>
                    <li class="active">/ Dashboard</li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb End -->
    </div>
    <!-- Title Count Start -->
    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <div class="icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                                <p class="text-muted">Active Member</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <div class="icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                                <p class="text-muted">Walkin-client</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-success">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <div class="icon"><i class="fa fa-file" aria-hidden="true"></i></div>
                                <p class="text-muted">Inventory</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-info">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 0%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                <p class="text-muted">Appointment</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-purple">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 0%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                                <p class="text-muted">Staff</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-purple">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 0%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Title Count End -->
    <div class="container">

    </div>
@endsection