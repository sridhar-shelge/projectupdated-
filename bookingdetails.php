<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();

if ( !isset($_SESSION["email"]) ) {
    header("Location: login.php");
    return;
}
if ( isset($_POST['cancel']) ) {
    header('Location: landingpage.php');
    return;
}

$user_id = $_SESSION["user_id"];
$stmt=$pdo->prepare("SELECT name from users where user_id=:user");
$stmt->execute(array(':user'=>$user_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$username=$row['name'];
$salt = 'XyZzy12*_';
$random=rand(1200,99999);
$hash = hash('md5', $salt.$user_id.$random.$username);

if ( isset($_POST['name']) && isset($_POST['contact']) && isset($_POST['date']) && isset($_POST['timeslot']) && 
    isset($_POST['address']) ) {


    $sql = "UPDATE list SET name = :name,
            contact = :contact, address = :address, date=:date,delivery_details=:delivery_details, booking_id=:booking_id,slot=:slot
            WHERE list_id = :list_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':list_id' => $_GET['list_id'],
        ':name' =>  htmlentities($_POST['name']),
        ':contact' => htmlentities($_POST['contact']),
        ':address' => $_POST['address'],
        ':booking_id' => $hash,
        ':date'=> htmlentities($_POST['date']),
        ':delivery_details'=> htmlentities($_POST['delivery_details']),
        ':slot' =>htmlentities($_POST['timeslot'])
        ));

    $_SESSION['success'] = "Record added.";
    header("Location: success.php?user_id=".$_SESSION["user_id"].'&'.'hash='.$hash);
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
                        <a id="home-button" class="nav-link" href="Landing Page.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="about-button" class="nav-link" href="Landing Page.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a id="contact-us-button" class="nav-link" href="#contact-us">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <div class="container" id="booking-details">
            <form method="post" action="">
                <div>
                    <h2>Booking Details</h2>
                </div>
                <div class="row justify-content-around" style="padding-bottom: 15px;">
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="name">Name</label>
                        </div>
                        <div class="row">
                            <input class="form-control" id="name" name="name" type="text" value=<?php echo ($_SESSION['name']); ?>>
                        </div>
                    </div>
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="contact">Contact</label>
                        </div>
                        <div class="row">
                            <input class="form-control" id="contact" name="contact" type="text">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around" style="padding-bottom: 15px;">
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="date">Select a Date</label>
                        </div>
                        <div class="row">
                            <input class="form-control" id="date" name="date" type="date">
                        </div>
                    </div>
                    <div class="col-11 col-md-5">
                        <div class="row">
                            <label for="timeslot">Pick a Timeslot</label>
                        </div>
                        <div class="row">
                            <select class="form-control" id="timeslot" name="timeslot" type="text">
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                                <option value="evening">Evening</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around" style="padding-bottom: 15px;">
                    <div class="col-11">
                        <div class="row">
                            <label for="address">Address</label>
                        </div>
                        <div class="row">
                            <textarea class="form-control" id="address" name="address" style="height:150"></textarea>
                        </div>    
                    </div>
                    <div class="col-11">
                        <div class="row">
                            <label for="delivery_details">Delivery Details</label>
                        </div>
                        <div class="row">
                            <textarea class="form-control" id="delivery_details" name="delivery_details" style="height:150"></textarea>
                        </div>    
                    </div>
                </div>
                

                <div class="row justify-content-around">
                    <div class="col-3">
                        <input id="submit" type="submit" class="form-control btn btn-success" onclick="return doValidate()">
                    </div>
                    <div class="col-3">
                        <input type="submit" name="cancel" id="cancel" class="form-control btn btn-danger" value="Cancel">
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

<script type="text/javascript">
    function doValidate() {
    console.log('Validating...');
    try {
        name = document.getElementById('name').value;
        contact = document.getElementById('contact').value;
        date = document.getElementById('date').value;
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = mm + '/' + dd + '/' + yyyy;
        if (name == null || name == "" || contact == null || contact == "" || date == null || date == "") {
            alert("name,contact,date are required");
            return false;
        }
        if(today>date){
            alert("select date properly");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>
