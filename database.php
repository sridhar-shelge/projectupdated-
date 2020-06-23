<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();

    if ( !isset($_SESSION["admin_id"]) ) {
        die('ACCESS DENIED');
    }
    
    if(isset($_POST['test_name'])){
        $stmt=$pdo->prepare('INSERT INTO tests(test_name) VALUES(:test_name)');
        $stmt->execute(array(
            ":test_name"=>$_POST['test_name']
        ));
        $_SESSION['success']="Test Added";
        header("location:database.php");
        return;
    }

    if(isset($_POST['lab_name'])){
        $stmt=$pdo->prepare('INSERT INTO labs(lab_name) VALUES(:lab_name)');
        $stmt->execute(array(
            ":lab_name"=>$_POST['lab_name']
        ));
        $_SESSION['success']="Lab Added";
        header("location:database.php");
        return;
    }

    if(isset($_POST['lab_test_name']) && isset($_POST['lab_lab_name'])){
        $stmt=$pdo->prepare('SELECT * from tests where test_name=:test_name');
        $stmt->execute(array(
            ":test_name"=>$_POST['lab_test_name']
        ));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $test_id=$row['test_id'];

        $stmt=$pdo->prepare('SELECT * from labs where lab_name=:lab_name');
        $stmt->execute(array(
            ":lab_name"=>$_POST['lab_lab_name']
        ));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $lab_id=$row['lab_id'];

        $stmt=$pdo->prepare('SELECT table_id from lab_test where lab_id=:lab_id and test_id=:test_id');
        $stmt->execute(array(
            ":lab_id"=>$lab_id,
            ":test_id"=> $test_id
            ));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        if($row['table_id']!==null){
            $_SESSION['error']='Already Exists';
            header("Location: database.php");
            return;
        }

        $stmt=$pdo->prepare('INSERT INTO lab_test(test_id,lab_id) VALUES(:lab_test_name,:lab_lab_name)');
        $stmt->execute(array(
            ":lab_test_name"=>$test_id,
            ":lab_lab_name"=>$lab_id
        ));
        $_SESSION['success']="Association Added";
        header("location:database.php");
        return;
    }
    
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script> 
        <script src="mindmup-editabletable.js"></script>
        <link rel="stylesheet" href="css/databas.css">
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
                            <a class="nav-link" href="bookinglist.php">bookinglist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="container">
                <div class="row justify-content-around">
                    <div class="col-11 alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?php
                                if ( isset($_SESSION['error']) ) {
                                    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                                    unset($_SESSION['error']);
                                }
                            ?>
                            <?php
                                if ( isset($_SESSION['success']) ) {
                                    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                                    unset($_SESSION['success']);
                                }
                            ?>
                        </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-5 col-sm-11" id="table1">
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Test_Id</th>
                                <th scope="col">Test_Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $stmt = $pdo->query("SELECT * from tests");
                                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                                    echo "<tr><td>";
                                    echo(htmlentities($row['test_id']));
                                    echo("</td><td>");
                                    echo('<p class="txtedit">'.htmlentities($row["test_name"]).'</p>');
                                    echo("</td><td>");
                                    echo('<a class="fa fa-trash delete" href="del.php?test_id='.$row['test_id'].'">Delete</a>');
                                    echo("</td></tr>\n");
                                }
                            ?>
                        </tbody>
                    </table>
                    <form method="post" action="database.php">
                        <input type="text" placeholder="Test Name" name="test_name">
                        <input type="submit" value="Add"/>
                    </form>
                </div>
                <hr>

                <div class="col-md-5 col-sm-11" id="table2">
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Lab_Id</th>
                                <th scope="col">Lab_Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $stmt = $pdo->query("SELECT * from labs");
                                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                                    echo "<tr><td>";
                                    echo(htmlentities($row['lab_id']));
                                    echo("</td><td>");
                                    echo(htmlentities($row['lab_name']));
                                    echo("</td><td>");
                                    echo('<a class="fa fa-trash delete" href="del.php?lab_id='.$row['lab_id'].'">Delete</a>');
                                    echo("</td></tr>\n");
                                }
                            ?>
                        </tbody>
                    </table>
                    <form method="post" action="database.php">
                        <input type="text" placeholder="Lab Name" name="lab_name">
                        <input type="submit" value="Add">
                    </form>
                </div>
            </div>
            <br>
            <br>

            <div class="row justify-content-center" id="table3">
                <div class="col">
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Table_Id</th>
                                <th scope="col">Test_Id</th>
                                 <th scope="col">Lab_Id</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $stmt = $pdo->query("SELECT * from lab_test");
                                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                                    echo "<tr><td>";
                                    echo(htmlentities($row['table_id']));
                                    echo("</td><td>");
                                    echo(htmlentities($row['lab_id']));
                                    echo("</td><td>");
                                    echo(htmlentities($row['test_id']));
                                    echo("</td><td>");
                                    echo('<a class="fa fa-trash delete" href="del.php?table_id='.$row['table_id'].'">Delete</a>');
                                    echo("</td></tr>\n");
                                }
                            ?>
                        </tbody>
                    </table>
                    <form method="post" action="database.php">
                        <input type="text" placeholder="Test Name" name="lab_test_name">
                        <input type="text" placeholder="Lab Name" name="lab_lab_name">
                        <input type="submit" value="Add"/>
                    </form>
                </div>

        </div>
    </body>
</html>

<script>

</script>