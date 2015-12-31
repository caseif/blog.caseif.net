<?php
require($_SERVER['DOCUMENT_ROOT'].'/templates/header.php');
?>
<div id="feed">
	<?php
	if (ie() && $_COOKIE['ignoreIeWarning'] != "true")
		header("Refresh: 0; url=\"./ie.php\"");
	if (!isset($page))
		$page = 1;
	$link = getDbConnection();
	$total = $link->query("SELECT * FROM posts WHERE visible = '1'")->num_rows;
	if ($total > 0){
		if (!isset($perpage))
			$perpage = $total;
		$pages = $total / $perpage;
		$start = ($page - 1) * $perpage;
		$query = $link->query("SELECT * FROM posts WHERE visible = '1' ORDER BY time DESC LIMIT ".$start.", ".$perpage);
		$numrows = $query->num_rows;
		if ($numrows > 0){
		$i = 0;
		while ($post = $query->fetch_array()){
			$i += 1;
			$id = $post['id'];
			$title = $post['title'];
			$content = $post['content'];
            $parser = new Parsedown();
			$content = $parser->text(syntaxPreprocessor($content));
			$authorid = $post['author'];
			$category = $post['category'];
			$bitly = $post['bitly'];
			$timestamp = $post['time'];
			$time = getdate($timestamp);
			$year = $time['year'];
			$month = $time['month'];
			$day = $time['mday'];
			$author = $link->query("SELECT * FROM login WHERE id='".$authorid."'")->fetch_array()['display'];
			$mustScan = !isset($post['preview']);
			$preview = mustScan ? 1000 : $post['preview'];
			$dots = false;
			if ($mustScan) {
				/*preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $content, $matches, PREG_SET_ORDER);
				$offlimits = array();
				foreach ($matches as $key => $val) {
					$pos = strpos($content, $val[0]);
					array_push($offlimits, array($pos, $pos + strlen($val[0])));
				}
				mainLoop:*/
				while (substr($content, $preview, 1) != " " && strlen($content) > $preview) {
					/*foreach ($offlimits as $val) {
						if ($preview >= $val[0] && $preview <= $val[1]) {
							echo $preview." ".$val[0]." ".$val[1]." ";
							$preview = $val[1];
							break 2;
						}
					}*/
					$preview += 1;
				}
			}
			if (strlen($content) > $preview){
				$content = substr($content, 0, $preview);
				$dots = true;
			}
			echo "<article><header class='heading'><a href='post.php?id=".$id."'>".$title."</a></header>";
			echo $content;
			if ($dots)
				echo ". . .";
			echo "<footer>";
			echo "<div class='full'><a href='post.php?id=".$id."'>See Full Post</a></div>";
			echo "<div class='sig'><span style='float:right'>Written by ".$author." on ".$month." ".$day.", ".$year."</span></div>";
			if ($userid == 1){
				echo "<br>";
				echo "<div class='postcontrol'><a href='edit.php?id=$id'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='delete.php?id=$id'>Delete</a></div>";
			}
            echo "<br>";
			echo "</footer></article>";
			if ($i < $numrows)
				echo "<hr class='divider'>";
		}
		if ($pages > 1) {
			?>
			<div id="pages">
			<?php
			echo "<footer>";
			echo "<center>";
			echo "<br>";
			$prev = $page - 1;
			$next = $page + 1;
			if ($page != 1)
				echo "<a href='./'>&#171;</a>&nbsp;&nbsp;&nbsp;<a href='./?p=$prev'>&#139;</a>&nbsp;&nbsp;&nbsp;";
			else
				echo "<font color='lightgray'>&#171;&nbsp;&nbsp;&nbsp;&#139;&nbsp;&nbsp;&nbsp;</font>";
			echo "Page ".$page."/".ceil($pages);
			if ($page < $pages)
				echo "&nbsp;&nbsp;&nbsp;<a href='./?p=$next'>&#155;</a>&nbsp;&nbsp;&nbsp;<a href='./?p=".ceil($pages)."'>&#187;</a>";
			else
				echo "<font color='lightgray'>&nbsp;&nbsp;&nbsp;&#155;&nbsp;&nbsp;&nbsp;&#187;</font>";
			echo "</center>";
			echo "</footer>";
			?>
			</div>
			<?php
		}
		}
		else
			header("location='/'");
	}
	else
		echo "<br><br>There haven't been any posts yet!";
	$link->close();
	?>
</div>
<?php
require($_SERVER['DOCUMENT_ROOT'].'/templates/footer.php');
?>
