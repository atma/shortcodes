<?php
/*
 *Insert customizible chart using "Google Chart"
 *
 *@name Google Chart
 *@author atma <atma@atmaworks.com>
 *@version 0.1
 *
 *@param &data string Delimited data for display
 *@param &colors string Color values for lines, legend etc. Values in hex mode (Ex.: 0C8FCE)
 *@param &size string Size of chart
 *@param &bg string Background color for chart
 *@param &title string Title of chart
 *@param &legend string Pie labels or chart legend
 *@param &grid integer Delimited values for grid. Applicable only for line charts
 *@param &type string Type of chart
 *Usage:
 *[chart colors="FF6600,0C8FCE,CE0C78" type="line" legend="Earth|Mars|Venus" grid="20,10"]
 *22,34,12,67,84
 *91,23,61,33,54
 *71,22,12,43,72
 *[/chart]
 *
 *[chart data="34,22,44" colors="aa0000|0000aa|00aa00" bg="F7F9FA" type="pie" legend="Red|Blue|Green" /]
 */
function googleChart($atts, $content = NULL ) {
	extract(shortcode_atts(array(
	    'data' => '',
	    'colors' => '',
	    'size' => '480x240',
	    'bg' => 'ffffff',
	    'title' => '',
	    'legend' => '',
		'grid' => '',
		'lines' => '',
	    'advanced' => '',
	    'type' => 'pie'
	), $atts));

	if ($content != NULL) {
		$content = str_replace(array("\r\n", "\n\r", "\r"), "\n", $content);
		$content = trim(strip_tags($content));
		$rows = explode("\n", $content);
		while (!empty($rows) and strlen(reset($rows)) === 0) {
			array_shift($rows);
		}
		while (!empty($rows) and strlen(end($rows)) === 0) {
			array_pop($rows);
		}
		$num = count($rows);
		if ($num == 1) {
			$data = $rows[0];
		} elseif ($num > 1) {
			$data = implode('|', $rows);
		} else {
			unset($content);
		}
	}

	switch ($type) {
		case 'line':
		case 'lc':
			$charttype = 'lc';
			(!empty($grid)) ? $grid = '&chg='.$grid : '';
			(!empty($lines)) ? $lines = '&chls='.$lines : '';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data.$grid.$lines;
			break;
		case 'xyline':
		case 'lxy':
			$charttype = 'lxy';
			(!empty($grid)) ? $grid = '&chg='.$grid : '';
			(!empty($lines)) ? $lines = '&chls='.$lines : '';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data.$grid.$lines;
			break;
		case 'bar':
		case 'bvs':
			$charttype = 'bvs';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'bhs':
			$charttype = 'bhs';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'bhg':
			$charttype = 'bhg';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'bvg':
			$charttype = 'bvg';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'meter':
		case 'gom':
			$charttype = 'gom';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'scatter':
		case 's':
			$charttype = 's';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'venn':
		case 'v':
			$charttype = 'v';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'pie':
		case 'p3':
			$charttype = 'p3';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		case 'pie2d':
		case 'p':
			$charttype = 'p';
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
		default :
			$charttype = $type;
			$urlpart = 'cht='.$charttype.'&chd=t:'.$data;
			break;
	}
 
 	($title) ? $chtt = '&chtt='.str_replace (' ', '+', $title) : '';
	if (!empty($legend)) {
		if ($charttype == 'p' || $charttype == 'p3') {
			$chl = '&chl='.$legend;
		} else {
			$chl = '&chdl='.$legend;
		}
	}
	
	(!empty($colors)) ? $colors = '&chco='.$colors : '';
	(!empty($size)) ? $size = '&chs='.$size : '';
	(!empty($bg)) ? $bg = '&chs='.$bg : '';

	$out = '<img alt="'.$title.'" src="http://chart.apis.google.com/chart?'.$urlpart.$chtt.$chl.$colors.$bg.$size.$advanced.'" />';

	return $out;
}
add_shortcode('chart', 'googleChart');
?>