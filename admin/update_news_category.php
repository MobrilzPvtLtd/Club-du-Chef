<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

if (file_exists('config/info.php')) {
    include('config/info.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['news_category_submit'])) {

        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];
        $category_seo_title = $_POST['category_seo_title'];
        $category_seo_description = $_POST['category_seo_description'];
        $category_seo_keywords = $_POST['category_seo_keywords'];
        $category_status = "Active";

        $city_slug = $_POST['city_slug'];
        if (is_array($city_slug)) {
            $city_slug = array_map(function($city) use ($conn) {
                return mysqli_real_escape_string($conn, $city);
            }, $city_slug);
            $city_slug_json = json_encode($city_slug);
        } else {
            $city_slug_json = json_encode([]);
        }

        //************ Category Name Already Exist Check Starts ***************


        $category_name_exist_check = mysqli_query($conn, "SELECT * FROM " . TBL . "news_categories  WHERE category_name='" . $category_name . "' AND category_id != $category_id ");

        if (mysqli_num_rows($category_name_exist_check) > 0) {


            $_SESSION['status_msg'] = "The Given Category name is Already Exist Try Other!!!";

            header('Location: news-category-edit.php?row=' . $category_id);
            exit;


        }

//************ Category Name Already Exist Check Ends ***************


        function checkNewsCategorySlug($link, $category_id, $counter = 1)
        {
            global $conn;
            $newLink = $link;
            do {
                $checkLink = mysqli_query($conn, "SELECT category_id FROM " . TBL . "news_categories WHERE category_slug = '$newLink' AND category_id != '$category_id'");
                if (mysqli_num_rows($checkLink) > 0) {
                    $newLink = $link . '' . $counter;
                    $counter++;
                } else {
                    break;
                }
            } while (1);

            return $newLink;
        }


        $category_name1 = trim(preg_replace('/[^A-Za-z0-9]/', ' ', $category_name));
        $category_slug = checkNewsCategorySlug($category_name1, $category_id);


        $sql = mysqli_query($conn, "UPDATE  " . TBL . "news_categories SET 
        category_name='" . $category_name . "', 
        city_slug='" . $city_slug_json . "', 
        category_status='" . $category_status . "',
        category_slug='" . $category_slug . "', 
        category_seo_title='" . $category_seo_title . "', 
        category_seo_description='" . $category_seo_description . "', 
        category_seo_keywords='" . $category_seo_keywords . "'
        where category_id='" . $category_id . "'");

        if ($sql) {

            $_SESSION['status_msg'] = "News category has been Updated Successfully!!!";


            header('Location: news-all-category.php');
            exit;

        } else {

            $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

            header('Location: news-category-edit.php?row=' . $category_id);
            exit;
        }

    }
} else {

    $_SESSION['status_msg'] = "Oops!! Something Went Wrong Try Later!!!";

    header('Location: news-all-category.php');
    exit;
}
?>