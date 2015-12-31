<?php
header("HTTP/1.0 500 Internal Server Error");
require("../templates/preheader.php");
$pagetitle = "500 Internal Server Error";
require("../templates/header.php");
?>
<div id="feed">
<header class='heading'>Something's gone terribly wrong...</header>
A grave mistake has been made on our server. We cannot say whether we are responsible, as only the logs may hold that precious information. The server may be over capacity, or perhaps the program has encountered a rather nasty bug. Or, most likely, we've made a mistake in our code. You could try refreshing the page, but if that doesn't fix the problem, then please feel free to <a href="mailto:caseif@caseif.net">send me an email</a> describing the problem.
<div class="massive">500</div>
</div>
<?php
require("../templates/footer.php");
?>