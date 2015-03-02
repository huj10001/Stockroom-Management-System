<?php
    // Connect to a session for the user (creating one if they don't have one)
    session_start();

    // First check if the user is already logged in (and redirect if applicable)
    if (isset($_SESSION['user'])) {
        if (isset($_REQUEST['redirect'])) {
            header('Location: ' + $_REQUEST['redirect']);
            exit();
        }
        exit("You are already logged in");
    }

    // Try to log the user in if possible
    if (isset($_REQUEST['email']) && isset($_REQUEST['pass'])) {
        // Make sure we are connected to the database
        require_once("secure_connect.php");

        // Lookup the user in the database
        $query = $mysqli->prepare("SELECT id, email, pass, type, enabled FROM user WHERE email=?");
        if (!$query) exit("Failed to connect to database");
        
        $query->bind_param('s', $_REQUEST['email']);
        $query->bind_result($id, $email, $pass, $type, $enabled);
        if (!$query->execute()) exit("Failed to perform query");
        
        // See if we get a username back
        if ($query->fetch() === TRUE) {
            // Compare the user's password against the retrieved password and log them in if it works (also make sure they are enabled)
            if (password_verify($_REQUEST['pass'], $pass) && $enabled) {
                // Log the user in and redirect if possible
                $_SESSION['user'] = array(
                    'id' => $id,
                    'email' => $email,
                    'type' => $type
                );
                if($type==1){
                    header('Location: ./secure_mainpage.php');
                }
                else if($type == 0){
                    header('Location: ./TA_page.php');
                }
                if (isset($_REQUEST['redirect'])) {
                    header('Location: ' + $_REQUEST['redirect']);
                    exit();
                }
                exit("You are now logged in");
            }
        }

        // If we get here note a bad attempt
        $bad_attempt = TRUE;
    }

    // If we get this far then display the login page
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <style>
    body{
        height: 200px;
        width: 400px;
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -100px;
        margin-left: -200px;
    }

    fieldset {
        border: 2px solid #CCA383;
        width: 400px;
        background: #FFE8EF;
        padding: 10px;
}

    label{
        /*display:inline-block;
        width:50px;
        margin-right:30px;*/

        color: #A52A2A;
        font-weight: bold;
        display: block;
        width: 150px;
        float: left;
}
.foo
{
    padding-right: 20px;
}
#create{
    float: right;
}
fieldset legend {
    background: #CCA383;
    padding: 6px;
    font-weight: bold;
}
    </style>

    <title>Login</title></head>
<body>
    <h1 align="center"><FONT FACE="algerian">S.M.S</FONT></h1>
<?php if (isset($bad_attempt) && $bad_attempt) echo "Incorrect username or password"; ?>
<form action="login.php" method="post">
    <?php if (isset($_REQUEST['redirect'])) {?> <input type="hidden" name="redirect" value="<?php echo $_REQUEST['redirect']; ?>"/> <?php } ?>
    <fieldset>
        <legend>
            Log in
        </legend>
    <label for="email">Email: </label><input type="text" style="border:2px outset #F7730E" class="foo" id="email" name="email"><br/>
    <br>
    <label for="pass">Password: </label><input type="password" style="border:2px outset #F7730E" class="foo" id="pass" name="pass"><br/>
    </fieldset>
    <input type="submit" value="Submit"> 
    <input type=button onClick="parent.location='createuser.php'" id="create" value='Create user'>

</form>

</body>
</html>