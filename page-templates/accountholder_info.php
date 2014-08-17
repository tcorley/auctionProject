<?php
session_start();
require('/u/tcorley/openZdatabase.php');
if (!isset($_SESSION['user']))
{
    $_SESSION['login_message'] = htmlspecialchars("You need to log in before you can do that!");
    header('Location: index.php');
}
$getPayment = $database->prepare('
	SELECT
        P.PAYMENT_ID, 
		P.EXPIRATION_DATE,
		C.CC_TYPE AS CARD,
		P.LAST_FOUR
		FROM PAYMENT P
		JOIN CC_COMPANY C ON P.CARD_TYPE = C.CARD_ID
		WHERE P.CARD_OWNER = :user;
	');
$getPayment->bindValue(':user',$_SESSION['user'],PDO::PARAM_INT);
$getPayment->execute();
$payments = $getPayment->fetchAll();
$getPayment->closeCursor();
$getCards = $database->prepare('
    SELECT
        CARD_ID,
        CC_TYPE
    FROM CC_COMPANY;
    ');
$getCards->execute();
$cards = $getCards->fetchAll();
$getCards->closeCursor();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Account Holder Information</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
        <script src="script.js"></script>
    </head>
    <body>
    	<ul class="navbar">
            <li><a href="javascript:toggleMenu();">v Menu v</a></li>
            <li><a href="browse.php">Browse</a></li>
            <li><a href="list_item.php">List Item</a></li>
            <li><a href="logout_confirm.php">Logout</a></li>
            <li class="go_right">You are <?=htmlspecialchars($_SESSION['username'])?> for this session :)</li>
        </ul>
                <div id="userSideMenu" style="display:none;">
            <h1><?=htmlspecialchars($_SESSION['username'])?></h1>
            <p><a href="browse.php">Browse Listings</a></p>
            <p>--or--</p>
            <p><a href="list_item.php">List Item</a></p>
            <p>--or--</p>
            <p><a href="user_activity.php">Your Current Activity</a></p>
            <p>--or--</p>
            <p><a href="logout_confirm.php">Logout</a></p>
            <p>--or--</p>
            <p><a href="reap_winnings.php">Simulate Cron Scheduler</a></p>
        </div>
        <h1>Your Account Info</h1>
        <div class="content">
        	<h3>Your Payment Method(s):</h3>
<?php
if(isset($_SESSION['account_log'])):
?>
        <p><?=htmlspecialchars($_SESSION['account_log'])?></p>
<?php
unset($_SESSION['account_log']);
endif
?>

<?php
if (sizeof($payments)):
?>
            <table class="payment">
                <tr>
                    <th>Card Number</th>
                    <th>Card Type</th>
                    <th>Expiration Date</th>
                    <th>Remove Payment</th>
                </tr>
<?php
foreach ($payments as $payment):
?>
            <tr>
                <td>XXXX-XXXX-XXXX-<?=htmlspecialchars($payment['LAST_FOUR'])?></td>
                <td><?=htmlspecialchars($payment['CARD'])?></td>
                <td><?=htmlspecialchars($payment['EXPIRATION_DATE'])?></td>
                <td><a href="remove_payment.php?id=<?=htmlspecialchars($payment['PAYMENT_ID'])?>">Remove</a></td>
            <tr>
<?php
endforeach;
?>
        </table>
<?php
else:
?>
        <p>None yet</p>
<?php
endif;
?>

        <h3>Add New Payment</h3>
        <form action="add_payment.php" method="post">
        <table class="payment">
            <tr>
                <td>Name on Card</td>
                <td><input type="text" name="dontCare" required="required"/></td>
            </tr>
            <tr>
                <td>Expiration Date</td>
                <td><select name="whatever">
                        <option value="1">In the future</option>
                    </select></td>
            </tr>
            <tr>
                <td>Card Type</td>
                <td><select name="card">
<?php
foreach ($cards as $card):
?>
                     <option value="<?=$card['CARD_ID']?>"><?=htmlspecialchars($card['CC_TYPE'])?></option>
<?php
endforeach;
?>     
                    </select></td>
            </tr>
            <tr>
                <td>Card Number(just 16 random digits is fine)</td>
                <td><input type="number" name="cardno" required="required"/></td>
            </tr>
            <tr>
                <td>Billing Address</td>
                <td><input type="text" name="address" required="required"/></td>
            </tr>
            <tr>
                <td>Billing City</td>
                <td><input type="text" name="city" required="required"/></td>
            </tr>
            <tr>
                <td>Billing State(two letters)</td>
                <td><input type="text" name="state" required="required"/></td>
            </tr>
            <tr>
                <td>Billing Zip</td>
                <td><input type="number" name="zip" required="required"/></td>
            </tr>
        </table>
        <input type="submit" value="Add payment"/>
        </form>
    	</div>
    </body>
</html>