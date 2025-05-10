<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A responsive admin dashboard template with sidebar navigation.">
    <meta name="robots" content="index, follow">
    <title>@yield('title', '') {{$siteSetting->title ?? ''}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#337ab7">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/img/siteLogo.png')}}">
</head>
<body>
<div id="loader">
    <div class="spinner"></div>
</div>
<div id="toastContainer" class="toast-container"></div>
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #337ab7; color: white;">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span id="actionType"></span> this <span id="entityType"></span>?</p>
            </div>
            <div class="modal-footer">
                <a href="{{request()->url()}}" type="button" class="btn btn-secondary">Cancel</a>
                <button type="button" class="btn btn-danger" id="confirmAction" style="background-color: #337ab7;">Yes, Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #337ab7; color: white;">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
            </div>
            <form id="deleteForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="deleteEntityId">
                <div class="modal-body">
                    <p id="deleteMessage">Are you sure you want to delete this <span id="entityName"></span>?</p>
                    <div class="mb-3">
                        <label for="password" class="form-label">Enter Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="toast-container">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: #d4edda; color: #155724;">
            <div class="toast-body text-dark">
                <button type="button" class="btn-close float-end d-flex justify-content-center"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif
@if(session('validation_errors'))
    <div class="toast-container">
        @foreach(session('validation_errors') as $error)
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <button type="button" class="btn-close float-end d-flex justify-content-center"
                            data-bs-dismiss="toast" aria-label="Close"></button>
                    {{ $error }}
                </div>
            </div>
        @endforeach
    </div>
@endif


@php
    $profileImage = auth()->user() !== null && auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('assets/img/profileImage.png');
@endphp


@if(auth()->user())
    <div class="main-container d-flex" id="content">
        @include('layouts.header')
        <main class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-light top-bar" aria-label="Main navigation">
                <div class="container-fluid">
                    <div class="d-flex d-lg-none d-block">
                        <button class="btn px-1 py-0 open-btn me-2 text-white open-menu" aria-label="Open sidebar">
                            <i class="bi bi-list" style="font-size: 28px !important;"></i>
                        </button>
                        <img id="logoPreview"
                             src="{{ isset($siteSetting) && $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/img/siteLogo.png') }}"
                             alt="Logo Preview" class="img-fluid"
                             style="height: 75px;">
                    </div>
                    <div class="d-flex flex-grow-1 justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active text-white d-flex align-items-center" aria-current="page"
                                   href="{{route('profileSettingPage')}}" title="View Profile">
                                    <img class="img-fluid d-block profile-image mx-2" src="{{$profileImage}}"
                                         alt="{{$profileImage}}">
                                    {{auth()->user()->name}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            @endif

            <section class="{{auth()->check() ? 'dashboard-content px-3 pt-4' : ''}} position-relative" style="height: 80%">
                @if(auth()->user())

                    <div class=" heading mb-4 d-inline-flex w-100 align-items-center position-relative">

                    <a href="{{ url()->previous() }}" class="btn btn-primary position-absolute l-3">Go Back</a> <h1 class="mx-auto mb-0">@yield('title')</h1>
                    </div>
                @endif
                @yield('content')
            </section>


            @if(auth()->user())
        </main>
    </div>
    @include('layouts.footer')
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="{{asset('assets/js/script.js')}}"></script>
<script src="{{asset('assets/js/center.js')}}"></script>
<script src="{{asset('assets/js/addSubject.js')}}"></script>
<script src="{{asset('assets/js/subject.js')}}"></script>
<script src="{{asset('assets/js/updateSubject.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // The button that triggered the modal
            var entity = button.getAttribute('data-entity'); // e.g., 'student', 'center'
            var entityId = button.getAttribute('data-id'); // Entity ID

            var form = document.getElementById('deleteForm');
            var entityInput = document.getElementById('deleteEntityId');
            var entityNameSpan = document.getElementById('entityName');
            var deleteMessage = document.getElementById('deleteMessage');

            // Update modal text
            entityNameSpan.textContent = entity;
            deleteMessage.innerHTML = `Are you sure you want to delete this <strong>${entity}</strong>?`;

            // Update form action dynamically
            form.action = `/delete-${entity}`; // e.g., /delete-student or /delete-center

            // Update hidden input field dynamically
            entityInput.name = `${entity}_id`; // e.g., student_id, center_id
            entityInput.value = entityId;
        });
    });
</script>
</body>
