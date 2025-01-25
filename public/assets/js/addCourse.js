document.getElementById('stream_name').addEventListener('change', function () {
    const streamId = this.value; // Get selected stream ID
    const enrollmentContainer = document.getElementById('enrollment-container'); // Enrollment container

    // Clear previous enrollment field
    enrollmentContainer.innerHTML = `
        <select id="enrollment" name="enrollment" class="form-select" aria-label="Default select example">
            <option value="">Select Enrollment</option>
        </select>
    `;

    // Find the selected stream
    const selectedStream = streamsData.find(stream => stream.stream_id == streamId);

    if (selectedStream && selectedStream.enrollments.length > 0) {
        if (selectedStream.enrollments.length === 1) {
            // If only one enrollment, show it as a pre-selected text field
            enrollmentContainer.innerHTML = `
                <input type="text" class="form-control" id="enrollment" name="enrollment_value"
                    value="${selectedStream.enrollments[0].enrollment_name}" readonly>
                <input type="hidden" name="enrollment" value="${selectedStream.enrollments[0].enrollment_id}">
            `;
        } else {
            // If multiple enrollments, populate the dropdown
            const enrollmentSelect = enrollmentContainer.querySelector('#enrollment');
            selectedStream.enrollments.forEach(enrollment => {
                const option = document.createElement('option');
                option.value = enrollment.enrollment_id;
                option.textContent = enrollment.enrollment_name;
                enrollmentSelect.appendChild(option);
            });
        }
    }
});
document.getElementById('courseType').addEventListener('change', function () {
    const courseType = this.value; // Get the selected course type
    const durationField = document.getElementById('duration'); // Get the duration field

    // Define limits for each course type
    const limits = {
        year: 12,
        semester: 30,
        monthly: 20
    };

    if (courseType in limits) {
        // Enable the duration field
        durationField.disabled = false;
        durationField.max = limits[courseType];
        durationField.placeholder = `Enter Course Duration (Max: ${limits[courseType]})`;

        // If the current value exceeds the limit, reset it
        if (durationField.value > limits[courseType]) {
            durationField.value = '';
        }
    } else {
        // Disable the duration field if no valid course type is selected
        durationField.disabled = true;
        durationField.value = '';
        durationField.placeholder = 'Select course type first';
    }
});
