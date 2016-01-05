<?php
function syntaxPreprocessor($str) {
    $pattern = '/```(.*?)\n(.*?)```/s';
    $replace = '<pre><code class="language-$1">$2</code></pre>';
}
?>