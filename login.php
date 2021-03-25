<?php
require "header.php";
?>

    <div id="login-container">
        <form id="login-form" action="login_validation.php" method="POST">
            <input type="text" placeholder="Username" name="username" maxlength="20" required /><br/>
            <input type="password" placeholder="Password" name="password" maxlength="20" required /><br/>
            <input type="submit" name="login" value="Login" id="login-button" class="header-button" />
        </form>
    </div>
</body>
</html>