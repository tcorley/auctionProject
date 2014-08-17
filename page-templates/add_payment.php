<?php
session_start();
require('/u/tcorley/openZdatabase.php');
require('password.php');
if(strlen($_POST['state']) <> 2 || strlen((string)$_POST['cardno']) <> 16 || strlen((string)$_POST['zip']) <> 5)
{
	$message = htmlspecialchars("Error in input. I'm not going to tell you what is is because you don't need to be putting in dumb values. Also, I've gotten a bit lazy:)");
	$_SESSION['account_log'] = $message;
	header('Location: accountholder_info.php');
}
$putItIn = $database->prepare('
	INSERT INTO PAYMENT 
	(PAYMENT_ID, CARD_OWNER, EXPIRATION_DATE, CARD_TYPE, LAST_FOUR) 
	VALUES (NEXT_SEQ_VALUE("PAYMENT"), :user, DATE_ADD(CURDATE(),INTERVAL 4 YEAR), :type,:four);
	');
$putItIn->bindValue(':user',$_SESSION['user'],PDO::PARAM_INT);
$putItIn->bindValue(':type',$_POST['card'],PDO::PARAM_INT);
// $putItIn->bindValue(':something','something ',PDO::PARAM_STR);
$putItIn->bindValue(':four',(int)(substr((string)$_POST['cardno'],-4)),PDO::PARAM_INT);
// $putItIn->bindValue(':address',$_POST['address'],PDO::PARAM_STR);
// $putItIn->bindValue(':state',$_POST['state'],PDO::PARAM_STR);
// $putItIn->bindValue(':city',$_POST['city'],PDO::PARAM_STR);
// $putItIn->bindValue(':zip',$_POST['zip'],PDO::PARAM_INT);
$status = $putItIn->execute();
$putItIn->closeCursor();

$message = ($status) ? htmlspecialchars("Successfully Added!") : htmlspecialchars("Didn't go through. Try again.");
$_SESSION['account_log'] = $message;
header('Location: accountholder_info.php');
?>