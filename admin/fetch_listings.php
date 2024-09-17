<?php
/**
 * Created by Vignesh.
 * User: Vignesh
 */

if (file_exists('config/info.php')) {
    include('config/info.php');
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_POST['user_id'];
    $all_ads_enquiry_id = $_POST['all_ads_enquiry_id'];

    $response = [];

    // Get all_ads_enquiry details
    $sql = "SELECT * FROM " . TBL . "all_ads_enquiry WHERE all_ads_enquiry_id = ?";
    if ($stmt1 = $conn->prepare($sql)) {
        $stmt1->bind_param('i', $all_ads_enquiry_id);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $all_ads_enquiry_row = $result1->fetch_assoc();
        
        $response['ads_enquiry'] = $all_ads_enquiry_row;

        $stmt1->close();
    } else {
        $response['error'] = 'Database error: Unable to prepare first statement.';
        echo json_encode($response);
        $conn->close();
        exit();
    }

    // Get listings for the user
    if ($stmt2 = $conn->prepare("SELECT * FROM " . TBL . "listings WHERE user_id = ? AND listing_is_delete != '2' ORDER BY listing_id DESC")) {
        $stmt2->bind_param('i', $user_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        
        $listings = [];
        while ($row = $result2->fetch_assoc()) {
            $listings[] = $row;
        }

        if (!empty($listings)) {
            $listing_ids = array_column($listings, 'listing_id');

            // Prepare and execute the second query
            $placeholders = implode(',', array_fill(0, count($listing_ids), '?'));
            $sql = "SELECT listing_id FROM " . TBL . "all_ads_enquiry WHERE listing_id IN ($placeholders)";
            
            if ($stmt3 = $conn->prepare($sql)) {
                $stmt3->bind_param(str_repeat('i', count($listing_ids)), ...$listing_ids);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                
                $enquiry_listing_ids = [];
                while ($row = $result3->fetch_assoc()) {
                    $enquiry_listing_ids[] = $row['listing_id'];
                }

                $filtered_listings = array_filter($listings, function($listing) use ($enquiry_listing_ids, $all_ads_enquiry_row) {
                    return !in_array($listing['listing_id'], $enquiry_listing_ids) || ($all_ads_enquiry_row && $listing['listing_id'] == $all_ads_enquiry_row['listing_id']);
                });

                $response['listings'] = $filtered_listings;

                $stmt3->close();
            } else {
                $response['error'] = 'Database error: Unable to prepare second statement.';
                echo json_encode($response);
                $conn->close();
                exit();
            }
        } else {
            $response['listings'] = [];
        }

        $stmt2->close();
    } else {
        $response['error'] = 'Database error: Unable to prepare third statement.';
    }

    echo json_encode($response);
    
    $conn->close();
}
?>