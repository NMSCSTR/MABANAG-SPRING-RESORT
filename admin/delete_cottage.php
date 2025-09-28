<?php
require_once 'connect.php';
require_once 'validate.php';

if(ISSET($_POST['cottage_id'])){
    $cottage_id = mysqli_real_escape_string($conn, $_POST['cottage_id']);
    
    // Get cottage info before deleting
    $cottage_info = $conn->query("SELECT cottage_type, photo FROM cottage WHERE cottage_id = '$cottage_id'");
    
    if($cottage_info && $cottage_info->num_rows > 0) {
        $cottage = $cottage_info->fetch_assoc();
        $cottage_type = $cottage['cottage_type'];
        $photo_name = $cottage['photo'];
        
        // Check if cottage has any active reservations
        $reservation_check = $conn->query("SELECT * FROM reservation WHERE cottage_id = '$cottage_id' AND status != 'cancelled'");
        
        if($reservation_check->num_rows > 0) {
            $_SESSION['alert_type'] = 'error';
            $_SESSION['alert_message'] = "Cannot delete cottage '$cottage_type' because it has active reservations!";
            $_SESSION['alert_title'] = 'Cannot Delete!';
        } else {
            // Delete the cottage
            if($conn->query("DELETE FROM cottage WHERE cottage_id = '$cottage_id'")) {
                // Delete the photo file if it exists
                if(!empty($photo_name) && file_exists("../photos/" . $photo_name)) {
                    unlink("../photos/" . $photo_name);
                }
                
                $_SESSION['alert_type'] = 'success';
                $_SESSION['alert_message'] = "Cottage '$cottage_type' has been deleted successfully!";
                $_SESSION['alert_title'] = 'Deleted!';
            } else {
                $_SESSION['alert_type'] = 'error';
                $_SESSION['alert_message'] = "Error deleting cottage: " . mysqli_error($conn);
                $_SESSION['alert_title'] = 'Error!';
            }
        }
    } else {
        $_SESSION['alert_type'] = 'error';
        $_SESSION['alert_message'] = "Cottage not found!";
        $_SESSION['alert_title'] = 'Error!';
    }
} else {
    $_SESSION['alert_type'] = 'error';
    $_SESSION['alert_message'] = "Invalid request!";
    $_SESSION['alert_title'] = 'Error!';
}

header("location: cottage.php");
exit();
?>