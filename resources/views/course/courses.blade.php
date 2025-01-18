@extends('layouts.app')
@section('title', 'Courses')
@section('content')
    <div class=" mt-5">
        <h2>Add Course</h2>
        <form id="courseForm" class="row">
            <!-- Course Title -->
            <div class="col-6 mb-3">
                <label for="courseTitle" class="form-label">Course Title</label>
                <input type="text" class="form-control" id="courseTitle" name="courseTitle" required>
            </div>

            <!-- Course Type (Year/Semester) -->
            <div class="col-6 mb-3">
                <label for="courseType" class="form-label">Course Type</label>
                <select class="form-select" id="courseType" name="courseType" required>
                    <option value="" disabled selected>Select Course Type</option>
                    <option value="year">Year</option>
                    <option value="semester">Semester</option>
                </select>
            </div>

            <!-- Course Duration -->
            <div class="col-6 mb-3">
                <label for="duration" class="form-label">Duration (Years/Semesters)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1" required>
            </div>

            <!-- Years/Semesters Sections -->
            <div id="durationSection" class="row">
                <!-- Dynamically Added Years/Semesters -->
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4 w-auto mx-auto">Save Course</button>
        </form>
    </div>
@endsection
