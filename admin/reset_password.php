<?php
require_once 'connect.php';

header('Content-Type: application/json');

if (isset($_POST['reset_password'])) {

    $admin_id = $_POST['admin_id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_new_password'];

    // Basic validation
    if (empty($admin_id) || empty($new_password) || empty($confirm_password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        exit;
    }

    if (strlen($new_password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long.']);
        exit;
    }

    // ⚙️ For demo (plain text password)
    // For real security use: $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $hashed_password = $new_password;

    $query = "UPDATE admin SET password = '$hashed_password' WHERE admin_id = '$admin_id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Password reset successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
