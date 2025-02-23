<?php

//Get All Sub Categories
function getAllExpertSubCategories()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE type = 'expert' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Sub Category with given Category Id
function getCategoryExpertSubCategories($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories where category_id='".$arg."' AND type = 'expert' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get particular Category using category id
function getExpertSubCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "sub_categories where sub_category_id='".$arg."' AND type = 'expert'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Sub Category Count using Category Id
function getCountExpertSubCategoryCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE category_id = '$arg' AND type = 'expert'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}