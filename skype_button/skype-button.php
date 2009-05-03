<?php
/*
 *Add Skype button or textlink
 *@name skype
 *@author atma <atma@atmaworks.com>
 *@version 0.1
 *
 *@param $name (optional, but need to be right default value in code) - set Skype name
 *@param $status (optional, default "hide") - set show|hide status for button. If $type=text, status always hide
 *@param $action (optional, default "call") - set action for skypebutton. Possible values call|add|chat|userinfo|sendfile|voicemail
 *@param $type (optional, default "icon_text") - type of link: text|icon_text|icon
 *@param $size (optional, default "small") - button size: small|big. Not applicable for $type=text
 *@param $style (optional, default "button") - style for button: button|balloon. Applicable only for $size=big
 *
 *Usage: [skype name="myname" status="show" action="chat" size="big"]
 */
function addSkypeButton($atts) {
	
	extract(shortcode_atts(array(
		'name' => 'echo123', //set your skypename here
		'status' => 'hide', //show|hide
		'action' => 'call', //call|add|chat|userinfo|sendfile|voicemail
		'type' => 'icon_text', //text|icon_text|icon
		'size' => 'small', //small|big
		'style' => 'button' //button|balloon
    ), $atts));
	
	$out = '';
	switch ($type) {
    case 'text':
        $out .= '<a href="skype:'.$name.'?'.$action.'">Skype me</a>';
        break;
    case 'icon_text':
        if ($status == 'hide') {
			if ($size == 'small') {
				$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_70x23.png" style="border: none" width="70" height="23" alt="Skype Me™!" /></a>';
			} elseif ($size == 'big') {
				if ($style == 'button') {
					$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_white_124x52.png" style="border: none" width="124" height="52" alt="Skype Me™!" /></a>';
				} elseif ($style == 'balloon') {
					$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_white_153x63.png" style="border: none" width="153" height="63" alt="Skype Me™!" /></a>';
				} else {
					$out .= 'Style can be "button" or "balloon". Check attributes!';
				}
			} else {
				$out .= 'Size can be "small" or "big". Check attributes!';
			}
		} elseif ($status == 'show') {
			if ($size == 'small') {
				$out .= '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
				$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://mystatus.skype.com/smallclassic/'.$name.'" style="border: none" width="114" height="20" alt="My status" /></a>';
			} elseif ($size == 'big') {
				if ($style == 'button') {
					$out .= '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
					$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://mystatus.skype.com/bigclassic/'.$name.'" style="border: none" width="182" height="44" alt="My status" /></a>';
				} elseif ($style == 'balloon') {
					$out .= '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
					$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://mystatus.skype.com/balloon/'.$name.'" style="border: none" width="150" height="60" alt="My status" /></a>';
				} else {
					$out .= 'Style can be "button" or "balloon". Check attributes!';
				}
			} else {
				$out .= 'Size can be "small" or "big". Check attributes!';
			}
		} else {
			$out .= 'Status can be "show" or "hide". Check attributes!';
		}
        break;
    case 'icon':
        if ($status == 'hide') {
			if ($size == 'small') {
				$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_34x34.png" style="border: none" width="34" height="34" alt="Skype Me™!" /></a>';
			} elseif ($size == 'big') {
				$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_white_92x82.png" style="border: none" width="92" height="82" alt="Skype Me™!" /></a>';
			} else {
				'Size can be "small" or "big". Check attributes!';
			}
		} elseif ($status == 'show') {
			if ($size == 'small') {
				$out .= '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
				$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://mystatus.skype.com/smallicon/'.$name.'" style="border: none" width="16" height="16" alt="My status" /></a>';
			} elseif ($size == 'big') {
				$out .= '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
				$out .= '<a href="skype:'.$name.'?'.$action.'"><img src="http://mystatus.skype.com/mediumicon/'.$name.'" style="border: none" width="26" height="26" alt="My status" /></a>';
			}
		} else {
			$out .= 'Status can be "show" or "hide". Check attributes!';
		}
        break;
	default:
		$out .= 'Type can be "text|icon_text|icon". Check attributes!';
}

    return $out;
}

add_shortcode('skype', 'addSkypeButton');
?>