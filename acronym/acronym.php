<?php
/*Automatic insertion and assigning the correct title for Acronym
 *@name Acronym
 *@author atma <atma@atmaworks.com>
 *@version pre-0.1
 *
 *@param $a (required) - acronym
 *@param $t (optional) - title for acronym tag not required if it predefined in array. $t can override array value or can be used for build tag <acronym> if acronym not in array
 *@param $class (optional, default "acronym") - CSS class for acronym tag
 *
*/
function getAcronym( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'a' => '',
		'class' => 'acronym'
	), $atts ) );
	
	if ($content != null) {
		$a = trim($content);
	} elseif ($a != '') {
		$a = trim($a);
	} else {
		return;
	}
	$acronyms = array(
		'24/7' => '24 hours / 7 days per week',
		'2D' => 'Two-Dimensional',
		'3D' => 'Three-Dimensional',
		'3G' => 'The Third Generation',
		'4D' => 'Four-Dimensional',
		'4WD' => 'Four-Wheel Drive',
		
		'A.C.' => '(Lat. ante Christum) before Christ',
		'ACK' => 'Acknowledgment',
		'ACPI' => 'Advanced Configuration and Power Interface',
		'A.D.' => '(Lat. Anno Domini) of the Christian era',
		'ADO' => 'ActiveX Data Object',
		'ADSL' => 'Asymmetric Digital Subscriber Line',
		'Adv' => 'Advanced',
		'AF' => 'Audio Frequency',
		'AGC' => 'Automatic Gain Control',
		'AGP' => 'Accelerated Graphics Port',
		'AIDS' => 'Acquired Immune Deficiency Syndrome',
		'AIS' => 'Automatic Identification System',
		'aka' => 'also known as',
		'a.m.' => '(Lat. ante meridiem) before noon',
		'ANSI' => 'American National Standards Institute',
		'AOL' => 'America OnLine',
		'AP' => 'Associated Press',
		'API' => 'Application Program(ming) Interface',
		'apt' => 'apartment',
		'ASAP' => 'As Soon As Possible',
		'ASCII' => 'American Standard Code for Information Interchange',
		'aso' => 'and so on',
		'AST' => 'U.S. Atlantic Standard Time (UTC - 4h)',
		'ATM' => 'Automatic Teller Machine',
		
		'BC' => 'Before Christ',
		'BIF' => 'Binary Information Files',
		'BIOS' => 'Basic Input/Output System',
		'BMP' => '(Windows) Bitmap',
		'bps' => 'bits per second',
		'BSD' => 'Berkeley Software Distribution',
		'btw' => 'by the way',
		'b/w' => 'black and white',
		
		'C' => 'Celsius (Centigrade)',
		'C4I' => 'Command, Control, Communications, Computers, and Intelligence',
		'CAD' => 'Computer-Aided Design',
		'CASE' => 'Computer-Aided Software Engineering',
		'CB' => 'Central Bureau',
		'cc' => 'cubic centimeter',
		'CCIR' => 'International Radio Consultative Committee',
		'CD' => 'Compact Disc',
		'CDE' => 'Common Desktop Environment (HP)',
		'CDMA' => 'Code Division Multiple Access',
		'CDT' => 'U.S. Central Daylight Time (UTC - 5h)',
		'CEO' => 'Chief Executive Officer',
		'CERN' => 'Center for European Laboratory for Particle Physics, Switzerland',
		'CET' => 'Central European Time (UTC + 1h)',
		'CGI' => 'Common Gateway Interface',
		'CIPE' => 'Central Institute for Physics of the Earth, Germany',
		'CIS' => 'Conventional Inertial System',
		'CLS' => 'CLear Screen',
		'CM' => 'Center of Mass',
		'CMOS' => 'Complementary Metal-Oxide Semiconductor',
		'CNN' => 'Cable News Network, USA',
		'COBOL' => 'COmmon Business-Oriented Language',
		'COO' => 'Chief Operating Officer',
		'CPC' => 'Cost per Click',
		'CPU' => 'Central Processing Unit',
		'CSS' => 'Cascading Style Sheets',
		'CST' => 'U.S. Central Standard Time (UTC - 6h)',
		'Ctl' => 'Control',
		'Ctrl' => 'Control',
		'CU' => 'see you',
		'CV' => 'Curriculum Vitae',
		
	);
	if (isset($t)) {
		$out = '<acronym class="'.$class.'" title="'.$t.'">'.$a.'</acronym>';
		return $out;
	} else {
		$key = strtolower($a);
		foreach ($acronyms as $k => $v) {
			if (strtolower($k) == $key) {
				$acronym = array('a' => $k, 't' => $v);
			}
		}
	}
	if (count($acronym) > 0) {
		$out = '<acronym class="'.$class.'" title="'.$acronym['t'].'">'.$acronym['a'].'</acronym>';
	} else {
		$out = $a;
		return $out;
	}
	return $out;
}

add_shortcode('acronym', 'getAcronym');
?>