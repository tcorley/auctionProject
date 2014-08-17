<?php
session_start();
require('/u/tcorley/openZdatabase.php');
$openAuctionQuery = $database->prepare('
    SELECT
        A.AUCTION_ID,
        A.STATUS,
        A.SELLER AS ITEM_OWNER,
        CONCAT(P.FORENAME, \' \', P.SURNAME) AS SELLER,
        A.OPEN_TIME,
        A.CLOSE_TIME,
        CONCAT(
            FLOOR(HOUR(TIMEDIFF(A.CLOSE_TIME, NOW())) / 24), " days ",
            MOD(HOUR(TIMEDIFF(A.CLOSE_TIME, NOW())), 24), " hours ",
            MINUTE(TIMEDIFF(A.CLOSE_TIME, NOW())), " minutes") AS TIME_LEFT,
        C.NAME AS ITEM_CATEGORY,
        A.ITEM_CAPTION,
        A.ITEM_DESCRIPTION,
        A.ITEM_PHOTO
        FROM AUCTION A
            JOIN ITEM_CATEGORY C ON A.ITEM_CATEGORY = C.ITEM_CATEGORY_ID
            JOIN PERSON P ON A.SELLER = P.PERSON_ID
        WHERE A.AUCTION_ID = :auctionId;
    ');
$thisAuctionId = $_POST['id'];
$openAuctionQuery->bindValue(':auctionId', $thisAuctionId, PDO::PARAM_INT);
$openAuctionQuery->execute();
$thisAuction = $openAuctionQuery->fetch();
$openAuctionQuery->closeCursor();
$checkHighestBid = $database->prepare('
    SELECT AMOUNT, BIDDER, BID_ID
    FROM BID
    WHERE AMOUNT = (
        SELECT MAX(AMOUNT)
        FROM BID
        WHERE AUCTION = :auctionId
        );
    ');
$checkHighestBid->bindValue(':auctionId', $thisAuctionId, PDO::PARAM_INT);
$checkHighestBid->execute();
$highBidder = $checkHighestBid->fetch();
$user = $_SESSION['user'];
$bidAmount = ($highBidder['AMOUNT']) ? '$' . $highBidder['AMOUNT'] : 'No bids yet';
$getPayment = $database->prepare('
    SELECT
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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Pay for Item</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
        <script src="script.js"></script>
    </head>
    <body>
        <ul class="navbar">
            <li><a href="javascript:toggleMenu();">v Menu v</a></li>
            <li><a href="browse.php">Browse</a></li>
            <li><a href="list_item.php">List Item</a></li>
<?php
if (isset($_SESSION['user']) && !empty($_SESSION['user'])):
?>
            <li><a href="logout_confirm.php">Logout</a></li>
            <li class="go_right">You are <?=htmlspecialchars($_SESSION['username'])?> for this session :)</li>
<?php
endif;
?>
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
        <div class="content">
        <h1>Pay for Item</h1>
         <div class="item_other">
                <img class="item_pic" alt="<?=htmlspecialchars($thisAuction['ITEM_CAPTION'])?>" src="image.php?photoId=<?=$thisAuction['AUCTION_ID']?>"/>
                <p>
                    <strong><?=htmlspecialchars($thisAuction['ITEM_CAPTION'])?></strong><br/>
                    <strong>Current price: </strong><?=htmlspecialchars($bidAmount)?><br/>
                    <strong>Seller: </strong><?=htmlspecialchars($thisAuction['SELLER'])?><br/>
                </p>
            </div>
<?php
if ($payments):
?>
        <form action="pay_action.php" method="post">
            <select name="payment_method">
<?php
foreach ($payments as $payment):
?>
            <option value="Doesn't Matter"><?=htmlspecialchars($payment['CARD']).'-'.htmlspecialchars($payment['LAST_FOUR'])?></option>
<?php
endforeach;
?>
            </select>
            <input type="hidden" name="id" value="<?=htmlspecialchars($thisAuctionId)?>"/>
            <input type="submit" value="Submit"/>
        </form>
<?php
else:
?>
        <p>You don't have any form of payment <a href="accountholder_info.php">Add one here</a></p>
<?php
endif;
?>
        </div>
    </body>
</html>
