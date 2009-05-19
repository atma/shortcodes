<?php
function build_twitter_link($atts) {
	extract(shortcode_atts( array(
		'name' => ''
	), $atts ) );
	if (empty($name)) {
		return false;
	}
	$name = trim($name);
	if ($name != '') {
		$out = '<a href="http://twitter.com/'.$name.'" title="'.$name.'" class="twitter-info">@'.$name.'</a>';
	} else {
		$out = '';
	}
	return $out;
}
add_shortcode('twitinfo', 'build_twitter_link');
?>
