<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["new_password"];
    $userId = $_SESSION['user_id'];

    $conn = new mysqli("localhost", "root", "", "authorization");

    if ($conn->connect_error) {
        die("Operation failed."); // Bezpieczniejszy komunikat
    }

    // Hashowanie hasła przy użyciu SHA2
    $stmt = $conn->prepare("UPDATE users SET password = SHA2(?, 256) WHERE id = ?");
    $stmt->bind_param("si", $newPassword, $userId);

    if ($stmt->execute()) {
        // Przekierowanie po pomyślnej zmianie hasła
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Operation failed.";
    }

    $stmt->close();
    $conn->close();
}
?>

<form action="change_password.php" method="POST">
    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br><br>
    <input type="submit" value="Change Password">
</form>
