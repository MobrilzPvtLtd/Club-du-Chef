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


        $_FILES['city_logo_1']['name'];

        if (!empty($_FILES['city_logo_1']['name'])) {
            $file = rand(1000, 100000) . $_FILES['city_logo_1']['name'];
            $file_loc = $_FILES['city_logo_1']['tmp_name'];
            $file_size = $_FILES['city_logo_1']['size'];
            $file_type = $_FILES['city_logo_1']['type'];
            $allowed = array("image/jpeg", "image/pjpeg", "image/png", "image/gif", "image/webp", "image/svg", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
            if (in_array($file_type, $allowed)) {
                $folder = "../images/cityimage/";
                $new_size = $file_size / 1024;
                $new_file_name = strtolower($file);
                $event_image = str_replace(' ', '-', $new_file_name);
                //move_uploaded_file($file_loc, $folder . $event_image);
                $city_logo_1 = compressImage($event_image, $file_loc, $folder, $new_size);
            } else {
                $city_logo_1 = $city_image_old;
            }
        } else {
            $city_logo_1 = $city_image_old;
        }

        $city_slug = generateSlug($city_name);


        $sql = mysqli_query($conn, "UPDATE  " . TBL . "cities SET city_name='" . $city_name . "', city_slug='" . $city_slug . "'
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