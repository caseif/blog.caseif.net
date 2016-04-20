<div id="sidebar">
	<span class="heading">Recent Postings</span>
	<div id="recent">
	<?php
	$recent = 5;
    $link = getDbConnection();
	$all = $link->query("SELECT * FROM posts WHERE visible = '1'");
	$total = $all->num_rows;
	$query = $link->query("SELECT * FROM posts WHERE visible = '1' ORDER BY time DESC LIMIT 0,".$recent);
	$numrows = $query->num_rows;
	if ($numrows > 0){
		echo "<ul>";
		while ($post = $query->fetch_array())
			echo "<li><a href='/post.php?id=".$post['id']."'>".$post['title']."</a></li>";
		if ($total > $recent)
			echo "<li><a href='/all.php'>+".($total - $recent)." more…</a></li>";
		echo "</ul>";
	}
	$link->close();
	?>
	</div>
	<div id="archives">
	<span class="heading">Archives</span>
	<?php
    $link = getDbConnection();
	$query = $link->query("SELECT * FROM posts WHERE visible = '1' ORDER BY time DESC");
	while ($post = $query->fetch_array()){
		$year = date("Y", $post['time']);
		$month = date("F", $post['time']);
		$day = date("j", $post['time']);
		$y = false;
		if ($year != $lastyear){
			if (isset($lastyear))
				echo "</ul></ul>";
			$lastyear = $year;
			echo "<ul><li>".$year."</li>";
			$y = true;
		}
		if ($month != $lastmonth){
			if (isset($lastmonth) && !$y)
				echo "</ul>";
			$lastmonth = $month;
			echo "<ul><li>".$month."</li>";
		}
		if ($day != $lastday){
			$lastday = $day;
		}
		echo "<ul><li><a href='/post.php?id=".$post['id']."'>".$month." ".$day."</a></li></ul>";
	}
	echo "</ul></ul></ul>";
	$link->close();
	?>
	</div>
	<?php
	if ($userid == 1 && $username == "mproncace"){
		echo "<div id='create'>
		<span class='heading'>Create</span>
		<ul><li><a href='create.php'>Get Blogging!</a></li></ul>
		</div>";
	}
	?>
	<div id="login">
	<?php
	if ($username && $userid)
		echo '<span class="heading">Login</span><ul><li>Signed in as '.$username.'</li><li><a href="./logout.php?url='.$_SERVER['REQUEST_URI'].'">Logout</a></li></ul>';
	else
		echo '<span class="heading">Login</span><ul><li><a href="./login.php?url='.$_SERVER['REQUEST_URI'].'">Sign In</a></li><li><a href="./register.php">Register an account</a></li></ul>';
	?>
	</div>
	<div id="programs">
	<span class="heading">Links and Stuff</span>
	<ul>
	<li><a href="https://github.com/caseif">GitHub</a></li>
	<li><a href="http://ci.caseif.net/">Jenkins</a></li>
	<li><a href="http://ci.caseif.net/job/Pore/" target="_blank">Pore</a></li>
	<ul><li><a href="https://github.com/LapisBlue/Pore" target="_blank">Source</a></li></ul>
	<li><a href="http://dev.bukkit.org/profiles/caseif/" target="_blank">Bukkit Plugins</a></li>
	</ul>
	</div>
	<!--<div id="advc">
		<script class="advert" async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
				style="display:inline-block;width:300px;height:250px"
				data-ad-client="ca-pub-5612433211040407"
				data-ad-slot="8419980973"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>-->
</div>
<div id="footer">
	<footer style="text-align: center">
	<br>
	<hr class="divider">
	<br>
	&#169;2016	Max Roncace
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="mailto:caseif@caseif.net">Email me!</a>
	<br>
	<br>
	<span title="(both before and after he redesigned it)">Design inspired by <a href="http://www.dinnerbone.com/">Dinnerbone.com</a></span<
	</footer>
</div>
</div>
</div>
</body>
<!--<script type="text/javascript">
// some festive snow
function letItSnow(){
	snowFall.snow($("#navbar"), {flakeCount: 250, round: true, minSize: 1, maxSize: 3});
}

if (getCookie("snow") != "off" && navigator.userAgent.indexOf("Trident") <= -1)
	$(document).ready = letItSnow();

function stopSnow(){
	document.cookie = 'snow=off; expires=' + new Date(2037, 0, 1, 0, 0, 0, 0).toGMTString() + '; path=/';
	snowFall.snow($("#navbar"), "clear");
	var flakes = document.getElementsByClassName("snowfall-flakes");
	if (flakes.length > 0)
		while (flakes[0])
			flakes[0].parentNode.removeChild(flakes[0]);
	document.getElementById("snowToggle").innerHTML = "<a href='javascript:startSnow()'>Want snow again? Click here!</a>";
	console.log("Well alrighty then Ebenezer");
}

function startSnow(){
	document.cookie = "snow=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
	letItSnow();
	document.getElementById("snowToggle").innerHTML = "<a href='javascript:stopSnow()'>Snow too slow? Turn it off!</a>";
	console.log("Let it snow!");
}
</script>-->
</html>
<?php
ob_end_flush();
?>
