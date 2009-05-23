<?php
function get_flickr_foto($atts) {
	extract(shortcode_atts( array(
		'tag' => '',
		'size' => 'medium',
		'position' => 'left',
		'link' => '',
		'style' => 'padding: 4px; border: #2266aa 1px solid;',
	), $atts ) );

	if ($tag == FALSE) {
		return false;
	}
	$tags = explode(',', $tag);
	$tags = array_map('trim', $tags);
	foreach ($tags as $key => $value) {
		$tags[$key] = urlencode(str_replace(' ', '+', $value));
	}
	$tags = implode(',', $tags);
	$url = 'http://api.flickr.com/services/feeds/photos_public.gne?tags='. $tags .'&tagmode=all&format=php_serial';
	$photos = file_get_contents($url);
	$photos = unserialize($photos);

	if (count($photos['items'])) {
		$photo['title'] = $photos['items'][0]['title'];
		$photo['url'] = $photos['items'][0]['url'];
		$photo['s_url'] = $photos['items'][0]['t_url'];
		$photo['m_url'] = $photos['items'][0]['m_url'];
		$photo['l_url'] = $photos['items'][0]['l_url'];
		unset($photos);
	} else {
		unset($photos);
		return false;
	}

	switch ($size) {
		case 'small':
			$img_url = $photo['s_url'];
			break;
		case 'medium':
			$img_url = $photo['m_url'];
			break;
		case 'large':
			$img_url = $photo['l_url'];
			break;
		default:
			$img_url = $photo['m_url'];
			break;
	}

	switch ($position) {
		case 'left':
			$style = 'float: left; margin: 5px; '. $style;
			break;
		case 'right':
			$style = 'float: right; margin: 5px; '. $style;
			break;
		case 'center':
			$style = 'display: block; margin: 5px auto; clear: both; text-align: center; '. $style;
			break;
		default:
			$style = 'float: left; margin: 5px; '. $style;
			break;
	}

	if ($link) {
		$out = '
		<a href="'. $photo['url'] .'" title="'. $photo['title'] .'" style="'. $style .'">
			<img src="'. $img_url .'" alt="'. $photo['title'] .'" />
		</a>
		';
	} else {
		$out = '
		<img src="'. $img_url .'" alt="'. $photo['title'] .'" style="'. $style .'" />
		';
	}
	return $out;
}
add_shortcode('livephoto', 'get_flickr_foto');
?>
