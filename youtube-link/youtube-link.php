<?php
function get_youtube_data($atts, $content = null) {
	extract(shortcode_atts( array(
		'v' => '',
		'video' => '',
		'wrapclass' => 'ytvideo',
		'date' => 'd.m.Y',
		'target' => 'self',
		'autoplay' => ''
	), $atts ) );
	if (empty($v) && empty($video)) {
		return false;
	} elseif (!empty($video)) {
		$v = trim(str_replace( array('#038;', '&amp;', '&&'), '&', $video ));
	} else {
		$v = trim(str_replace( array('#038;', '&amp;', '&&'), '&', $v ));
	}
	if (substr($v, 0, 4) == 'http') {
		$linkdata = array();
		foreach (explode('&', parse_url($v, PHP_URL_QUERY)) as $part) {
			list($key, $value) = explode('=', $part, 2);
			$linkdata[$key] = $value;
		}
		$v = $linkdata['v'];
	}
	$vjs = str_replace('-', '_', $v);
	if ($autoplay) {
		$autoplay = '&autoplay=1';
	}
	if ($target) {
		$target = ' target="_'.$target.'"';
	}

	$videoData = file_get_contents('http://gdata.youtube.com/feeds/api/videos/'.$v.'?alt=json');
	$videoData = json_decode($videoData, true);
	
	$video = array();
	$video['title'] = $videoData['entry']['title']['$t'];
	$video['descr'] = $videoData['entry']['content']['$t'];
	$video['watchlink'] = $videoData['entry']['link'][0]['href'];
	$video['date'] = date($date, strtotime($videoData['entry']['published']['$t']));
	$video['author'] = $videoData['entry']['author'][0]['name']['$t'];
	$video['cat'] = $videoData['entry']['media$group']['media$category'][0]['$t'];
	$video['catlabel'] = $videoData['entry']['media$group']['media$category'][0]['label'];
	$video['thumb'] = $videoData['entry']['media$group']['media$thumbnail'][3]['url'];
	$video['duration'] = $videoData['entry']['media$group']['yt$duration']['seconds'];
	$video['minutes'] = intval($video['duration'] / 60);
	$video['seconds'] = $video['duration'] - ($video['minutes'] * 60);
	$video['views'] = $videoData['entry']['yt$statistics']['viewCount'];
	$video['favorited'] = $videoData['entry']['yt$statistics']['favoriteCount'];
	
	$keywords = array();
	$keywords = explode(', ', $videoData['entry']['media$group']['media$keywords']['$t']);
	unset($videoData);
	
	if (count($keywords) > 0) {
		$tags = '';
		foreach($keywords as $keyword) {
			$tags .= '<a class="yttag" href="http://www.youtube.com/results?search_query='.$keyword.'&search=tag"'.$target.' title="Search '.$keyword.' tagged videos on Youtube"><span>'.$keyword.'</span></a>
			';
		}
	}
	
	$out = '<div class="'.$wrapclass.'" id="'.$v.'">
	';
	$out .= '<a href="javascript:;" title="Play video" onclick="embed'.$vjs.'(\''.$v.'\')" >
	<img src="'.$video['thumb'].'" alt="'.$video['title'].'" width="320" height="240" class="ytthumb"/>
	</a>
	';
	$out .= '<h4><a href="'.$video['watchlink'].'" title="'.$video['title'].'" '.$target.'>'.$video['title'].'</a></h4>';
	$out .= '<p class="ytauthor">Posted by <a href="http://www.youtube.com/user/'.$video['author'].'" title="Watch other videos from '.$video['author'].'" '.$target.'>'.$video['author'].'</a> under <strong>'.$video['catlabel'].'</strong> on '.$video['date'].'</p>';
	$out .= '<p class="ytmeta">Length: '.$video['minutes'].':'.$video['seconds'].' Views: '.$video['views'].' Favs: '.$video['favorited'].'</p>';
	$out .= '<p class="yttags">Tags: '.$tags.'</p>';
	$out .= '<p class="ytdescription">'.$video['descr'].'</p';
	$out .= '</div>';
	
	$embedscript = '
	<script type="text/javascript">
	function embed'.$vjs.'(v) {
    
	var code;
    code=\'<object width="560" height="340">\'+
		\'<param name="movie" value="http://www.youtube.com/v/\'+v+\''.$autoplay.'"></param>\'+
		\'<param name="allowFullScreen" value="true"></param>\'+
		\'<param name="allowscriptaccess" value="always"></param>\'+
		\'<embed src="http://www.youtube.com/v/\'+v+\''.$autoplay.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed>\'+
	\'</object>\'

    document.getElementById("'.$v.'").innerHTML=code;
}
</script>
	';
	
	$out .= $embedscript;
	return $out;
}
add_shortcode('ytlink', 'get_youtube_data');
?>