document.addEventListener('DOMContentLoaded', function () {
    // Select all practical dropdowns
    const practicalDropdowns = document.querySelectorAll('.practical-dropdown');

    practicalDropdowns.forEach(function (dropdown) {

        dropdown.addEventListener('change', function () {
            const idParts = dropdown.id.split('-'); // Split ID
            const duration = idParts[2]; // Extract duration
            const index = idParts[3]; // Extract index


            // Get the practical marks div using the correct ID format
            const practicalMarksDiv = document.getElementById(`practical-marks-${duration}-${index}`);

            if (practicalMarksDiv) {

                if (dropdown.value === "true") {
                    practicalMarksDiv.classList.remove('d-none');
                } else {
                    practicalMarksDiv.classList.add('d-none');

                    // Clear input fields
                    practicalMarksDiv.querySelectorAll('input').forEach(input => input.value = '');
                }
            } else {
                console.log('Practical Marks Div NOT found for:', dropdown.id);
            }
        });

        // Trigger change event on page load to apply initial visibility
        dropdown.dispatchEvent(new Event('change'));
    });
});



// Update Subject JavaScript functionality
$(document).ready(function() {
    // Handle the toggle for practical marks section for existing subjects
    $('.practical-dropdown').on('change', function() {
        const $this = $(this);
        const duration = $this.attr('id').split('-')[2];
        const index = $this.attr('id').split('-')[3];
        const practicalMarksSection = $('#practical-marks-' + duration + '-' + index);

        if ($this.val() === 'true') {
            practicalMarksSection.removeClass('d-none');
        } else {
            practicalMarksSection.addClass('d-none');
        }
    });

    // Handle adding new subjects while updating
    $('.add-subject-btn').on('click', function() {
        const $this = $(this);
        const duration = $this.data('duration');
        const subjectContainer = $('#subject-container-' + duration);

        // Calculate the next index by counting existing subjects in this specific container
        const nextIndex = subjectContainer.find('.subject-form').length;

        // Create new subject form
        const newSubjectTemplate = `
            <div class="subject-form mb-3 mt-4">
                <h5>Subject ${nextIndex + 1}</h5>
                <input type="hidden" name="subjects[${duration}][${nextIndex}][id]" value="new">

                <div class="mb-3">
                    <label class="form-label">Subject Name</label>
                    <input type="text"
                           class="form-control"
                           name="subjects[${duration}][${nextIndex}][name]"
                           placeholder="Enter Subject Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject Code</label>
                    <input type="text"
                           class="form-control"
                           name="subjects[${duration}][${nextIndex}][code]"
                           placeholder="Enter Subject Code" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Max Marks</label>
                        <input type="number"
                               class="form-control"
                               name="subjects[${duration}][${nextIndex}][max_marks]"
                               placeholder="Enter Max Marks" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Min Marks</label>
                        <input type="number"
                               class="form-control"
                               name="subjects[${duration}][${nextIndex}][min_marks]"
                               placeholder="Enter Min Marks" required>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Is Practical?</label>
                    <select class="form-select practical-dropdown"
                            id="practical-dropdown-${duration}-${nextIndex}"
                            name="subjects[${duration}][${nextIndex}][is_practical]"
                            required>
                        <option value="false">No</option>
                        <option value="true">Yes</option>
                    </select>
                </div>

                <div id="practical-marks-${duration}-${nextIndex}"
                     class="practical-marks row d-none">
                    <div class="col-md-6">
                        <label class="form-label">Practical Max Marks</label>
                        <input type="number" class="form-control"
                               name="subjects[${duration}][${nextIndex}][practical_max_marks]"
                               placeholder="Max Practical Marks">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Practical Min Marks</label>
                        <input type="number" class="form-control"
                               name="subjects[${duration}][${nextIndex}][practical_min_marks]"
                               placeholder="Min Practical Marks">
                    </div>
                </div>

                <button type="button" class="btn btn-danger btn-sm remove-subject mt-2" data-duration="${duration}">Remove Subject</button>
            </div>
        `;

        // Add the new subject form to the specific container
        subjectContainer.append(newSubjectTemplate);

        // Apply practical dropdown functionality to the newly added dropdown
        $(`#practical-dropdown-${duration}-${nextIndex}`).on('change', function() {
            const $this = $(this);
            const practicalMarksSection = $(`#practical-marks-${duration}-${nextIndex}`);

            if ($this.val() === 'true') {
                practicalMarksSection.removeClass('d-none');
            } else {
                practicalMarksSection.addClass('d-none');
            }
        });
    });

    // Handle remove subject button - only for newly added subjects
    $(document).on('click', '.remove-subject', function() {
        const $this = $(this);
        const duration = $this.data('duration');
        const subjectForm = $this.closest('.subject-form');
        const container = $('#subject-container-' + duration);

        // Remove the subject form
        subjectForm.remove();

        // Renumber the remaining subjects in this container
        container.find('.subject-form').each(function(index) {
            $(this).find('h5').text('Subject ' + (index + 1));

            // Update input names to maintain proper indexing
            $(this).find('input, select').each(function() {
                const name = $(this).attr('name');
                if (name && name.includes(`subjects[${duration}]`)) {
                    const newName = name.replace(/subjects\[(\d+)]\[(\d+)]/, `subjects[$1][${index}]`);
                    $(this).attr('name', newName);
                }

                // Update IDs for practical dropdowns and sections
                const id = $(this).attr('id');
                if (id && id.startsWith(`practical-dropdown-${duration}`)) {
                    $(this).attr('id', `practical-dropdown-${duration}-${index}`);
                }
            });

            // Update practical section IDs
            const practicalSection = $(this).find('.practical-marks');
            if (practicalSection.length) {
                practicalSection.attr('id', `practical-marks-${duration}-${index}`);
            }
        });
    });
});
