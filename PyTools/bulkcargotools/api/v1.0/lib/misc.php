<?php

function getRequestBody() {
    $rawInput = fopen('php://input', 'r');
    $tempStream = fopen('php://temp', 'r+');
    stream_copy_to_stream($rawInput, $tempStream);
    rewind($tempStream);

    return $tempStream;
}

function cleanContent($str){
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(
        array(// Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu'
            ),
        "", //replace above with nothing
        $str );
   // $str = replaceWhitespace($str);
    $str = strip_tags($str);
	$str = cleanEncoding($str);
    return $str;
}

function replaceWhitespace($str) {
    $result = $str;
    foreach (array(
    "  ", " \t",  " \r",  " \n",
    "\t\t", "\t ", "\t\r", "\t\n",
    "\r\r", "\r ", "\r\t", "\r\n",
    "\n\n", "\n ", "\n\t", "\n\r",
    ) as $replacement) {
    $result = str_replace($replacement, $replacement[0], $result);
    }
    return $str !== $result ? replaceWhitespace($result) : $result;
}

function cleanEncoding($str) {
	$str = str_replace("=C3=9F", "ß", $str);
	$str = str_replace("=C3=BC", "ü", $str);
	$str = str_replace("=C3=A4", "ä", $str);
	$str = str_replace("=3D", "", $str);
	$str = str_replace("&uuml;", "ü", $str);
	$str = str_replace("&auml;", "ä", $str);
	$str = str_replace("&ouml;", "ö", $str);
	$str = str_replace(array("&zwnj;", "&nbsp;", "&#54;", "&#53;", "&#52;", "&#51;", "&#50;", "&#49;", "&#48;", "&#47;", "&#56;"), "", $str);
	return $str;
}

?>