<!-- START -->
<?php
// Fetch query of booking_availability
if (isset($availability_day_result)) {
    $availability_days = [];
    $day_map = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6
    ];

    while ($availability = mysqli_fetch_assoc($availability_day_result)) {
        $day_name = $availability['day'];
        if (isset($day_map[$day_name])) {
            $day_index = $day_map[$day_name];
            
            $availability_days[] = [
                'day' => $day_index,
                'start_time' => $availability['start_time'],
                'end_time' => $availability['end_time'],
                'start_time_2' => $availability['start_time_2'],
                'end_time_2' => $availability['end_time_2'],
            ];
        }
    }
   
    $available_days = array_map(function($slot) { return $slot['day']; }, $availability_days);
    $available_slots = json_encode($availability_days);

    echo "<script>
            var availableDays = " . json_encode($available_days) . ";
            var availableSlots = " . $available_slots . ";
        </script>";

    // Fetch existing booking dates from the database
    $date_times = [];

    while ($exist_day = mysqli_fetch_assoc($exist_day_result)) {
        $date_times[] = $exist_day['date_time'];
    }

    echo "<script>
        var existDays = " . json_encode($date_times) . ";
    </script>";
}

?>
<!-- booking system form start  -->
<div class="modal fade" id="booking">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top: 30%;">
            <div class="log-bor">&nbsp;</div>
            <span class="udb-inst">Booking</span>
            <button type="button" class="close" data-dismiss="modal" style="margin-left: 92%;">&times;</button>
            <div class="quote-pop">
                <form method="post" action="/booking_insert.php" enctype="multipart/form-data">
                    <input type="hidden" name="booking_type" value="<?php echo $booking_type; ?>">
                    <input type="hidden" name="booking_type_id" value="<?php echo $booking_type_id ?? '0'; ?>">
                    <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $session_user_id; ?>">
                    <input type="hidden" name="city" value="<?php echo $city; ?>">
                    <div class="form-group col-md-6 serex-date">
                        <input type="text" class="form-control" name="booking_date" placeholder="DATE" id="booking_date" required>
                    </div>
                    
                    <div class="form-group col-md-6 serex-date">
                        <select class="form-control" name="booking_time" id="booking_time" required>
                            <option value="">Select Time</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="comment">Comment</label>
                        <textarea name="comment" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- booking system form end  -->

<!-- BOOKING SYSTEM SCRIPT FOR ADMIN AND BUSINESS BOOKING BUTTON & POPUP FORM -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<script>
    $(function() {
        // Date picker configuration
        $("#booking_date").datepicker({
            minDate: 0, 
            beforeShowDay: function(date) {
                var day = date.getDay(); // Get the day of the week (0=Sunday, 1=Monday, etc.)
                return [availableDays.indexOf(day) !== -1, "", ""];
            },
            onSelect: function(selectedDate) {
                updateTimeSlots(selectedDate);
            }
        });

        // Time picker configuration
        $('#booking_time').timepicker({
            'minTime': '08:00',   // Default start time (to be updated dynamically)
            'maxTime': '18:00',   // Default end time (to be updated dynamically)
            'interval': 30,       // Time interval in minutes
            'disableTime': []     // Disable times based on selected date
        });

        // Function to update time slots based on selected date
        function updateTimeSlots(selectedDate) {

            // Format the selected date as 'yyyy-mm-dd'
            var dateString = $.datepicker.formatDate('yy-mm-dd', new Date(selectedDate));
            var dayOfWeek = new Date(selectedDate).getDay();
            
            // Find the available slots for the selected day
            var daySlots = availableSlots.find(function(slot) {
                return slot.day === dayOfWeek;  // Match the selected day
            });

            // Check if daySlots are found and contain valid start_time and end_time
            if (daySlots && daySlots.start_time && daySlots.end_time || daySlots.start_time_2 && daySlots.end_time_2) {
                var startTime = daySlots.start_time;
                var endTime = daySlots.end_time;
                var startTime_2 = daySlots.start_time_2;
                var endTime_2 = daySlots.end_time_2;

                // Generate time slots between start and end times (30-minute intervals)
                var timeSlots = generateTimeSlots(startTime, endTime, startTime_2, endTime_2, 30); // 30-minute intervals
                
                $('#booking_time').empty();  

                timeSlots.forEach(function(timeSlot) {
                    var isDisabled = existDays.some(function(existingDate) {

                        if (existingDate && typeof existingDate === 'string') {
                            var dateParts = existingDate.split(' ');

                            var existingDateString = dateParts[0];  
                            var existingTime = dateParts[1] || '00:00';  

                            existingTime = existingTime.split(':').slice(0, 2).join(':'); 

                                if (existingDateString === dateString) {
                                    if (existingTime === timeSlot) {
                                        console.log('Disabling exact time slot:', timeSlot);
                                        return true; 
                                    }
                                }
                        } else {
                            console.log('Invalid or undefined existingDate:', existingDate); 
                        }

                        return false;
                    });

                    // Append the time slot to the dropdown, and disable it if already booked
                    $('#booking_time').append(
                        '<option value="' + timeSlot + '" ' + (isDisabled ? 'disabled' : '') + '>' + timeSlot + '</option>'
                    );
                });
            }
        }


        // Function to generate time slots between start time and end time
        function generateTimeSlots(startTime, endTime, startTime_2, endTime_2, interval) {
            var slots = [];

            // Convert times to minutes for both ranges
            var start = convertToMinutes(startTime);
            var end = convertToMinutes(endTime);

            var start_2 = convertToMinutes(startTime_2);
            var end_2 = convertToMinutes(endTime_2);

            // Generate time slots for the first range
            for (var time = start; time < end; time += interval) {
                slots.push(convertToTimeFormat(time));
            }

            // Generate time slots for the second range
            for (var time = start_2; time < end_2; time += interval) {
                slots.push(convertToTimeFormat(time));
            }

            return slots;
        }


        // Convert time in 'HH:mm' format (24-hour) to total minutes
        // function convertToMinutes(time) {
        //     var timeParts = time.split(':');
        //     var hours = parseInt(timeParts[0]);
        //     var minutes = parseInt(timeParts[1]);

        //     // Convert 12-hour format to 24-hour format for correct minute calculation
        //     if (hours < 12) {
        //         return hours * 60 + minutes;
        //     } else {
        //         return (hours === 12 ? 0 : hours - 12 + 12) * 60 + minutes; // Convert 12 PM correctly
        //     }
        // }
        function convertToMinutes(time) {
            var timeParts = time.split(':');
            return parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
        }

        // Convert minutes back to 'hh:mm AM/PM' format (12-hour)
        function convertToTimeFormat(minutes) {
            var hours = Math.floor(minutes / 60);
            var mins = minutes % 60;

            // Convert back to 12-hour format
            // var period = hours < 12 ? 'AM' : 'PM'; // Determine AM/PM

            // if (hours === 0) {
            //     hours = 12; // Midnight (12:00 AM)
            // } else if (hours > 12) {
            //     hours -= 12; // Convert PM hours (13:00 to 1:00 PM)
            // }

            if (mins < 10) {
                mins = '0' + mins;
            }

            if (hours < 10) {
                hours = '0' + hours;
            }
            
            return hours + ':' + mins;

            // return hours + ':' + mins + ' ' + period;
        }

    });
</script>