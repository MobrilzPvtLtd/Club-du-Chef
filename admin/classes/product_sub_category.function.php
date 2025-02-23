<?php

//Get All Sub Categories
function getAllProductSubCategories()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE type = 'product' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Sub Category with given Category Id
function getCategoryProductSubCategories($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories where category_id='".$arg."' AND type = 'product' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get particular Category using category id
function getProductSubCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "sub_categories where sub_category_id='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getSlugProductSubCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "sub_categories where sub_category_slug='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Sub Category Count using Category Id
function getCountProductSubCategoryCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE category_id = '$arg' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}