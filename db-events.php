<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}
include "dashboard_left_pane.php";

if (file_exists('config/general_user_authentication.php')) {
    include('config/general_user_authentication.php');
}

if (file_exists('config/event_page_authentication.php')) {
    include('config/event_page_authentication.php');
}

?>
			<!--CENTER SECTION-->
            <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs">
			<div class="ud-cen">
				<div class="log-bor">&nbsp;</div>
				<span class="udb-inst"><?php echo $Zitiziti['ALL_EVENTS']; ?></span>
                <?php include('config/user_activation_checker.php'); ?>
                <div class="ud-cen-s2">
                    <h2><?php echo $Zitiziti['EVENT_DETAILS']; ?></h2>
                    <?php include "page_level_message.php"; ?>
                    <a href="create-new-event" class="db-tit-btn"><?php echo $Zitiziti['ADD_NEW_EVENT']; ?></a>
                    <table class="responsive-table bordered" id="myTable">
							<thead>
								<tr>
									<th><?php echo $Zitiziti['S_NO']; ?></th>
                                    <th><?php echo $Zitiziti['EVENT_NAME']; ?></th>
									<th><?php echo $Zitiziti['EVENT_DATE']; ?></th>
									<th><?php echo $Zitiziti['VIEWS']; ?></th>
									<th><?php echo $Zitiziti['EDIT']; ?></th>
									<th><?php echo $Zitiziti['DELETE']; ?></th>
									<th><?php echo $Zitiziti['PREVIEW']; ?></th>
								</tr>
							</thead>
							<tbody>

                            <?php
                            $si = 1;
                            foreach (getAllUserEvents($_SESSION['user_id']) as $eventrow) {

                                ?>

                                <tr>
                                    <td><?php echo $si; ?></td>
                                    <td><?php echo $eventrow['event_name']; ?> <span><?php echo dateFormatconverter($eventrow['event_cdt']); ?></span></td>
                                    <td><?php   echo dateFormatconverter($eventrow['event_start_date']); ?></td>
                                    <td><span class="db-list-rat"><?php  echo event_pageview_count($eventrow['event_id']); ?></span></td>
                                    <td><a href="edit-event?code=<?php echo $eventrow['event_id']; ?>" class="db-list-edit"><?php echo $Zitiziti['EDIT']; ?></a></td>
                                    <td><a href="delete-event?code=<?php echo $eventrow['event_id']; ?>" class="db-list-edit"><?php echo $Zitiziti['DELETE']; ?></a></td>
                                    <td><a href="<?php echo $EVENT_URL.urlModifier($eventrow['event_slug']); ?>" class="db-list-edit" target="_blank"><?php echo $Zitiziti['PREVIEW']; ?></a></td>
                                </tr>
                                <?php
                                $si++;
                            }
                            ?>
							</tbody>
						</table>
                </div>
            </div>
<?php
include "dashboard_right_pane.php";
?>