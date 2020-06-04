<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();

    if ( !isset($_SESSION["admin_id"]) ) {
        die('ACCESS DENIED');
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="css/admin.css">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark" id="navigation">
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
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container" id="booking-list">
            <?php
                if ( isset($_SESSION['success']) ) {
                    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                    unset($_SESSION['error']);
                }
            ?>
            <table class="table table-responsive-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">List_Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Booking ID</th>
                        <th scope="col">Slot</th>
                        <th scope="col">Status</th>
                        <th scope="col">Lab</th>
                        <th scope="col">Test</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $pdo->query("SELECT * from list");
                        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                            echo "<tr><td>";
                            echo(htmlentities($row['list_id']));
                            echo("</td><td>");
                            echo(htmlentities($row['name']));
                            echo("</td><td>");
                            echo(htmlentities($row['contact']));
                            echo("</td><td>");
                            echo(htmlentities($row['address']));
                            echo("</td><td>");
                            echo(htmlentities($row['booking_id']));
                            echo("</td><td>");
                            echo(htmlentities($row['slot']));
                            echo("</td><td>");
                            echo('Pending');
                            echo('<form method="post" action="delete.php?list_id='.$row['list_id'].'">');
                            echo('<input type="submit" value="Done"/></form>');
                            echo("</td><td>");
                            echo(htmlentities($row['lab']));
                            echo("</td><td>");
                            echo(htmlentities($row['test']));
                            echo("</td></tr>\n");
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>