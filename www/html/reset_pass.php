<?php
//ini_set('display_errors',1);
//handle account session and cookie
function newDB(){
        //make connection with DB
        $db = new PDO('sqlite:/var/www/user.db');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
}

if($_GET['key'] && $_GET['reset'])
{
  $email=$_GET['key'];
  $pass=$_GET['reset'];
  
  $db=newDB();
  $q=$db->prepare('SELECT email,password FROM account');
  $q->execute();
  //echo($q);
  while($r=$q->fetch())
  {
    if(md5($r['email'])==$email && md5($r['password'])==$pass)
	{	echo "User:";
		echo($r['email']);
    ?>
    <form method="post" action="submit_new.php">
    <input type="hidden" name="email" value="<?php echo $email;?>">
    <p>Enter New password</p>
    <input type="password" name='password' required="true" pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" />
    <input type="submit" name="submit_password">
    </form>
    <?php
	}
  }
}
?>

