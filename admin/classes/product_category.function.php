<?php

//Get All Categories
function getAllProductCategories()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'product' ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Categories order by position Id
function getAllProductCategoriesPos()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'product' ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get All Active Categories order by position Id
function getAllActiveProductCategoriesPos()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE category_filter = 0 AND type = 'product' ORDER BY category_filter_pos_id ASC";
    $rs = mysqli_query($conn, $sql);
    return $rs;

}

//Get particular Category using category id
function getProductCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getNameProductCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_name='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category using category name
function getSlugProductCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM  " . TBL . "categories where category_slug='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row;

}

//Get particular Category Name using category id
function getProductCategoryName($arg)
{
    global $conn;

    $sql = "SELECT category_name FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];

}

//Get particular Category Name using category id
function getProductCategorySlug($arg)
{
    global $conn;

    $sql = "SELECT category_slug FROM  " . TBL . "categories where category_id='".$arg."' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($rs);
    return $row[0];

}

//Get All Category Count
function getCountProductCategory()
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE type = 'product' ORDER BY category_id DESC";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}

//Sub Category Count using Category Id
function getCountCategoryProductCategory($arg)
{
    global $conn;

    $sql = "SELECT * FROM " . TBL . "categories WHERE category_id = '$arg' AND type = 'product'";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($rs);
    return $row;

}