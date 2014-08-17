<?php
session_start();
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('HTTP/1.1 403 Forbidden: TLS Required');
    // Optionally output an error page here
    exit(1);
}
require('/u/tcorley/openZdatabase.php');
$placeBid = $database->prepare('
	DELETE FROM PAYMENT WHERE PAYMENT_ID = :id;
	');

$placeBid->bindValue(':id',$_REQUEST['id'],PDO::PARAM_INT);
$status = $placeBid->execute();
$placeBid->closeCursor();

$message = ($status) ? htmlspecialchars("Card removed.") : htmlspecialchars("Card not removed.");
$_SESSION['account_log'] = $message;
header('Location: accountholder_info.php');
?>