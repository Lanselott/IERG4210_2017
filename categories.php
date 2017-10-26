<!DOCTYPE html>
<html>
<?php
	include_once('lib/db.inc.php');
	ini_set('display_errors',1);
	$db = ierg4210_DB();
	$q = $db->prepare("SELECT * FROM categories LIMIT 100;");
	$q->execute();
	$cat = $q->fetchAll();
//	if(!preg_match('/^\d*$/',$_GET['pid'])){header('Location: Main.php'); exit();}
//	if (!preg_match('/^\d*$/', $_GET['pid'])||(int)$_GET['pid']==0)
//		{header('Location: Main.php'); exit();}
	if(!isset($_GET['catid'])){header('Location: Main.php');exit();}
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
    #product{
      width:40%;
      float:left;
      padding:10px;
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
  <a href="Main.php">Home>></a> 
  <?php if ($_GET['catid'])
	{
	echo $cat[(int)$_GET['catid']-1]['name'];
	}
	else{
	echo 'Please select a category';
	}
  ?>
</div>
<!--Shopping Cart -->
<style>
  #shopping-list ul li ul li{display: none;}
  #shopping-list ul li:hover ul li {display: block;background-color: green;}
</style>
<!--Hover-->
Shopping cart HK $<span id="Total">0.0</span>
<div id="shopping-list">
 <ul>
    <li>Shopping Cart
      <ul>
        <li>
          <a href="#">
            <button type="button" name="checkout">Checkout</button>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>

  <!--List of Product-->
<ul id="product">
<?php 
	if (!preg_match('/^\d*$/', $_GET['catid']))
		{
		  header('Location: Main.php'); 
		exit();}
	if ($_GET['catid'])
	{$q2 = $db->prepare("SELECT * FROM products WHERE catid = ?;");
	$q2->execute(array((int)$_GET['catid']));
	$prod = $q2->fetchAll();
	if (!$prod) {
		  header('Location: Main.php');
		 exit();}
	for ($i=0;$i<sizeof($prod);$i++){
?>
	<li>
		<a href="product/Adventure_product1.php?pid=<?php echo $prod[$i]['pid']?>"><img src="include/img/<?php echo $prod[$i]['pid']?>.jpg" width="33%"/></a>
		<div class="product-title">
			<?php echo $prod[$i]['name']  ?>
		</div>
	<button type="button" name="addToCart" onclick="ui.cart.add(<?php echo $prod[$i]['pid']?>)">Buy it NOW</button>
	</li>

<?php
	}}
?>
</ul>
<script type="text/javascript" src="include/myLib.js"></script>
<script type="text/javascript" src="include/ui.js"></script>
</body>
</html>
