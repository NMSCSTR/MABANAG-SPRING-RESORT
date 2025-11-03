I want my code execute it depends on user selection
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_method" class="form-label">Payment Method *</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                                <option value="gcashreceipt">Manual GCash Upload</option> 
                                                <option value="xendit">Pay Now (Online Payment)</option>
                                        </select>
                                    </div>


if user select xendit it run this code 
this sample for xendit not yet final  update of reservation status into database happens when it redirect to $success_url,

// Calculate amount (rate × number of days) is universal
<?php
require 'config.php';

// Get POST data safely
$given_names    = $_POST['given_names'];
$surname        = $_POST['surname'];
$email          = $_POST['email'];
$mobile_number  = $_POST['mobile_number'];
$amount         = $_POST['amount']; // from // Calculate amount (rate × number of days)
$description    = $_POST['description'];

$base_url     = "http://localhost/xendit_system";
$success_url  = $base_url . "/success.php";
$failure_url  = $base_url . "/fail.php";

// Prepare the invoice data
$data = [
    'external_id'           => 'invoice_' . uniqid(),
    'payer_email'           => $email,
    'amount'                => intval($amount),
    'description'           => $description,
    'success_redirect_url'  => $success_url,
    'failure_redirect_url'  => $failure_url,
    'customer'              => [
        'given_names'   => $given_names,
        'surname'       => $surname,
        'email'         => $email,
        'mobile_number' => $mobile_number
    ]
];

// Optional: Log data to browser console
echo "<script>console.log(" . json_encode($data) . ");</script>";

// Initialize cURL
$ch = curl_init('https://api.xendit.co/v2/invoices');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $XENDIT_API_KEY . ":");
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Send the request
$response = curl_exec($ch);
curl_close($ch);

// Process the response
$invoice = json_decode($response, true);

if($invoice){
    $url = $invoice['invoice_url'];
    header('location:'.$url);
}else{
    
}

                                                

// if (isset($invoice['id'])) {
//     echo "<h3>Invoice Created Successfully!</h3>";
//     echo "<p>Invoice ID: " . htmlspecialchars($invoice['id']) . "</p>";
//     echo "<p>Invoice URL: <a href='" . htmlspecialchars($invoice['invoice_url']) . "' target='_blank'>" . htmlspecialchars($invoice['invoice_url']) . "</a></p>";
// } else {
//     echo "<h3>Error Creating Invoice</h3>";
//     echo "<p>" . htmlspecialchars($invoice['message'] ?? 'Unknown error') . "</p>";
// }






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname         = $_POST['firstname'];
        $lastname          = $_POST['lastname'];
        $contactno         = $_POST['contactno'];
        $email             = $_POST['email'];
        $address           = $_POST['address'];
        $reservation_type  = $_POST['reservation_type'];
        $room_id           = $_POST['room_id'] ?? null;
        $cottage_id        = $_POST['cottage_id'] ?? null;
        $check_in_date     = $_POST['check_in_date'];
        $check_out_date    = $_POST['check_out_date'];
        $payment_method    = $_POST['payment_method'];
        $payment_reference = $_POST['payment_reference'] ?? '';

        $transaction_ref = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);


        // Handle file upload
        $receipt_file = null;
        if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] == 0) {
            $upload_dir = 'uploads/receipts/';
            if (! file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension     = strtolower(pathinfo($_FILES['receipt_file']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];

            if (in_array($file_extension, $allowed_extensions)) {
                $file_name = 'receipt_' . time() . '_' . uniqid() . '.' . $file_extension;
                $file_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['receipt_file']['tmp_name'], $file_path)) {
                    $receipt_file = $file_path;
                } else {
                    $error_message = "Error uploading receipt file.";
                }
            } else {
                $error_message = "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
            }
        }

        // Calculate amount (rate × number of days)
        $total_amount = 0;
        if ($reservation_type == 'room' && $room_id) {
            $room_query = $conn->query("SELECT room_price FROM room WHERE room_id = '$room_id'");
            if ($room_query && $room_query->num_rows > 0) {
                $room_data  = $room_query->fetch_array();
                $daily_rate = floatval($room_data['room_price']);

                // Calculate number of days
                $check_in       = new DateTime($check_in_date);
                $check_out      = new DateTime($check_out_date);
                $number_of_days = $check_out->diff($check_in)->days;

                if ($number_of_days == 0) {
                    $number_of_days = 1;
                }

                $total_amount = $daily_rate * $number_of_days;
            }
        } elseif ($reservation_type == 'cottage' && $cottage_id) {
            $cottage_query = $conn->query("SELECT cottage_price FROM cottage WHERE cottage_id = '$cottage_id'");
            if ($cottage_query && $cottage_query->num_rows > 0) {
                $cottage_data = $cottage_query->fetch_array();
                $daily_rate   = floatval($cottage_data['cottage_price']);

                // Cottage is charged per use (no checkout)
                $total_amount   = $daily_rate;
                $check_out_date = 'NULL';
            }
        }

        if ($reservation_type == 'room' && $room_id) {
            $conflict_query = $conn->query("
                SELECT * FROM reservation
                WHERE room_id = '$room_id'
                AND status = 'confirmed'
                AND (
                        (check_in_date <= '$check_out_date' AND check_out_date >= '$check_in_date')
                    )
            ");
        } elseif ($reservation_type == 'cottage' && $cottage_id) {
            $conflict_query = $conn->query("
                SELECT * FROM reservation
                WHERE cottage_id = '$cottage_id'
                AND status = 'confirmed'
                AND (
                        (check_in_date <= '$check_out_date' AND check_out_date >= '$check_in_date')
                    )
            ");
        }

        if (isset($conflict_query) && $conflict_query->num_rows > 0) {
            $error_message = "Sorry, the selected date is already booked (confirmed) for this " . $reservation_type . ".";
        } else {

                    // Insert guest information
        $guest_query = $conn->query("INSERT INTO guest (firstname, lastname, address, contactno)
                                    VALUES ('$firstname', '$lastname', '$address', '$contactno')");

        if ($guest_query) {
            $guest_id = $conn->insert_id;

            // Insert reservation
            $reservation_query = $conn->query("INSERT INTO reservation (guest_id, transaction_reference, room_id, cottage_id, check_in_date, check_out_date, total_amount)
                                             VALUES ('$guest_id', '$transaction_ref', " . ($room_id ? "'$room_id'" : 'NULL') . ", " . ($cottage_id ? "'$cottage_id'" : 'NULL') . ", '$check_in_date', " . ($check_out_date === 'NULL' ? 'NULL' : "'$check_out_date'") . ", '$total_amount')");

            if ($reservation_query) {
                $reservation_id = $conn->insert_id;

                // Insert payment record for admin review
                $receipt_file_sql      = $receipt_file ? "'$receipt_file'" : 'NULL';
                $payment_reference_sql = ! empty($payment_reference) ? "'$payment_reference'" : 'NULL';
                $payment_query         = $conn->query("INSERT INTO payment (reservation_id, amount, payment_method, payment_reference, receipt_file, payment_status)
                                             VALUES ('$reservation_id', '$total_amount', '$payment_method', $payment_reference_sql, $receipt_file_sql, 'pending')");

                if ($payment_query) {
                    // Redirect to transaction details page
                    header("Location: transaction_details.php?reservation_id=" . $reservation_id . "&transaction_ref=" . $transaction_ref);
                    exit();
                } else {
                    $error_message = "Error creating payment record: " . $conn->error;
                }
            } else {
                $error_message = "Error creating reservation: " . $conn->error;
            }
        } else {
            $error_message = "Error creating guest record: " . $conn->error;
        }

        }
    }