<?php
session_start();
if (!isset($_SESSION['user']))
{
    $_SESSION['login_message'] = htmlspecialchars("You need to log in before you can list an item!");
    header('Location: index.php');
}
require('../openZdatabase.php');
$categoriesQuery = $database->prepare('
    SELECT
        ITEM_CATEGORY_ID,
        NAME
        FROM ITEM_CATEGORY;
    ');
$categoriesQuery->execute();
$categories = $categoriesQuery->fetchAll();
$categoriesQuery->closeCursor();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="script.js"></script>
        <title>List Item</title>
    </head>
    <body>
         <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Longhorn Auction</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
<?php
if (isset($_SESSION['user']) && !empty($_SESSION['user'])):
?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="browse.php">Browse</a></li>
                                <li><a href="list_item.php">List Item</a></li>
                                <li><a href="user_activity.php">Your Current Activity</a></li>
                                <li><a href="logout_confirm.php">Logout</a></li>
                                <li class="divider"></li>
                                <li><a href="reap_winnings.php">Simulate Cron Scheduler</a></li>
                            </ul>
                        </li>
                        <li><a href="list_item.php">List Item</a></li>
                        <li><a href="logout_confirm.php">Logout</a></li>
<?php
else:
?>
                        <li><a href="index.php">Login</a></li>

<?php
endif;
?>
                    </ul>
<?php
if (isset($_SESSION['user']) && !empty($_SESSION['user'])):
?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a>You are <?=htmlspecialchars($_SESSION['username'])?> for this session :)</a></li>
                    </ul>
<?php
endif;
?>
                </div>
            </div>
        </div>
        <div class="centered">
        <h1>List Item</h1>
 <?php
if ($_SESSION['list_message']):
?>
            <p class="warning"><?=htmlspecialchars($_SESSION['list_message'])?></p>
<?php
unset($_SESSION['list_message']);
endif;
?>       
        <form enctype="multipart/form-data" action="list_action.php" method="post">
        <table border="1">
            <tr>
                <td>Item name: </td>
                <td><input type="text" required="required" name="item_name"/></td>
            </tr>
            <tr>
            <!-- from class -->
                <td>Category: </td>
                <td><select name="category" required="required">
<?php
foreach ($categories as $currCat):
?>
            <option value="<?=htmlspecialchars($currCat['ITEM_CATEGORY_ID'])?>"><?=htmlspecialchars($currCat['NAME'])?></option>
<?php
endforeach;
?>
        </select></td>
            </tr>
            <tr>
                <td>Description: </td>
                <td><textarea name="description" cols="25" rows="5" required="required" placeholder="Be descriptive!"></textarea></td>
            </tr>
            <tr>
                <td>Auction Duration:</td>
                <td><select name="duration" required="required">
                    <option value="1">1 day</option>
                    <option value="3">3 days</option>
                    <option value="5">5 days</option>
                    <option value="7">7 days</option>
                    <option value="10">10 days</option>
                </select></td>
            </tr>
            <tr>
                <td>Photo(2MB max): </td>
                <td><input type="file" name="photo" required="required" accept="image/jpeg"/><br/></td>
            </tr>
        </table>
            <input type="submit" value="list item!"/>
        </form>
        </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit">Made by Tyler Corley, with love and a bit of Bootstrap :)  Project for CS 105 taught by <a href="http://www.cs.utexas.edu/~jthywiss/‎">John Thywissen</a></p>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
