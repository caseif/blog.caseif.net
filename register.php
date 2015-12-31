<?php
require($_SERVER['DOCUMENT_ROOT']."/templates/header.php";
?>
<div id="feed">
<h3>Register</h3>
<?php
$r = $_GET['r'];
if ($userid && $username){
	echo "You are already logged in. Redirecting to home page...";
	header("Refresh: 1; url='$r'");
}
else
if ($_POST['regbtn']){
	$getuser = $_POST['user'];
	$getuser = str_replace("'", "&#39", $getuser);
	$getuser = str_replace('"', "&#34", $getuser);
	$getdisplayname = $_POST['display'];
	$getdisplayname = str_replace("'", "&#39", $getdisplayname);
	$getdisplayname = str_replace('"', "&#34", $getdisplayname);
	$getpass = $_POST['pass'];
	$confirmpass = $_POST['confirmpass'];
	$getemail = $_POST['email'];
	$getemail = str_replace("'", "&#39", $getemail);
	$getemail = str_replace('"', "&#34", $getemail);
	
	if ($getuser){
		if ($getdisplayname){
			if ($getpass){
				if ($confirmpass){
					if ($getemail){
						if ($getpass === $confirmpass){
							if ((strlen($getemail) >= 6) && (strstr($getemail, "@")) && (strstr($getemail, "."))){
								if (strlen($getpass) >= 8){
									if ((strlen($getuser) >= 6) && (strlen($getuser) <= 20)){
										if (strlen($getdisplayname) >= 6 && strlen($getdisplayname) <= 20){
                                            $link = getDbConnection();
											$query = $link->query("SELECT * FROM login WHERE username='$getuser'");
											$numrows = $query->num_rows;
											if ($numrows == 0){
												$query = $link->query("SELECT * FROM login WHERE email='$getemail'");
												$numrows = $query->num_rows;
												if ($numrows == 0){
													$url = 'https://www.google.com/recaptcha/api/siteverify';
													$data = array(
														'secret' => file_get_contents('/etc/captcha.secret'),
														'response' => $_POST['g-recaptcha-response'],
														'remoteip' => $_SERVER['REMOTE_ADDR']
													);
													$options = array(
														'http' => array(
															'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
															'method'  => 'POST',
															'content' => http_build_query($data),
														),
													);
													$context  = stream_context_create($options);
													$result = json_decode(file_get_contents($url, false, $context), true);
													if ($result['success']) {
														$salt = randStr();
														$password = sha1($getpass.$salt);
														$time = time();
														$sta = $link->prepare("INSERT INTO login (username, display, password, email, active, time, salt) VALUES ('".$getuser."', '".$getdisplayname."', '".$password."', '".$getemail."', '1', '".$time."', '".$salt."')");
														$sta->execute();
														$query = $link->query("SELECT * FROM login WHERE username='".$getuser."'");
														$numrows = $query->num_rows;
														if ($numrows == 1) {
															echo "You have been successfully registered with the username <b>$getuser</b>. To log into your new account, <a href='/login.php'>click this link.</a>";
															$dispForm = true;
														}
														else
															$errmsg = "An error occured while registering you; please try again in a few minutes. If this problem persists, please contact me at <a href='mailto:caseif@caseif.net'>caseif@caseif.net</a>.";
													}
													else
														$errmsg = "Incorrect Captcha response!";
												}
												else
													$errmsg = "That email has already been registered. Are you trying to <a href='/login.php'>login</a>?";
											}
											else
												$errmsg = "That username is already taken.  Are you trying to <a href='./login.php'>login</a>?";
										}
										else
											$errmsg = "Your display name must be between 6 and 20 characters.";
									}
									else
										$errmsg = "Your username must be between 6 and 20 characters.";
								}
								else
									$errmsg = "Your password must be at least 8 characters long.";
							}
							else
								$errmsg = "Please enter a valid email address.";
						}
						else
							$errmsg = "Your passwords did not match.";
					}
					else
						$errmsg = "You must enter a valid email address to register.";
				}
				else
					$errmsg = "You must confirm your password.";
			}
			else
				$errmsg = "You must enter a password.";
		}
		else
			$errmsg = "You must enter a display name (it can be the same as your username if you'd like).";
	}
	else
		$errmsg = "You must enter a username.";
}
	
$form = "<form action='./register.php?r=$r' method='post'>
<table>
<tr>
	<td><font color='red'><b>$errmsg</b></font></td>
</tr>
</table>
<table>
<tr>
	<td>Username</td>
	<td><input type='text' name='user' value='$getuser' required autofocus /></td>
</tr>
<tr>
	<td>Display Name</td>
	<td><input type='text' name='display' value='$getdisplayname' required /></td>
</tr>
<tr>
	<td>Password</td>
	<td><input type='password' name='pass' required /></td>
</tr>
<tr>
	<td>Confirm Password</td>
	<td><input type='password' name='confirmpass' required /></td>
</tr>
<tr>
	<td>Email Address</td>
	<td><input type='email' name='email' value='$getemail' required /></td>
</tr>
<tr>
	<td><input type='submit' name='regbtn' value='Register' /></td>
</tr>
</table>
<br>
<div class='g-recaptcha' data-sitekey='6LfV0wMTAAAAAGtfBuucY_iwvdafyECpyo_cAtXr'></div>
</form>";

if (!$dispForm) echo $form;
?>
</div>
<?php
include('templates/footer.php');
?>
