<?php
require_once './config.php';

//Autoload all classes by PSR-4 specification
require_once __DIR__ . '/vendor/autoload.php';

?>
<!DOCTYPE HTML>
<html lang="bg">
<head>
    <title>Registration form</title>
    <meta charset="utf-8" />
    <meta name="description" content="This is test task developed by Krasimir Kostadinov" />
    <meta name="author" content="Krasimir Kostadinov" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=9" />

    <link rel="stylesheet" type="text/css" href="<?php echo HOST_PATH; ?>/public/css/style.css">
    <script src="<?php echo HOST_PATH; ?>/public/js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo HOST_PATH; ?>/public/js/main.js"></script>
    <script>
        var host_path = '<?php echo HOST_PATH; ?>';
    </script>
</head>
<body>
    <div class="container">
        <form method="post" name="registertration-form" action="<?php HOST_PATH . '/ajax/save_user.php' ?>" id="reg-user" novalidate>
            <h2>Registration form</h2>

            <span><input type="text" placeholder="Enter your username" name="username" maxlength="50" required /></span>

            <span><input type="email" placeholder="Enter your email" name="email" maxlength="50" required /></span>

            <span><input type="text" placeholder="Enter your first name" name="first-name" maxlength="50" required /></span>

            <span><input type="text" placeholder="Enter your last name" name="last-name" maxlength="50" required /></span>

            <span><input type="password" placeholder="Enter your password" name="password1"  maxlength="50" required /></span>

            <span><input type="password" placeholder="Repeat your password" name="password2" maxlength="50" required /></span>

            <div class="btn-area">
                <p><input type="submit" class="reg-btn" value="Register" /></p>
            </div>
        </form>

        <footer>
            This is test task developed by <a href="http://krasimirkostadinov.com">@Krasimir Kostadinov</a>
        </footer>
    </div>

</body>
</html>
