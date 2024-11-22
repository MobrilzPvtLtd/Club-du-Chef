<?php
include "header.php";

if (file_exists('config/user_authentication.php')) {
    include('config/user_authentication.php');
}

include "dashboard_left_pane.php";

?>
			<!--CENTER SECTION-->
            <div class="ud-main">
   <div class="ud-main-inn ud-no-rhs">
			<div class="ud-cen">
				<div class="log-bor">&nbsp;</div>
				<span class="udb-inst"><?php echo $Zitiziti['EDIT_USER_PROFILE']; ?></span>
                <?php include('config/user_activation_checker.php'); ?>
                <div class="ud-cen-s2 ud-pro-edit">
                    <h2><?php echo $Zitiziti['PROFILE_DETAILS']; ?></h2>
                    <?php include "page_level_message.php"; ?>
                    <?php
                    $user_details_row = getUser($_SESSION['user_id']);
                    ?>
                    <form id="profile_update" name="profile_update" action="profile_update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $user_details_row['profile_image']; ?>" autocomplete="off" name="profile_image_old" id="profile_image_old" required class="validate">
                        <input type="hidden" value="<?php echo $user_details_row['cover_image']; ?>" autocomplete="off" name="cover_photo_old" id="cover_photo_old" required class="validate">
                        <input type="hidden" value="<?php echo $user_details_row['profile_id_proof']; ?>" autocomplete="off" name="profile_id_proof_old" id="profile_id_proof_old" required class="validate">
                        <input type="hidden" value="<?php echo $user_details_row['password']; ?>" autocomplete="off" name="password_old" id="password_old" required class="validate">
                        <table class="responsive-table bordered">
							<tbody>
								<tr>
                                    <td><?php echo $Zitiziti['NAME']; ?></td>
									<td><?php echo $user_details_row['first_name']; ?></td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['EMAIL_ID']; ?></td>
									<td><?php echo $user_details_row['email_id']; ?></td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['PROFILE_PASSWORD']; ?></td>
									<td>
                                        <div class="form-group">
                                          <input type="text" class="form-control" name="password" placeholder="<?php echo $Zitiziti['CHANGE_PASSWORD'];?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['MOBILE_NUMBER']; ?></td>
									<td>
                                        <div class="form-group">
                                          <input type="text" name="mobile_number" class="form-control" value="<?php echo $user_details_row['mobile_number']; ?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['PROFILE_PICTURE']; ?></td>
									<td>
                                        <div class="form-group">
                                          <div class="fil-img-uplo">
                                                <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE'];  ?></span>
                                                <input type="file" name="profile_image" accept="image/*,.jpg,.jpeg,.png" class="form-control">
                                            </div>
                                        </div>
                                        
                                    </td>
								</tr>
                               <tr>
                                    <td><?php echo $Zitiziti['PROFILE_PICTURE_COVER']; ?></td>
									<td>
                                        <div class="form-group">
                                          <div class="fil-img-uplo">
                                                <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE'];  ?></span>
                                                <input type="file" name="cover_photo" accept="image/*,.jpg,.jpeg,.png" class="form-control">
                                            </div>
                                        </div>
                                        
                                    </td>
								</tr>
                               <tr>
                                    <td><?php echo $Zitiziti['PROFILE_IDPROOF']; ?></td>
									<td>
                                        <div class="form-group">
                                          <div class="fil-img-uplo">
                                                <span class="dumfil"><?php echo $Zitiziti['UPLOAD_A_FILE'];  ?></span>
                                                <input type="file" name="profile_id_proof" accept="image/*,.jpg,.jpeg,.png" class="form-control">
                                            </div>
                                        </div>
                                        
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['CITY']; ?></td>
									<td>
                                        <div class="form-group">
                                          <input type="text" id="select-city" class="autocomplete form-control"
                                                 name="user_city" value="<?php echo $user_details_row['user_city']; ?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['JOIN_DATE']; ?></td>
									<td><?php  echo dateFormatconverter($user_details_row['user_cdt']); ?></td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['VERIFIED']; ?></td>
									<td><?php if($user_details_row['user_status']== "Active"){ echo "Yes";}else {echo "No";} ?></td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['PREMIUM_SERVICE_PROVIDER']; ?></td>
									<td><?php if($user_details_row['user_type']== "Service provider"){ echo "Yes";}else {echo "No";} ?></td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['FACEBOOK']; ?></td>
									<td>
                                        <div class="form-group">
                                          <input type="text" class="form-control" name="user_facebook" value="<?php echo $user_details_row['user_facebook']; ?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['TWITTER']; ?></td>
                                    <td>
                                        <div class="form-group">
                                          <input type="text" class="form-control" name="user_twitter" value="<?php echo $user_details_row['user_twitter']; ?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['YOUTUBE']; ?></td>
                                    <td>
                                        <div class="form-group">
                                          <input type="text" class="form-control" name="user_youtube" value="<?php echo $user_details_row['user_youtube']; ?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td><?php echo $Zitiziti['USER_WEBSITE']; ?></td>
                                    <td>
                                        <div class="form-group">
                                          <input type="text" class="form-control" name="user_website" value="<?php echo $user_details_row['user_website']; ?>">
                                        </div>
                                    </td>
								</tr>
                                <tr>
                                    <td>
                                        <button type="submit" name="profile_update_submit" class="db-pro-bot-btn"><?php echo $Zitiziti['SAVE_CHANGES']; ?></button>
                                        <a href="db-payment" class="db-pro-bot-btn"><?php echo $Zitiziti['UPGRADE']; ?></a>
                                    </td>
									<td></td>
								</tr>
							</tbody>
						</table>
                    </form>
                </div>
            </div>
<?php
include "dashboard_right_pane.php";
?>