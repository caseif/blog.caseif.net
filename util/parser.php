<?php
function syntaxPreprocessor($str) {
    $pattern[] = '/```([^\s]+?)\n(.*?)```/s';
    $replace[] = '<pre><code class="language-$1">$2</code></pre>';

    return preg_replace($pattern, $replace, str_replace('&#39;', '\'', $str));
}
?>