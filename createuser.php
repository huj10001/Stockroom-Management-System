<?php
// This should really be restricted to only users who have permission to create accounts
// Connect to a session for the user (creating one if they don't have one)
    session_start();

    // Try to log the user in if possible
    if (isset($_REQUEST['email']) && isset($_REQUEST['pass'])) {
        $bad_attempt = false;
        // Make sure we are connected to the database
        require_once("secure_connect.php");

        // Add the user to toe database
        $query = $mysqli->prepare("INSERT INTO user (email, pass, type, enabled) VALUES (?, ?, ?, true)");
        if (!$query) exit("Failed to connect to database");
        
        $email = $_REQUEST['email'];
        $pass = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);
        $type = 1;
        $query->bind_param('ssi', $email, $pass, $type);
        if ($query->execute()) {
            echo '<script language="javascript">';
            echo 'alert("User Created!")';
            echo '</script>';
            exit();
        }

        // If we get here note a bad attempt
        $bad_attempt = TRUE;
    }

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head><title>Create User</title></head>
<body>
    <style>
        body{
            background: #5F9EA0;
            height: 200px;
            width: 400px;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -100px;
            margin-left: -200px;
        }
        fieldset{
            border: 2px solid #000000;
        }
        #reset{
            float: right;
        }
    </style>

    <script>
        function goBack(){
            window.location = "login.php";
            return false;
        }
        function checkPass(){
            var pass1 = document.getElementById('pass').value;
            var pass2 = document.getElementById('rpass').value;
            if (pass1 != pass2) {
                alert("Passwords did not Match!");
                return false;
            }
            else {
                return true;
            }
        }
        function checkEmail(){
            var email = document.getElementById('email').value;
            if(email == '') {
                alert("Please Enter your Email");
                return false;
            }
            else{
                return true;
            }
        }
        function userNameTaken(){
            alert("Username already taken!");
        }
        function validateForm() {
            var isFormValid = true;
            isFormValid &= checkPass();
            isFormValid &= checkEmail();
            return isFormValid? true:false;
        }
    </script>

<?php 
    if (isset($bad_attempt) && $bad_attempt){
        echo '<script language="javascript">';
        echo 'userNameTaken();';
        echo '</script>';
    }
?>

<form action="createuser.php" method="post" onsubmit="return validateForm();">
    <?php if (isset($_REQUEST['redirect'])) {?> <input type="hidden" name="redirect" value="<?php echo $_REQUEST['redirect']; ?>"/> <?php } ?>
    
    <fieldset>
        <legend><font size="6">Account Info</font></legend>
        <table cellpadding="3">
            <tr><td><label for="email">Email: </label></td><td><input type="text" id="email" name="email"></td></tr>
            <tr><td><label for="pass">Password: </label></td><td><input type="password" id="pass" name="pass"></td></tr>
            <tr><td><label for="rpass">Retype Password: </label></td><td><input type="password" id="rpass" name="rpass"></td></tr>
        </table>
            <input type="submit" value="Submit request">
            <input type=button onClick="parent.location='login.php'" id="back" value='Go Back'>
    </fieldset>
</form>
</body>
</html>