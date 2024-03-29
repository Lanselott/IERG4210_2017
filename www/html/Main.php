<!DOCTYPE html>
<html>
<?php
	include_once('lib/auth.php');
	include_once('lib/csrf.php');
        include_once('lib/db.inc.php');
        ini_set('display_errors',1);
     
	$check = auth();
//	if(!$check){
//		header('Location: login.php');
//		exit();
//	}

   	$db = ierg4210_DB();
        $q = $db->prepare("SELECT * FROM categories LIMIT 100;");
        $q->execute();
        $cat = $q->fetchAll();
?>
  <head>
    <script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>IERG4210 online store</title>
    <style media="screen">
    #header{
      background-color: black;
      color:white;
      text-align: center;
      padding:5px;
    }
    #nav{
      line-height: 30px;
      background: #eeeeee;
      width:25%;
      float:left;
      padding: 5px;
    }
    #menu{
      height: 45px;
      padding: 2px;
      background-color: burlywood;
      width: 35%;
      float:left;
    }
    #shopping-list{
      position: absolute;
      right:8px;
      background-color: grey;
      text-align: right;
      width: auto;
      height: 45px;
      float:right;
      padding: 2px;
      z-index: 5;
    }
    #welcome-homepage{
      width:40%;
      float:left;
      padding:10px;
      text-align: middle;
    }
    #shopping-cart{
      position: absolute;
      right:8px;
    }

    </style>
  </head>

<body>
  <!---Show LOGO Here-->
<div id="header">
    <h1>G fat's Steam Store</h1>
</div>

  <!--List of categories-->
    <style>
      ul.categories{width:40%; height:auto;
               float:left; margin:10px; padding:10px; list-style:none;
               overflow: auto;}
      ul.categories li{width:100%; height:auto;
               float: left; border:2px; solid #111}
    .clear{clear: both;}
    </style>

<div id="nav">
  <ul class="categories">
        <?php for ($i = 0;$i<sizeof($cat);$i++) { ?>
        <?php
                echo '<li>';
        ?>
                <a href="categories.php?catid=<?php echo $cat[$i]['catid'];?>">
        <?php
                echo $cat[$i]['name'];echo '</a>';
                echo '</li>';
        }
        ?>
  </ul>
<div class="fb-page" data-href="https://www.facebook.com/CUHKofficial/" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/CUHKofficial/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/CUHKofficial/">The Chinese University of Hong Kong 香港中文大學 - CUHK</a></blockquote></div>
</div>
<div id="menu">
  You are at:
  <a href="Main.php">Home</a>
</div>
<!--Shopping Cart -->
<style>
   #shopping-list li {display: none;}
   #shopping-cart:hover ul li{display:block; background-color: green;}
</style>

<?php
if($check){ ?>
	<form id="logout" method="POST" action="auth-process.php?action=logout">
        <input type="submit" value="Logout" />
        </form>
	<ul>Welcome! <?php echo ($check['em']); ?></ul>
<?php } 
else{ ?>
	<a href="login.php">login in</a>
<?php } ?>	


<div id="shopping-cart">
<?php
if($check){?>
	Shopping cart HK $<span id="Total">0.0</span>
	<form method="POST" action="https://www.sandbox.paypal.com/cgi-bin/webscr" onsubmit="return ui.cart.submit(this)">
		<ul id="shopping-list"></ul>
		<input type="hidden" name="cmd" value="_cart" />
		<input type="hidden" name="upload" value="1" />
		<input type="hidden" name="business" value="497653881-facilitator@qq.com" />
		<input type="hidden" name="currency_code" value="HKD" />
		<input type="hidden" name="charset" value="utf-8" />
		<input type="hidden" name="custom" value="0" />
		<input type="hidden" name="invoice" value="0" />
		<input type="submit" value="Checkout" />
	</form>
<?php } ?>
</div>

<div id="welcome-homepage">
  Welcome to IERG 4210's Online store!
  Website is under construction now +.+
  <img src="G_fat.jpg" alt="G_fat_evil">
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v2.11';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript" src="include/myLib.js"></script>
<script type="text/javascript" src="include/ui.js"></script>


</body>
</html>
