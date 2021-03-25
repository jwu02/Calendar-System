<?php
require "db_connection.php";

require "header.php";
?>

    <div id="settings-container">
        Username: <?php echo $_SESSION["username"]; ?><br/>

        <!--change password-->
        <form onsubmit="return checkPasswordMatch()" method="POST">
            Current password: <input type="password" id="current_password" name="current_password" maxlength="20" required /><br/>
            New password: <input type="password" id="new_password" name="new_password" maxlength="20" required /><br/>
            Confirm password: <input type="password" id="confirm_password" name="confirm_password" maxlength="20" required /><br/>

            <input type="submit" id="change_password" class="header-button" name="change_password" value="Change password" />
        </form>
    </div>
    
    <?php
    if (isset($_POST["change_password"])) {
        //store current password and new password entered in variables
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];

        //get password in database for comparison
        $fetch_id = $_SESSION["user_ID"]; //store id stored in session variable for query
        $fetchPword_sql = "SELECT `password` FROM users WHERE `user_ID`='$fetch_id';";
        $sql = $fetchPword_sql;

        $result = mysqli_query($db, $sql);
        $pwordInDb = mysqli_fetch_assoc($result);

        //check if current password enterd matches password in database
        if ($current_password == $pwordInDb["password"]) {
            //if match update password in database to new password
            $changePword_sql = "UPDATE users SET `password`='$new_password' WHERE `user_ID`='$fetch_id';";
            $sql = $changePword_sql;

            if (mysqli_query($db, $sql)) {
                echo "Password updated.";
            } else {
                echo "An error occurred updating password.";
            }
        } else {
            echo "Current password incorrect.";
        }
    }
    ?>

    <script type='text/javascript' src='script.js'></script>
</body>
</html>