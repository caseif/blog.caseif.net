<?php
include('./templates/header.php');
?>
<div id="feed">
	<h3>Log Out</h3>
	<?php
	$url = $_GET['url'];
	if ($userid && $username){
		$time = (time() - 3600);
		setcookie("userid", "", "$time", "/");
		setcookie("username", "", "$time", "/");
		session_destroy();
		echo 'You have been logged out. Redirecting...';
		header('Location: '.$url);
	}
	else {
		echo "You are not logged in! Redirecting...";
		header('Location: '.$url);
	}
	?>
</div>
<?php
include('./templates/footer.php');
?>
