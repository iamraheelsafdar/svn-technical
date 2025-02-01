@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="bg-primary mx-auto text-center p-3 d-flex align-items-center justify-content-between"><h2 class="mb-0">
            Welcome, {{auth()->user()->name}} ! </h2>
        <div class="ms-4 clock">
            <div class="center"></div>
            <div class="hand hour" id="hour"></div>
            <div class="hand minute" id="minute"></div>
            <div class="hand second" id="second"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <!-- Card 1 -->
            <div class="{{auth()->user()->role == 'Center' ? 'col-12' : 'col-12 col-md-6 col-lg-3 mb-4'}}">
                <div class="card bg-success-custom text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Students</h5>
                                <p class="mb-0">Active: {{$details['active_students']}}</p>
                                <p>Inactive: {{$details['inactive_students']}}</p>
                                <h6>Total: {{$details['total_students']}}</h6>
                            </div>
                            <i class="bi bi-person-workspace card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->role == 'Admin')
                <!-- Card 2 -->
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card bg-primary-custom text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Centers</h5>
                                    <p class="mb-0">Active: {{$details['active_centers']}}</p>
                                    <p>Inactive: {{$details['inactive_centers']}}</p>
                                    <h6>Total: {{$details['total_centers']}}</h6>
                                </div>
                                <i class="bi bi-people-fill card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card bg-danger-custom text-white shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Enrollment</h5>
                                    <p class="mb-0">Active: {{$details['active_enrollments']}}</p>
                                    <p>Inactive: {{$details['inactive_enrollments']}}</p>
                                    <h6>Total: {{$details['total_enrollments']}}</h6>
                                </div>
                                <i class="bi bi-mortarboard-fill  card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card bg-warning-custom shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Courses</h5>
                                    <p class="mb-0">Active: {{$details['active_courses']}}</p>
                                    <p>Inactive: {{$details['inactive_courses']}}</p>
                                    <h6>Total: {{$details['total_courses']}}</h6>
                                </div>
                                <i class="bi bi-pencil-fill card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
