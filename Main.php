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
Shopping cart HK $<span id="Total">0.0</span>
<ul id="shopping-list"></ul>

</div>

<div id="welcome-homepage">
  Welcome to IERG 4210's Online store!
  Website is under construction now +.+
  <img src="G_fat.jpg" alt="G_fat_evil">
</div>

<script type="text/javascript" src="include/myLib.js"></script>
<script type="text/javascript" src="include/ui.js"></script>


</body>
</html>
