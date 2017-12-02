<?php

session_start();
//handle account session and cookie
function newDB(){
	//make connection with DB
	$db = new PDO('sqlite:/var/www/user.db');
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $db;
}

function loginProcess($email, $password){
	$db=newDB();
		$q=$db->prepare('SELECT * FROM account WHERE email = ?');
		$q->execute(array($email));
		if($r=$q->fetch()){
			$saltPassword=sha1($r['salt'].$password);
		//	echo "$saltPassword,$password";
		//	echo($r['salt']);
		//	echo "///";
		//	echo($r['password']);//ERROR!
			//echo "BUG";
			if($saltPassword == $r['password']){
				$exp = time() + 3600 * 24 *3; //3 days
				$token = array(
				'id'=>$r['userid'],
				'em'=>$r['email'], 
				'exp'=>$exp,
				'k'=>sha1($exp . $r['salt'] . $r['password']));
			setcookie('authtoken',json_encode($token),$exp,'','',true,true);//HttpOnly setting
			//put it also in the session
			$_SESSION['authtoken'] = $token;
			return true;
			}
		return false;
		}
	return false;
}
//DO authority
function auth(){
	if(!empty($_SESSION['authtoken']))
		return $_SESSION['authtoken'];
	if(!empty($_COOKIE['authtoken'])){
		if($t = json_decode(stripslashes($_COOKIE['authtoken']),true)){
			if(time()>$t['exp'])
				return false; //expire user
		$db=newDB();
	 	$q=$db->prepare('SELECT * FROM account WHERE email = ?');
		$q->execute(array($t['em']));
		if($r=$q->fetch()){
			$realk = hash_hmac('sha1', $t['exp'].$r['password'],$r['salt']);
			if($realk == $t['k']){
				$_SESSION['authtoken'] = $t;
				return $t['userid'];
			}
		}
		}
	}
return false;
}


?>
