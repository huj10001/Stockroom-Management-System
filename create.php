<form action="http://demo.qualityunit.com/pax4/affiliates/signup.php" method="post">
<fieldset>
    <legend>Personal Info</legend>
    <table cellpadding="3">
      <tr><td width="150px"><strong>Username (Email)</strong></td><td><input type="text" name="username"></td></tr>
      <tr><td><strong>First name</strong></td><td><input type="text" name="firstname"></td></tr>
      <tr><td><strong>Last name</strong></td><td><input type="text" name="lastname"></td></tr>
      <tr><td>Referral ID</strong></td><td><input type="text" name="refid"></td></tr>
    </table>
    </fieldset>

<fieldset>
    <legend>Additional info</legend>
    <table cellpadding="3">
        <tr><td width="150px"><strong>Web Url</strong></td><td><input type="text" name="data1"></td></tr>
        <tr><td><strong>Company name</strong></td><td><input type="text" name="data2"></td></tr>
        <tr><td><strong>Street</strong></td><td><input type="text" name="data3"></td></tr>
        <tr><td><strong>City</strong></td><td><input type="text" name="data4"></td></tr>
        <tr><td><strong>State</strong></td><td><input type="text" name="data5"></td></tr>
        <tr><td><strong>Country</strong></td><td><input type="text" name="data6"></td></tr>
    </table>
    </fieldset>

<fieldset style="text-align: center">
    <legend>Terms & conditions</legend>

    <textarea cols="50" rows="5">You can write your own terms & conditions here</textarea>
    <br/>
    I confirm that I agree with terms & conditions <input type="checkbox" name="agreeWithTerms" value="Y">
    <br/><br/>
    
    <?php
      if(array_key_exists('cumulativeErrorMessage', $_POST) && $_POST['cumulativeErrorMessage'] != '') {
    ?>
    <fieldset style="color: #ff0000;">
        <legend>There were errors</legend>
        <?php echo $_POST['cumulativeErrorMessage']?>
    </fieldset>
    <?php
      }
    ?>
    <br/>
    
    <input type="submit" value="Signup">
    <input type="hidden" name="errorUrl" value="http://demo.qualityunit.com/pax4/html_signup_form.php">
    <input type="hidden" name="successUrl" value="http://demo.qualityunit.com/pax4/after_signup.php">

</form>