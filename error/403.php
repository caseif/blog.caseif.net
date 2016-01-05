<?php
header("HTTP/1.1 403 Forbidden");
require_once($_SERVER['DOCUMENT_ROOT']."/templates/preheader.php");
$pagetitle = "403 Forbidden";
require_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php");
?>
<div id="feed">
<header class='heading'>None shall pass</header>
Greetings, stranger. We won't waste time asking how you found this place, but we're afraid we can't let you proceed any further. For you see, access to these particular electrons is forbidden by policy, and if we were to let you through, well, the entire machine would collapse into utter anarchy. And thus, in order to prevent such chaos, we've unconditionally barred your entry. However, we may be mistaken, and if this is so, then <a href="mailto:caseif@caseif.net">you may request that policy be rewritten</a>.
<div class="massive">403</div>
</div>
<?php
require_once($_SERVER['DOCUMENT_ROOT']."/templates/footer.php");
?>