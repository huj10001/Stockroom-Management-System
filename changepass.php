<?php

    // Connect to a session for the user (creating one if they don't have one)
    session_start();

    // First check if the user is already logged in (and redirect if applicable)
    if (!isset($_SESSION['user'])) {
        exit("You need to be logged in to use this page");
    }

    // Try to change password if possible
    if (isset($_REQUEST['oldpass']) && isset($_REQUEST['newpass'])) {
        // Make sure we are connected to the database
        require_once("secure_connect.php");

        // Lookup the user in the database
        $query = $mysqli->prepare("SELECT pass FROM user WHERE email=?");
        if (!$query) exit("Failed to connect to database: " . $mysqli->error);
        
        $query->bind_param('s', $_SESSION['user']['email']);
        $query->bind_result($pass);
        if (!$query->execute()) exit("Failed to perform query");

        // See if we get a username back
        if ($query->fetch() === TRUE) {
            // Compare the user's password against the retrieved password and log them in if it works (also make sure they are enabled)
            if (password_verify($_REQUEST['oldpass'], $pass)) {
                $pass2 = password_hash($_REQUEST['newpass'], PASSWORD_DEFAULT);

                $query->close(); // End the last statement first
                $query2 = $mysqli->prepare("UPDATE user SET pass=? WHERE email=?");
                if (!$query2) exit("Failed to connect to database to change pass: " . $mysqli->error);

                $query2->bind_param('ss', $pass2, $_SESSION['user']['email']);
                if (!$query2->execute()) exit("Failed to perform query");
                exit("Password changed");
            }
        }

        // If we get here note a bad attempt
        $bad_attempt = TRUE;
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head><title>Change Password</title></head>
<body>
<?php if (isset($bad_attempt) && $bad_attempt) echo "Incorrect Password"; ?>
<form action="changepass.php" method="post">
    <?php if (isset($_REQUEST['redirect'])) {?> <input type="hidden" name="redirect" value="<?php echo $_REQUEST['redirect']; ?>"/> <?php } ?>
    <label for="oldpass">Current Password: </label><input type="password" id="oldpass" name="oldpass"><br/>
    <label for="newpass">New Password: </label><input     type="password" id="newpass" name="newpass"><br/>
    <input type="submit" value="Submit">
</form>
</body>
</html>