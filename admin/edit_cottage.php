<?php
require_once 'connect.php';
require_once 'validate.php';

if(ISSET($_POST['edit_cottage'])){
    // Initialize variables
    $errors = array();
    
    // Validate and sanitize inputs
    $cottage_id = mysqli_real_escape_string($conn, $_POST['cottage_id']);
    $cottage_type = mysqli_real_escape_string($conn, $_POST['cottage_type']);
    $cottage_price = mysqli_real_escape_string($conn, $_POST['cottage_price']);
    $cottage_availability = mysqli_real_escape_string($conn, $_POST['cottage_availability']);
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    
    // Validate required fields
    if(empty($cottage_type)) {
        $errors[] = "Cottage type is required";
    }
    if(empty($cottage_price) || !is_numeric($cottage_price) || $cottage_price < 0) {
        $errors[] = "Valid cottage price is required";
    }
    if(empty($cottage_availability)) {
        $errors[] = "Cottage availability is required";
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
            $result = $conn->query("SELECT photo FROM cottage WHERE cottage_id = '$cottage_id'");
            if($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_photo = $row['photo'];
            }
        }
        
        // Build the SQL query
        if(!empty($photo_name)) {
            // Update with new photo
            $sql = "UPDATE `cottage` SET 
                    `cottage_type` = '$cottage_type',
                    `cottage_price` = '$cottage_price',
                    `cottage_availability` = '$cottage_availability',
                    `photo` = '$photo_name',
                    `description` = '$description'
                    WHERE `cottage_id` = '$cottage_id'";
        } else {
            // Update without changing the photo
            $sql = "UPDATE `cottage` SET 
                    `cottage_type` = '$cottage_type',
                    `cottage_price` = '$cottage_price',
                    `cottage_availability` = '$cottage_availability',
                    `description` = '$description'
                    WHERE `cottage_id` = '$cottage_id'";
        }
        
        // Execute the query
        if($conn->query($sql)) {
            // Delete old photo if a new one was uploaded and old one exists
            if(!empty($photo_name) && !empty($current_photo) && file_exists("../photos/" . $current_photo)) {
                unlink("../photos/" . $current_photo);
            }
            
            $_SESSION['alert_type'] = 'success';
            $_SESSION['alert_message'] = "Cottage '$cottage_type' updated successfully!";
            $_SESSION['alert_title'] = 'Success!';
        } else {
            $_SESSION['alert_type'] = 'error';
            $_SESSION['alert_message'] = "Error updating cottage: " . mysqli_error($conn);
            $_SESSION['alert_title'] = 'Error!';
            
            // If update failed, delete the uploaded photo
            if(!empty($photo_name) && file_exists("../photos/" . $photo_name)) {
                unlink("../photos/" . $photo_name);
            }
        }
    } else {
        $_SESSION['alert_type'] = 'error';
        $_SESSION['alert_message'] = implode('<br>', $errors);
        $_SESSION['alert_title'] = 'Validation Error!';
        $_SESSION['form_data'] = $_POST;
    }
    
    header("location: cottage.php");
    exit();
} else {
    header("location: cottage.php");
    exit();
}
?>