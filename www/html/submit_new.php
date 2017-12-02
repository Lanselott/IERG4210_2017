<?php
//ini_set('display_errors',1);
function newDB(){
        //make connection with DB
        $db = new PDO('sqlite:/var/www/user.db');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
}

if(isset($_POST['submit_password']) && $_POST['email'] && $_POST['password'])
{
  $email=$_POST['email'];
  $pass=$_POST['password'];
  $salt=mt_rand();
  $saltedPassword=sha1($salt.$pass);
  //echo($saltedPassword);
  $db=newDB();
  $q=$db->prepare('SELECT email,password FROM account');
  $q->execute();
  //echo($q);
  while($r=$q->fetch())
  {
	if(md5($r['email'])==$email)
	{
		echo $r['email'];
                $r_email=$r['email'];
  		$qq=$db->prepare("UPDATE account SET password='$saltedPassword',salt='$salt' WHERE email='$r_email' ");
	  
		if($qq->execute())
		{
//			echo($pass);
			echo "Update your password success!";
		}
  		else echo "created fail";
	}
  //$select=mysql_query("update user set password='$pass' where email='$email'");
  }
}
?>
