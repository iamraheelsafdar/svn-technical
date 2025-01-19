// Side Navigation
$('.open-btn').on('click', function () {
    $('#side_nav').addClass('active');
});
$('.close-btn').on('click', function () {
    $('#side_nav').removeClass('active');
});
// Toasts
document.addEventListener('DOMContentLoaded', function () {
    // Get all toast elements
    var toastElements = document.querySelectorAll('.toast');

    // For each toast element, initialize and show the toast, then hide it after 3 seconds
    toastElements.forEach(function (toastElement) {
        var toast = new bootstrap.Toast(toastElement);
        toast.show(); // Show the toast

        // Hide the toast after 3 seconds
        setTimeout(function () {
            toast.hide();
        }, 10000); // Hide each toast after 10 seconds
    });
});

// change date format
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#dateInput", {
        dateFormat: "d-m-Y",  // This ensures the date format is dd-mm-yyyy
    });
});


// Show toast function
function showToast(message, type) {
    const toastStyle = type === 'success' ? 'background-color: #d4edda; color: #155724;' : '';
    const toastHTML = `

        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
             style="${toastStyle}">
            <div class="toast-body text-dark">
                <button type="button" class="btn-close float-end d-flex justify-content-center"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                ${message}
            </div>
        </div>
    `;

    const toastContainer = document.getElementById('toastContainer');
    toastContainer.innerHTML = toastHTML;
    const toast = new bootstrap.Toast(toastContainer.firstElementChild);
    toast.show();
}

//Clock
function updateClock() {
    const now = new Date();

    // Get hours, minutes, and seconds
    let hours = now.getHours() % 12; // Convert to 12-hour format
    hours = hours === 0 ? 12 : hours; // Adjust for midnight/noon (0 -> 12)
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    // Calculate the angles
    const hourAngle = (360 / 12) * hours + (30 / 60) * minutes; // Each hour is 30 degrees, adjust by minutes
    const minuteAngle = (360 / 60) * minutes + (6 / 60) * seconds; // Each minute is 6 degrees, adjust by seconds
    const secondAngle = (360 / 60) * seconds; // Each second is 6 degrees

    // Rotate the hands
    if (document.getElementById('hour')) {
        document.getElementById('hour').style.transform = `rotate(${hourAngle}deg)`;
        document.getElementById('minute').style.transform = `rotate(${minuteAngle}deg)`;
        document.getElementById('second').style.transform = `rotate(${secondAngle}deg)`;
    }
}

// Update the clock every second
setInterval(updateClock, 1000);

// Initialize the clock
updateClock();
