<?php
// --- Database Configuration ---
$host = "localhost";
$dbname = '#';
$username = '#';
$password = '#';

// --- Connect to Database ---
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Check if POST request ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize form inputs
    $first_name  = $conn->real_escape_string($_POST['first_name'] ?? '');
    $last_name   = $conn->real_escape_string($_POST['last_name'] ?? '');
    $company     = $conn->real_escape_string($_POST['company_name'] ?? '');
    $website     = $conn->real_escape_string($_POST['website'] ?? '');
    $phone       = $conn->real_escape_string($_POST['phone'] ?? '');
    $email       = $conn->real_escape_string($_POST['email'] ?? '');
    $networks    = $conn->real_escape_string($_POST['networks'] ?? '');
    $verticals   = $conn->real_escape_string($_POST['verticals'] ?? '');
    $niche       = $conn->real_escape_string($_POST['niche'] ?? '');
    $service     = $conn->real_escape_string($_POST['service'] ?? '');

    // Insert into DB
    $sql = "INSERT INTO marketer_request (
                first_name, last_name, company_name, website,
                phone, email, networks, verticals, niche, service
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", 
        $first_name, $last_name, $company, $website,
        $phone, $email, $networks, $verticals, $niche, $service
    );

    if ($stmt->execute()) {
        echo "✔️ Your marketer request has been submitted successfully!";
    } else {
        echo "❌ Failed to submit request. Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
