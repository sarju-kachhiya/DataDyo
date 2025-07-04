<?php
// --- Database Configuration ---
$host = "localhost";
$dbname = '#';
$username = '#';
$password = '#';

// --- Connect to DB ---
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// --- Handle Form Submission ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize Inputs
    $name    = $conn->real_escape_string($_POST['name'] ?? '');
    $email   = $conn->real_escape_string($_POST['email'] ?? '');
    $phone   = $conn->real_escape_string($_POST['Phone'] ?? ''); // used as Subject
    $message = $conn->real_escape_string($_POST['message'] ?? '');

    // Prepare SQL Insert
    $sql = "INSERT INTO contact_requests (name, email, phone_subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($stmt->execute()) {
        echo "✔️ Your message has been submitted successfully!";
    } else {
        echo "❌ Failed to submit message. Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
