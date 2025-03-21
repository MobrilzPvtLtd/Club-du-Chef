<?php

//Get All Sub Categories
function getAllJobSubCategories()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE type = 'job' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Sub Category with given Category Id
function getCategoryJobSubCategories($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories where category_id='".$arg."' AND type = 'job' ORDER BY sub_category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get particular Category using category id
function getJobSubCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "sub_categories where sub_category_id='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Sub Category Count using Category Id
function getCountJobSubCategoryCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "sub_categories WHERE category_id = '$arg' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}

//Get particular Sub Category using Sub category slug
function getSlugJobSubCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "sub_categories where sub_category_slug='".$arg."' AND type = 'job'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}