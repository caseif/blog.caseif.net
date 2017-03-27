<?php
require_once($_SERVER['DOCUMENT_ROOT']."/templates/preheader.php");

if ($userid != 1) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT']."/error/403.php");
    die();
}

require_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php");
?>
<div id="feed">
<h3><b>Create a Post</b></h3>
<?php
$form = "
<form action='create.php' method='post'>
    <table>
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' value='$title'></td>
        </tr>
        <tr>
            <td>Content</td>
            <td><textarea name='content' rows='25' cols='70'>$content</textarea></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
                <select name='category' value='$cat'>
                    <option value='blog'>This Blog</option>
                    <option value='rants'>Rants</option>
                    <option value='personal'>Personal</option>
                    <option value='code'>Code</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type='submit' name='submit' value='Post'></td>
        </tr>
    </table>
</form>";
if ($_POST['submit']){
	$link = getDbConnection();
	$title = str_replace("'", "&#39;", $_POST['title']);
	$title = str_replace('"', "&#34;", $title);
	$title = str_replace("\n", "", $title);
	$content = str_replace("'", "&#39;", $_POST['content']);
	$sta = $link->prepare("INSERT INTO posts (title, content, time, author, category, visible) VALUES ('".$link->real_escape_string($title)."', '".$link->real_escape_string($content)."', ".time().", '".$link->real_escape_string($userid)."', '".$link->real_escape_string($_POST['category'])."', 1)");
	$sta->execute();
	$id = $link->query("SELECT * FROM posts WHERE title='".$link->real_escape_string($title)."'")->fetch_array()['id'];
	header("Location: /post.php?id=".$id);
}
echo $form;
?>
</div>
<?php
require($_SERVER['DOCUMENT_ROOT']."/templates/footer.php");
?>
