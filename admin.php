<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: landingpage.php");
    return;
}

$salt = 'XyZzy12*_';

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: admin.php");
        return;
    }
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Enter Data";
        header("Location: admin.php");
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        $stmt=$pdo->prepare("SELECT password,admin_id from admin where email=:email");
        $stmt->execute(array(":email"=>$_POST['email']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row['password'] == $check) {
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["admin_id"] = $row['admin_id'];
            $_SESSION["success"] = "Logged in.";
            error_log("Login success ".$_POST['email']);
            header( 'Location: bookinglist.php' ) ;
            return;
        } else {
            $_SESSION["error"] = "Incorrect password.";
            error_log("Login fail ".$_POST['email']." $check");
            header( 'Location: admin.php' ) ;
            return;
        }
    }
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Sign In</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                  <h3 class="login-heading mb-4">Welcome Admin!</h3>
                  <?php
                    if ( isset($_SESSION['error']) ) {
                        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                        unset($_SESSION['error']);
                    }
                  ?>
                  <form method="post" action="admin.php">
                    <div class="form-label-group">
                      <input type="username" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
                      <label for="inputEmail">Email address</label>
                    </div>

                    <div class="form-label-group">
                      <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass" required>
                      <label for="inputPassword">Password</label>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Remember password</label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign in</button>
                    <div class="text-center">
                      <a class="small" href="#">Forgot password?</a></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
