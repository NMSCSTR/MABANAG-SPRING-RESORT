<?php
require_once 'connect.php';
require_once 'validate.php';

header('Content-Type: application/json');


if (!isset($_POST['room_id']) || empty($_POST['room_id'])) {
    echo json_encode(array('status' => 'error', 'message' => 'Room ID is required.'));
    mysqli_close($conn);
    exit;
}


$room_id = (int)$_POST['room_id'];


$check_reservation_sql = "SELECT COUNT(*) AS active_count FROM reservation WHERE room_id = $room_id AND status IN ('pending', 'confirmed')";

$result_check = mysqli_query($conn, $check_reservation_sql);

if ($result_check === false) {
    echo json_encode(array('status' => 'error', 'message' => 'Database error while checking reservations: ' . mysqli_error($conn)));
    mysqli_close($conn);
    exit;
}

$row = mysqli_fetch_assoc($result_check);
$active_reservations = $row['active_count'];

if ($active_reservations > 0) {
    echo json_encode(array('status' => 'error', 'message' => "Cannot delete room. It has $active_reservations active reservations (pending or confirmed)."));
    mysqli_free_result($result_check);
    mysqli_close($conn);
    exit;
}

$get_photo_sql = "SELECT photo FROM room WHERE room_id = $room_id";
$result_photo = mysqli_query($conn, $get_photo_sql);

if ($result_photo === false) {

    echo json_encode(array('status' => 'error', 'message' => 'Database error while retrieving photo name: ' . mysqli_error($conn)));
    mysqli_close($conn);
    exit;
}

$photo_data = mysqli_fetch_assoc($result_photo);
$photo_name = $photo_data ? $photo_data['photo'] : null;


mysqli_free_result($result_photo);



$delete_sql = "DELETE FROM room WHERE room_id = $room_id";

if (mysqli_query($conn, $delete_sql)) {

    if (mysqli_affected_rows($conn) > 0) {
        
        $unlink_status = 'Image was not unlinked or did not exist.';
        $photo_path = "../photos/" . $photo_name;
        

        if (!empty($photo_name) && file_exists($photo_path)) {
            if (unlink($photo_path)) {
                $unlink_status = "Image file '$photo_name' successfully deleted.";
            } else {
                $unlink_status = "Error: Could not delete file '$photo_name' (check permissions).";
            }
        }
        
        
        echo json_encode(array(
            'status' => 'success', 
            'message' => 'Room and associated record successfully deleted.',
            'image_unlink_status' => $unlink_status
        ));

    } else {

        echo json_encode(array('status' => 'error', 'message' => 'Error: Room with ID ' . $room_id . ' not found.'));
    }
} else {

    echo json_encode(array('status' => 'error', 'message' => 'Database error during deletion: ' . mysqli_error($conn)));
}


mysqli_close($conn);

?>