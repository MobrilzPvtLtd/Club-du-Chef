
<!-- BOOKING SYSTEM SCRIPT FOR ADMIN AND BUSINESS PANEL -->
<script>
    $(document).ready(function() {
        // Show or hide the booking details when the checkbox is toggled
        $("#booking").change(function() {
            if ($(this).is(':checked')) {
                $("#booking-details").show();
            } else {
                $("#booking-details").hide();
                $("#booking_url_group").hide();
                $("#booking_url").val('');
            }
        });

        // Clear the booking URL when the inbuilt booking system is selected
        $("#is_booking").change(function() {
            if ($(this).is(':checked')) {
                $("#booking_days").show();
                $("#booking_url").val('');
                $("#booking_url_group").hide();
            }
        });
 
        // Monday checkbox event handler
        $('#booking_monday').change(function() {
            if ($(this).is(':checked')) {
                $(".monday_time").show();
            } else {
                $(".monday_time").hide();
            }
        });

        // Tuesday checkbox event handler
        $('#booking_tuesday').change(function() {
            if ($(this).is(':checked')) {
                $(".tuesday_time").show();
            } else {
                $(".tuesday_time").hide();
            }
        });

        // Wednesday checkbox event handler
        $('#booking_wednesday').change(function() {
            if ($(this).is(':checked')) {
                $(".wednesday_time").show();
            } else {
                $(".wednesday_time").hide();
            }
        });

        // Thursday checkbox event handler
        $('#booking_thursday').change(function() {
            if ($(this).is(':checked')) {
                $(".thursday_time").show();
            } else {
                $(".thursday_time").hide();
            }
        });

        // Friday checkbox event handler
        $('#booking_friday').change(function() {
            if ($(this).is(':checked')) {
                $(".friday_time").show();
            } else {
                $(".friday_time").hide();
            }
        });

        // Saturday checkbox event handler
        $('#booking_saturday').change(function() {
            if ($(this).is(':checked')) {
                $(".saturday_time").show();
            } else {
                $(".saturday_time").hide();
            }
        });

        // Sunday checkbox event handler
        $('#booking_sunday').change(function() {
            if ($(this).is(':checked')) {
                $(".sunday_time").show();
            } else {
                $(".sunday_time").hide();
            }
        });

        // Show/hide the booking URL input based on the radio button selection
        $("#is_booking_url").change(function() {
            if ($(this).is(':checked')) {
                // Show the booking URL group and hide the day-specific booking options
                $("#booking_url_group").show();
                $("#booking_days").hide();  // Hides the entire booking days section

                // Hide each day's checkbox and clear their checked state
                $(".monday_time, .tuesday_time, .wednesday_time, .thursday_time, .friday_time, .saturday_time, .sunday_time").hide();
                $("#booking_monday, #booking_tuesday, #booking_wednesday, #booking_thursday, #booking_friday, #booking_saturday, #booking_sunday").prop("checked", false);
            } else {
                // Hide the booking URL group when unchecked
                $("#booking_url_group").hide();
                $("#booking_url").val('');  // Clear the booking URL input value
            }
        });

    });

</script>