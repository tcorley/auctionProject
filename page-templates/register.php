<?php session_start(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="script.js"></script>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <title>Create Account</title>
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
        <div class="centered">
        <h1>Create an Account</h1>
<?php
if ($_SESSION['errorarray']):
?>
            <p class="warning">Please fix the following error(s):</p>
<?php
foreach ($_SESSION['errorarray'] as $error):
?>
            <p class="warning"><?=htmlspecialchars($error)?></p>
<?php
endforeach;
?>

<?php
unset($_SESSION['errorarray']);
endif;
?>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <form name="registerForm" action="register_action.php" method="post">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="username" placeholder="Email" required>
                            <span class="input-group-addon info"><span class="glyphicon glyphicon-remove"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first">First Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="first" id="validate-text" placeholder="First Name" required>
                            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last">Last Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="last" id="validate-text" placeholder="Last Name" required>
                            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first">First Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="first" id="validate-text" placeholder="First Name" required>
                            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first">First Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="first" id="validate-text" placeholder="First Name" required>
                            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                        </div>
                    </div>
                    <input type="checkbox" name="TOC"/>I have read and agree to the <a href="tac.php">Terms and Conditions</a>
                    <input class="btn btn-lg btn-success btn-block" type="submit" value="Register!"/>
                </form>
            </div>
        </div>
        <!-- <form name="registerForm" action="register_action.php" onsubmit="return validateRegister();" method="post">
            <table border="1">
                <tr>
                    <td>Email:  </td>
                    <td><input type="text" required="required" name="username"/></td>
                </tr>
                <tr>
                    <td>First Name: </td>
                    <td><input type="text" required="required" name="first"/></td>
                </tr>
                <tr>
                    <td>Last Name: </td>
                    <td><input type="text" required="required" name="last"/></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" required="required" name="pwd"/></td>
                </tr>
                <tr>
                    <td>Retype Password:</td>
                    <td><input type="password" required="required" name="pwd_confirm"/></td>
                </tr>
            </table>
            <input type="checkbox" name="TOC"/>I have read and agree to the <a href="tac.php">Terms and Conditions</a><br/> 
            <input type="submit" value="Register!"/>
        </form> -->
        </div>
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
