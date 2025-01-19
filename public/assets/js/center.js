function showConfirmationModal(toggle) {
    const actionType = toggle.checked ? 'Activate' : 'Deactivate';
    const entityId = toggle.getAttribute('data-id'); // Get the ID of the entity
    const entityType = toggle.getAttribute('data-type'); // Get the type of the entity (prefix, center, etc.)

    // Update modal content with the action type
    document.getElementById('actionType').textContent = actionType;
    document.getElementById('entityType').textContent = entityType;

    // Show the confirmation modal using Bootstrap's Modal API
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.show();

    // Store the current toggle state to revert if necessary
    const initialToggleState = toggle.checked;

    // Handle confirmation (when user clicks 'Confirm' in the modal)
    document.getElementById('confirmAction').onclick = function () {
        // Close the modal after confirmation
        confirmationModal.hide();

        // Construct the dynamic URL based on the entity type
        const url = `/update-${entityType}-status`;

        // Make AJAX request to update the status on the server
        ajaxRequest(
            url, // Dynamic URL
            'POST', // HTTP method
            { id: entityId, status: initialToggleState ? 1 : 0 }, // Send updated status
            (data) => {
                // Success callback
                showToast(data.message, 'success'); // Show success toast
                toggle.checked = initialToggleState; // Update the checkbox state after the successful action
            },
            (error) => {
                // Error callback
                console.error(error);
                showToast(error, 'error'); // Show error toast
                toggle.checked = !initialToggleState; // Revert the toggle to its initial state if an error occurs
            }
        );
    };

    // Prevent the checkbox from toggling immediately
    toggle.checked = initialToggleState;
}

function ajaxRequest(url, method, data, successCallback, errorCallback) {
    $.ajax({
        type: method,
        url: url,
        data: method === 'GET' ? data : JSON.stringify(data),
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Add CSRF token here
        },
        success: function (response) {
            if (successCallback) successCallback(response);
        },
        error: function (xhr) {
            const responseJSON = xhr.responseJSON;
            if (errorCallback) errorCallback(responseJSON.errors[0] || 'Validation error occurred.');
        },
    });
}
