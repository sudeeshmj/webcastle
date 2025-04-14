window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});

$(document).ready(function () {
    /* Book Appointment Start */
    // Function to load slots for a selected date
    function loadSlotsForDate(button) {
        $(".date-btn")
            .removeClass("btn-primary text-white")
            .addClass("btn-outline-primary");
        button
            .removeClass("btn-outline-primary")
            .addClass("btn-primary text-white");
        $("#appointment-form").addClass("d-none");

        let doctorId = $("#doctor_id").val();
        let selectedDate = button.data("date");
        $("#appointment_date").val(selectedDate);

        $.ajax({
            url: "/get-available-slots",
            method: "POST",
            data: {
                doctor_id: doctorId,
                date: selectedDate,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                let html =
                    '<div><strong>Available Slots:</strong></div><div class="d-flex flex-wrap gap-2 mt-2">';
                if (response.length > 0) {
                    response.forEach((slot) => {
                        html += `<button data-slot="${
                            slot.time
                        }" class="btn btn-sm btn-outline-secondary slot-btn" id="slot-btn" ${
                            slot.disabled ? "disabled" : ""
                        }>${slot.time}</button>`;
                    });
                } else {
                    html += "<div>No slots available</div>";
                }
                html += "</div>";
                $("#slots-container").html(html);
            },
            error: function (xhr) {
                $("#slots-container").html(
                    '<p class="text-danger">Error fetching slots.</p>'
                );
            },
        });
    }

    // Manual date selection
    $(".date-btn").on("click", function () {
        loadSlotsForDate($(this));
    });

    // Auto-select today's date and load its slots on page load
    let todayBtn = $(".date-btn").first();
    if (todayBtn.length) {
        loadSlotsForDate(todayBtn);
    }

    // Handle slot selection
    $(document).on("click", ".slot-btn", function () {
        $(".slot-btn")
            .removeClass("btn-primary text-white")
            .addClass("btn-outline-secondary");
        $(this)
            .removeClass("btn-outline-secondary")
            .addClass("btn-primary text-white");
        $("#slot").val($(this).data("slot"));
        $("#appointment-form").removeClass("d-none");
    });

    /* Book Appointment End */
});
