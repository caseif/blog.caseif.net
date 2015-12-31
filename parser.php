<?php

function bbcode($string){

// convert pre-existing HTML tags
$pattern[] = '/<(.*?^code^pre)>(.*?)<\/(.*?^code^pre)>/i';
$replace[] = '&lt;$1&gt;$2&lt;/$3&gt;';

// **bold**
$pattern[] = '/\*\*(.*?)\*\*/i';
$replace[] = '<b>$1</b>';

// *italics*
$pattern[] = '/\*(.*?)\*/i';
$replace[] = '<i>$1</i>';

// _underline_
$pattern[] = '/\_(.*?)\_/i';
$replace[] = '<u>$1</u>';

// ~strikethrough~
$pattern[] = '/\~(.*?)\~/i';
$replace[] = '<s>$1</s>';

// [link name](url)
$pattern[] = '/\[(.*?)\]\((.*?)\)/i';
$replace[] = '<a href="$2" target="_blank">$1</a>';

// /r/subreddit and /u/username
// fuck, what?
//$pattern[] = '/\/r\/(.*?)\s/i';
//$replace[] = '<a href="http://www.reddit.com/r/$1" target="_blank">/r/$1 </a>';

//$pattern[] = '/\/u\/(.*?)\s/i';
//$replace[] = '<a href="http://www.reddit.com/u/$1" target="_blank">/u/$1 </a>';

// convert [url=URL]link_title[/url]
$pattern[] = '/\[url=(.*?)\](.*?)\[\/url\]/i';
$replace[] = '<a href="$1" target="_blank">$2</a>';

// convert [url]url_link[/url]
$pattern[] = '/\[url\](.*?)\[\/url\]/i';
$replace[] = '<a href="$1" target="_blank">$1</a>';

// convert [img]image_link[/img]
$pattern[] = '/\[img\](.*?)\[\/img\]/i';
$replace[] = '<img src="$1">';

// convert strikethrough
$pattern[] = '/\[s\](.*?)\[\/s\]/i';
$replace[] = '<s>$1</s>';

// convert bold text
$pattern[] = '/\[b\](.*?)\[\/b\]/i';
$replace[] = '<b>$1</b>';

// convert italics
$pattern[] = '/\[i\](.*?)\[\/i\]/i';
$replace[] = '<i>$1</i>';

// convert underlined text
$pattern[] = '/\[u\](.*?)\[\/u\]/i';
$replace[] = '<u>$1</u>';

// convert subscript text
$pattern[] = '/\[sub\](.*?)\[\/sub\]/i';
$replace[] = '<sub>$1</sub>';

// convert superscript text
$pattern[] = '/\[sup\](.*?)\[\/sup\]/i';
$replace[] = '<sup>$1</sup>';

// convert ASCII emoticons
//why not zoidberg?
/*$pattern[] = '/\(V\)\(\;\,\,\;\)\(V\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/zoidberg.png" alt="Zoidberg" title="Why not Zoidberg?" height=18 width=18>';
// and homer
$pattern[] = '/\~\(\_8\^\(I\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/homer.png" alt="Homer" title="Doh!" height=18 width=18>';
// it's not ogre till I say it's ogre
$pattern[] = '/\:onion\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/shrek.gif" alt="Shrek" title="Ogres are like onions!" height=18 width=18>';
$pattern[] = '/\:layer\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/shrek.gif" alt="Shrek" title="Layers! Ogres. have. layers!" height=18 width=18>';
$pattern[] = '/\:shrek\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/shrek.gif" alt="Shrek" title="This is the part where you run away." height=18 width=18>';
//smile
$pattern[] = '/\:\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/smile.png" alt=":)" title=":)" height=18 width=18>';
$pattern[] = '/\:\-\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/smile.png" alt=":-)" title=":-)" height=18 width=18>';
$pattern[] = '/\(\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/smile.png" alt="(:" title="(:" height=18 width=18>';
$pattern[] = '/\(\-\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/smile.png" alt="(-:" title="(-:" height=18 width=18>';
//grin
$pattern[] = '/\:D/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/grin.png" alt=":D" title=":D" height=18 width=18>';
$pattern[] = '/\:\-D/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/grin.png" alt=":-D" title=":-D" height=18 width=18>';
//frown
$pattern[] = '/\:\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/frown.png" alt=":(" title=":(" height=18 width=18>';
$pattern[] = '/\:\-\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/frown.png" alt=":-(" title=":-(" height=18 width=18>';
$pattern[] = '/\)\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/frown.png" alt="):" title="):" height=18 width=18>';
$pattern[] = '/\)\-\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/frown.png" alt=")-:" title=")-:" height=18 width=18>';
//angry face
$pattern[] = '/\>\:\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt=">:(" title=">:(" height=18 width=18>';
$pattern[] = '/\>\:\-\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt=">:-(" title=">:-(" height=18 width=18>';
$pattern[] = '/\)\:\</i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt="):<" title="):<" height=18 width=18>';
$pattern[] = '/\)\-\:\</i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt=")-:<" title=")-:<" height=18 width=18>';
//crying face
$pattern[] = '/\:\'\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=":\'(" title=":\'(" height=18 width=18>';
$pattern[] = '/\:\,\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=":,(" title=":,(" height=18 width=18>';
$pattern[] = '/\:\'\-\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=":\'-(" title=":\'-(" height=18 width=18>';
$pattern[] = '/\:\,\-\(/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=":,-(" title=":,-(" height=18 width=18>';
$pattern[] = '/\)\'\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=")\':" title=")\':" height=18 width=18>';
$pattern[] = '/\)\,\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt="),:" title="),:" height=18 width=18>';
$pattern[] = '/\)\-\'\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=")-\':" title=")-\':" height=18 width=18>';
$pattern[] = '/\)\-\,\:/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/crying.png" alt=")-,:" title=")-,:" height=18 width=18>';
//laughing face
$pattern[] = '/XD/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/laughing.png" alt="XD" title="XD" height=18 width=18>';
$pattern[] = '/X\-D/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/laughing.png" alt="X-D" title="X-D" height=18 width=18>';
//winking face
$pattern[] = '/;\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/winking.png" alt=";)" title=";)" height=18 width=18>';
$pattern[] = '/;\-\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/winking.png" alt=";-)" title=";-)" height=18 width=18>';
//slash face
$pattern[] = '/\:\//i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/slash.png" alt=":/" title=":/" height=18 width=18>';
$pattern[] = '/\:\-\//i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/slash.png" alt=":-/" title=":-/" height=18 width=18>';
$pattern[] = '/\:\\\/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/slash.png" alt=":\\" title=":\\" height=18 width=18>';
$pattern[] = '/\:\-\\//i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/slash.png" alt=":-\\" title=":-\\" height=18 width=18>';
//tongue face
$pattern[] = '/\:p/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/tongue.png" alt=":p" title=":p" height=18 width=18>';
$pattern[] = '/\:P/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/tongue.png" alt=":P" title=":P" height=18 width=18>';
$pattern[] = '/\:\-p/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/tongue.png" alt=":-p" title=":-p" height=18 width=18>';
$pattern[] = '/\:\-P/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/tongue.png" alt=":-P" title=":-P" height=18 width=18>';
$pattern[] = '/X\-p/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/tongue.png" alt="X-p" title="X-p" height=18 width=18>';
$pattern[] = '/X\-P/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/tongue.png" alt="X-P" title="X-P" height=18 width=18>';
//evil grin
$pattern[] = '/\>\:\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt=">:)" title=">:)" height=18 width=18>';
$pattern[] = '/\>\:\-\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt=">:-)" title=">:-)" height=18 width=18>';
$pattern[] = '/\(\:\</i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt="(:<" title="(:<" height=18 width=18>';
$pattern[] = '/\(\-\:\</i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/angry.png" alt="(-:<" title="(-:<" height=18 width=18>';
//glasses face
//$pattern[] = '/B\)/i';
//$replace[] = '<img src="http://amigocraft.net/images/emoticons/glasses.png" alt="B)" title="B)" height=18 width=18>';
$pattern[] = '/B\-\)/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/glasses.png" alt="B-)" title="B-)" height=18 width=18>';
//wide-eyed face
$pattern[] = '/o\.O/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/wideeyed.png" alt="o.O" title="o.O" height=18 width=18>';
$pattern[] = '/O\.o/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/wideeyed.png" alt="O.o" title="O.o" height=18 width=18>';
//nerd face
$pattern[] = '/8\|/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/nerd.png" alt="8|" title="8|" height=18 width=18>';
$pattern[] = '/8\-\|/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/nerd.png" alt="8-|" title="8-|" height=18 width=18>';
// heart
$pattern[] = '/\<3/i';
$replace[] = '<img src="http://amigocraft.net/images/emoticons/heart.png" alt="<3" title="<3" height=18 width=18>';*/

// convert newlines, for some reason
$pattern[] = '/\n/i';
$replace[] = '<br>';

return preg_replace($pattern, $replace, $string);

}

function devParse($string){

// convert newlines, for some reason
$pattern[] = '/\n/i';
$replace[] = '<br>';

$pattern[] = '/\[syntax[ =](.*?)\](.*?)\[\/syntax\]/s';
$replace[] = '<pre><code class="language-$1">$2</code></pre>';

// [link name](url)
$pattern[] = '/\[(.*?)\]\((.*?)\)/i';
$replace[] = '<a href="$2">$1</a>';

// convert [url]url_link[/url]
$pattern[] = '/\[url\](.*?)\[\/url\]/i';
$replace[] = '<a href="$1">$1</a>';

// convert [img]image_link[/img]
$pattern[] = '/\[img\](.*?)\[\/img\]/i';
$replace[] = '<img src="$1">';

return preg_replace($pattern, $replace, $string);

}

function syntaxPreprocessor($str) {
    $pattern = '/```(.*?)\n(.*?)```/s';
    $replace = '<pre><code class="language-$1">$2</code></pre>';
}
?>