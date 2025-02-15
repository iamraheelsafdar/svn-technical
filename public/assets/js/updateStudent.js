document.addEventListener("DOMContentLoaded", function () {
    const lateralSelect = document.getElementById("lateral");
    const reduceLateralContainer = document.getElementById("reduce-lateral-container");
    const lateralContainer = document.getElementById("lateral-container");

    function toggleReduceLateral() {
        if (lateralSelect.value === "1") {
            reduceLateralContainer.style.display = "block";
            lateralContainer.className = "col-6 col-md-3 col-lg-3 mb-3"; // Adjust class
        } else {
            reduceLateralContainer.style.display = "none";
            lateralContainer.className = "col-12 col-md-6 col-lg-6 mb-3"; // Restore class
        }
    }

    // Initial state on page load
    toggleReduceLateral();

    // Event listener for dropdown change
    lateralSelect.addEventListener("change", toggleReduceLateral);
});
