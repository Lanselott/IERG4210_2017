<!DOCTYPE html>
<html>
<?php
        include_once('lib/db.inc.php');
        ini_set('display_errors',1);
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
  #shopping-list ul li ul li{display: none;}
  #shopping-list ul li:hover ul li {display: block;background-color: green;}
</style>
<!--Hover-->
<div id="shopping-list">
  <ul>
    <li>Shopping Cart
      <ul>
        <li>
          <a href="#">Buy1</a>
          <input type="number" name="quantity" min="1" max="5">
        </li>
        <li>
          <a href="#">Buy2</a>
          <input type="number" name="quantity" min="1" max="5">
        </li>
        <li>
          <a href="#">Buy3</a>
          <input type="number" name="quantity" min="1" max="5">
        </li>
        <li>
          <a href="#">
            <button type="button" name="checkout">Checkout</button>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>
<div id="welcome-homepage">
  Welcome to IERG 4130's Online store!
  Website is under construction now +.+
  <img src="G_fat.jpg" alt="G_fat_evil">
</div>




</body>
</html>
