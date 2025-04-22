$(document).ready(function () {
    let yearSemesterCounter = 0;

    // Helper function for ordinal numbers
    function getOrdinalNumber(number) {
        const ordinals = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth'];
        return ordinals[number - 1] || `${number}th`;
    }

    // Handle Change in Course Type
    $('#courseType').change(function () {
        $('#duration').val(''); // Reset duration
        $('#durationSection').empty(); // Clear previous sections
        yearSemesterCounter = 0; // Reset counter
    });

    // Handle Change in Duration
    $('#duration').change(function () {
        const duration = parseInt($(this).val());
        const type = $('#courseType').val();

        // Max duration limit set to 12
        if (duration > 12) {
            alert('The maximum course duration is 12.');
            $(this).val('');
            return;
        }

        if (!type) {
            alert('Please select course type (Year or Semester) first.');
            $(this).val('');
            return;
        }

        // Clear previous sections
        $('#durationSection').empty();
        yearSemesterCounter = 0;

        // Add sections for each year/semester
        for (let i = 1; i <= duration; i++) {
            yearSemesterCounter++;
            const yearSemesterLabel = type === 'year' ? `${getOrdinalNumber(i)} Year` : `${getOrdinalNumber(i)} Semester`;

            const cardTemplate = `
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #337ab7">
                        <h5 class="mb-0">Add Subjects</h5>
                    </div>
                    <div class="card-body border-0" id="subjectContainer_${yearSemesterCounter}">
                        <!-- Mandatory First Subject -->
                        <div class="p-3 mt-2 subject" id="subject_${yearSemesterCounter}_1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">First ${type === 'year' ? 'Year' : 'Semester'} Subject</h6>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="subjectName_${yearSemesterCounter}_1" class="form-label">Subject Name</label>
                                    <input type="text" class="form-control" id="subjectName_${yearSemesterCounter}_1" name="subjects[${yearSemesterCounter}][1][name]" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="hasPractical_${yearSemesterCounter}_1" class="form-label">Has Practical?</label>
                                    <select class="form-select has-practical" id="hasPractical_${yearSemesterCounter}_1" name="subjects[${yearSemesterCounter}][1][hasPractical]" required>
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div id="practicalMarksSection_${yearSemesterCounter}_1" class="row g-3 mt-2 d-none">
                                <div class="col-md-6">
                                    <label for="practicalMarks_${yearSemesterCounter}_1" class="form-label">Practical Marks</label>
                                    <input type="number" class="form-control" id="practicalMarks_${yearSemesterCounter}_1" name="subjects[${yearSemesterCounter}][1][practicalMarks]" min="0">
                                </div>
                                <div class="col-md-6">
                                    <label for="practicalMinMarks_${yearSemesterCounter}_1" class="form-label">Practical Min Marks</label>
                                    <input type="number" class="form-control" id="practicalMinMarks_${yearSemesterCounter}_1" name="subjects[${yearSemesterCounter}][1][practicalMinMarks]" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-transparent border-top-0">
                        <button type="button" class="btn btn-primary text-white addSubject" data-section-id="${yearSemesterCounter}">
                            Add More ${yearSemesterLabel} Subjects
                        </button>
                    </div>
                </div>
            </div>
        `;
            $('#durationSection').append(cardTemplate);
        }
    });


    $(document).on('click', '.addSubject', function () {
        const sectionId = $(this).data('section-id');
        const subjectContainer = $(`#subjectContainer_${sectionId}`);
        const subjectCounter = subjectContainer.children('.subject').length + 1;
        const type = $('#courseType').val();
        const subjectLabel = `${getOrdinalNumber(subjectCounter)} ${type === 'year' ? 'Year' : 'Semester'} Subject`;

        // Limit subjects to 10
        if (subjectCounter > 10) {
            $(this).prop('disabled', true); // Disable the button
            alert('Maximum subject limit (10) reached for this section.');
            return;
        }

        const subjectTemplate = `
        <div class="border p-3 mt-2 subject" id="subject_${sectionId}_${subjectCounter}">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">${subjectLabel}</h6>
                <button type="button" class="btn btn-danger btn-sm removeSubject" data-section-id="${sectionId}">Remove</button>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="subjectName_${sectionId}_${subjectCounter}" class="form-label">Subject Name</label>
                    <input type="text" class="form-control" id="subjectName_${sectionId}_${subjectCounter}" name="subjects[${sectionId}][${subjectCounter}][name]" required>
                </div>
                <div class="col-md-6">
                    <label for="hasPractical_${sectionId}_${subjectCounter}" class="form-label">Has Practical?</label>
                    <select class="form-select has-practical" id="hasPractical_${sectionId}_${subjectCounter}" name="subjects[${sectionId}][${subjectCounter}][hasPractical]" required>
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
            </div>
            <div id="practicalMarksSection_${sectionId}_${subjectCounter}" class="row g-3 mt-2 d-none">
                <div class="col-md-6">
                    <label for="practicalMarks_${sectionId}_${subjectCounter}" class="form-label">Practical Marks</label>
                    <input type="number" class="form-control" id="practicalMarks_${sectionId}_${subjectCounter}" name="subjects[${sectionId}][${subjectCounter}][practicalMarks]" min="0">
                </div>
                <div class="col-md-6">
                    <label for="practicalMinMarks_${sectionId}_${subjectCounter}" class="form-label">Practical Min Marks</label>
                    <input type="number" class="form-control" id="practicalMinMarks_${sectionId}_${subjectCounter}" name="subjects[${sectionId}][${subjectCounter}][practicalMinMarks]" min="0">
                </div>
            </div>
        </div>
    `;
        subjectContainer.append(subjectTemplate);

        // Disable button if limit of 10 subjects is reached
        if (subjectCounter >= 10) {
            $(this).prop('disabled', true); // Disable the button
        }
    });

    $(document).on('click', '.removeSubject', function () {
        const sectionId = $(this).data('section-id');
        const subjectContainer = $(`#subjectContainer_${sectionId}`);
        const subjects = subjectContainer.find('.subject');

        // Remove the subject
        $(this).closest('.subject').remove();

        // Re-enable the "Add More" button if subject count < 10
        const subjectCount = subjects.length - 1;
        const addButton = $(`#subjectContainer_${sectionId}`).closest('.card').find('.addSubject');

        if (subjectCount < 10) {
            addButton.prop('disabled', false);
        }

        // Adjust subject titles
        subjectContainer.children('.subject').each(function (index) {
            const subjectIndex = index + 1;
            const subjectLabel = `${getOrdinalNumber(subjectIndex)} ${$('#courseType').val() === 'year' ? 'Year' : 'Semester'} Subject`;
            $(this).find('h6').text(subjectLabel);
        });
    });

    // Handle Practical Option Change
    $(document).on('change', '.has-practical', function () {
        const subjectId = $(this).closest('.subject').attr('id');
        const practicalSection = $(`#${subjectId} #practicalMarksSection_${$(this).attr('id').split('_')[1]}_${$(this).attr('id').split('_')[2]}`);
        if ($(this).val() === 'yes') {
            practicalSection.removeClass('d-none');
        } else {
            practicalSection.addClass('d-none');
        }
    });
    $(document).on('input', '.practicalMarks, .practicalMinMarks', function () {
        const minMarks = parseInt($(this).closest('.subject').find('.practicalMinMarks').val());
        const maxMarks = parseInt($(this).closest('.subject').find('.practicalMarks').val());

        if (minMarks > maxMarks && !isNaN(minMarks) && !isNaN(maxMarks)) {
            alert('Practical Min Marks cannot be greater than Practical Marks.');
            $(this).val(''); // Reset the invalid value
        }
    });
    // Remove Subject Handler
    $(document).on('click', '.removeSubject', function () {
        $(this).closest('.subject').remove();
    });

    $('#courseForm').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serializeArray();

        const data = {
            courseTitle: $('#courseTitle').val(),
            courseType: $('#courseType').val(),
            duration: $('#duration').val(),
            subjects: {}
        };

        formData.forEach(field => {
            // Match the field names for subjects like subjects[1][1][name]
            const matches = field.name.match(/^subjects\[(\d+)]\[(\d+)]\[(\w+)]$/);
            if (matches) {
                const yearIndex = parseInt(matches[1]);
                const subjectIndex = parseInt(matches[2]);
                const key = matches[3];

                // Create year and subject structure if it doesn't exist
                const yearKey = `year_${yearIndex === 1 ? 'first' : yearIndex === 2 ? 'second' : 'third'}`;  // Adjust as needed
                const subjectKey = `subject_${subjectIndex === 1 ? 'first' : subjectIndex === 2 ? 'second' : 'third'}`;  // Adjust as needed

                if (!data.subjects[yearKey]) {
                    data.subjects[yearKey] = {};
                }

                if (!data.subjects[yearKey][subjectKey]) {
                    data.subjects[yearKey][subjectKey] = {};
                }

                data.subjects[yearKey][subjectKey][key] = field.value;
            } else {
                data[field.name] = field.value;
            }
        });

        // Send the structured data as JSON
        console.log(JSON.stringify(data));
        $.ajax({
            type: 'POST',
            url: '/api/add-course', // Change to your backend API endpoint
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                alert('Course added successfully!');
                location.reload(); // Reload or redirect
            },
            error: function (xhr) {
                alert('Error adding course. Please try again.');
                console.error(xhr.responseJSON);
            }
        });
    });
});
