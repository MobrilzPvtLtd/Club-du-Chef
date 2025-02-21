<?php
include "header.php";

include "dashboard_left_pane.php";

unset($_SESSION['user_code']);
unset($_SESSION['user_name']);
unset($_SESSION['user_id']);

if((!isset($_SESSION['user_code']) || empty($_SESSION['user_code'])) && (!isset($_SESSION['user_name']) ||  empty($_SESSION['user_name']) && (!isset($_SESSION['user_id']) ||  empty($_SESSION['user_id']))) )
{
    header("Location: ".$webpage_full_link);
    exit();
}

?>