@extends('layouts.app')
@section('title', $course->name)
@section('content')
    <div class="pb-4">
        <form action="{{ route('createResult') }}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <div class="row scroll">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="type" value="{{ $course->type }}">
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                @php
                    //Update existing result
                    $subjectIds = $result->pluck('subject_id')->toArray();
                    if (count($result)>0){
                        $courseData = $course->subjects->whereIn('id', $subjectIds)->sortBy('duration_part')->groupBy('duration_part');
                    }else{
                        if ($student->lateral_entry){
                            $courseData = $course->subjects->where('duration_part','>',$student->lateral_duration)->sortBy('duration_part')->groupBy('duration_part');
                        }else{
                            $courseData = $course->subjects->sortBy('duration_part')->groupBy('duration_part');
                        }
                    }
                @endphp
                <!-- Group subjects by duration (year/semester) -->
                @foreach ($courseData as $duration => $subjects)
                    <div class="col-md-6 mb-4">
                        <div class="card text-dark">
                            <div class="card-header bg-primary text-white">
                                {{ ucfirst($course->type) }} {{ $duration }}
                            </div>
                            <div class="card-body">
                                <!-- Loop through each subject in this duration -->
                                @foreach ($subjects as $index => $subject)
                                    @if(count($result->toArray()) > 0)
                                        <input type="hidden" name="subjects[{{ $duration }}][{{ $index }}][subject_id]" value="{{ $result->where('subject_id' , $subject->id)->first()?->id }}">
                                    @endif
                                    <h5>Subject {{$index+1}}</h5>
                                    <input type="hidden" name="subjects[{{ $duration }}][{{ $index }}][id]" value="{{ $subject->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Subject Name</label>
                                        <input readonly type="text"
                                               class="form-control"
                                               name="subjects[{{ $duration }}][{{ $index }}][name]"
                                               value="{{ old("subjects.$duration.$index.name", $subject->name) }}"
                                               placeholder="Enter Subject Name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subject Code</label>
                                        <input disabled type="text"
                                               class="form-control"
                                               name="subjects[{{ $duration }}][{{ $index }}][code]"
                                               value="{{ old("subjects.$duration.$index.code", $subject->code) }}"
                                               placeholder="Enter Subject Code" required>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <label class="form-label">Obtained Marks</label>
                                            @if(count($result->toArray()) > 0 )
                                                <input  type="number"
                                                       class="form-control mb-2"
                                                       name="subjects[{{ $duration }}][{{ $index }}][obtained_marks]"
                                                       max="{{ old("subjects.$duration.$index.max_marks", $subject->max_marks) }}"
                                                       value="{{ $result->where('subject_id' , $subject->id)->first()?->subject_obtained_marks }}"
                                                       placeholder="Enter Subject Obtained Marks" required>
                                            @else
                                                <input  type="number"
                                                        class="form-control mb-2"
                                                        name="subjects[{{ $duration }}][{{ $index }}][obtained_marks]"
                                                        max="{{ old("subjects.$duration.$index.max_marks", $subject->max_marks) }}"
                                                        value="{{ old("subjects.$duration.$index.obtained_marks") }}"
                                                        placeholder="Enter Subject Oasbtained Marks" required>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Min Marks</label>
                                            <input readonly type="number"
                                                   class="form-control"
                                                   name="subjects[{{ $duration }}][{{ $index }}][min_marks]"
                                                   value="{{ old("subjects.$duration.$index.min_marks", $subject->min_marks) }}"
                                                   placeholder="Enter Min Marks" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Max Marks</label>
                                            <input readonly type="number"
                                                   class="form-control"
                                                   name="subjects[{{ $duration }}][{{ $index }}][max_marks]"
                                                   value="{{ old("subjects.$duration.$index.max_marks", $subject->max_marks) }}"
                                                   placeholder="Enter Max Marks" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Is Practical?</label>
                                        <select class="readonly-select form-select practical-dropdown" id="practical-dropdown-{{ $duration }}-{{ $index }}" name="subjects[{{ $duration }}][{{ $index }}][is_practical]" required>
                                            <option value="false" {{ old("is_practical", $subject->is_practical) == 0 ? 'selected' : '' }}>No</option>
                                            <option value="true" {{ old("is_practical", $subject->is_practical) == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                    <!-- Practical Marks Section (Initially Hidden or Visible Based on Dropdown) -->
                                        @php
                                            $subjectResult = $result->where('subject_id', $subject->id)->first();
                                        @endphp
                                        <div id="practical-marks-{{ $duration }}-{{ $index }}" class="practical-marks row {{ ($subject->is_practical == 1 || old("subjects.$duration.$index.is_practical") == 1) ? '' : 'd-none' }}">
                                            <div class="col-md-12">
                                                <label class="form-label">Practical Obtained Marks</label>
                                                <input type="number" class="form-control mb-2" name="subjects[{{ $duration }}][{{ $index }}][practical_obtained_marks]" value="{{ $subjectResult?->practical_obtained_marks }}" max="{{ $subject->practical_max_marks ?? old("subjects.$duration.$index.practical_max_marks") }}" placeholder="Enter Practical Obtained Marks">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Practical Min Marks</label>
                                                <input readonly type="number" class="form-control" name="subjects[{{ $duration }}][{{ $index }}][practical_min_marks]" value="{{ $subject->practical_min_marks ?? old("subjects.$duration.$index.practical_min_marks") }}" placeholder="Min Practical Marks">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Practical Max Marks</label>
                                                <input readonly type="number" class="form-control" name="subjects[{{ $duration }}][{{ $index }}][practical_max_marks]" value="{{ $subject->practical_max_marks ?? old("subjects.$duration.$index.practical_max_marks") }}" placeholder="Max Practical Marks">
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn {{count($result->toArray()) ? 'btn-warning' : 'btn-primary'}} mt-5 mx-auto d-block">{{count($result->toArray()) ? 'Update Result' : 'Create Result'}}</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".readonly-select").forEach(select => {
                select.addEventListener("mousedown", function(e) {
                    e.preventDefault(); // Prevents dropdown from opening
                });
                select.addEventListener("keydown", function(e) {
                    e.preventDefault(); // Prevents selection changes via keyboard
                });
            });
        });
    </script>
@endsection
