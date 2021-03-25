<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main menu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <button id="header-mainmenu" class="header-button" onclick="location.href='index.php'">Main menu</button>
        <button id="header-societies" class="header-button" onclick="location.href='societies.php'">Societies</button>
        <?php
        if (isset($_SESSION["logged_in"])) { //if user is logged in
            echo '<button id="header-settings" class="header-button" onclick="location.href=\'settings.php\'">Settings</button>';
        }
        ?>

        <span id="header-date"><?php echo date('M Y'); ?></span>
        <?php
        if (isset($_SESSION["logged_in"])) { //if user is logged in
            echo '<button id="header-login" class="header-button" onclick="location.href=\'logout.php\'">Logout</button>';
        } else {
            echo '<button id="header-login" class="header-button" onclick="location.href=\'login.php\'">Login</button>';
        }
        ?>
    </header>