<?php
//database configuration
if (file_exists('config/info.php')) {
    include('config/info.php');
}

if (isset($_GET['q'])) {
    $query = $conn->real_escape_string($_GET['q']);
    
    $CurrentCity = isset($_SESSION['city']) ? $_SESSION['city'] : 'www';
    
    $results = [
        'listings' => [],
        'products' => [],
        'categories' => [],
        'events' => [],
        'blogs' => [],
        'jobs' => []
    ];

    // Query listings
    $sql = "SELECT listing_name FROM " . TBL . "listings WHERE listing_name LIKE '%$query%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www') AND listing_is_delete != '2' ";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results['listings'][] = $row['listing_name'];
        }
    }

    // Query products
    $sql1 = "SELECT product_name FROM " . TBL . "products WHERE product_name LIKE '%$query%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $results['products'][] = $row['product_name'];
        }
    }

    // Query categories
    $sql2 = "SELECT category_name FROM " . TBL . "categories WHERE category_name LIKE '%$query%'";
    $result2 = $conn->query($sql2);
    if ($result2 && $result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $results['categories'][] = $row['category_name'];
        }
    }

    // Query events
    $sql3 = "SELECT event_name FROM " . TBL . "events WHERE event_name LIKE '%$query%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $result3 = $conn->query($sql3);
    if ($result3 && $result3->num_rows > 0) {
        while ($row = $result3->fetch_assoc()) {
            $results['events'][] = $row['event_name'];
        }
    }

    // Query blogs
    $sql4 = "SELECT blog_name FROM " . TBL . "blogs WHERE blog_name LIKE '%$query%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $result4 = $conn->query($sql4);
    if ($result4 && $result4->num_rows > 0) {
        while ($row = $result4->fetch_assoc()) {
            $results['blogs'][] = $row['blog_name'];
        }
    }

    // Query jobs
    $sql5 = "SELECT job_title FROM " . TBL . "jobs WHERE job_title LIKE '%$query%' AND (JSON_CONTAINS(city_slug, '\"$CurrentCity\"') OR '$CurrentCity' = 'www')";
    $result5 = $conn->query($sql5);
    if ($result5 && $result5->num_rows > 0) {
        while ($row = $result5->fetch_assoc()) {
            $results['jobs'][] = $row['job_title'];
        }
    }

    // Return the results as JSON
    echo json_encode($results);
}

?>
