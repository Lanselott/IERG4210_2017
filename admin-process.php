<?php
include_once('lib/csrf.phg');
include_once('lib/auth.php');
include_once('lib/db.inc.php');

if(!auth())
{
	header('Location:login.php');
	exit();
}
//error_reporting(E_ALL | E_STRICT);
ini_set('display_errors',1);

function ierg_prod_insert() {
  //input validation or santization
  if(!preg_match('/^[\w\- ]+$/', $_POST['name']))
    throw new Exception("invalid-name");

  if(!preg_match('/^[0-9]+$/', $_POST['price']))
    throw new Execption("invalid-price");
  if (!preg_match('/^\d*$/', $_POST['catid']))
    throw new Exception("invalid-catid");
       $_POST['catid'] = (int) $_POST['catid'];
  if (!preg_match('/^[\w\- ]+$/', $_POST['description']))
    throw new Exception("invalid-description");
 
//DB manipulation
  global $db;
  $db = ierg4210_DB();
  $sql = "INSERT INTO products (catid, name, price, description) VALUES (?,?,?,?)";
  $q = $db->prepare($sql);
  
  if($_FILES["file"]["error"] == 0 && $_FILES["file"]["type"] == "image/jpeg"
         && mime_content_type($_FILES["file"]["tmp_name"]) == "image/jpeg"
         && $_FILES["file"]["size"] < 1000000)
  { 		
    $q->execute(array($_POST['catid'],$_POST['name'],$_POST['price'],$_POST['description']));
    $lastId = $db->lastInsertId();
    //current user is apache*
    if(move_uploaded_file($_FILES["file"]["tmp_name"],"include/img/" . $lastId . ".jpg")){
      //header(....)   redirect to orginal page
      exit();
    }
    
  }
 // $dir = '/var/www/cart.db';
 // $db = new PDO('cart.db') or die("cannot open the database");
 // $q = $db->prepare("INSERT INTO products (name) VALUES (?)");
  echo htmlspecialchars($_POST['name']);
  return $q->execute(array($_POST['name']));
  echo "ALOHA";
}

function ierg_prod_delete() {
   if(!preg_match('/^[\w\-, ]+$/',$_POST['name']))
     throw new Exception("invalid-name");
  //DB
  global $db;
  $db = ierg4210_DB();
  $sql = "DELETE FROM products WHERE catid = ?";
  $q = $db->prepare($sql);

  return $q->execute(array($_POST['catid']));
}

function ierg_prod_update() {
	global $db;
	$db = ierg4210_DB();
	
	if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
		throw new Exception("invalid-name");
	if (!preg_match('/^\d*$/', $_POST['catid']))
		throw new Exception("invalid-catid");
	$_POST['catid'] = (int) $_POST['catid'];
	if (!preg_match('/^[\d\.]+$/', $_POST['price']))
		throw new Exception("invalid-price");
	if (!preg_match('/^[\w\- ]+$/', $_POST['description']))
		throw new Exception("invalid-textt");
	if (!preg_match('/^\d*$/', $_POST['pid']))
		throw new Exception("invalid-pid");
	$_POST['pid'] = (int) $_POST['pid'];
       //TODO:udapte connection with pid 	
	$sql="UPDATE products SET name = ?,catid = ?,price = ?,description = ? WHERE pid = ?";
	$q = $db->prepare($sql);
	$q->execute(array($_POST['name'], $_POST['catid'],$_POST['price'], $_POST['description'],$_POST['pid']));
	
	if ($_FILES["file"]["error"] == 0
		&& $_FILES["file"]["type"] == "image/jpeg"
		&& mime_content_type($_FILES["file"]["tmp_name"]) == "image/jpeg"
		&& $_FILES["file"]["size"] < 1000000) {
			
		if (move_uploaded_file($_FILES["file"]["tmp_name"], "include/img/" . $_POST['pid'] . ".jpg")) {
			//header('Location: admin_panel.php');
			exit();
		}
	}elseif ($_FILES["file"]["size"]==0){
		//no file
		//header('Location: admin_panel.php');
		exit();
	}else {
		//header('Content-Type: text/html; charset=utf-8');
		//echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
		exit();
	}
}

function ierg_cate_rename() {
	global $db;
        $db = ierg4210_DB();

        if (!preg_match('/^[\w\- ]+$/', $_POST['oldname']))
                throw new Exception("invalid-name");
        if (!preg_match('/^[\w\- ]+$/', $_POST['newname']))
		throw new Exception("invalid-name");
	
	$sql="UPDATE categories SET name = ? WHERE name = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_POST['newname'],$_POST['oldname']));
}

function ierg_cate_add() {
	global $db;
	$db = ierg4210_DB();

        if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
                throw new Exception("invalid-name");

	$sql="INSERT INTO categories (name) VALUES (?)";
        $q = $db->prepare($sql);
        $q->execute(array($_POST['name']));
}

function ierg_cate_delete() {
	global $db;
	$db = ierg4210_DB();

	$sql="DELETE FROM categories WHERE name = (?)";
        $q = $db->prepare($sql);
        $q->execute(array($_POST['name']));
}
//ierg_cate_delete();



//ierg_cate_add();
//ierg_prod_rename();
//ierg_prod_update();	
//ierg_prod_delete();
//ierg_prod_insert();
//call_user_func("ierg_4210".$_REQUEST["action"]);
header('Content-Type: application/json');

if(empty($_REQUEST['action']) || !preg_match('/^\w+$/',$_REQUEST['action'])){
	echo json_encode(array('failed'=>'undefined'));
	echo $_REQUEST['action'];
	exit();
}

try{
	//TODO: About security part?
	if($_REQUEST['action']=='prod_insert' || $_REQUEST['action']=='prod_delete' ||
		$_REQUEST['action']=='prod_update' || $_REQUEST['action']=='cate_rename' ||
		$_REQUEST['action']=='cate_add' || $_REQUEST['action']=='cate_delete')
	{
		//
	}	
	if(($return_val = call_user_func('ierg_' . $_REQUEST['action'])) === false) {
		if($db && $db->errorCode()) //error operation on DB
			error_log(print_r($db->errorInfo(),true));
		echo json_encode(array('failed'=>'1'));
	}
	echo 'while(1);' . json_encode(array('success'=>$return_val));
	
} catch(PDOException $e)
	{
		error_log($e->getMessage());
		echo json_encode(array('failed'=>'error-in-db'));
	}
	catch(Exception $e)
	{
		echo 'while(1);' . json_encode(array('failed' => $e->getMessage()));
	}

?>
