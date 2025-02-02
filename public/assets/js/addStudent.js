document.getElementById('stream_id').addEventListener('change', function () {
    const streamId = this.value;
    const courseInput = document.getElementById('course-input');
    const courseDatalist = document.getElementById('courses');

    // Clear previous courses
    courseDatalist.innerHTML = '';
    courseInput.value = '';

    // Find the selected stream
    const selectedStream = streamsData.find(stream => stream.stream_id == streamId);

    if (selectedStream && selectedStream.courses.length > 0) {
        if (selectedStream.courses.length === 1) {
            // If only one course, show it in an input field (readonly)
            courseInput.value = selectedStream.courses[0].course_name;
            courseInput.setAttribute('readonly', true);
            courseInput.insertAdjacentHTML('afterend', `<input type="hidden" name="course" value="${selectedStream.courses[0].course_id}">`);
        } else {
            // If multiple courses, populate the datalist
            courseInput.removeAttribute('readonly'); // Enable editing
            selectedStream.courses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.course_name; // Set course name as value
                option.setAttribute('data-id', course.course_id); // Store course_id as data attribute
                courseDatalist.appendChild(option);
            });
        }
    }
});

// Capture the selected course ID when user selects from datalist
document.getElementById('course-input').addEventListener('input', function () {
    const selectedOption = [...document.getElementById('courses').options].find(opt => opt.value === this.value);
    if (selectedOption) {
        this.insertAdjacentHTML('afterend', `<input type="hidden" name="course" value="${selectedOption.getAttribute('data-id')}">`);
    }
});
