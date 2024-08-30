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
        $existing_files_sql = "SELECT city_logo_1, city_logo_2, ad_image_1, ad_image_2, ad_image_3, ad_image_4, ad_image_5, ad_image_6, ad_image_7, ad_image_8 FROM " . TBL . "cities WHERE city_id='" . mysqli_real_escape_string($conn, $city_id) . "'";
        $result = mysqli_query($conn, $existing_files_sql);
        $existing_files = mysqli_fetch_assoc($result);
        
        $city_logo_1 = processFile('city_logo_1', 0, $existing_files['city_logo_1']);
        $city_logo_2 = processFile('city_logo_2', 0, $existing_files['city_logo_2']);
        $ad_image_1 = processFile('ad_image_1', 0, $existing_files['ad_image_1']);
        $ad_image_2 = processFile('ad_image_2', 0, $existing_files['ad_image_2']);
        $ad_image_3 = processFile('ad_image_3', 0, $existing_files['ad_image_3']);
        $ad_image_4 = processFile('ad_image_4', 0, $existing_files['ad_image_4']);
        $ad_image_5 = processFile('ad_image_5', 0, $existing_files['ad_image_5']);
        $ad_image_6 = processFile('ad_image_6', 0, $existing_files['ad_image_6']);
        $ad_image_7 = processFile('ad_image_7', 0, $existing_files['ad_image_7']);
        $ad_image_8 = processFile('ad_image_8', 0, $existing_files['ad_image_8']);

        $city_slug = generateSlug($city_name);

        $sql = mysqli_query($conn, "UPDATE  " . TBL . "cities SET city_name='" . $city_name . "', city_slug='" . $city_slug . "',city_logo_1='" . $city_logo_1 . "',city_logo_2='" . $city_logo_2 . "',ad_image_1='" . $ad_image_1 . "',ad_image_2='" . $ad_image_2 . "',ad_image_3='" . $ad_image_3 . "',ad_image_4='" . $ad_image_4 . "',ad_image_5='" . $ad_image_5 . "',ad_image_6='" . $ad_image_6 . "',ad_image_7='" . $ad_image_7 . "',ad_image_8='" . $ad_image_8 . "'
        where city_id='" . $city_id . "'");

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