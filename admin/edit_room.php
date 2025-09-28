<?php
require_once 'connect.php';
require_once 'validate.php';

if(ISSET($_POST['edit_room'])){
    // Initialize variables
    $errors = array();
    
    // Validate and sanitize inputs
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $room_number = mysqli_real_escape_string($conn, $_POST['room_number']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $room_price = mysqli_real_escape_string($conn, $_POST['room_price']);
    $room_availability = mysqli_real_escape_string($conn, $_POST['room_availability']);
    
    // Validate required fields
    if(empty($room_number)) {
        $errors[] = "Room number is required";
    }
    if(empty($room_type)) {
        $errors[] = "Room type is required";
    }
    if(empty($room_price) || !is_numeric($room_price) || $room_price < 0) {
        $errors[] = "Valid room price is required";
    }
    if(empty($room_availability)) {
        $errors[] = "Room availability is required";
    }
    
    // Handle photo upload if provided
    $photo_name = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $photo = $_FILES['photo'];
        
        // Check if file was uploaded without errors
        if($photo['error'] === UPLOAD_ERR_OK) {
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'webp');
            $file_extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
            $max_size = 2 * 1024 * 1024; // 2MB
            
            // Validate file type
            if(!in_array($file_extension, $allowed_types)) {
                $errors[] = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed";
            }
            
            // Validate file size
            if($photo['size'] > $max_size) {
                $errors[] = "File size must be less than 2MB";
            }
            
            // Validate image dimensions
            $image_info = getimagesize($photo['tmp_name']);
            if(!$image_info) {
                $errors[] = "Uploaded file is not a valid image";
            }
            
            // If no errors, process the upload
            if(empty($errors)) {
                // Keep original filename but sanitize it
                $original_name = $photo['name'];
                $sanitized_name = preg_replace("/[^a-zA-Z0-9._-]/", "_", $original_name);
                
                // Add timestamp prefix to avoid conflicts
                $photo_name = time() . '_' . $sanitized_name;
                $upload_path = "../photos/" . $photo_name;
                
                // Create directory if it doesn't exist
                if(!is_dir("../photos")) {
                    mkdir("../photos", 0755, true);
                }
                
                // Check if file already exists and generate unique name if needed
                $counter = 1;
                $base_name = pathinfo($sanitized_name, PATHINFO_FILENAME);
                $extension = pathinfo($sanitized_name, PATHINFO_EXTENSION);
                
                while(file_exists($upload_path)) {
                    $photo_name = time() . '_' . $base_name . '_' . $counter . '.' . $extension;
                    $upload_path = "../photos/" . $photo_name;
                    $counter++;
                }
                
                // Move uploaded file
                if(!move_uploaded_file($photo['tmp_name'], $upload_path)) {
                    $errors[] = "Failed to upload photo";
                }
            }
        } else {
            // Handle specific upload errors
            $upload_errors = array(
                1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk',
                8 => 'A PHP extension stopped the file upload'
            );
            $error_message = isset($upload_errors[$photo['error']]) ? $upload_errors[$photo['error']] : 'Unknown upload error';
            $errors[] = "File upload error: " . $error_message;
        }
    }
    
    // If no errors, update the database
    if(empty($errors)) {
        // First, get the current photo name to delete it if we're uploading a new one
        $current_photo = '';
        if(!empty($photo_name)) {
            $result = $conn->query("SELECT photo FROM room WHERE room_id = '$room_id'");
            if($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_photo = $row['photo'];
            }
        }
        
        // Build the SQL query
        if(!empty($photo_name)) {
            // Update with new photo
            $sql = "UPDATE `room` SET 
                    `room_number` = '$room_number',
                    `room_type` = '$room_type',
                    `room_price` = '$room_price',
                    `room_availability` = '$room_availability',
                    `photo` = '$photo_name' 
                    WHERE `room_id` = '$room_id'";
        } else {
            // Update without changing the photo
            $sql = "UPDATE `room` SET 
                    `room_number` = '$room_number',
                    `room_type` = '$room_type',
                    `room_price` = '$room_price',
                    `room_availability` = '$room_availability'
                    WHERE `room_id` = '$room_id'";
        }
        
        // Execute the query
        if($conn->query($sql)) {
            // Delete old photo if a new one was uploaded and old one exists
            if(!empty($photo_name) && !empty($current_photo) && file_exists("../photos/" . $current_photo)) {
                unlink("../photos/" . $current_photo);
            }
            
            $_SESSION['success'] = "Room updated successfully";
        } else {
            $_SESSION['error'] = "Error updating room: " . mysqli_error($conn);
            
            // If update failed, delete the uploaded photo
            if(!empty($photo_name) && file_exists("../photos/" . $photo_name)) {
                unlink("../photos/" . $photo_name);
            }
        }
    } else {
        // Store errors in session to display on redirect
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST; // Preserve form data
    }
    
    // Redirect back to room management page
    header("location: room.php");
    exit();
} else {
    // If form wasn't submitted properly, redirect
    header("location: room.php");
    exit();
}
?>