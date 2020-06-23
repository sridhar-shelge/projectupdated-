<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();

    if ( !isset($_SESSION["admin_id"]) ) {
        die('ACCESS DENIED');
    }

    if(isset($_GET['test_id'])){
    	$stmt=$pdo->prepare('DELETE from tests where test_id=:test_id');
    	$stmt->execute(array(
    		":test_id"=>$_GET['test_id']
    	));
    	$_SESSION['success']="Record Deleted";
    	header("location:database.php");
    	return;
    }

    if(isset($_GET['lab_id'])){
    	$stmt=$pdo->prepare('DELETE from labs where lab_id=:lab_id');
    	$stmt->execute(array(
    		":lab_id"=>$_GET['lab_id']
    	));
    	$_SESSION['success']="Record Deleted";
    	header("location:database.php");
    	return;
    }

    if(isset($_GET['table_id'])){
    	$stmt=$pdo->prepare('DELETE from lab_test where table_id=:table_id');
    	$stmt->execute(array(
    		":table_id"=>$_GET['table_id']
    	));
    	$_SESSION['success']="Record Deleted";
    	header("location:database.php");
    	return;
    }

?>