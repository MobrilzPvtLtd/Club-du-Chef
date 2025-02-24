<?php

//Get All Categories For Listing
function getAllCategoriesListing()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'listing' ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}
//Get All Categories
function getAllCategories()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories order by position Id for listing section
function getAllCategoriesPosListing()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'listing' ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories order by position Id for category section
function getAllCategoriesPos()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Active Categories order by position Id
function getAllActiveCategoriesPos()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE category_filter = 0 AND type = 'listing' ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get particular Category using category id for sabcategory
function getCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_id='".$arg."'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getNameCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_name='".$arg."' AND type = 'listing'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getSlugCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_slug='".$arg."' AND type = 'listing'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category Name using category id
function getCategoryName($arg)
{
    global $conn;

    $sql = "SELECT category_name FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'listing'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];

}

//Get particular Category Name using category id
function getCategorySlug($arg)
{
    global $conn;

    $sql = "SELECT category_slug FROM  " . TBL . "categories where category_id='".$arg."' type = 'listing'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];

}

//Get All Category Count
function getCountCategory()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'listing' ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}
//Get All Category Count
function getSubCountCategory()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE type = 'listing' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}

//Get All Experts with given Category Id and Expert Id
function getAllCategoriesLimit($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories where category_id != '".$arg."' AND type = 'listing' ORDER BY category_id DESC LIMIT 3";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Category Count
function getCountCategoryCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories where category_id='".$arg."' AND type = 'listing'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}

//Get particular Category SEO Score using category id
function getCategorySeoScore($arg)
{
    global $conn;

    $sql = "select ( case category_seo_title when '' then 0 else 1 end +
        case category_seo_description when '' then 0 else 1 end +
        case category_seo_keywords when '' then 0 else 1 end +
        case category_faq_1_ques when '' then 0 else 1 end +
        case category_faq_1_ans when '' then 0 else 1 end +
        case category_faq_2_ques when '' then 0 else 1 end +
        case category_faq_2_ans when '' then 0 else 1 end +
        case category_faq_3_ques when '' then 0 else 1 end +
        case category_faq_3_ans when '' then 0 else 1 end +
        case category_faq_4_ques when '' then 0 else 1 end +
        case category_faq_4_ans when '' then 0 else 1 end +
        case category_faq_5_ques when '' then 0 else 1 end +
        case category_faq_5_ans when '' then 0 else 1 end +
        case category_faq_6_ques when '' then 0 else 1 end +
        case category_faq_6_ans when '' then 0 else 1 end +
        case category_faq_7_ques when '' then 0 else 1 end +
        case category_faq_7_ans when '' then 0 else 1 end +
        case category_faq_8_ques when '' then 0 else 1 end +
        case category_faq_8_ans when '' then 0 else 1 end +
        case category_google_schema when '' then 0 else 1 end ) 
        * 100 / 20 as complete FROM " . TBL . "categories WHERE category_id = $arg AND type = 'listing'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];
}
