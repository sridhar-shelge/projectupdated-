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

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["prescription"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["prescription"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["prescription"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["prescription"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["prescription"]["name"]). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }


    $stmt = $pdo->prepare('INSERT INTO list
    (user_id,test,lab) VALUES ( :user_id,:test,:lab)');
    $stmt->execute(array(
    ':user_id'=>$_SESSION["user_id"],
    ':test' => htmlentities($_POST['select-tests']),
    ':lab' => htmlentities($_POST['select-lab'])
    ));
    $list_id=$pdo->lastInsertId();


    $stmt = $pdo->prepare('INSERT INTO bookingpage
    (user_id,test,prescription,lab) VALUES ( :user_id, :test, :prescription, :lab)');
    $stmt->execute(array(
    ':user_id' => $_SESSION["user_id"] ,
    ':test' => htmlentities($_POST['select-tests']),
    ':prescription' => basename( $_FILES["prescription"]["name"]),
    ':lab' => htmlentities($_POST['select-lab'])
    ));
    $id=$pdo->lastInsertId();
    $_SESSION['success'] = "Record added.";
    header("Location: bookingdetails.php?book_id=".$id.'&'.'list_id='.$list_id);
    return;
}

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
        <link rel="stylesheet" href="css/styles.css">
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
                <div class="row justify-content-around" style="padding-bottom: 15px;">
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="select-tests">Select a Test(s)</label>
                        </div>
                        <div class="row">
                            <select class="form-control" id="select-tests" name="select-tests" type="text">
                                <option value="test1">Test 1</option>
                                <option value="test2">Test 2</option>
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
                                <option value="lab1">Lab 1</option>
                                <option value="lab2">Lab 2</option>
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
    <footer>
        <div class="row justify-content-around">
            <div class="col-11 col-sm-6" id="contact-us">
                <h2>Contact Us</h2>
                <p>Have questions about our products, support services, or anything else? Let us know and we&apos;ll get back to you.</p>
                <div id="address">
                    <h4>Address</h4>
                    <p>Salarpuria symbiosis Arekere Village Begur, Bannerghatta Main Rd, Venugopal Reddy Layout, Uttarahalli Hobli, Bengaluru, Karnataka 560076</p>
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                        <i class="fas fa-blog fa-stack-1x fa-inverse"></i>
                    </span>
                    <a href="https://blog.practo.com/" data-toggle="tooltip" data-placement="right" title="Our Blog">Blog</a><br>
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                        <i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i>
                    </span>
                    <a href="https://www.practo.com/company/press" data-toggle="tooltip" data-placement="right" title="Latest News">Press</a>
                </div>
            </div>
            <div class="col-11 col-sm-5 col-md-4" id="quick-links">
                <h2>Social</h2>
                <ul>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="https://www.facebook.com/practo">Facebook</a></li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="https://twitter.com/Practo">Twitter</a>
                    </li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="https://www.linkedin.com/company/practo-technologies-pvt-ltd">Linkedin</a>
                    </li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="https://www.youtube.com/user/PractoSupport">Youtube</a>
                    </li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="https://github.com/practo">Github</a>
                    </li>
                </ul>
                <h2>Quick Links</h2>
                <ul>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-home fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="#home">Home</a>
                    </li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-ticket fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="New Booking Page.php">Book a Diagnostic Test</a>
                    </li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-info fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="#about">About</a>
                    </li>
                    <li>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square fa-stack-2x" style="color: black;"></i>
                            <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
                        </span>
                        <a href="#contact-us">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</html>