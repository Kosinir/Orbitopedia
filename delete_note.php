<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$noteId = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "Orbitopedia");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $noteId, $_SESSION['user_id']);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Operation failed.";
}

$stmt->close();
$conn->close();
?>
