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
    	<div id="wrap" style="margin-top:100px;text-align:center;margin-left:100px">

<?php
for ($i = 0; $i < 10; $i++):
?>


    	<div class="row">

<?php
for ($j = 0; $j < 3; $j++):
?>
    		<div class="col-xs-18 col-sm-6 col-md-3">
    			<div class="panel panel-default" style="border: 2px solid black">
            		<p><a href="item.php?id=<?=$element['AUCTION_ID']?>"><?=htmlspecialchars($element['ITEM_CAPTION'])?></a><br/>
            		Current price: <?=htmlspecialchars(($element['BID_AMOUNT']) ? '$' . $element['BID_AMOUNT'] : 'No bids yet')?><br/>
            		Category: <?=htmlspecialchars($element['ITEM_CATEGORY'])?><br/>
            		Auction Start: <?=htmlspecialchars($element['OPEN_TIME'])?><br/>
            		Time Left: <?=htmlspecialchars($element['TIME_LEFT'])?><br/>
        			</p>
        			<p id="<?=$element['AUCTION_ID']?>" style="display:none;">
            			<?=htmlspecialchars($element['ITEM_DESCRIPTION'])?>
            			someethingsomethign
       				</p>
       				<button class="btn" type="button" onclick="toggleContent(<?=$element['AUCTION_ID']?>,<?=htmlspecialchars($element['ITEM_DESCRIPTION'])?>)"><span class="glyphicon glyphicon-search"></span> More/Less Info</button>
    			</div>
    		</div>
<?php
endfor;
?>
    	</div>
<?php
endfor;
?>
			<div id="push"></div>
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