<?php
/*
 *Shortcode return normal(long) link from shortened url
 *@name longurl
 *@author atma <atma@atmaworks.com>
 *@version 0.1
 *
 *@param $url (required) - shortened url
 *
 *Usage: [longurl url="http://bit.ly/XuWIV"]
 *       or
 *       [longurl] http://is.gd/w [/longurl]
 */
function create_long_url( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url' => ''
	), $atts ) );

	if ($content == null && $url == '') {
		$out = "All empty";
		return;
	} elseif ($content) {
		$content = trim($content);
		if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $content)) {
			$url = $content;
		} else {
			$content = '';
		}
	}
	if ($url) {
		$url = trim($url);
		if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
			$url = 'http://api.longurl.org/v1/expand?url='.$url.'&format=json';
			$urlarr = json_decode(file_get_contents($url,0,null,null), true);
			if (isset($urlarr['long_url'])) {
				$linkurl = $urlarr['long_url'];
			}
			if (isset($urlarr['title'])) {
				$linktitle = ' title="'.$urlarr['title'].'"';
				$linktext = $urlarr['title'];
			} else {
				$linktext = $urlarr['long_url'];
			}
			$out = '<a href="'.$linkurl.'"'.$linktitle.'>'.$linktext.'</a>';
		} else {
			$out = 'Url format incorrect!';
		}
	}
	return $out;
}

add_shortcode('longurl', 'create_long_url');
?>