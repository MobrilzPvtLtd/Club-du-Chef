<?php

//database configuration
if (file_exists('config/info.php')) {
    include('config/info.php');
}

if(isset($_POST['type'])){
    $type = $_POST['type'];
    foreach (getAllCategories() as $categories_row) {
        if ($categories_row['type'] == $type) {
            if ($categories_row['type'] == $type) {
                echo "<option value='{$categories_row['category_id']}'>{$categories_row['category_name']}</option>";
            }
        }
    }
    
}else{
    $category_id = $_POST['category_id'];
    //get matched data from Sub - category table
    
    if(getCountSubCategoryCategory($category_id) <= 0){
        ?>
        <option value=""><?php echo $Zitiziti['NO_SUB_CATEGORY_FOUND_MESSAGE']; ?></option>
        <?php
    }else {
    
    foreach (getCategorySubCategories($category_id) as $sub_categories_row) {
    
        ?>
    
            <option <?php if ($_SESSION['sub_category_id'] == $sub_categories_row['sub_category_id']) {
                echo "selected";
            } ?>
                value="<?php echo $sub_categories_row['sub_category_id']; ?>"><?php echo $sub_categories_row['sub_category_name']; ?></option>
    
            <?php
        }
    
    }
}

?>
