<?php 
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel'] ) ) {
    
    header("Location: landingpage.php");
    return;
}

$salt = 'XyZzy12*_';

if ( isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['conf_password']) ) {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: signup.php");
        return;
    }
    if ( $_POST['password'] != $_POST['conf_password'] ) {
        $_SESSION['error'] = "password doesn't match";
        header("Location: signup.php");
        return;
    }
    else {
      $check = hash('md5', $salt.$_POST['password']);
      $stmt=$pdo->prepare("INSERT INTO 
        users(email,password,name) values(:email,:password,:name)");
      $stmt->execute(array(
            ':email' => htmlentities($_POST['email']),
            ':password' => $check,
            ':name' => htmlentities($_POST['username'])
        ));
      $_SESSION["email"] = $_POST["email"];
      $_SESSION["success"] = "Registered Successfully.";
      error_log("Login success ".$_POST['email']);
      header( 'Location: login.php' ) ;
      return;
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php require_once "bootstrap.php" ?>
    <link rel="stylesheet" href="css/signup.css" />
    <title>My website!</title>
  </head>
  <header>
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light" id="navigation">
          <a class="navbar-brand" href="#"><img src="images/logo.png" alt="logo" height=40 width=40>Practo</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto" align="center">
              <li class="nav-item active">
                <a class="nav-link" href="landingpage.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="landingpage.php#about">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="landingpage,php#contact-us">Contact</a>
              </li>
            </ul>
          </div>
        </nav>
  </header>
  <body>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
          <div class="card card-signin flex-row my-5">
            <div class="card-img-left d-none d-md-flex">
               <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body">
              <h5 class="card-title text-center">Register</h5>
              <?php
                if ( isset($_SESSION['error']) ) {
                    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                    unset($_SESSION['error']);
                }
              ?>
              <form method="post" class="form-signin">
                <div class="form-label-group">
                  <input type="text" id="inputUserame" class="form-control" name="username" placeholder="Username" required autofocus>
                  <label for="inputUserame">Username</label>
                </div>

                <div class="form-label-group">
                  <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required>
                  <label for="inputEmail">Email address</label>
                </div>
                
                <hr>

                <div class="form-label-group">
                  <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                </div>
                
                <div class="form-label-group">
                  <input type="password" id="inputConfirmPassword" class="form-control" name="conf_password" placeholder="Password" required>
                  <label for="inputConfirmPassword">Confirm password</label>
                </div>

                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
                <hr>
                <p class="d-block text-center mt-2 small" >Already have an Account</p>
                <a class="btn btn-lg btn-primary btn-block text-uppercase" href="login.php">Sign In</a>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>