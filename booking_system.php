<!-- BOOKING SYSTEM START -->
<div class="row">
    <div class="col-md-12">
        <div class="chbox">
            <input type="checkbox" name="booking" id="booking">
            <label for="booking">Booking System</label>
        </div>
    </div>
</div>

<!-- Use inbuilt booking system -->
<div class="col-md-12" id="booking-details" style="display:none;">
    <div class="form-check">
        <input class="form-check-input" type="radio" value="1" name="is_booking" id="is_booking" style="height: 13px;">
        <label class="form-check-label" for="is_booking">Use inbuilt booking system</label>
    </div>

    <!-- Days fieilds  -->
    <div class="row" id="booking_days" style="display:none;">
        <?php
            $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            
            foreach ($days_of_week as $day) {
        ?>
        <div class="col-md-12" style="margin-left: 15px;">
            <div class="chbox">
                <input type="checkbox" name="<?php echo strtolower($day); ?>" id="booking_<?php echo strtolower($day); ?>" value="<?php echo $day; ?>" style="height: 0px;" >
                <label for="booking_<?php echo strtolower($day); ?>"><?php echo $day; ?></label>

                <div class="row <?php echo strtolower($day); ?>_time" style="display:none;">
                    <div class="form-group col-md-4 serex-date">
                        <input type="time" class="form-control" name="start_time_<?php echo strtolower($day); ?>" value="">
                    </div>
                    <div class="form-group col-md-4 serex-date">
                        <input type="time" class="form-control" name="end_time_<?php echo strtolower($day); ?>" value="">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- Use your own booking system -->
    <div class="form-check">
        <input class="form-check-input" type="radio" value="0" name="is_booking" id="is_booking_url" style="height: 13px;">
        <label class="form-check-label" for="is_booking_url">Use your own booking system</label>
    </div>

    <div class="form-group mt-2" id="booking_url_group" style="display:none;margin-left: 15px;">
        <input type="text" name="booking_url" id="booking_url" class="form-control" value="" placeholder="Enter your booking system url...">
    </div>
</div>
<!-- BOOKING SYSTEM END -->