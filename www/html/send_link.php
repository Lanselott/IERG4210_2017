<?php
ini_set('display_errors',1);
session_start();
//handle account session and cookie
function newDB(){
        //make connection with DB
        $db = new PDO('sqlite:/var/www/user.db');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
}

if(isset($_POST['submit_email']) && $_POST['email'])
{
  $email=$_POST['email'];
  $db=newDB();
  $q=$db->prepare('SELECT email,password FROM account WHERE email = ?');
  $q->execute(array($email));
  //$r=$q->fetch();
  //echo($r['password']);
        if($r=$q->fetch()){
                $email=md5($r['email']);
                $pass=md5($r['password']);
	   }
    //phpinfo();
    $link="<a href='https://secure.s54.ierg4210.ie.cuhk.edu.hk/reset_pass.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    //require_once('PHPMailer/class.phpmailer.php');
    require 'vendor/autoload.php';
    $mail = new PHPMailer;
    $mail->CharSet =  "utf-8";
    //$mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;
    // GMAIL username
    $mail->Username = "alexjohnny1207@gmail.com";
    // GMAIL password
    $mail->Password = "951207chen";
    $mail->SMTPSecure = "ssl";
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='alexjohnny1207@gmail.com';
    $mail->FromName='Lanselott';
    $mail->AddAddress($r['email']);
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$link.'';
    //echo "hello";
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
 
}
?>
