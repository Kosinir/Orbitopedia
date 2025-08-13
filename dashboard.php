<!doctype html>
<html lang = en>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <!--<script src="Form Validator/script.js" type="text/javascript"></script>-->
    <meta name="author" content="Szymon Warguła">
    <link rel="icon" href="https://cosmos.network/presskit/cosmos-brandmark-dynamic-dark.svg" type="image/x-icon">
    
    <title>Sign in</title>
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
    <div id="header">
        <div id="logo">
            <a href="main.html"><img src="https://cosmos.network/presskit/cosmos-brandmark-dynamic-dark.svg" alt="Uni-logo" id="Uni-logo">
            </a>
            The Site about Cosmos - Demo
        </div>
        <div id="menu-ex">
            <nav>
            <a href="page1.html">
                <div id="Planets">Planets and Moons</div>
            </a>
            <a href="page2.html">
                <div id="Constelations">Constelations</div>
            </a>
            <a href="page3.html">
                <div id="Galactics">Galactics</div>
            </a>
        </nav>
        </div>
        <div id="menu" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">
                &times;
            </a>
            <a href="page1.html">Planets and Moons</a>
            <a href="page2.html">Constelations</a>
            <a href="page3.html">Galactics</a>
        </div>
        <span onclick="toggleNav()" class="menu-button">&#9776; Menu</span>
        <button id="mode" onclick="ModeToogle()">Dark Mode</button>
        <a href="form.html" id="LoginFormButton">Sign in</a>   
    </div>
    <div id="sub-header">
        <h2>Orbitopedia</h2>
    </div>


<div class="main-dashboard" id="main-dashboard">
    
    <h1>Your Notes</h1>
    <table>
        <tr>
            <th>Topic</th>
            <th>Created</th>
            <th>Last Modified</th>
            <th>Actions</th>
        </tr>

        <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: login.html');
            exit();
        }

        $user_id = $_SESSION['user_id'];

        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "Orbitopedia";
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT id, topic, created_at, updated_at FROM notes WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['topic']) . "</td>";
            echo "<td>". $row['created_at'] ."</td>";
            echo "<td>" . $row['updated_at'] . "</td>";
            echo "<td><a href='edit_note.php?id=" . $row['id'] . "'><button class='action-button edit'>Edit</button></a><a href='delete_note.php?id=" . $row['id'] . "'><button class='action-button delete'>Delete</button></a></td>";
            echo "</tr>";
        }


        $stmt->close();
        $conn->close();
        ?>

    </table>
    
    <div id="add-section">
            <form method="POST" action="add_note.php">
                <div class="add-section-submit">
                    <input type="submit" class="add-new-note" value="Add New Note">
                </div>
                
                <div class="add-section-form">
                    <label for="topic">
                        <span>Topic:</span>
                    </label>
                        <input type="text" name="topic" class="new-note" id="topic" placeholder="New Topic" required>

                    <label for="content">
                        <span>Content:</span>
                    </label>
                        <textarea name="content" id="content" class="new-note" placeholder="Content of your new topic" required></textarea>

                </div>    
            </form>
    </div>
    <div id="password-section">
        <h2>User's Settings</h2>
        <form action="change_password.php" method="POST">
            <label for="new_password">New Password:</label><br>
            <input type="password" id="new_password" name="new_password" required><br><br>
            <input type="submit" value="Change Password">
        </form>
    </div>

 </div>


 <footer class="footer">
    <div class="footer-container">
        <div class="row">
            <div class="footer-col">
                <h4>Author</h4>
                <ul>
                    <li><a href="https://github.com/Kosinir" target="_blank">Szymon Warguła 158037</a></li>
                    <li><a href="https://ekursy.put.poznan.pl/course/view.php?id=14599" target="_blank">Course</a></li>
                    <li><a href="https://put.poznan.pl" target="_blank">University</a></li>
            
                </ul>
            </div>
            <div class="footer-col">
                <h4>Sources</h4>
                <ul>
                    <li><a href="https://cosmos.network/presskit/" target="_blank">Logo</a></li>
                    <li><a href="https://pl.wikipedia.org/wiki/Wszechświat" target="_blank">Wikipedia</a></li>
                    <li><a href="https://unsplash.com" target="_blank">Photos</a ></li>
            
                </ul>
            </div>
            <div class="footer-col">
                <h4>Other</h4>
                <ul>
                    <li><a href="html-cms-zadanie.pdf" target="_blank">Task</a></li>
                </ul>
            </div>            
        </div>
    </div>
</footer>
</body>
</html>