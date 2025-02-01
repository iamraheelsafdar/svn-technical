@extends('layouts.app')
@section('title', 'Update Subject')
@section('content')
    <div class="pb-4">
        <h4 class="text-center">{{$course->name}}</h4>
        <form action="{{ route('updateSubjects') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <div class="row scroll">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="type" value="{{ $course->type }}">

                <!-- Group subjects by duration (year/semester) -->
                @foreach ($course->subjects->groupBy('duration_part') as $duration => $subjects)
                    <div class="col-md-6 mb-4">
                        <div class="card text-dark">
                            <div class="card-header bg-primary text-white">
                                {{ ucfirst($course->type) }} {{ $duration }}
                            </div>
                            <div class="card-body">
                                <!-- Loop through each subject in this duration -->
                                @foreach ($subjects as $index => $subject)
                                    <h5>Subject {{$index+1}}</h5>
                                    <input type="hidden" name="subjects[{{ $duration }}][{{ $index }}][id]" value="{{ $subject->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Subject Name</label>
                                        <input type="text"
                                               class="form-control"
                                               name="subjects[{{ $duration }}][{{ $index }}][name]"
                                               value="{{ old("subjects.$duration.$index.name", $subject->name) }}"
                                               placeholder="Enter Subject Name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subject Code</label>
                                        <input type="text"
                                               class="form-control"
                                               name="subjects[{{ $duration }}][{{ $index }}][code]"
                                               value="{{ old("subjects.$duration.$index.code", $subject->code) }}"
                                               placeholder="Enter Subject Code" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Min Marks</label>
                                            <input type="number"
                                                   class="form-control"
                                                   name="subjects[{{ $duration }}][{{ $index }}][min_marks]"
                                                   value="{{ old("subjects.$duration.$index.min_marks", $subject->min_marks) }}"
                                                   placeholder="Enter Min Marks" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Max Marks</label>
                                            <input type="number"
                                                   class="form-control"
                                                   name="subjects[{{ $duration }}][{{ $index }}][max_marks]"
                                                   value="{{ old("subjects.$duration.$index.max_marks", $subject->max_marks) }}"
                                                   placeholder="Enter Max Marks" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Is Practical?</label>
                                        <select class="form-select practical-dropdown" id="practical-dropdown-{{ $duration }}-{{ $index }}" name="subjects[{{ $duration }}][{{ $index }}][is_practical]" required>
                                            <option value="false" {{ old("is_practical", $subject->is_practical) == 0 ? 'selected' : '' }}>No</option>
                                            <option value="true" {{ old("is_practical", $subject->is_practical) == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                    <!-- Practical Marks Section (Initially Hidden or Visible Based on Dropdown) -->
                                    <div id="practical-marks-{{ $duration }}-{{ $index }}" class="practical-marks row {{ old("subjects.$duration.$index.is_practical", $subject->is_practical) == 1 ? '' : 'd-none' }}">
                                        <div class="col-md-6">
                                            <label class="form-label">Practical Min Marks</label>
                                            <input type="number" class="form-control" name="subjects[{{ $duration }}][{{ $index }}][practical_min_marks]" value="{{ old("subjects.$duration.$index.practical_min_marks", $subject->practical_min_marks) }}" placeholder="Min Practical Marks">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Practical Max Marks</label>
                                            <input type="number" class="form-control" name="subjects[{{ $duration }}][{{ $index }}][practical_max_marks]" value="{{ old("subjects.$duration.$index.practical_max_marks", $subject->practical_max_marks) }}" placeholder="Max Practical Marks">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-danger mt-5 mx-auto d-block">Update Subjects</button>
        </form>
    </div>

@endsection
