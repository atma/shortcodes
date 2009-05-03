<?php
/*WP shortcode for Translate inline content
 *@name google-translate
 *@author atma
 *@version 0.1
 *
 *@param $from (optional, default "en") - language to translate from
 *@param $to (optional, default "es") - language to translate to
 *@param $text (required) - text to be translated
 *@param $wrap (optional, default "div") - tag for translated text wrapper. Can be "div|p|span"
 *@param $wrapclass (optional, default "google-translate") - set css class for text wrapper
 *
 *Usage: [translate from="ru" to="en" wrap="span" text="здравствуй мир"]
 *       or
 *       [translate]hello world[/translate]
 */
function google_translate( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'from' => 'en',
		'to' => 'es',
		'text' => '',
		'wrap' => 'div',
		'wrapclass' => 'google-translate'
	), $atts ) );
	$langList = array(
		'ar'=>'Arabic',
		'bg'=>'Bulgarian',
		'zh-CN'=>'Simplified Chinese',
		'zh-TW'=>'Traditional Chinese',
		'hr'=>'Croatian',
		'cs'=>'Czech',
		'da'=>'Danish',
		'nl'=>'Dutch',
		'en'=>'English',
		'fi'=>'Finnish',
		'fr'=>'French',
		'de'=>'German',
		'el'=>'Greek',
		'hi'=>'Hindi',
		'it'=>'Italian',
		'ja'=>'Japanese',
		'ko'=>'Korean',
		'pl'=>'Polish',
		'pt'=>'Portuguese',
		'ro'=>'Romanian',
		'ru'=>'Russian',
		'es'=>'Spanish',
		'sv'=>'Swedish'
	);
	
	$from = trim($from);
	if (array_key_exists($from , $langList)) {
		$status = '';
	} elseif (in_array($from, $langList)) {
		return array_search($from, $langList);
	} else {
		$status = '$from language not in the translation list<br />';
	}
	$to = trim($to);
	if (array_key_exists($to , $langList)) {
		$status .= '';
	} elseif (in_array($to, $langList)) {
		return array_search($to, $langList);
	} else {
		$status .= '$to language not in the translation list<br />';
	}
	if ($status != '') {
		return $status;
	}
	if (($content != null) and trim($content) != '') {
		$text = trim(strip_tags($content));
	} elseif (trim($text) != '') {
		$text = trim(strip_tags($text));
	} else {
		$status = 'You ned to enter some text';
		return $status;
	}
	$wraps = array('div', 'p', 'span');
	$wrap = strtolower($wrap);
	if (in_array($wrap, $wraps)) {
		$status = '';
	} else {
		$status = 'Wrapper tag incorrect. Check attributes';
		return $status;
	}
	$gtout = file_get_contents('http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='.urlencode($text).'&langpair='.$from.'%7C'.$to);
	$gtout = json_decode($gtout);
	if ($gtout->responseStatus = 200) {
		$translate = $gtout->responseData->translatedText;
	} else {
		$status = $gtout->responseData->responseDetails;
		return $status;
	}
	
	$out = '';
	$out .= '<'.$wrap.' class="'.$wrapclass.'">'.$translate.'</'.$wrap.'>';
	return $out;
}

add_shortcode('translate', 'google_translate');
?>
