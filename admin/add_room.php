<?php
require_once 'connect.php';
require_once 'validate.php';

if(ISSET($_POST['add_room'])){
    // Initialize variables
    $errors = array();
    
    // Validate and sanitize inputs
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
    
    // Handle photo upload
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
            $errors[] = "File upload error: " . $photo['error'];
        }
    }
    
    // If no errors, insert into database
    if(empty($errors)) {
        $sql = "INSERT INTO `room` (`room_number`, `room_type`, `room_price`, `room_availability`, `photo`) 
                VALUES ('$room_number', '$room_type', '$room_price', '$room_availability', '$photo_name')";
        
        if($conn->query($sql)) {
            $_SESSION['success'] = "Room added successfully";
        } else {
            $_SESSION['error'] = "Error adding room: " . mysqli_error($conn);
            
            // If insert failed, delete the uploaded photo
            if(!empty($photo_name) && file_exists("../photos/" . $photo_name)) {
                unlink("../photos/" . $photo_name);
            }
        }
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
    }
    
    header("location: room.php");
    exit();
}
?>