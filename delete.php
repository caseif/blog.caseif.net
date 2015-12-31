<?php
include('./templates/header.php');
$id = $_GET['id'];
if (!isset($id))
	header("Refresh: 0; url='./'");
?>
<div id="feed">
<?php
if ($userid == 1){
$link = getDbConnection();
$query = $link->query("SELECT * FROM posts WHERE id = $id");
if ($query->num_rows > 0){
	echo "Are you sure you want to delete this post?";
	$post = $query->fetch_array();
	$title = $post['title'];
	$content = $post['content'];
	$category = $post['category'];
	$authorid = $post['author'];
	$author = $link->query("SELECT * FROM login WHERE id='$authorid'")->fetch_array()['display'];
	$timestamp = $post['time'];
	$time = getdate($timestamp);
	$year = $time['year'];
	$month = $time['month'];
	$day = $time['mday'];
	$preview = 1000;
	$dots = false;
	$content = bbcode($content);
	while (substr($content, $preview, 1) != " " && strlen($content) > $preview)
		$preview += 1;
	if (strlen($content) > $preview){
		$content = substr($content, 0, $preview);
		$dots = true;
	}
	echo "<article><header><h3>$title</h3></header>";
			echo "$content";
			if ($dots)
				echo ". . .";
			echo "<footer>";
			echo "<div class='full'><a href='post.php?id=$id'>See Full Post</a></div>";
			echo "<div class='sig'>Written by ".$author." on ".$month." ".$day.", ".$year."</div>";
			if ($userid == 1){
				echo "<br>";
				echo "<a href='edit.php?id=$id'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='delete.php?id=$id'>Delete</a>";
			}
			echo "</footer></article>";
	$form = "<form action='delete.php?id=$id' method='post'>
	<table>
	<tr>
	<td><input type='submit' name='yes' value='Yes'><input type='submit' name='no' value='No'></td>
	</tr>
	</table>
	</form>";
	if ($_POST['yes']){
		$link->query("UPDATE posts SET visible = 0 WHERE id = ".$id);
		if ($link->query("SELECT * FROM posts WHERE id = ".$id." AND visible = 1")->num_rows == 0)
			echo "<font color='green'>Your post was deleted successfully.</font>";
		else
			echo "<font color='red'>An error has occurred; please try again later.</font>";
		$link->close();
		//echo "<script>window.location.replace('./')</script>";
	}
	if ($_POST['no']){
		header("Refresh: 0; url='./post.php?id=".$id."'");
	}
	echo $form;
}
else
	echo "Oh noes! No post by this ID exists!";
$link->close();
}
else
	header("Refresh: 0; url='./'");
?>
</div>
<?php
include('./templates/footer.php');
?>