<?php
include 'admin/connect.php'; // make sure this creates $conn as a mysqli connection

$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$type = $_POST['type'] ?? 'all';

// Base SQL query
$sql = "SELECT * FROM room r
        WHERE r.room_availability = 'available'
        AND r.room_id NOT IN (
            SELECT room_id FROM reservation
            WHERE status != 'cancelled'
            AND (
                (check_in_date <= ? AND check_out_date >= ?) OR
                (check_in_date < ? AND check_out_date >= ?) OR
                (check_in_date >= ? AND check_in_date <= ?)
            )
        )";

// Add type filter if needed
if ($type !== 'all') {
    $sql .= " AND r.room_type = ?";
}

$stmt = $conn->prepare($sql);

if ($type !== 'all') {
    $stmt->bind_param(
        "sssssss",
        $check_out, $check_in,
        $check_in, $check_in,
        $check_in, $check_out,
        $type
    );
} else {
    $stmt->bind_param(
        "ssssss",
        $check_out, $check_in,
        $check_in, $check_in,
        $check_in, $check_out
    );
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($room = $result->fetch_assoc()) {
        echo '
        <div class="card mb-3 shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="uploads/'.$room['photo'].'" class="img-fluid rounded-start" alt="'.$room['room_type'].'">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">'.$room['room_type'].' Room</h5>
                        <p class="card-text text-muted">'.$room['room_description'].'</p>
                        <p class="fw-bold mb-1">₱'.$room['room_price'].' / night</p>
                        <a href="room_details.php?id='.$room['room_id'].'" class="btn btn-outline-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<p class="text-muted">No rooms available for the selected dates.</p>';
}

$stmt->close();
$conn->close();
?>
