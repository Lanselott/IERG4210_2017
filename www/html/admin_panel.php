<?php
        include_once('lib/db.inc.php');
  	include_once('lib/csrf.php');
	include_once('lib/auth.php');	
//	ini_set('display_errors',1);
	$check = auth();
	if(!$check){
		header('Location: login.php');
		exit();
	}
	if($check['id'] != 1)//if not admin user
	{
		header('Refresh:3; Main.php');
    		echo '<b>You are not the Administrator!</b> <br>Redirct to the Main page in 3 seconds...';
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>IERG4210 Calvin Shop - Admin Panel</title>
</head>

<body>
<h1>G Fat's Online Game store - Admin Panel
<h2>Admin User: <?php echo($check['em'])?>
<form id="logout" method="POST" action="auth-process.php?action=logout">
     <input type="submit" value="Logout" />
</form>
<a href="chgpwd.php">I want change my Password</a>
<!--TODO: change password:chgPwd.php -->
</h1>

<article id="main">
<?php
  
?>
<section id="productPanel">
<fieldset>
  <legend>New Product</legend>
  <form id="prod_insert" method="post" action="admin-process.php?action=<?php echo ($action='prod_insert');?>" enctype="multipart/form-data">
    <label for="prod_catid">Category *</label>
    <div>
      <select id="prod_catid" name="catid">
        <?php
	  show_categories(); 
	?>
      </select>
    </div>

    <label for="prod_name">Name *</label>
    <div>
      <input id="prod_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
      <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
    </div>
    <label for="prod_price">Price *</label>
    <div>
      <input id="prod_price" type="text" name="price" required="true"
      pattern="^[0-9]+$"/>
    </div>
    <label for="prod_description">Description *</label>
    <div>
      <input id="prod_description" type="text" name="description" required="true"/>
    </div>
    <label for="prod_name">Image *</label>
    <div>
      <input type="file" name="file" required="true" accept="image/jpeg" />
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>
</section>

<section id="productDeletePanel">
<fieldset>
  <legend>Delete Product</legend>
  <form id="prod_delete" action="admin-process.php?action=<?php echo ($action='prod_delete'); ?>" method="POST" enctype="application/x-www-form-urlencoded">
    <label for="prod_name">Name *</label>
    <div>
      <input id="prod_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
      <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>
</section>

<section id="updateproductPanel">
<fieldset>
  <legend>Update Product</legend>
  <form id="prod_update" action="admin-process.php?action=<?php echo ($action='prod_update');?>" method="POST" enctype="multipart/form-data">
    <label for="prod_catid">Category *</label>
    <div>
      <select id="prod_catid" name="catid">
      <?php 
        show_categories();
      ?>
      </select>
    </div>

    <label for="prod_name">Name *</label>
    <div>
      <input id="prod_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
      <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
    </div>
    <label for="prod_price">Price *</label>
    <div>
      <input id="prod_price" type="text" name="price" required="true"
      pattern="^[0-9]+$"/>
    </div>
    <label for="prod_description">Description *</label>
    <div>
      <input id="prod_description" type="text" name="description" required="true"/>
    </div>
    <label for="prod_name">Image *</label>
    <div>
      <input type="file" name="file" accept="image/jpeg" />
    </div>
    <input type="hidden" id="prod_edit_pid" name="pid" />
    <input type="submit" value="Submit" />

  </form>
</fieldset>
</section>

<section id="categoryrenamePanel">
<fieldset>
  <legend>Rename categories</legend>
  <form id="cate_rename" action="admin-process.php?action=<?php echo ($action='cate_rename');?>" method="POST" enctype="application/x-www-form-urlencoded">
    <label for="cate_catid">Old Name *</label>
    <div>
      <input id="cate_oldname" type="text" name="oldname" required="true"
      pattern="^[\w\- ]+$"/>
      <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
    </div>

    <label for="cate_newname">New Name *</label>
    <div>
      <input id="cate_newname" type="text" name="newname" required="true"
      pattern="^[\w\- ]+$"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>
</section>

<section id="addcategoriesPanel">
<fieldset>
  <legend>Add categories</legend>
  <form id="cate_add" action="admin-process.php?action=<?php echo ($action='cate_add');?>" method="POST"
  enctype="application/x-www-form-urlencoded">

    <label for="cate_newname">Name *</label>
    <div>
      <input id="cate_newname" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
      <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>
</section>

<section id="deleteCatPanel">
<fieldset>
  <legend>Delete categories</legend>
  <form id="cate_delete" action="admin-process.php?action=<?php echo ($action='cate_delete');?>" method="POST"
  enctype="application/x-www-form-urlencoded">
    <label for="cate_catid">Category *</label>
    <div>
      <input id="cate_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
      <input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>
</section>
</article>
<?php
function show_categories() {
         $db = ierg4210_DB();
	foreach($db ->query('SELECT catid,name FROM categories') as $row)
	{
	    unset($catid,$name);
            $catid = $row['catid'];
            $name = $row['name'];
            echo '<option value="'.$catid.'">'.$name.'</option>';
	} 
}
?>
<section id="txnTable">
<fieldset style="width:900px">
<legend>Lastest 50 Transaction Records</legend>
<table>
<tr><th width="70">Order ID</th><th width="400">Digest</th><th width="200">Salt</th><th width="200">Transaction ID</th></tr>
<?php
$db = new PDO('sqlite:/var/www/orders.db');
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$q=$db->prepare('SELECT * FROM orderlist ORDER BY oid DESC LIMIT 50');
	if ($q->execute()){
		$OrderRecord=$q->fetchAll();}
	foreach($OrderRecord as $Rcd){
		?><tr><th width="70"><?php echo $Rcd['oid'];?></th><th width="400"><?php echo $Rcd['digest'];?></th><th width="200"><?php echo $Rcd['salt'];?></th><th width="200"><?php echo $Rcd['pay'];?></th></tr><?php
	}
?>
</table>
</fieldset>
</section>
