<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

if (file_exists('config/info.php')) {
    include('config/info.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['listing_submit'])) {
        
        // Basic Personal Details
        $is_booking = $_POST["is_booking"] ?? 0;
        $booking_url = $_POST["booking_url"] ?? null;

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $mobile_number = $_POST["mobile_number"];
        $email_id = $_POST["email_id"];

        $register_mode = "Direct";

        // Common Listing Details
        $listing_name = $_POST["listing_name"];
        $listing_mobile = $_POST["listing_mobile"];
        $listing_email = $_POST["listing_email"];
        $listing_website = $_POST["listing_website"];
        $listing_whatsapp = $_POST["listing_whatsapp"];
        $listing_address = $_POST["listing_address"];
        $listing_lat = $_POST["listing_lat"];
        $listing_lng = $_POST["listing_lng"];
        $listing_description = addslashes($_POST["listing_description"]);
        $listing_type_id = 1;

        $service_locations = $_POST["service_locations"];

        $mon_is_open = $_POST['mon_is_open'];
        $mon_open_time = $_POST['mon_open_time'];
        $mon_close_time = $_POST['mon_close_time'];

        $tue_is_open = $_POST['tue_is_open'];
        $tue_open_time = $_POST['tue_open_time'];
        $tue_close_time = $_POST['tue_close_time'];

        $wed_is_open = $_POST['wed_is_open'];
        $wed_open_time = $_POST['wed_open_time'];
        $wed_close_time = $_POST['wed_close_time'];

        $thu_is_open = $_POST['thu_is_open'];
        $thu_open_time = $_POST['thu_open_time'];
        $thu_close_time = $_POST['thu_close_time'];

        $fri_is_open = $_POST['fri_is_open'];
        $fri_open_time = $_POST['fri_open_time'];
        $fri_close_time = $_POST['fri_close_time'];

        $sat_is_open = $_POST['sat_is_open'];
        $sat_open_time = $_POST['sat_open_time'];
        $sat_close_time = $_POST['sat_close_time'];

        $sun_is_open = $_POST['sun_is_open'];
        $sun_open_time = $_POST['sun_open_time'];
        $sun_close_time = $_POST['sun_close_time'];

        $state_id = "1";

        $city_slug = $_POST['city_slug'];
        if (is_array($city_slug)) {
            $city_slug = array_map(function($city) use ($conn) {
                return mysqli_real_escape_string($conn, $city);
            }, $city_slug);
            $city_slug_json = json_encode($city_slug);
        } else {
            $city_slug_json = json_encode([]);
        }

        if ($footer_row['admin_google_paid_geo_location'] == 1) { 

           //    Condition to get City Id Starts

            $session_city = $_POST['geo_city'];
           
            $city_details = mysqli_query($conn,"SELECT * FROM  " . TBL . "cities where city_name='" . $session_city . "'");
            $city_details_row = mysqli_fetch_array($city_details);

            $city_id = $city_details_row['city_id'];  //City Id

          if($city_id == NULL){
            
            $qry = "INSERT INTO " . TBL . "cities 
					(city_name, state_id, city_cdt) 
					VALUES ('$session_city', 1, '$curDate')";

            $res = mysqli_query($conn,$qry);
            $LID = mysqli_insert_id($conn);
            $lastID = $LID;

            $city_id = $lastID; //City Id

          }else{
            $city_id = $city_details_row['city_id'];  //City Id
          } 
          //    Condition to get City Id Ends
          
          //    Condition to get Country Id Starts
          $session_country = $_POST['geo_country'];
           
          $country_details = mysqli_query($conn,"SELECT * FROM  " . TBL . "countries where country_name='" . $session_country . "'");
          $country_details_row = mysqli_fetch_array($country_details);

          $country_id = $country_details_row['country_id'];  //Country Id

        if($country_id == NULL){
          
          $qry = "INSERT INTO " . TBL . "countries 
                  (country_name, country_cdt) 
                  VALUES ('$session_country', '$curDate')";

          $res = mysqli_query($conn,$qry);
          $LID1 = mysqli_insert_id($conn);
          $lastID1 = $LID1;

          $country_id = $lastID1; //Country Id

        }else{
          $country_id = $country_details_row['country_id'];  //Country Id
        } 
          //    Condition to get Country Id Ends
        }else{
                $country_id = $_POST["country_id"];
                $city_id1 = $_POST["city_id"];

        $prefix = $fruitList = '';
        foreach ($city_id1 as $fruit)
        {
            $city_id .= $prefix .  $fruit ;
            $prefix = ',';
        }
             
            }

        $category_id123 = $_POST["category_id"];

        $prefix = $fruitList = '';
        foreach ($category_id123 as $fruit) {
            $category_id .= $prefix . $fruit;
            $prefix = ',';
        }

        $sub_category_id123 = $_POST["sub_category_id"];

        $prefix = $fruitList = '';
        foreach ($sub_category_id123 as $fruit) {
            $sub_category_id .= $prefix . $fruit;
            $prefix = ',';
        }

        $service_id123 = $_POST["service_id"];

        $prefix1 = $fruitList = '';
        foreach ($service_id123 as $fruit1) {
            $service_id .= $prefix1 . $fruit1;
            $prefix1 = ',';
        }

// Listing Timing Details
        $opening_days = $_POST["opening_days"];
        $opening_time = $_POST["opening_time"];
        $closing_time = $_POST["closing_time"];

// Listing Social Link Details
        $fb_link = $_POST["fb_link"];
        $gplus_link = $_POST["gplus_link"];
        $twitter_link = $_POST["twitter_link"];

// Listing Location Details
        $google_map = $_POST["google_map"];
        $threesixty_view = $_POST["360_view"];

        // Listing Video
        $listing_video123 = $_POST["listing_video"];

        $prefix6 = $fruitList = '';
        foreach ($listing_video123 as $fruit6) {
            $listing_video1 = $prefix6 . $fruit6;
            $listing_video .= addslashes($listing_video1);
            $prefix6 = '|';
        }

// Listing Service Names Details

        $service_1_name123 = $_POST["service_1_name"];

        $service_1_name = implode("|", $service_1_name123);

// Listing Offer Prices Details
        $service_1_price123 = $_POST["service_1_price"];

        $prefix1 = $fruitList = '';
        foreach ($service_1_price123 as $fruit1) {
            $service_1_price .= $prefix1 . $fruit1;
            $prefix1 = ',';
        }
        $service_2_price = 0;
        $service_3_price = 0;
        $service_4_price = 0;
        $service_5_price = 0;
        $service_6_price = 0;

// Listing Offer Details
        $service_1_detail123 = $_POST["service_1_detail"];

        $service_1_detail1 = implode("|", $service_1_detail123);
        $service_1_detail = addslashes($service_1_detail1);

        // Listing Offer View more link
        $service_1_view_more123 = $_POST["service_1_view_more"];
        $prefix1 = $fruitList = '';
        foreach ($service_1_view_more123 as $fruit1) {
            $service_1_view_more .= $prefix1 . $fruit1;
            $prefix1 = ',';
        }

        // Listing Products View More
        $listing_products1 = $_POST["listing_products"];
        $prefix = $fruitList = '';
        foreach ($listing_products1 as $fruit) {
            $listing_products .= $prefix . $fruit;
            $prefix = ',';
        }

// Listing Events View More
        $listing_events1 = $_POST["listing_events"];
        $prefix = $fruitList = '';
        foreach ($listing_events1 as $fruit) {
            $listing_events .= $prefix . $fruit;
            $prefix = ',';
        }

//Listing Other Informations
        $listing_info_question123 = $_POST["listing_info_question"];
        $prefix1 = $fruitList = '';
        foreach ($listing_info_question123 as $fruit1) {
            $listing_info_question .= $prefix1 . $fruit1;
            $prefix1 = ',';
        }

        $listing_info_answer123 = $_POST["listing_info_answer"];
        $prefix1 = $fruitList = '';
        foreach ($listing_info_answer123 as $fruit1) {
            $listing_info_answer .= $prefix1 . $fruit1;
            $prefix1 = ',';
        }

// Listing Status
        $payment_status = "Pending";

        function checkListingSlug($link, $counter = 1)
        {
            global $conn;
            $newLink = $link;
            do {
                $checkLink = mysqli_query($conn, "SELECT listing_id FROM " . TBL . "listings WHERE listing_slug = '$newLink'");
                if (mysqli_num_rows($checkLink) > 0) {
                    $newLink = $link . '' . $counter;
                    $counter++;
                } else {
                    break;
                }
            } while (1);

            return $newLink;
        }


        $listing_name1 = trim(preg_replace('/[^A-Za-z0-9]/', ' ', $listing_name));
        $listing_slug = checkListingSlug($listing_name1);

//    Condition to get User Id starts

        if (isset($_POST['user_code']) && !empty($_POST['user_code'])) {
            $user_code = $_POST['user_code'];
            $user_details = mysqli_query($conn, "SELECT * FROM  " . TBL . "users where user_code='" . $user_code . "'");
            $user_details_row = mysqli_fetch_array($user_details);

            $user_id = $user_details_row['user_id'];  //User Id

            // if ($user_details_row['user_status'] == 'Active') {
                // Listing Status
                $listing_status = "Active";
            // } else {
                // Listing Status
                // $listing_status = "Inactive";
            // }

        } else {

            $user_status = "Active";

            $qry = "INSERT INTO " . TBL . "users 
					(first_name, last_name, email_id, mobile_number, register_mode, user_status, user_cdt) 
					VALUES ('$first_name', '$last_name', '$email_id', '$mobile_number','$register_mode', '$user_status', '$curDate')";

            $res = mysqli_query($conn, $qry);
            $LID = mysqli_insert_id($conn);
            $lastID = $LID;

            switch (strlen($LID)) {
                case 1:
                    $LID = '00' . $LID;
                    break;
                case 2:
                    $LID = '0' . $LID;
                    break;
                default:
                    $LID = $LID;
                    break;
            }

            $userID = 'USER' . $LID;

            $upqry = "UPDATE " . TBL . "users 
					  SET user_code = '$userID' 
					  WHERE user_id = $lastID";

            //echo $upqry; die();
            $upres = mysqli_query($conn, $upqry);

            $user_id = $lastID; //User Id

            // Listing Status
            $listing_status = "Active";


        }
//    Condition to get User Id Ends

//************************  Profile Image Upload starts  **************************

        if (!empty($_FILES['profile_image']['name'])) {
            $file = rand(1000, 100000) . $_FILES['profile_image']['name'];
            $file_loc = $_FILES['profile_image']['tmp_name'];
            $file_size = $_FILES['profile_image']['size'];
            $file_type = $_FILES['profile_image']['type'];
            $allowed = array("image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp", "image/svg", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
            if (in_array($file_type, $allowed)) {
                $folder = "../images/listings/";
                $new_size = $file_size / 1024;
                $new_file_name = strtolower($file);
                $event_image = str_replace(' ', '-', $new_file_name);
                //move_uploaded_file($file_loc, $folder . $event_image);
                $profile_image = compressImage($event_image, $file_loc, $folder, $new_size);
            } else {
                $profile_image = '';
            }
        }
//************************  Profile Image Upload Ends  **************************

//************************  Cover Image Upload starts  **************************

        if (!empty($_FILES['cover_image']['name'])) {
            $file = rand(1000, 100000) . $_FILES['cover_image']['name'];
            $file_loc = $_FILES['cover_image']['tmp_name'];
            $file_size = $_FILES['cover_image']['size'];
            $file_type = $_FILES['cover_image']['type'];
            $allowed = array("image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp", "image/svg", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
            if (in_array($file_type, $allowed)) {
                $folder = "../images/listing-ban/";
                $new_size = $file_size / 1024;
                $new_file_name = strtolower($file);
                $event_image = str_replace(' ', '-', $new_file_name);
                //move_uploaded_file($file_loc, $folder . $event_image);
                $cover_image = compressImage($event_image, $file_loc, $folder, $new_size);
            } else {
                $cover_image = '';
            }
        }

//************************  Cover Image Upload ends  **************************

// ************************  Gallery Image Upload starts  **************************   

        $all_gallery_image = $_FILES['gallery_image'];
        $all_gallery_image23 = $_FILES['gallery_image']['name'];

        for ($k = 0; $k < count($all_gallery_image23); $k++) {


            if (!empty($all_gallery_image['name'][$k])) {
                $file1 = rand(1000, 100000) . $all_gallery_image['name'][$k];
                $file_loc1 = $all_gallery_image['tmp_name'][$k];
                $file_size1 = $all_gallery_image['size'][$k];
                $file_type1 = $all_gallery_image['type'][$k];
                $allowed = array("image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp", "image/svg", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
                if (in_array($file_type1, $allowed)) {
                    $folder1 = "../images/listings/";
                    $new_size = $file_size1 / 1024;
                    $new_file_name1 = strtolower($file1);
                    $event_image1 = str_replace(' ', '-', $new_file_name1);
                    //move_uploaded_file($file_loc1, $folder1 . $event_image1);
                    $gallery_image1[] = compressImage($event_image1, $file_loc1, $folder1, $new_size);
                } else {
                    $gallery_image1[] = '';
                }
            }

        }
        if($gallery_image1 != NULL){
            $gallery_image = implode(",", $gallery_image1);
            }else{
                $gallery_image = '';
            }

// ************************  Gallery Image Upload ends  **************************   

// ************************  Service Image Upload starts  ************************** 

        $all_service_image = $_FILES['service_image'];
        $all_service_image23 = $_FILES['service_image']['name'];

        for ($k = 0; $k < count($all_service_image23); $k++) {

            if (!empty($_FILES['service_image']['name'][$k])) {
                $file = rand(1000, 100000) . $_FILES['service_image']['name'][$k];
                $file_loc = $_FILES['service_image']['tmp_name'][$k];
                $file_size = $_FILES['service_image']['size'][$k];
                $file_type = $_FILES['service_image']['type'][$k];
                $allowed = array("image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp", "image/svg", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
                if (in_array($file_type, $allowed)) {
                    $folder = "../images/services/";
                    $new_size = $file_size / 1024;
                    $new_file_name = strtolower($file);
                    $event_image = str_replace(' ', '-', $new_file_name);
                    //move_uploaded_file($file_loc, $folder . $event_image);
                    $service_image1[] = compressImage($event_image, $file_loc, $folder, $new_size);
                } else {
                    $service_image1[] = '';
                }
            }

        }
        if($service_image1 != NULL){
        $service_image = implode(",", $service_image1);
    }else{
        $service_image = '';
    }

// ************************  Service Image Upload ends  **************************

// ************************  Offer Image Upload Starts  **************************

        $all_service_1_image = $_FILES['service_1_image'];
        $all_service_1_image2 = $_FILES['service_1_image']['name'];

        for ($k = 0; $k < count($all_service_1_image2); $k++) {

            if (!empty($_FILES['service_1_image']['name'][$k])) {
                $file = rand(1000, 100000) . $_FILES['service_1_image']['name'][$k];
                $file_loc = $_FILES['service_1_image']['tmp_name'][$k];
                $file_size = $_FILES['service_1_image']['size'][$k];
                $file_type = $_FILES['service_1_image']['type'][$k];
                $allowed = array("image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp", "image/svg", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
                if (in_array($file_type, $allowed)) {
                    $folder = "../images/services/";
                    $new_size = $file_size / 1024;
                    $new_file_name = strtolower($file);
                    $event_image = str_replace(' ', '-', $new_file_name);
                    //move_uploaded_file($file_loc, $folder . $event_image);
                    $service_1_image1[] = compressImage($event_image, $file_loc, $folder, $new_size);
                } else {
                    $service_1_image1[] = '';
                }
            }

        }
        if($service_1_image1 != NULL){
        $service_1_image = implode(",", $service_1_image1);
        }else{
        $service_1_image = '';
        }
// ************************  Offer Image Upload ends  **************************

//    Listing Insert Part Starts

        $listing_qry = "INSERT INTO " . TBL . "listings
					(user_id, category_id, sub_category_id,city_slug, service_id, service_image, listing_type_id, listing_name, listing_mobile, listing_email
					, listing_website, listing_whatsapp, listing_description, listing_address, listing_lat, listing_lng, service_locations, country_id, state_id, city_id, profile_image, cover_image
					, gallery_image, opening_days, opening_time, closing_time, fb_link, twitter_link, gplus_link, google_map
					, 360_view, listing_video, service_1_name, service_1_price, service_1_detail, service_1_image, service_1_view_more, service_2_name,service_2_price, service_2_image, service_3_name,service_3_price, service_3_image
					, service_4_name,service_4_price,service_4_image,service_5_name,service_5_price, service_5_image, service_6_name,service_6_price, service_6_image, listing_status, listing_products, listing_events
					, mon_is_open, mon_open_time, mon_close_time, tue_is_open, tue_open_time, tue_close_time, wed_is_open, wed_open_time, wed_close_time
					, thu_is_open, thu_open_time, thu_close_time, fri_is_open, fri_open_time, fri_close_time, sat_is_open, sat_open_time, sat_close_time
					, sun_is_open,sun_open_time, sun_close_time
					, listing_info_question , listing_info_answer, payment_status, listing_slug, is_booking,booking_url, listing_cdt) 
					VALUES 
					('$user_id', '$category_id', '$sub_category_id','$city_slug_json', '$service_id', '$service_image', '$listing_type_id', '$listing_name', '$listing_mobile', '$listing_email', '$listing_website', '$listing_whatsapp', '$listing_description'
					, '$listing_address', '$listing_lat', '$listing_lng', '$service_locations', '$country_id'
					, '$state_id', '$city_id', '$profile_image', '$cover_image'
					,'$gallery_image', '$opening_days', '$opening_time', '$closing_time', '$fb_link', '$twitter_link', '$gplus_link', '$google_map'
					,'$threesixty_view', '$listing_video', '$service_1_name', '$service_1_price', '$service_1_detail', '$service_1_image', '$service_1_view_more', '$service_2_name', '$service_2_price', '$service_2_image', '$service_3_name', '$service_3_price', '$service_3_image'
					, '$service_4_name', '$service_4_price', '$service_4_image', '$service_5_name', '$service_5_price', '$service_5_image', '$service_6_name', '$service_6_price', '$service_6_image', '$listing_status', '$listing_products', '$listing_events'
					, '$mon_is_open', '$mon_open_time', '$mon_close_time', '$tue_is_open', '$tue_open_time', '$tue_close_time', '$wed_is_open', '$wed_open_time', '$wed_close_time'
					, '$thu_is_open', '$thu_open_time', '$thu_close_time', '$fri_is_open', '$fri_open_time', '$fri_close_time', '$sat_is_open', '$sat_open_time', '$sat_close_time'
					, '$sun_is_open', '$sun_open_time', '$sun_close_time'
					, '$listing_info_question', '$listing_info_answer', '$payment_status', '$listing_slug','$is_booking','$booking_url', '$curDate')";

        $listing_res = mysqli_query($conn, $listing_qry);
        $ListingID = mysqli_insert_id($conn);
        $listlastID = $ListingID;
        
        $booking_type = "listing";
        include "../booking_syatem_insert.php";

        switch (strlen($ListingID)) {
            case 1:
                $ListingID = '00' . $ListingID;
                break;
            case 2:
                $ListingID = '0' . $ListingID;
                break;
            default:
                $ListingID = $ListingID;
                break;
        }

        $ListCode = 'LIST' . $ListingID;

        $lisupqry = "UPDATE " . TBL . "listings
					  SET listing_code = '$ListCode' 
					  WHERE listing_id = $listlastID";

        $lisupres = mysqli_query($conn, $lisupqry);

        //****************************    Top Service Providers listing count check and addition starts    *************************


        //**  To check the given category id is available on top_service_provider_table    ***

        $top_service_sql = "SELECT * FROM  " . TBL . "top_service_providers where top_service_provider_category_id='" . $category_id . "'";
        $top_service_sql_rs = mysqli_query($conn, $top_service_sql);
        $top_service_sql_count = mysqli_num_rows($top_service_sql_rs);

        if ($top_service_sql_count > 0) {  //if category ID available in top service provider

            $top_service_sql_row = mysqli_fetch_array($top_service_sql_rs);

            $top_service_provider_listings = $top_service_sql_row['top_service_provider_listings'];
            $top_service_provider_category_id = $top_service_sql_row['top_service_provider_category_id'];

            $top_service_provider_listings_array = explode(",", $top_service_provider_listings);

            $top_service_provider_listings_array_count = count($top_service_provider_listings_array);

            if ($top_service_provider_listings_array_count <= 4) {   //if Listings less than or equal to 4 means update top service provider

                $parts = $top_service_provider_listings_array;
                $parts[] = $ListingID;                                  //updating existing listings array with new listing ID

                $top_service_provider_listings_new = implode(',', $parts);

                $top_service_provider_sql = mysqli_query($conn, "UPDATE  " . TBL . "top_service_providers SET top_service_provider_listings = '$top_service_provider_listings_new'
     where top_service_provider_category_id='" . $top_service_provider_category_id . "'");

            }
        }

        //****************************    Top Service Providers listing count check and addition ends    *************************


        //****************************    Admin Primary email fetch starts    *************************

        $admin_primary_email_fetch = mysqli_query($conn, "SELECT * FROM " . TBL . "footer  WHERE footer_id = '1' ");
        $admin_primary_email_fetchrow = mysqli_fetch_array($admin_primary_email_fetch);
        $admin_primary_email = $admin_primary_email_fetchrow['admin_primary_email'];
        $admin_footer_copyright = $admin_primary_email_fetchrow['footer_copyright'];
        $admin_site_name = $admin_primary_email_fetchrow['website_address'];
        $admin_address = $admin_primary_email_fetchrow['footer_address'];

        //****************************    Admin Primary email fetch ends    *************************


        if ($lisupres) {

            $admin_email = $admin_primary_email; // Admin Email Id

            $webpage_full_link_with_login = $webpage_full_link . "login";  //URL Login Link

//****************************    Admin email starts    *************************

            $to = $admin_email;
            $subject = "$admin_site_name -New Listing has been created";

            $admin_sql_fetch = mysqli_query($conn, "SELECT * FROM " . TBL . "mail  WHERE mail_id = 7 "); //admin mail template fetch
            $admin_sql_fetch_row = mysqli_fetch_array($admin_sql_fetch);

            $mail_template_admin = $admin_sql_fetch_row['mail_template'];

            $message1 = stripslashes(str_replace(array('\'.$admin_site_name.\'', '\' . $first_name . \'', '\' . $email_id . \''
            , '\' . $mobile_number . \'', '\' . $listing_name . \'', '\' . $listing_email . \'', '\' . $listing_mobile . \'', '\'.$admin_footer_copyright.\'', '\'.$admin_address.\'', '\'.$webpage_full_link.\'', '\'.$webpage_full_link_with_login.\'', '\'.$admin_primary_email.\''),
                array('' . $admin_site_name . '', '' . $first_name . '', '' . $email_id . '', '' . $mobile_number . '', '' . $listing_name . '', '' . $listing_email . '', '' . $listing_mobile . '', '' . $admin_footer_copyright . '', '' . $admin_address . '', '' . $webpage_full_link . '', '' . $webpage_full_link_with_login . '', '' . $admin_primary_email . ''), $mail_template_admin));


            $headers = "From: " . "$email_id" . "\r\n";
            $headers .= "Reply-To: " . "$email_id" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";


            mail($to, $subject, $message1, $headers); //admin email


//****************************    Admin email ends    *************************

//****************************    Client email starts    *************************

            $to1 = $email_id;
            $subject1 = "$admin_site_name Listing Creation Successful";

            $client_sql_fetch = mysqli_query($conn, "SELECT * FROM " . TBL . "mail  WHERE mail_id = 6 "); //User mail template fetch
            $client_sql_fetch_row = mysqli_fetch_array($client_sql_fetch);

            $mail_template_client = $client_sql_fetch_row['mail_template'];

            $message2 = stripslashes(str_replace(array('\'.$admin_site_name.\'', '\' . $first_name . \'', '\' . $email_id . \''
            , '\' . $mobile_number . \'', '\' . $listing_name . \'', '\' . $listing_email . \'', '\' . $listing_mobile . \'', '\'.$admin_footer_copyright.\'', '\'.$admin_address.\'', '\'.$webpage_full_link.\'', '\'.$webpage_full_link_with_login.\'', '\'.$admin_primary_email.\''),
                array('' . $admin_site_name . '', '' . $first_name . '', '' . $email_id . '', '' . $mobile_number . '', '' . $listing_name . '', '' . $listing_email . '', '' . $listing_mobile . '', '' . $admin_footer_copyright . '', '' . $admin_address . '', '' . $webpage_full_link . '', '' . $webpage_full_link_with_login . '', '' . $admin_primary_email . ''), $mail_template_client));


            $headers1 = "From: " . "$admin_email" . "\r\n";
            $headers1 .= "Reply-To: " . "$admin_email" . "\r\n";
            $headers1 .= "MIME-Version: 1.0\r\n";
            $headers1 .= "Content-Type: text/html; charset=utf-8\r\n";


            mail($to1, $subject1, $message2, $headers1); //admin email

//****************************    client email ends    *************************


            $_SESSION['status_msg'] = "New Listing has been created Successfully!!!";

            header('Location: admin-all-listings.php');
        } else {

            $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

            header('Location: admin-add-new-listings-start.php');
        }

        //    Listing Insert Part Ends

    }
} else {

    $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

    header('Location: admin-add-new-listings-start.php');
}