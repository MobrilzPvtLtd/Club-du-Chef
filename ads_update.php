<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

if (file_exists('config/info.php')) {
    include('config/info.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['create_ad_submit'])) {
        $path = $_POST['path'];
        $all_ads_enquiry_id = $_POST['all_ads_enquiry_id'];

        $user_id = $_SESSION['user_id']; //Session data
        $all_ads_price_id = $_POST["all_ads_price_id"];
        $listing_id = $_POST["listing_id"];
        // printf($listing_id);
        // die();

        $ad_start_date_old = $_POST["ad_start_date"];
        $timestamp1 = strtotime($ad_start_date_old);
        $ad_start_date = date('Y-m-d H:i:s', $timestamp1);

        $ad_end_date_old = $_POST["ad_end_date"];
        $timestamp = strtotime($ad_end_date_old);
        $ad_end_date = date('Y-m-d H:i:s', $timestamp);

        $ad_total_days = $_POST["ad_total_days"];
        $ad_cost_per_day = $_POST["ad_cost_per_day"];
        $ad_total_cost = $_POST["ad_total_cost"];

        $allowed_types = array(
            "image/jpeg",
            "image/pjpeg",
            "image/png",
            "image/gif",
            "image/webp",
            "image/svg+xml",
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.template"
        );
        
        function processFile($fileInputName, $index, $existingFile = '') {
            global $allowed_types;
        
            if (!empty($_FILES[$fileInputName]['name'][$index])) {
                $file_name = rand(1000, 100000) . '_' . basename($_FILES[$fileInputName]['name'][$index]);
                $file_loc = $_FILES[$fileInputName]['tmp_name'][$index];
                $file_size = $_FILES[$fileInputName]['size'][$index];
                $file_type = $_FILES[$fileInputName]['type'][$index];
        
                if (in_array($file_type, $allowed_types)) {
                    $folder = "images/ads/";
                    $new_size = $file_size / 1024; 
                    $new_file_name = strtolower($file_name);
                    $event_image = str_replace(' ', '-', $new_file_name);
        
                    if (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }
        
                    compressImage($event_image, $file_loc, $folder, $new_size);
                    return $event_image;
                } else {
                    return $existingFile; 
                }
            }
            return $existingFile; 
        }

        // Fetch existing file names from the database
        $existing_files_sql = "SELECT listing_id, ad_start_date, ad_end_date, ad_total_days, ad_cost_per_day,ad_total_cost, ad_enquiry_status, ad_enquiry_cdt, ad_image_1, ad_image_2, ad_image_3, ad_image_4, image_1_link, image_2_link, image_3_link, image_4_link FROM " . TBL . "all_ads_enquiry WHERE all_ads_enquiry_id='" . mysqli_real_escape_string($conn, $all_ads_enquiry_id) . "'";
        $result = mysqli_query($conn, $existing_files_sql);
        $existing_files = mysqli_fetch_assoc($result);

        $ad_images = [];
        for ($j = 1; $j <= 4; $j++) {
            $ad_images[] = processFile('ad_image_' . $j, 0 ,$existing_files['ad_image_' . $j]);
        } 
        
        $images_link = [];
        for ($l = 1; $l <= 8; $l++) {
            $images_link[] = $_POST['image_' . $l . '_link'];
        }
        
        $ad_enquiry_status = "InActive";
        $curDate = date('Y-m-d H:i:s');

        $sql = mysqli_query($conn, "UPDATE  " . TBL . "all_ads_enquiry SET 
            user_id = '" . $user_id . "',
            all_ads_price_id = '" . $all_ads_price_id . "',
            ad_start_date = '" . $ad_start_date . "',
            ad_end_date = '" . $ad_end_date . "',
            listing_id = '" . $listing_id . "',
            ad_total_days = '" . $ad_total_days . "',
            ad_cost_per_day = '" . $ad_cost_per_day . "',
            ad_total_cost = '" . $ad_total_cost . "',
            ad_image_1='" . $ad_images[0] . "',
            ad_image_2='" . $ad_images[1] . "',
            ad_image_3='" . $ad_images[2] . "',
            ad_image_4='" . $ad_images[3] . "',
            image_1_link='" . $images_link[0] . "',
            image_2_link='" . $images_link[1] . "',
            image_3_link='" . $images_link[2] . "',
            image_4_link='" . $images_link[3] . "'
            where all_ads_enquiry_id='" . $all_ads_enquiry_id . "'"
        );

        if ($sql) {
            // $result = mysqli_query($conn, "SELECT payment_status FROM " . TBL . "all_ads_enquiry WHERE all_ads_enquiry_id='" . mysqli_real_escape_string($conn, $all_ads_enquiry_id) . "'");
            
            // if ($result && $row = mysqli_fetch_assoc($result)) {
            //     if ($row['payment_status'] == "Unpaid") {
            //         $_SESSION['ads_enquiry_id'] = $all_ads_enquiry_id;
            //         $_SESSION['ad_total_cost'] = $ad_total_cost;
            //         header('Location: payment_paypal_ads.php');
            //     } else {
            //         $_SESSION['status_msg'] = "Ad has been Updated Successfully!!!";
            //         header('Location: db-post-ads');
            //     }
            // } else {
            //     $_SESSION['status_msg'] = $Zitiziti['OOPS_SOMETHING_WENT_WRONG'];
            //     header('Location: post-your-ads');
            // }

            $_SESSION['status_msg'] = "Ad has been Updated Successfully!!!";
            header('Location: db-post-ads');
        } else {
            $_SESSION['status_msg'] = $Zitiziti['OOPS_SOMETHING_WENT_WRONG'];
            header('Location: post-your-ads');
        }
        exit;        
    }
} else {

    $_SESSION['status_msg'] = $Zitiziti['OOPS_SOMETHING_WENT_WRONG'];

    header('Location: post-your-ads');
    exit;
}
?>