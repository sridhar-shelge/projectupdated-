<?php
    require_once "pdo.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/styles.css">
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
                <a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#contact-us">Contact</a>
              </li>
              <?php
                if ( !isset($_SESSION["email"]) ) {
                    echo('<li class="nav-item">');
                    echo('<a class="nav-link" href="signup.php">Login/SignUp</a>'); 
                    echo('</li>');
                }
                else{
                    echo('<li class="nav-item">');
                    echo('<a class="nav-link" href="logout.php">Logout</a>'); 
                    echo('</li>');
                }
                ?>
            </ul>
          </div>
        </nav>
    </header>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <div class="container">
            <div class="carousel slide" id="main-carousel" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#main-carousel" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid mx-auto" src="images/slide 1.jpg">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid mx-auto" src="images/slide 3.jpg">
                    </div>
                </div>
                <a href="#main-carousel" class="carousel-control-prev" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="sr-only" aria-hidden="true">Prev</span>
                </a>
                <a href="#main-carousel" class="carousel-control-next" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="sr-only" aria-hidden="true">Next</span>
                </a>
            </div>
        </div>
        <div class="container" id="home">
            <div class="row justify-content-around">
                <div class="col-11 col-md-5">
                    <img src="images/practo.png" height="140px" width="256px" class="img img-responsive">
                </div>
                <div class="col-11 col-md-6 my-auto">
                    <p>
                        Introducing Video Consultations.<br>
                        Don&apos;t delay your health concerns.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-success" onclick="location.href='bookingpage.php';">Book a Diagnostic Test</button>
                </div>
            </div>
        </div>
        <div class="container" id="details">
            <div class="row justify-content-around">
                <div class="col-md-5" id="features">
                    <h2>Features</h2>
                    <ul>
                        <li>Search doctors nearby</li>
                        <li>Online consultations</li>
                        <li>Book your appointments online</li>
                        <li>Setting up the reminders for the medicine</li>
                        <li>Online booking for a lab test</li>
                        <li>24/7 service</li>
                    </ul>
                </div>
                <div class="col-md-5" id="advantages">
                    <h2>Advantages</h2>
                    <ul>
                        <li>No Need to Travel</li>
                        <li>Improved ways to check your symptoms</li>
                        <li>Save Your Money</li>
                        <li>Privacy and Security</li>
                        <li>Comfortable and Convenient</li>
                        <li>No Risk of Infections From the Doctor's Clinic</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container" id="about">
            <div class="container">
            	<div class="row">
                	<div>
		                <h2>Your home for health</h2>
		                <p>
		                    For millions of people, Practo is the trusted and familiar home where they know they&apos;ll find a healing touch. It connects them with everything they need to take good care of themselves and their family - assessing health issues, finding the right doctor, booking diagnostic tests, obtaining medicines, storing health records or learning new ways to live healthier.<br><br>
		                    Healthcare providers can also harness the power of Practo as the definitive platform that helps them build their presence, grow establishments and engage patients more deeply than ever.
		                </p>
		            </div>
		        </div>
            </div>
            <div>
                <h2>Diverse people. One purpose.</h2>
                <p>We are dreamers, thinkers and do-ers rolled into one.Together, we want to improve the healthcare experience for all humanity. We are guided by our values and driven by our motto to do great. These are not just principles for our products or our company, but they are a reflection of who we are as people.</p>
            </div>
            <div>
                <h2>#DoGreat</h2>
                <p>Do Great is our motto and is the hallmark of a true Practeon. It signifies the intrinsic motivation in each Practeon to strive for excellence. Every time. This means Practeons do their best work, not for want of rewards or recognitions but because they expect it of themselves.</p>
            </div>
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