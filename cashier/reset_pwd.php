<?php
ini_set("display_errors", 1);
session_start();

include_once("config/config.php");

if (isset($_POST["reset_code"])) {
    $reset_code = $_POST["reset_code"];
    $admin_email = "admin@mail.com";

    $result = $mysqli->query("SELECT created_at, reset_code FROM `rpos_pass_resets` WHERE reset_email='$admin_email' ORDER BY created_at DESC LIMIT 1");
    $res = mysqli_fetch_array($result);
    if ($res['reset_code'] == $reset_code) {
        echo $res['reset_id'];
    } else {
        $err = "Incorrect reset code";
    }

    if ($result = $mysqli->query("SELECT reset_code FROM `rpos_pass_resets` WHERE reset_email='$admin_email' AND reset_code='$reset_code' AND reset_status='Pending' LIMIT 1;")) {
        if ($result->num_rows > 0) {
            $new_password  = sha1(md5($_POST['new_password']));
            $query = "UPDATE rpos_admin SET  admin_password=? WHERE admin_email=?";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('ss', $new_password, $admin_email);
            $stmt->execute();
            if ($stmt) {
                $success = "Password Changed";
                $query = "UPDATE `rpos_pass_resets` SET reset_status='Complete' WHERE id=2";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('ss', $new_password, $admin_email);
                $stmt->execute();
            } else {
                $err = "Failed changing password";
            }
        } else {
            $err = "Reset code is incorrect";
        }
        $result->free_result();
    }
}

include_once('partials/_head.php');
?>

<body>
    <h1>Enter password reset code</h1>
    <form action="reset_pwd.php" method="post">
        <input type="text" id="reset_code" name="reset_code" placeholder="Reset code"><br>
        <input type="text" id="new_password" name="new_password" placeholder="New password"><br>
        <input type="submit" name="submit" value="Proceed">
    </form>
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>