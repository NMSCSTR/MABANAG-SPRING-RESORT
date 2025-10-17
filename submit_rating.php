<?php
require_once 'admin/connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Initialize variables and collect form data
    $review_text    = trim($_POST['review_text'] ?? '');
    $guest_name     = trim($_POST['guest_name'] ?? '');
    $guest_location = trim($_POST['guest_location'] ?? '');
    $badge_category = trim($_POST['badge_category'] ?? '');
    $rating         = (int) ($_POST['rating'] ?? 0); 

    
    $review_date = date("Y-m-d");

    
    if (empty($review_text) || empty($guest_name) || $rating < 1 || $rating > 5) {

        header("Location: /thank_you.html?status=error&message=Please fill out all required fields and provide a valid rating.");
        exit;
    }


    $safe_review_text    = $conn->real_escape_string($review_text);
    $safe_guest_name     = $conn->real_escape_string($guest_name);
    $safe_guest_location = $conn->real_escape_string($guest_location);
    $safe_badge_category = $conn->real_escape_string($badge_category);
    

    $sql = "INSERT INTO testimonials (review_text, guest_name, guest_location, badge_category, rating, review_date) 
            VALUES (
                '$safe_review_text', 
                '$safe_guest_name', 
                '$safe_guest_location', 
                '$safe_badge_category', 
                $rating, 
                '$review_date'
            )";


    if ($conn->query($sql) === TRUE) {

        header("Location: index.php?status=success");
        exit;
    } else {
     
        error_log("Testimonial Insertion Error: " . $conn->error);
        header("Location: /index.php?status=error&message=A database error occurred. Please try again.");
        exit;
    }


    $conn->close();
} else {

    header("Location: index.php"); 
    exit;
}
?>
