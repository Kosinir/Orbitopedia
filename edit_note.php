<!doctype html>
<html lang = en>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <meta name="author" content="Szymon Warguła">
    <link rel="icon" href="https://cosmos.network/presskit/cosmos-brandmark-dynamic-dark.svg" type="image/x-icon">
    
    <title>Sign in</title>

    <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.html");
            exit();
        }

        $noteId = $_GET['id'];
        $conn = new mysqli("localhost", "root", "", "authorization");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT topic, content FROM notes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $noteId, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($topic, $content);

        if ($stmt->num_rows === 1) {
            $stmt->fetch();
        } else {
            echo "Note not found.";
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newTopic = $_POST["topic"];
            $newContent = $_POST["content"];

            $stmt = $conn->prepare("UPDATE notes SET topic = ?, content = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("ssi", $newTopic, $newContent, $noteId);

            if ($stmt->execute()) {
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Operation failed.";
            }
        }
    ?>

</head>
<body>
    <div class="wrapper">
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
        <div class="round"></div>
    </div>
    <div id ="edit-section">
        <form action="edit_note.php?id=<?php echo $noteId; ?>" method="POST">
            <div class="edit-section-submit">
                <input type="submit" class="edit-submit" value="Update Note">
            </div>
            
            <div class="edit-section-form">
            <label>Topic:</label><br>
            <input type="text" name="topic" class="edit-note" value="<?php echo $topic; ?>" required><br><br>
            
            <label>Content:</label><br>
            <textarea rows="6" cols="50" name="content"  required><?php echo $content; ?></textarea><br><br>
            </div>
            
        </form>
    </div>
</body>



