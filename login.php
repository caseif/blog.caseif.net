<?php
require($_SERVER['DOCUMENT_ROOT']."/templates/preheader.php");
require($_SERVER['DOCUMENT_ROOT']."/templates/header.php");
?>
<div id="feed">
<h3>Log In</h3>
<?php
	$url = isset($_GET['url']) ? $_GET['url'] : "/";
	$form = "<form action='login.php?url=".$url."' method='post'>
	<table>
	<tr>
		<td><font color='black'><b>Username</b></font></td>
		<td><input type='text' name='user' required autofocus /></td>
	</tr>
	<tr>
		<td><font color='black'><b>Password</b></font></td>
		<td><input type='password' name='pass' required /></td>
	</tr>
	<tr>
	<td>
		<font color='black'><b>Stay Logged In</b></font>
		<input type='checkbox' name='cookie' checked='checked' />
	</td>
	</tr>
	<tr>
	<td><input type='submit' name='loginbtn' value='Login' /></td>
	</tr>
	</table>
	</form>";
	if ($userid && $username){
		echo "You are already logged in. Redirecting...";
		header('Location: /'.$url);
	}
	else {
		if ($_POST['loginbtn']){
			$user = $_POST['user'];
			$password = $_POST['pass'];
			$cookie = $_POST['cookie'];
			$num = $_POST['num'];
			$unit = $_POST['unit'];
			if ($user){
				if ($password){
                    $link = getDbConnection();
					$link->select_db('blog');
					$query = $link->query("SELECT * FROM login WHERE username='".$link->real_escape_string($user)."'");
					$numrows = $query->num_rows;
					if ($numrows == 1){
						$row = $query->fetch_assoc();
						$dbid = $row['id'];
						$dbuser = $row['username'];
						$dbpass = $row['password'];
						$dbactive = $row['active'];
						$url = $_GET['url'];
						$salt = $row['salt'];
						$hash = sha1($password.$salt);
						if ($hash == $dbpass) {
							if ($dbactive == 1){
								if (isset($_POST['cookie'])){
									if ($cookie == 'on'){
										$time = mktime (0, 0, 0, 12, 31, 2016);
										setcookie('userid', $dbid, $time,"/");
										setcookie('username', $dbuser, $time,"/");
									}
								}
								$_SESSION['userid'] = $dbid;
								$_SESSION['username'] = $dbuser;
								echo 'You have been logged in as <b>'.$dbuser.'</b>. Redirecting...';
								header('Location: '.$url);
							}
							else
								$errmsg = "Your account still is awaiting activation.";
						}
						else
							$errmsg = "Unrecognized username/password combination.";
					}
					else
						$errmsg = "Unrecognized username/password combination.";
					$link->close();
				}
				else
					$errmsg = "You must enter your password.";
			}
			else
				$errmsg = "You must enter your username.";
		}
	}
	echo "<font color='red'>".$errmsg."</font>".$form;
	?>
</div>
<?php
require($_SERVER['DOCUMENT_ROOT']."/templates/footer.php");
?>
