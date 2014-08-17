<?php session_start(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="script.js"></script>
        <title>Login</title>
	    <meta charset="utf-8"/>
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
    <!--     <div id="wrap" class="text-center">
  <br>
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Modal with blur effect
</button>
</div> -->
<?php
if ($_SESSION['login_message']):
?>
            <!-- awesome blur modal for warnings (need to work on this) -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labeledby="myModalLabel" aria-hidden="true">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 text-center">
                            <h1><?=htmlspecialchars($_SESSION['login_message'])?></h1>
                            <div class="alert alert-info"><h4><kbd>esc</kbd> or click to close</h4></div>
                        </div>
                    </div>
                </div>
            </div>
            
<?php
unset($_SESSION['login_message']);
endif;
?>
        <div class="container login">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Please Login</strong></h3>
                        </div>
                        <div class="panel-body">
                            <form accept-charset="UTF-8" role="form" name="loginform" action="login.php" method="post" onsubmit="return validateLogin();">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" type="text" name="username"/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" type="password" name="pwd"/>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"/> Remember Me
                                    </label>
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login!"/>
                                <p style"text-align:center">No account? Register <a href="register.php">here</a>.</p>
                            </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer">
            <div class="container">
                <p class="muted credit">Made by Tyler Corley, with love and a bit of Bootstrap :)  Project for CS 105 taught by <a href="http://www.cs.utexas.edu/~jthywiss/‎">John Thywissen</a></p>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>

