<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $topic = $_POST['topic'];
    $content = $_POST['content'];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "Orbitopedia";
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "INSERT INTO notes (user_id, topic, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $topic, $content);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header('Location: dashboard.php');
    exit();
}
?>

<form method="POST" action="add_note.php">
    <label for="topic">Topic</label>
    <input type="text" name="topic" id="topic" required>

    <label for="content">Content</label>
    <textarea name="content" id="content" required></textarea>

    <input type="submit" value="Add Note">
</form>

