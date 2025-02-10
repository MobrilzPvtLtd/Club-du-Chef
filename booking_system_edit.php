<!-- BOOKING SYSTEM START -->
<div class="row">
    <div class="col-md-12">
        <div class="chbox">
            <input type="checkbox" name="booking" id="booking" <?php echo ($edit_a_row['is_booking'] == 1 || $edit_a_row['booking_url'] != '') ? 'checked' : ''; ?>>
            <label for="booking">Booking System</label>
        </div>
    </div>
</div>

<!-- Use inbuilt booking system -->
<div class="col-md-12" id="booking-details" style="display:<?php echo ($edit_a_row['is_booking'] == 1 || $edit_a_row['booking_url'] != '') ? 'block' : 'none'; ?>;">
    <div class="form-check">
        <input class="form-check-input" type="radio" value="1" name="is_booking" id="is_booking" style="height: 13px;" <?php echo $edit_a_row['is_booking'] == 1 ? 'checked' : ''; ?>>
        <label class="form-check-label" for="is_booking">Use inbuilt booking system</label>
    </div>

    <!-- Days fieilds  -->
    <div class="row" id="booking_days"
        <?php if($edit_a_row['is_booking'] != 1) { ?> 
            style="display:none;" 
        <?php } ?>>
        <?php
            $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            
            foreach ($days_of_week as $day) {
                $is_checked = isset($availability_days[$day]) ? 'checked' : '';
                $start_time = isset($availability_days[$day]) ? $availability_days[$day]['start_time'] : '';
                $end_time = isset($availability_days[$day]) ? $availability_days[$day]['end_time'] : '';
                $start_time_1 = isset($availability_days[$day]) ? $availability_days[$day]['start_time_1'] : '';
                $end_time_1 = isset($availability_days[$day]) ? $availability_days[$day]['end_time_1'] : '';
                $start_time_2 = isset($availability_days[$day]) ? $availability_days[$day]['start_time_2'] : '';
                $end_time_2 = isset($availability_days[$day]) ? $availability_days[$day]['end_time_2'] : '';
                $start_time_3 = isset($availability_days[$day]) ? $availability_days[$day]['start_time_3'] : '';
                $end_time_3 = isset($availability_days[$day]) ? $availability_days[$day]['end_time_3'] : '';
        ?>
        <div class="col-md-12" style="margin-left: 15px;">
            <div class="chbox">
                <input type="checkbox" name="<?php echo strtolower($day); ?>" id="booking_<?php echo strtolower($day); ?>" value="<?php echo $day; ?>" style="height: 0px;" <?php echo $is_checked; ?>>
                <label for="booking_<?php echo strtolower($day); ?>"><?php echo $day; ?></label>

                <div class="row <?php echo strtolower($day); ?>_time" style="display: <?php echo $is_checked ? 'block' : 'none'; ?>;">
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="start_time_<?php echo strtolower($day); ?>" value="<?php echo $start_time; ?>" placeholder="Start Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="end_time_<?php echo strtolower($day); ?>" value="<?php echo $end_time; ?>" placeholder="End Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="start_time_1_<?php echo strtolower($day); ?>" value="<?php echo $start_time_1; ?>" placeholder="Start Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="end_time_1_<?php echo strtolower($day); ?>" value="<?php echo $end_time_1; ?>" placeholder="End Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="start_time_2_<?php echo strtolower($day); ?>" value="<?php echo $start_time_2; ?>" placeholder="Start Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="end_time_2_<?php echo strtolower($day); ?>" value="<?php echo $end_time_2; ?>" placeholder="End Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="start_time_3_<?php echo strtolower($day); ?>" value="<?php echo $start_time_3; ?>" placeholder="Start Time">
                    </div>
                    <div class="form-group col-md-5 serex-date">
                        <input type="time" class="form-control" name="end_time_3_<?php echo strtolower($day); ?>" value="<?php echo $end_time_3; ?>" placeholder="End Time">
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- Use your own booking system -->
    <div class="form-check">
        <input class="form-check-input" type="radio" value="0" name="is_booking" id="is_booking_url" style="height: 13px;" <?php echo $edit_a_row['is_booking'] == 0 ? 'checked' : ''; ?>>
        <label class="form-check-label" for="is_booking_url">Use your own booking system</label>
    </div>

    <div class="form-group mt-2" id="booking_url_group" style="display:<?php echo ($edit_a_row['booking_url']) ? 'block' : 'none'; ?>;margin-left: 15px;">
        <input type="text" name="booking_url" id="booking_url" class="form-control" value="<?php echo $edit_a_row['booking_url']; ?>" placeholder="Enter your booking system url...">
    </div>
</div>
<!-- BOOKING SYSTEM END -->