<?php
session_start();
if ($_SESSION['user'] == "")
{
    $_SESSION['login_message'] = htmlspecialchars("Please log in again.");
    header("Location: index.php"); 
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <title>Main Page</title>
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
                        <li><a href="list_item.php">List Item</a></li>
                        <li><a href="logout_confirm.php">Logout</a></li>
                        <li><a href="browse.php">Browse</a></li>
<?php
else:
?>
                        <li><a href="browse.php">Browse (No login required)</a></li>

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
        <div class="jumbotron" style="margin-top:70px">
            <div class="container-fluid" style="padding:10px 20px 10px 20px;text-align:center">
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <span class="glyphicon glyphicon-search" style="font-size:5em;padding-top:10px"></span>
                            <div class="caption">
                                <h3>Browse Listings</h3>
                                <p>See all of our wonderful listings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <span class="glyphicon glyphicon-user" style="font-size:5em;padding-top:10px"></span>
                            <div class="caption">
                                <h3>User Activity</h3>
                                <p>Check on your current bids, your listings, and update your information</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <span class="glyphicon glyphicon-pencil" style="font-size:5em;padding-top:10px"></span>
                            <div class="caption">
                                <h3>List Item</h3>
                                <p>Add a new item to our listings</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="well"></div></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="thumbnail">
                            <span class="glyphicon glyphicon-log-out" style="font-size:5em;padding-top:10px"></span>
                            <div class="caption">
                                <h3>Log out</h3>
                                <p>If you're done or shouldn't be here, log out</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="thumbnail">
                            <span class="glyphicon glyphicon-usd" style="font-size:5em;padding-top:10px"></span>
                            <div class="caption">
                                <h3>Simulate Cron Scheduler</h3>
                                <p>This script will check for any listings that are out of time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!--  <h1>Hello, <?=htmlspecialchars($_SESSION['username'])?>!</h1>
            <p>Some stuff here</p>
            <p><a class="btn btn-warning btn-lg" role="button">Learn more</a></p>
            <span class="glyphicon glyphicon-search" style="font-size:10.2em"></span> -->
            </div>
        </div>
<!--         <div class="centered">
        <h1>Welcome, <?=htmlspecialchars($_SESSION['username'])?>!</h1>
        <p><a href="browse.php">Browse Listings</a></p>
        <p>--or--</p>
        <p><a href="list_item.php">List Item</a></p>
        <p>--or--</p>
        <p><a href="user_activity.php">Your Current Activity</a></p>
        <p>--or--</p>
        <p><a href="logout_confirm.php">Logout</a></p>
        <p>--or--</p>
        <p><a href="reap_winnings.php">Simulate Cron Scheduler</a></p>
        </div> -->
        <div id="footer">
            <div class="container">
                <p class="muted credit">Made by Tyler Corley, with love and a bit of Bootstrap :)  Project for CS 105 taught by <a href="http://www.cs.utexas.edu/~jthywiss/‎">John Thywissen</a></p>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
