<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();

if ( !isset($_SESSION["email"]) ) {
    header("Location: login.php");
    return;
}

if ( isset($_POST['cancel']) ) {
    header('Location: landingpage.php');
    return;
}

if ( isset($_POST['select-tests']) && isset($_POST['select-lab'])  ) {

    if (empty($_FILES["prescription"]["name"])) {
        $_SESSION['error']='Prescription cannot be empty';
        header("Location:bookingpage.php");
        return;
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["prescription"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["prescription"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }

    // Check file size
    if ($_FILES["prescription"]["size"] > 500000) {
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['error']='error in uploading file';
    } else {
      if (move_uploaded_file($_FILES["prescription"]["tmp_name"], $target_file)) {

      } else {
       
      }
    }

    $stmt=$pdo->prepare('SELECT test_id from tests where test_name=:test');
    $stmt->execute(array(
        ":test"=> $_POST['select-tests']
        ));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $test_id=$row['test_id'];

    $stmt=$pdo->prepare('SELECT lab_id from labs where lab_name=:lab');
    $stmt->execute(array(
        ":lab"=> $_POST['select-lab']
        ));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $lab_id=$row['lab_id'];


    $stmt=$pdo->prepare('SELECT table_id from lab_test where lab_id=:lab_id and test_id=:test_id');
    $stmt->execute(array(
        ":lab_id"=>$lab_id,
        ":test_id"=> $test_id
        ));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row['table_id']==false){
        $_SESSION['error']=strtoupper($_POST['select-tests']).' '.' is not provided by '.strtoupper($_POST['select-lab']);
        header("Location: bookingpage.php");
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO list
    (user_id,test,prescription,lab,email) VALUES ( :user_id,:test,:prescription,:lab,:email)');
    $stmt->execute(array(
    ':user_id'=>$_SESSION["user_id"],
    ':test' => htmlentities($_POST['select-tests']),
    ':prescription' => basename( $_FILES["prescription"]["name"]),
    ':lab' => htmlentities($_POST['select-lab']),
    ':email'=>$_SESSION['email']
    ));
    $list_id=$pdo->lastInsertId();


    $_SESSION['success'] = "Record added.";
    header("Location: bookingdetails.php?list_id=".$list_id);
    return;
}

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
        <link rel="stylesheet" href="css/main.css">
        <style>
            .fa {
              

              padding: 10px;
              font-size: 30px;
              width: 50px;
              text-align: center;
              text-decoration: none;
              border-radius: 50%;
            }

            /* Add a hover effect if you want */
            .fa:hover {
              opacity: 0.7;
            }

            /* Set a specific color for each brand */

            /* Facebook */
            .fa-facebook {
              background: #3B5998;
              color: white;
            }

            /* Twitter */
            .fa-twitter {
              background: #55ACEE;
              color: white;
            }
            .fa-linkedin {
              background: #007bb5;
              color: white;
            }
            .fa-youtube {
              background: #bb0000;
              color: white;
            }
        </style>
    </head>
    <header>
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light" id="navigation">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" height=30 width=30>
                Practo
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-content">
                <ul class="navbar-nav ml-auto" align="center">
                    <li class="nav-item">
                        <a class="nav-link" href="landingpage.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="landingpage.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <div class="container" id="booking-details">
            <form method="post" action="bookingpage.php" enctype="multipart/form-data">
                <div>
                    <h2>New Booking</h2>
                </div>
                <?php
                    if ( isset($_SESSION['error']) ) {
                        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                        unset($_SESSION['error']);
                    }
                ?>
                <div class="row justify-content-around" style="padding-bottom: 15px;">
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="select-tests">Select a Test(s)</label>
                        </div>
                        <div class="row">
                            <select class="form-control" id="select-tests" name="select-tests" type="text">
                                <?php
                                    $stmt=$pdo->query('SELECT * from tests');
                                    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                                        echo('<option value="'.$row['test_name'].'">');
                                        echo(htmlentities($row['test_name']));
                                        echo('</option>');
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="prescription">Upload Prescription</label>
                        </div>
                        <div class="row">
                            <input class="form-control" id="prescription" name="prescription" type="file">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around" style="padding-bottom: 20px;">
                    <div class="col-11">
                        <div class="row">
                            <label for="select-lab">Select Lab</label>
                        </div>
                        <div class="row">
                            <select class="form-control" id="select-lab" name="select-lab" type="text">
                                <?php
                                    $stmt=$pdo->query('SELECT * from labs');
                                    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                                        echo('<option value="'.$row['lab_name'].'">');
                                        echo(htmlentities($row['lab_name']));
                                        echo('</option>');
                                    } 
                                ?>
                            </select>
                        </div>    
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-3">
                        <input id="submit" type="submit" name="submit" class="form-control btn btn-success" value="Proceed">
                    </div>
                    <div class="col-3">
                        <input type="submit" id="cancel" name="cancel" class="form-control btn btn-danger" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </body>
    <footer id="foot">
        <div class="row justify-content-around" id="foot1">
            <div class="col-11 col-md-4" id="contact-us" >
                <h2 style="color: white">Contact Us</h2>
                <b>Have questions about our products, support services, or anything else? Let us know and we&apos;ll get back to you.</b>
                <hr>
                <div id="address">
                    <h4 style="color: white">Address</h4>
                    <strong>Salarpuria symbiosis Arekere Village Begur, Bannerghatta Main Rd, Venugopal Reddy Layout, Uttarahalli Hobli, Bengaluru, Karnataka 560076</strong>
                    <hr>
                </div>
            </div>
            <div class="col-11 col-md-5" id="contact-us">
                <h3 style="color: red">Social</h3>
                <a href="https://www.facebook.com/practo" class="fa fa-facebook"></a>
                <a href="https://twitter.com/Practo" class="fa fa-twitter"></a>
                <a href="https://www.linkedin.com/company/practo-technologies-pvt-ltd" class="fa fa-linkedin"></a>
                <a href="https://www.youtube.com/user/PractoSupport" class="fa fa-youtube"></a>
                <hr>
                <h3 style="color: red">Quick Links</h3>
                <a href="#home" class="fa fa-home" style="color: black;"></a>
                <a href="bookingpage.php" class="fa fa-ticket" style="color: black;"></a>
                <a href="#about" class="fa fa-info" style="color: black;"></a>
                <a href="#contact-us" class="fa fa-phone" style="color: black;"></a>
            </div>
        </div>
    </footer>
</html>