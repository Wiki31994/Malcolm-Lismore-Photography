<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Change this if you use a different MySQL username
$password = ""; // Change this if you use a different MySQL password
$dbname = "mydatabase";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);
$subject = trim($_POST['subject']);

// Validate form data
$errors = [];
if (empty($name)) {
    $errors[] = "Name is required.";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required.";
}
if (empty($message)) {
    $errors[] = "Message is required.";
}
if (empty($subject)) {
    $errors[] = "Subject is required.";
}

if (empty($errors)) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "Thank you for contacting us! Your message has been sent.";
    } else {
        echo "Oops! Something went wrong and we couldn't store your message.";
    }

    // Close the statement
    $stmt->close();
} else {
    // Display errors
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
}

// Close the connection
$conn->close();
?>
