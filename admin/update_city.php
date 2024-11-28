<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

if (file_exists('config/info.php')) {
    include('config/info.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['city_submit'])) {

        $city_id = $_POST['city_id'];
        $city_name = $_POST['city_name'];


        //************ city Name Already Exist Check Starts ***************


        $city_name_exist_check = mysqli_query($conn, "SELECT * FROM " . TBL . "cities  WHERE city_name='" . $city_name . "' AND city_id != $city_id ");

        if (mysqli_num_rows($city_name_exist_check) > 0) {


            $_SESSION['status_msg'] = "The Given city name is Already Exist Try Other!!!";

            header('Location: admin-city-edit.php?row=' . $city_id);
            exit;


        }

        //************ city Name Already Exist Check Ends ***************

        $allowed_types = array(
            "image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp",
            "image/svg+xml", "application/pdf", "application/msword",
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
                    $folder = "../images/cityimage/";
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
        $existing_files_sql = "SELECT city_logo_1, city_logo_2, ad_image_1, ad_image_2, ad_image_3, ad_image_4, ad_image_5, ad_image_6, ad_image_7, ad_image_8, image_1_link,image_2_link,image_3_link,image_4_link,image_5_link,image_6_link,image_7_link,image_8_link,cat_image_1,cat_image_2,cat_image_3,cat_image_4,cat_image_5,cat_image_6,cat_image_7,cat_image_8,cat_image_1_link,cat_image_2_link,cat_image_3_link,cat_image_4_link,cat_image_5_link,cat_image_6_link,cat_image_7_link,cat_image_8_link,details_image_1,details_image_2,details_image_3,details_image_4,details_image_5,details_image_6,details_image_7,details_image_8,details_image_1_link,details_image_2_link,details_image_3_link,details_image_4_link,details_image_5_link,details_image_6_link,details_image_7_link,details_image_8_link,single_image_1,single_image_2,single_image_3,single_image_4,single_image_5,single_image_6,single_image_7,single_image_8,single_image_1_link,single_image_2_link,single_image_3_link,single_image_4_link,single_image_5_link,single_image_6_link,single_image_7_link,single_image_8_link FROM " . TBL . "cities WHERE city_id='" . mysqli_real_escape_string($conn, $city_id) . "'";
        $result = mysqli_query($conn, $existing_files_sql);
        $existing_files = mysqli_fetch_assoc($result);
        
        // $city_name = processFile('city_name', 0, $existing_files['city_name']);
        $city_logo_1 = processFile('city_logo_1', 0, $existing_files['city_logo_1']);
        $city_logo_2 = processFile('city_logo_2', 0, $existing_files['city_logo_2']);

        $ad_images = [];
        $cat_image = [];
        $details_image = [];
        $single_image = [];
        for ($j = 1; $j <= 8; $j++) {
            $ad_images[] = processFile('ad_image_' . $j, 0 ,$existing_files['ad_image_' . $j]);
            $cat_image[] = processFile('cat_image_' . $j, 0, $existing_files['cat_image_' . $j]);
            $details_image[] = processFile('details_image_' . $j, 0, $existing_files['details_image_' . $j]);
            $single_image[] = processFile('single_image_' . $j, 0, $existing_files['single_image_' . $j]);
        } 

        // $ad_image_1 = processFile('ad_image_1', 0, $existing_files['ad_image_1']);
        // $ad_image_2 = processFile('ad_image_2', 0, $existing_files['ad_image_2']);
        // $ad_image_3 = processFile('ad_image_3', 0, $existing_files['ad_image_3']);
        // $ad_image_4 = processFile('ad_image_4', 0, $existing_files['ad_image_4']);
        // $ad_image_5 = processFile('ad_image_5', 0, $existing_files['ad_image_5']);
        // $ad_image_6 = processFile('ad_image_6', 0, $existing_files['ad_image_6']);
        // $ad_image_7 = processFile('ad_image_7', 0, $existing_files['ad_image_7']);
        // $ad_image_8 = processFile('ad_image_8', 0, $existing_files['ad_image_8']);

        $images_link = [];
        $cat_image_link = [];
        $details_image_link = [];
        $single_image_link = [];
        for ($l = 1; $l <= 8; $l++) {
            $images_link[] = $_POST['image_' . $l . '_link'];
            $cat_image_link[] = $_POST['cat_image_' . $l . '_link'];
            $details_image_link[] = $_POST['details_image_' . $l . '_link'];
            $single_image_link[] = $_POST['single_image_' . $l . '_link'];
        }

        $city_slug = generateSlug($city_name);

        $sql = mysqli_query($conn, "UPDATE  " . TBL . "cities SET 
            city_name='" . $city_name . "', city_slug='" . $city_slug . "',city_logo_1='" . $city_logo_1 . "',city_logo_2='" . $city_logo_2 . "',
            ad_image_1='" . $ad_images[0] . "',
            ad_image_2='" . $ad_images[1] . "',
            ad_image_3='" . $ad_images[2] . "',
            ad_image_4='" . $ad_images[3] . "',
            ad_image_5='" . $ad_images[4] . "',
            ad_image_6='" . $ad_images[5] . "',
            ad_image_7='" . $ad_images[6] . "',
            ad_image_8='" . $ad_images[7] . "',
            image_1_link='" . $images_link[0] . "',
            image_2_link='" . $images_link[1] . "',
            image_3_link='" . $images_link[2] . "',
            image_4_link='" . $images_link[3] . "',
            image_5_link='" . $images_link[4] . "',
            image_6_link='" . $images_link[5] . "',
            image_7_link='" . $images_link[6] . "',
            image_8_link='" . $images_link[7] . "',
            cat_image_1='" . $cat_image[0] . "',
            cat_image_2='" . $cat_image[1] . "',
            cat_image_3='" . $cat_image[2] . "',
            cat_image_4='" . $cat_image[3] . "',
            cat_image_5='" . $cat_image[4] . "',
            cat_image_6='" . $cat_image[5] . "',
            cat_image_7='" . $cat_image[6] . "',
            cat_image_8='" . $cat_image[7] . "',
            cat_image_1_link='" . $cat_image_link[0] . "',
            cat_image_2_link='" . $cat_image_link[1] . "',
            cat_image_3_link='" . $cat_image_link[2] . "',
            cat_image_4_link='" . $cat_image_link[3] . "',
            cat_image_5_link='" . $cat_image_link[4] . "',
            cat_image_6_link='" . $cat_image_link[5] . "',
            cat_image_7_link='" . $cat_image_link[6] . "',
            cat_image_8_link='" . $cat_image_link[7] . "', 
            details_image_1='" . $details_image[0] . "',
            details_image_2='" . $details_image[1] . "',
            details_image_3='" . $details_image[2] . "',
            details_image_4='" . $details_image[3] . "',
            details_image_5='" . $details_image[4] . "',
            details_image_6='" . $details_image[5] . "',
            details_image_7='" . $details_image[6] . "',
            details_image_8='" . $details_image[7] . "',
            details_image_1_link='" . $details_image_link[0] . "',
            details_image_2_link='" . $details_image_link[1] . "',
            details_image_3_link='" . $details_image_link[2] . "',
            details_image_4_link='" . $details_image_link[3] . "',
            details_image_5_link='" . $details_image_link[4] . "',
            details_image_6_link='" . $details_image_link[5] . "',
            details_image_7_link='" . $details_image_link[6] . "',
            details_image_8_link='" . $details_image_link[7] . "', 
            single_image_1='" . $single_image[0] . "',
            single_image_2='" . $single_image[1] . "',
            single_image_3='" . $single_image[2] . "',
            single_image_4='" . $single_image[3] . "',
            single_image_5='" . $single_image[4] . "',
            single_image_6='" . $single_image[5] . "',
            single_image_7='" . $single_image[6] . "',
            single_image_8='" . $single_image[7] . "',
            single_image_1_link='" . $single_image_link[0] . "',
            single_image_2_link='" . $single_image_link[1] . "',
            single_image_3_link='" . $single_image_link[2] . "',
            single_image_4_link='" . $single_image_link[3] . "',
            single_image_5_link='" . $single_image_link[4] . "',
            single_image_6_link='" . $single_image_link[5] . "',
            single_image_7_link='" . $single_image_link[6] . "',
            single_image_8_link='" . $single_image_link[7] . "' 
            where city_id='" . $city_id . "'"
        );

        if ($sql) {

            $_SESSION['status_msg'] = "city has been Updated Successfully!!!";

            header('Location: admin-all-city.php');
            exit;

        } else {

            $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

            header('Location: admin-city-edit.php?row=' . $city_id);
            exit;
        }
    }
} else {

    $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

    header('Location: admin-all-city.php');
    exit;
}


function generateSlug($string)
{
    // Lowercase the string
    $string = strtolower($string);

    // Check if the string contains any spaces
    if (strpos($string, ' ') === false) {
        return $string;
    }

    // Replace non-alphanumeric characters with hyphens
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);

    // Trim leading and trailing hyphens
    $string = trim($string, '-');

    // Additional check to remove a hyphen at the end if present
    if (substr($string, -1) === '-') {
        $string = substr($string, 0, -1);
    }

    return $string;

}
?>