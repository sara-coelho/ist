<?php

session_start();

if(isset($_SESSION["user_id"])){
    $mysqli = require __DIR__ . "/assets/database/database.php";
    $sql = "SELECT * FROM user WHERE id={$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}


?>


<!DOCTYPE html>
<html>
    <head>
        <title>profile-page</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Home</h1>
        <?php if (isset($user)):?>
            <p>Hello, <?= htmlspecialchars($user["user"])?></p>
            <a href="logout.php">Log Out</a>           
            <form method="post" action="assets/database/update_description.php">
                <label for="description">Update Description:</label>
                <input type="text" name="description" id="description">
                <button type="submit">Submit</button>
            </form>
            <?php if (!empty($user['descricao'])): ?>
                <p>Description: <?= htmlspecialchars($user['descricao']) ?></p>
            <?php endif; ?>
            <!-- Add a button to update the workshops field -->
            <form method="post" action="assets/database/update_workshops.php">
                <button type="submit" name="update_workshops">Update Workshops</button>
            </form>
            <form method="post" action="assets/database/update_linkedin.php">
                <label for="linkedin">Update LinkedIn:</label>
                <input type="text" name="linkedin" id="linkedin">
                <button type="submit">Submit</button>
            </form>
            <!-- Display workshops based on the user's workshops field -->
            <?php
            $workshops_array = [
                "workshop1",
                "workshop2",
                "workshop3"
            ];

            $workshop_ids = array_map('intval', explode(',', $user['workshops']));
            foreach ($workshop_ids as $workshop_id) {
                $workshop_info = $workshops_array[$workshop_id];
                if ($workshop_info) {
                    echo "<p>{$workshop_info}</p>";
                }
            }
            ?>
            
            <?php
            $sql = 'SELECT * FROM user ORDER BY points DESC';
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Users Sorted by Points</h2>";
                echo "<ul>";

                while ($row = $result->fetch_assoc()) {
                    echo "<li>{$row['user']} - Points: {$row['points']}</li>";
                }

                echo "</ul>";
            } else {
                echo "No users found.";
            }
            ?>

        <?php else: ?>
            <p><a href="login.php">Log In</a> or <a href="signup.html">Sign Up</a>.</p>
        <?php endif; ?>


    </body>

</html>
