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
    
    if ($stmt = $conn->prepare("SELECT * FROM " . TBL . "listings WHERE user_id = ? AND listing_is_delete != '2' ORDER BY listing_id DESC")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $listings = [];
        while ($row = $result->fetch_assoc()) {
            $listings[] = $row;
        }

        if (!empty($listings)) {
            $listing_ids = array_column($listings, 'listing_id');

            // Prepare and execute the second query
            $placeholders = implode(',', array_fill(0, count($listing_ids), '?'));
            $sql = "SELECT listing_id FROM " . TBL . "all_ads_enquiry WHERE listing_id IN ($placeholders)";
            
            if ($stmt2 = $conn->prepare($sql)) {
                $stmt2->bind_param(str_repeat('i', count($listing_ids)), ...$listing_ids);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                
                $enquiry_listing_ids = [];
                while ($row = $result2->fetch_assoc()) {
                    $enquiry_listing_ids[] = $row['listing_id'];
                }

                // Filter listings based on enquiry listing IDs
                $filtered_listings = array_filter($listings, function($listing) use ($enquiry_listing_ids) {
                    return !in_array($listing['listing_id'], $enquiry_listing_ids);
                });

                echo json_encode($filtered_listings);

                $stmt2->close();
            } else {
                echo json_encode(['error' => 'Database error: Unable to prepare second statement.']);
            }
        } else {
            echo json_encode([]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database error: Unable to prepare statement.']);
    }
    $conn->close();
}
?>