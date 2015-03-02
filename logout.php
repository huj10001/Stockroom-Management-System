<?php
// Open the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect if applicable
if (isset($_REQUEST['./login.php'])) {
    header('Location: ' + $_REQUEST['./login.php']);
    exit();
}
echo("You are now logged out");

?>
<html>
<head>
<script>
setTimeout('Redirect()', 1000);

function Redirect() {
    window.location = "login.php";
}
</script>
</head>
</html>