<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();

    if ( !isset($_SESSION["admin_id"]) ) {
        die('ACCESS DENIED');
    }

    if(isset($_POST['delete']) && isset($_POST['list_id']) ){

        $sql = "DELETE FROM list WHERE list_id=:zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['list_id']));
        $_SESSION['success'] = 'Record deleted';
        header( 'Location: bookinglist.php' ) ;
        return;
    }

    if ( ! isset($_GET['list_id']) ) {
      $_SESSION['error'] = "Missing list_id";
      header('Location: bookinglist.php');
      return;
    }
    
    $stmt = $pdo->prepare("SELECT * FROM list where list_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['list_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for list_id';
        header( 'Location: bookinglist.php' ) ;
        return;
    }

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/delete.css"/>
    </head>
    <body style="background-color: rgb(10,100,70)">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col">
                    <h2>Delete from Database</h2>
                    <p>Confirm: Deleting <?= htmlentities($row['name'])."'s" ?> Booking</p>
                    <form method="post">
                        <input type="hidden" name="list_id" value="<?= $row['list_id'] ?>">
                        <input class="btn btn-success" type="submit" value="Delete" name="delete">
                    </form>
                    <button class="btn btn-danger" onclick="location.href='bookinglist.php';">Cancel</button>
                </div>
            </div>
        </div>
    </body>
</html>

