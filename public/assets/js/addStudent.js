
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
            handleCourseSelection(selectedStream.courses[0]); // Handle course selection
        } else {
            // If multiple courses, populate the datalist
            courseInput.removeAttribute('readonly'); // Enable editing
            selectedStream.courses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.course_name; // Set course name as value
                option.setAttribute('data-id', course.course_id); // Store course_id as data attribute
                option.setAttribute('data-duration', course.course_duration); // Store course duration
                option.setAttribute('data-type', course.course_type); // Store course type
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
        const selectedCourse = {
            course_id: selectedOption.getAttribute('data-id'),
            course_duration: selectedOption.getAttribute('data-duration'),
            course_type: selectedOption.getAttribute('data-type')
        };
        handleCourseSelection(selectedCourse); // Handle course selection
    }
});

// Handle course selection
function handleCourseSelection(course) {
    const lateralContainer = document.getElementById('lateral-container');
    const reduceLateralContainer = document.getElementById('reduce-lateral-container');
    const lateralDurationSelect = document.getElementById('lateral_duration');

    // Always show lateral-container when course is selected
    lateralContainer.style.display = 'block';

    // Reset to default state when new course is selected
    lateralContainer.classList.add('col-md-6', 'col-lg-6');
    lateralContainer.classList.remove('col-md-3', 'col-lg-3');
    reduceLateralContainer.style.display = 'none';
    document.getElementById('lateral').value = '0';

    // Handle lateral entry change
    document.getElementById('lateral').addEventListener('change', function () {
        if (this.value === '1') {
            lateralContainer.classList.remove('col-md-6', 'col-lg-6');
            lateralContainer.classList.add('col-md-3', 'col-lg-3');
            reduceLateralContainer.style.display = 'block';

            // Populate duration options (your existing logic)
            lateralDurationSelect.innerHTML = '';
            const courseDuration = parseInt(course.course_duration);

            for (let i = 1; i < courseDuration; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `${course.course_type} ${i}`;
                lateralDurationSelect.appendChild(option);
            }
        } else {
            lateralContainer.classList.remove('col-md-3', 'col-lg-3');
            lateralContainer.classList.add('col-md-6', 'col-lg-6');
            reduceLateralContainer.style.display = 'none';
        }
    });
}
// Updated JavaScript
document.getElementById('lateral').addEventListener('change', function () {
    const lateralContainer = document.getElementById('lateral-container');
    const reduceLateralContainer = document.getElementById('reduce-lateral-container');

    if (this.value === '1') {
        // When "Yes" is selected
        lateralContainer.classList.remove('col-md-6', 'col-lg-6');
        lateralContainer.classList.add('col-md-3', 'col-lg-3');
        reduceLateralContainer.style.display = 'block';
    } else {
        // When "No" is selected
        lateralContainer.classList.remove('col-md-3', 'col-lg-3');
        lateralContainer.classList.add('col-md-6', 'col-lg-6');
        reduceLateralContainer.style.display = 'none';
    }
});
