<html>
    <head>
        <?php require_once "bootstrap.php" ?>
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
            <h3>You have successfully Booked a Diagnostic Test</h3>
            <p>Your Booking Id is <?php echo $_GET['hash']; ?>
            <br>
            <a href='landingpage.php'>Go To Home</a>
        </div>
    </body>
    <footer id="foot" style="">
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