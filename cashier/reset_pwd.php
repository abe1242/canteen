<?php
ini_set("display_errors", 1);
session_start();

include_once("config/config.php");

if (isset($_POST["reset_code"])) {
    $reset_code = $_POST["reset_code"];
    $reset_email = $_POST["reset_email"];

    $result = $mysqli->query("SELECT * FROM `rpos_pass_resets` WHERE reset_email='$reset_email' ORDER BY created_at DESC LIMIT 1");
    $res = mysqli_fetch_array($result);
    if ($res['reset_code'] == $reset_code) {
        $reset_id = $res['reset_id'];
        $result = $mysqli->query("SELECT reset_code FROM `rpos_pass_resets` WHERE reset_email='$reset_email' AND reset_code='$reset_code' AND reset_status='Pending' LIMIT 1;");
        if ($result->num_rows > 0) {
            $new_password  = sha1(md5($_POST['new_password']));
            // Check if email belongs to admin or customer
            if($mysqli->query("SELECT * FROM rpos_admin WHERE admin_email='$reset_email'")->num_rows > 0){
                $query = "UPDATE rpos_admin SET  admin_password=? WHERE admin_email=?";
            } else {
                $query = "UPDATE rpos_customers SET  customer_password=? WHERE customer_email=?";
            }
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('ss', $new_password, $reset_email);
            $stmt->execute();
            if ($stmt) {
                $success = "Password Changed";
                $query = "UPDATE `rpos_pass_resets` SET reset_status='Complete' WHERE reset_id=?";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('s', $reset_id);
                $stmt->execute();
            } else {
                $err = "Failed changing password";
            }
        } else {
            $err = "Reset code is incorrect";
        }
        $result->free_result();
    } else {
        $err = "Incorrect reset code";
    }
}

include_once('partials/_head.php');
?>

<body class="bg-dark">
    <div>
        <div class="main-content">
            <div class="header bg-gradient-primar py-7">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-6">
                                <h1 class="text-white">Canteen Order</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container mt--8 pb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="card">
                            <div class="card-body px-lg-5 py-lg-5">
                                <form method="post" role="form">
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                            </div>
                                            <input class="form-control" required name="reset_code" placeholder="Reset code" type="text">
                                        </div>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input class="form-control" required name="new_password" placeholder="New password" type="password"><br>
                                        </div>
                                    </div>
                                    <input type="hidden" name="reset_email" value="<?= $_GET["reset_email"] ?>">
                                    <div class="text-center">
                                        <button type="submit" name="reset_pwd" class="btn btn-primary my-4">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php
        require_once('partials/_footer.php');
        ?>
        <!-- Argon Scripts -->
        <?php
        require_once('partials/_scripts.php');
        ?>
    </div>
</body>

</html>