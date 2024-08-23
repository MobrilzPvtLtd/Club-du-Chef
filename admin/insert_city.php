<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

include "config/info.php";
if (isset($_POST['city_submit'])) {

    if ($_POST['city_name'] != NULL) {
        $cnt = count($_POST['city_name']);
    }
    $country_id = $_POST['country_id'];

    // *********** if Count of city name is zero means redirect starts ********

    if ($cnt == 0) {
        header('Location: admin-add-city.php');
        exit;
    }

    // *********** if Count of city name is zero means redirect ends ********

    for ($i = 0; $i < $cnt; $i++) {

        $city_name = $_POST['city_name'][$i];

        $state_sql = "SELECT * FROM  " . TBL . "states where country_id='" . $country_id . "'";
        $state_rs = mysqli_query($conn, $state_sql);
        while ($state_row = mysqli_fetch_array($state_rs)) {

            //************ city Name Already Exist Check Starts ***************


            $city_name_exist_check = mysqli_query($conn, "SELECT * FROM " . TBL . "cities  WHERE city_name='" . $city_name . "' AND state_id='" . $state_row['state_id'] . "' ");

            if (mysqli_num_rows($city_name_exist_check) > 0) {


                $_SESSION['status_msg'] = "The Given City name $city_name is Already Exist Try Other!!!";

                header('Location: admin-add-city.php');
                exit;


            }
        }

        //************ city Name Already Exist Check Ends ***************
        

        $allowed_types = array(
            "image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp",
            "image/svg+xml", "application/pdf", "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.template"
        );
        
        function processFile($fileInputName, $index) {
            global $allowed_types;
        
            if (isset($_FILES[$fileInputName])) {
                $file_name_key = $_FILES[$fileInputName]['name'][$index];
                if (!empty($file_name_key)) {
                    $file_name = rand(1000, 100000) . '-' . basename($file_name_key);
                    $file_loc = $_FILES[$fileInputName]['tmp_name'][$index];
                    $file_size = $_FILES[$fileInputName]['size'][$index];
                    $file_type = $_FILES[$fileInputName]['type'][$index];
        
                    if (in_array($file_type, $allowed_types)) {
                        $folder = "../images/cityimage/";
                        $new_size = $file_size / 1024; // size in KB
                        $new_file_name = strtolower($file_name);
                        $event_image = str_replace(' ', '-', $new_file_name);
                        
                        if (!is_dir($folder)) {
                            mkdir($folder, 0777, true);
                        }
        
                        return compressImage($event_image, $file_loc, $folder, $new_size);
                    } else {
                        return '';
                    }
                }
            }
            return '';
        }

       
        
        $i = isset($i) ? intval($i) : 0;
        
        $city_logo_1 = processFile('city_logo_1', $i);
        $city_logo_2 = processFile('city_logo_2', $i);
        $ad_images = [];
        for ($j = 1; $j <= 8; $j++) {
            $ad_images[] = processFile('ad_image_' . $j, $i);
        }        

        echo "<pre>";
        print_r($ad_images);

         die();

        $state_sql_1 = "SELECT * FROM  " . TBL . "states where country_id='" . $country_id . "' LIMIT 1";
        $state_rs_1 = mysqli_query($conn, $state_sql_1);
        $state_roww = mysqli_fetch_array($state_rs_1);

        $state_id = $state_roww['state_id'];

        $city_slug = generateSlug($city_name);

        $sql = mysqli_query($conn, "INSERT INTO  " . TBL . "cities (city_name,city_slug,state_id,city_cdt,city_logo_1,city_logo_2,ad_image_1,ad_image_2,ad_image_3,ad_image_4,ad_image_5,ad_image_6,ad_image_7,ad_image_8)
        VALUES ('$city_name','$city_slug','$state_id','$curDate','$city_logo_1','$city_logo_2','$ad_images[0]','$ad_images[1]','$ad_images[2]','$ad_images[3]','$ad_images[4]','$ad_images[5]','$ad_images[6]','$ad_images[7]')");
    }


    if ($sql) {

        $_SESSION['status_msg'] = "City(s) has been Added Successfully!!!";
        header('Location: admin-all-city.php');
        exit;

    } else {


        $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

        //  header('Location: admin-add-city.php');
        exit;
    }

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