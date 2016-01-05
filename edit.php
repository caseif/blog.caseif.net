<?php
require_once($_SERVER['DOCUMENT_ROOT']."/templates/preheader.php");

if ($userid != 1) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT']."/error/403.php");
    die();
}


require_once($_SERVER['DOCUMENT_ROOT'].'/templates/header.php');
?>
<div id="feed">
<h3>Edit</h3>
<?php
$id = $_GET['id'];
if (!isset($id)) {
    header("Location: /");
}
$link = getDbConnection();
$row = $link->query("SELECT * FROM posts WHERE id='".$id."'")->fetch_array();
$title = $row['title'];
$content = $row['content'];
$content = str_replace("<br>", "\n", $content);
$content = str_replace("<br/>", "\n", $content);
$content = str_replace("<br />", "\n", $content);
$content = str_replace("&#39;", "'", $content);
$content = str_replace("&", "&amp;", $content);
$category = $row['category'];
$form = "<form action='edit.php?id=".$id."' method='post'>
<table>
<tr>
<td>Title</td>
<td><input type='text' name='title' value='".$title."'></td>
</tr>
<tr>
<td>Content</td>
<td><textarea name='content' rows=25 cols=70>".$content."</textarea></td>
</tr>
<tr>
<td>Category</td>
<td>
<select name='category'>
<option value='blog' ".($category == "blog" ? "selected='selected'" : "").">This Blog</option>
<option value='rants' ".($category == "rants" ? "selected='selected'" : "").">Rants</option>
<option value='personal' ".($category == "personal" ? "selected='selected'" : "").">Personal</option>
<option value='code' ".($category == "code" ? "selected='selected'" : "").">Code</option>
</select>
</td>
</tr>
<tr>
<td><input type='submit' name='submit' value='Submit'></td>
</tr>
</table>
</form>";
if ($_POST['submit']){
	$title = str_replace("'", "&#39;", $_POST['title']);
	//$content = str_replace("\n", "<br>", $_POST['content']);
	$content = str_replace("'", "&#39;", $_POST['content']);
	$sta = $link->prepare("UPDATE posts SET title='".$title."',content='".$content."',category='".$_POST['category']."' WHERE id='".$id."'");
	$sta->execute();
	header('Location: /post.php?id='.$id);
}
echo $form;
?>
</div>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/templates/footer.php');
?>
