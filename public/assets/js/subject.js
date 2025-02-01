$(document).ready(function () {
    const subjectCount = {};

    // Add new subject
    $(".add-subject-btn").on("click", function () {
        const index = $(this).data("index");

        if (!subjectCount[index]) {
            subjectCount[index] = 1;
        }
        subjectCount[index]++;

        const subjectForm = `
        <div class="subject-form mb-3">
          <h5>Subject ${subjectCount[index]}</h5>
          <button type="button" class="btn btn-danger btn-sm float-end remove-subject-btn">Remove Subject</button>
          <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" class="form-control" name="subjects[${index}][name][]" placeholder="Enter Subject Name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Subject Code</label>
            <input type="text" class="form-control" name="subjects[${index}][code][]" placeholder="Enter Subject Code" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label class="form-label">Min Marks</label>
              <input type="number" class="form-control min-marks" name="subjects[${index}][min_marks][]" placeholder="Enter Min Marks" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Max Marks</label>
              <input type="number" class="form-control max-marks" name="subjects[${index}][max_marks][]" placeholder="Enter Max Marks" required>
            </div>
          </div>
          <div class="mb-3 mt-3">
            <label class="form-label">Is Practical?</label>
            <select class="form-select practical-dropdown" data-index="${index}" name="subjects[${index}][is_practical][]" required>
              <option value="false">No</option>
              <option value="true">Yes</option>
            </select>
          </div>
          <div class="practical-marks row d-none">
            <div class="col-md-6">
              <label class="form-label">Practical Min Marks</label>
              <input type="number" class="form-control practical-min-marks" name="subjects[${index}][practical_min_marks][]" placeholder="Min Practical Marks">
            </div>
            <div class="col-md-6">
              <label class="form-label">Practical Max Marks</label>
              <input type="number" class="form-control practical-max-marks" name="subjects[${index}][practical_max_marks][]" placeholder="Max Practical Marks">
            </div>
          </div>
        </div>
      `;
        $(`#subject-container-${index}`).append(subjectForm);
    });

    // Remove subject and re-index
    $(document).on("click", ".remove-subject-btn", function () {
        const subjectContainer = $(this).closest(`#subject-container-${$(this).closest(".card-body").find(".add-subject-btn").data("index")}`);

        $(this).closest(".subject-form").remove();

        // Re-index remaining subjects
        subjectContainer.find(".subject-form").each(function (i) {
            $(this).find("h5").text(`Subject ${i + 1}`);
        });

        const index = $(this).closest(".card-body").find(".add-subject-btn").data("index");
        subjectCount[index] = subjectContainer.find(".subject-form").length;
    });

    // Toggle practical marks fields and manage "required" attribute
    $(document).on("change", ".practical-dropdown", function () {
        const practicalMarks = $(this).closest(".subject-form").find(".practical-marks");
        if ($(this).val() === "true") {
            practicalMarks.removeClass("d-none");
            practicalMarks.find("input").prop("required", true); // Add "required" to practical marks
        } else {
            practicalMarks.addClass("d-none");
            practicalMarks.find("input").prop("required", false).val(""); // Remove "required" and clear fields
        }
    });

    // Validate min and max marks
    $(document).on("input", ".min-marks, .max-marks", function () {
        const subjectForm = $(this).closest(".subject-form");
        const minMarks = parseInt(subjectForm.find(".min-marks").val());
        const maxMarks = parseInt(subjectForm.find(".max-marks").val());

        if (minMarks > maxMarks) {
            alert("Min marks cannot be greater than Max marks.");
            $(this).val(""); // Clear the invalid input
        }
    });

    // Validate form on submission
    $("form").on("submit", function (e) {
        let isValid = true;

        $(".subject-form").each(function () {
            const subjectForm = $(this);
            const minMarks = parseInt(subjectForm.find(".min-marks").val());
            const maxMarks = parseInt(subjectForm.find(".max-marks").val());

            if (minMarks > maxMarks) {
                isValid = false;
                alert(`Error in ${subjectForm.find("h5").text()}: Min marks cannot be greater than Max marks.`);
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});
