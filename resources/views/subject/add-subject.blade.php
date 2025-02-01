@extends('layouts.app')
@section('title', 'Add Subject')
@section('content')
    <div class="pb-4">
        <h4 class="text-center">{{$course->name}}</h4>
        <form action="{{ route('addSubject') }}" method="POST">
            @csrf
            <div class="row scroll">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="type" value="{{ $course->type }}">
                <!-- Loop through the number of durations -->
                @for ($i = 1; $i <= $course->duration; $i++)
                    <div class="col-md-6 mb-4">
                        <div class="card text-dark">
                            <div class="card-header bg-primary text-white">
                                {{ ucfirst($course->type) }} {{ $i }}
                            </div>
                            <div class="card-body">
                                <div id="subject-container-{{ $i }}">
                                    <!-- Initial Subject -->
                                    <div class="subject-form mb-3">
                                        <h5>Subject 1</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Subject Name</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="subjects[{{ $i }}][name][]"
                                                   value="{{ old('subjects.' . $i . '.name.0') }}"
                                                   placeholder="Enter Subject Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subject Code</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="subjects[{{ $i }}][code][]"
                                                   value="{{ old('subjects.' . $i . '.code.0') }}"
                                                   placeholder="Enter Subject Code" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Min Marks</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="subjects[{{ $i }}][min_marks][]"
                                                       value="{{ old('subjects.' . $i . '.min_marks.0') }}"
                                                       placeholder="Enter Min Marks" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Max Marks</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="subjects[{{ $i }}][max_marks][]"
                                                       value="{{ old('subjects.' . $i . '.max_marks.0') }}"
                                                       placeholder="Enter Max Marks" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Is Practical?</label>
                                            <select class="form-select practical-dropdown"
                                                    data-index="{{ $i }}"
                                                    name="subjects[{{ $i }}][is_practical][]"
                                                    required>
                                                <option value="false"
                                                    {{ old('subjects.' . $i . '.is_practical.0') === 'false' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                                <option value="true"
                                                    {{ old('subjects.' . $i . '.is_practical.0') === 'true' ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                            </select>
                                        </div>
                                        <div class="practical-marks row
                                    {{ old('subjects.' . $i . '.is_practical.0') === 'true' ? '' : 'd-none' }}">
                                            <div class="col-md-6">
                                                <label class="form-label">Practical Min Marks</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="subjects[{{ $i }}][practical_min_marks][]"
                                                       value="{{ old('subjects.' . $i . '.practical_min_marks.0') }}"
                                                       placeholder="Min Practical Marks">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Practical Max Marks</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="subjects[{{ $i }}][practical_max_marks][]"
                                                       value="{{ old('subjects.' . $i . '.practical_max_marks.0') }}"
                                                       placeholder="Max Practical Marks">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success add-subject-btn mt-3"
                                        data-index="{{ $i }}">Add Subject
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <button type="submit" class="btn btn-success mt-5 mx-auto d-block">Add Subjects</button>
        </form>
    </div>

@endsection
