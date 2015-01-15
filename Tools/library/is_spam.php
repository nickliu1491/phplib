<?php
/**
 * 黑名单过滤
 * @param unknown $text
 * @param unknown $file
 * @param string $split
 * @param string $regex
 * @return boolean
 */
function is_spam($text, $file, $split = ':', $regex = false) {
	$handle = fopen ( $file, 'rb' );
	$contents = fread ( $handle, filesize ( $file ) );
	fclose ( $handle );
	$lines = explode ( "n", $contents );
	$arr = array ();
	foreach ( $lines as $line ) {
		list ( $word, $count ) = explode ( $split, $line );
		if ($regex) {
			$arr [$word] = $count;
		} else {
			$arr [preg_quote ( $word )] = $count;
		}
	}
	preg_match_all ( "~" . implode ( '|', array_keys ( $arr ) ) . "~", $text, $matches );
	$temp = array ();
	foreach ( $matches [0] as $match ) {
		if (! in_array ( $match, $temp )) {
			$temp [$match] = $temp [$match] + 1;
			if ($temp [$match] >= $arr [$word]) {
				return true;
			}
		}
	}
	return false;
}

$file = 'spam.txt';
$str = 'This string has cat, dog word';
if (is_spam ( $str, $file )) {
	echo 'this is spam';
}
else {
	echo 'this is not spam';
}