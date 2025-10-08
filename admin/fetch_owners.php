<?php
require_once 'connect.php';

$query = $conn->query("SELECT * FROM owners_info ORDER BY info_id DESC");
$data = [];

while ($row = $query->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
?>
