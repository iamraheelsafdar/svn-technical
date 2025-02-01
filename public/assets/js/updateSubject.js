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
