<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["f_email"];
    $password = $_POST["f_password"];

    // Database Connection
    $conn = new mysqli("localhost", "root", "", "authorization");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate login authentication using prepared statements
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND password = SHA2(?, 256)");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId);
        $stmt->fetch();

        // Set user ID in session
        $_SESSION['user_id'] = $userId;
        header("Location: dashboard.php");
        exit();
    } else {
        echo '<script type="text/javascript">
        alert("Invalid email or password");
        window.history.back();
      </script>';
    }

    $stmt->close();
    $conn->close();
}
?>
