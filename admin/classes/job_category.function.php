<?php

//Get All Categories
function getAllJobCategories()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'job' ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories
function getAllJobCategoriesOrderByJobsTable()
{
    global $conn;

    $sql = "SELECT T1.*, COUNT(T2.category_id) AS views FROM " . TBL . "categories AS T1 LEFT JOIN " . TBL . "jobs AS T2 ON T1.category_id = T2.category_id WHERE type = 'job' GROUP BY T1.category_id ORDER BY views DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories
function getAllJobCategoriesOrderByJobsTableLimit($arg)
{
    $CurrentCity = isset($_SESSION['city']) ? $_SESSION['city'] : 'www';

    global $conn;

    $sql = "SELECT T1.*, COUNT(T2.category_id) AS views FROM " . TBL . "categories AS T1 LEFT JOIN " . TBL . "jobs AS T2 ON T1.category_id = T2.category_id AND (JSON_CONTAINS(T1.city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www') WHERE type = 'job' GROUP BY T1.category_id ORDER BY views DESC LIMIT $arg";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories Limit
function getAllJobCategoriesLimit($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'job' ORDER BY category_id DESC LIMIT $arg";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories order by position Id
function getAllJobCategoriesPos()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'job' ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Active Categories order by position Id
function getAllActiveJobCategoriesPos()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE category_filter = 0 AND type = 'job' ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get particular Category using category id
function getJobCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getNameJobCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_name='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getSlugJobCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_slug='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category Name using category id
function getJobCategoryName($arg)
{
    global $conn;

    $sql = "SELECT category_name FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];

}

//Get particular Category Name using category id
function getJobCategorySlug($arg)
{
    global $conn;

    $sql = "SELECT category_slug FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];

}

//Get All Category Count
function getCountJobCategory()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'job' ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}

//Sub Category Count using Category Id
function getCountCategoryJobCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE category_id = '$arg' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}