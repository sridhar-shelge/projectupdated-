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

<p>Confirm: Deleting <?= htmlentities($row['name']) ?> Booking's</p>

<form method="post">
<input type="hidden" name="list_id" value="<?= $row['list_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="bookinglist.php">Cancel</a>
</form>