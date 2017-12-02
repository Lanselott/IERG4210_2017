<?php
ini_set('display_errors',1);
include_once('lib/auth.php');
$db1=newDB();
//$saltedPassword=sha1($salt."951207Chen"); 
$q=$db1->prepare("INSERT INTO account  (userid,email, salt, password) VALUES (?,?,?,?)");
$q->bindParam(1,$userid);
$q->bindParam(2,$email);
$q->bindParam(3,$salt);
$q->bindParam(4,$saltedPassword);

$userid=3;
$email="JiangZeMin@haha.xym";
$salt=mt_rand();
$password="Excited2017";//id1:951207Chen,id2:951207Alex,id3:Excited2017
$saltedPassword=sha1($salt."Excited2017");

if($q->execute()){echo "success!";}
else {echo "shit!";}
//catch(PDOException $e) {echo $e->getMessage();}

//if($q->execute(array(null,$email, $salt, $saltedPassword))){echo "success";}
	//		echo 'created already !';
//		else {echo "error";}
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Created?</title>
</head>
<body>:)</body>
</html>
