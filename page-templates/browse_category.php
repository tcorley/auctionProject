<?php
require('/u/tcorley/openZdatabase.php');
session_start();
$openAuctionQuery = $database->prepare('
    SELECT
        A.AUCTION_ID,
        A.STATUS,
        A.OPEN_TIME,
        A.CLOSE_TIME,
        A.ITEM_DESCRIPTION,
        CONCAT(
            FLOOR(HOUR(TIMEDIFF(A.CLOSE_TIME, NOW())) / 24), " days ",
            MOD(HOUR(TIMEDIFF(A.CLOSE_TIME, NOW())), 24), " hours ",
            MINUTE(TIMEDIFF(A.CLOSE_TIME, NOW())), " minutes") AS TIME_LEFT,
        C.NAME AS ITEM_CATEGORY,
        A.ITEM_CAPTION,
        A.ITEM_PHOTO,
        (
            SELECT 
                MAX(AMOUNT)
            FROM BID
                JOIN AUCTION ON AUCTION_ID = AUCTION
            WHERE AUCTION = A.AUCTION_ID
        ) AS BID_AMOUNT
    FROM AUCTION A
        JOIN ITEM_CATEGORY C ON A.ITEM_CATEGORY = C.ITEM_CATEGORY_ID
    WHERE A.STATUS = 1 AND ITEM_CATEGORY = :browseCategory;
    ');
$thisBrowseCat = $_POST['category'];
$openAuctionQuery->bindValue(':browseCategory', $thisBrowseCat, PDO::PARAM_INT);
$openAuctionQuery->execute();
$thisAuction = $openAuctionQuery->fetchAll();
$openAuctionQuery->closeCursor();
//from class
$categoriesQuery = $database->prepare('
    SELECT
        ITEM_CATEGORY_ID,
        NAME
        FROM ITEM_CATEGORY;
    ');
$categoriesQuery->execute();
$categories = $categoriesQuery->fetchAll();
$categoriesQuery->closeCursor();

$elementsToDisplay = 20;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
                <script src="script.js"></script>
        <title>Browse <?=htmlspecialchars($categories[$thisBrowseCat-1]['NAME'])?> Listings</title>
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
            <h1>Browse <?=htmlspecialchars($categories[$thisBrowseCat-1]['NAME'])?> Listings</h1>
                <p class="right">Displaying <?=count($thisAuction)?> out of <?=count($thisAuction)?> results</p>
            <div class="browse_bar">
            <form action="browse_category.php" method="post">
            <table>
                <tr>
                    <td>Browse by Category: </td>
                    <td><select name="category">
<?php
foreach ($categories as $category):
?>
                     <option value="<?=$category['ITEM_CATEGORY_ID']?>"><?=htmlspecialchars($category['NAME'])?></option>
<?php
endforeach;
?>  
                </select></td>
                <td><input type="submit" value="Go"/></td>
                </tr>
            </table>
            </div>
        </div>
                 <!-- <a href="item.php"><img class="item_pic" alt="generic image" src="http://www.c4gallery.com/artist/bale-allen-tumbleweeds/bale-creek-allen-tumbleweed-4.jpg"/></a> -->
    <div class="content">
<?php
if (!count($thisAuction)):
?>
        <h3>No items to display in <?=htmlspecialchars($categories[$thisBrowseCat-1]['NAME'])?></h3>
<?php
endif;
?>

<?php
foreach ($thisAuction as $element):
?>

    <div class="item_default">
        <a href="item.php?id=<?=$element['AUCTION_ID']?>"><img class="item_pic" alt="<?=htmlspecialchars($element['ITEM_CAPTION'])?>" src="image.php?photoId=<?=$element['AUCTION_ID']?>"/></a>
        <p>
            <a href="item.php?id=<?=$element['AUCTION_ID']?>"><?=htmlspecialchars($element['ITEM_CAPTION'])?></a><br/>
            Current price: <?=htmlspecialchars(($element['BID_AMOUNT']) ? '$' . $element['BID_AMOUNT'] : 'No bids yet')?><br/>
            Category: <?=htmlspecialchars($element['ITEM_CATEGORY'])?><br/>
            Auction Start: <?=htmlspecialchars($element['OPEN_TIME'])?><br/>
            Time Left: <?=htmlspecialchars($element['TIME_LEFT'])?><br/>
        </p>
        <p id="<?=$element['AUCTION_ID']?>" style="display:none;">
            <?=htmlspecialchars($element['ITEM_DESCRIPTION'])?>
        </p>
<?php
$id = $element['AUCTION_ID'];
$fullText = htmlspecialchars($element['ITEM_DESCRIPTION']);
    echo "<button type=\"button\" onclick=\"toggleContent('".$id."','".$fullText."')\">More/Less Info</button>";
?>
    </div>

<?php
endforeach;
?>

        </div>
        <div class="page_nav">
            <nav>
<?php
if (count($thisAuction) > $elementsToDisplay):
?>
                <!-- I'll eventually implement this -->
                <a href="browse.php">Next Page</a>
<?
endif;
?>
            </nav>
        </div>
    </body>
</html>
