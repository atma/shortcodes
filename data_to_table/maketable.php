<?php
/*
 *@name maketable
 *@author atma
 *@version 0.1
 *
 *@param $thead (optional, default 1) - use tag THEAD in table
 *@param $tfoot (optional, default 0) - use tag TFOOT in table
 *@param $delimiter (optional, default "|") - set char for data delimiting
 *@param $tclass (optional, default "table-class") - set classname for table
 *@param $emptycell (optional, default "&nbsp;") - set char for empty cells
 *
 *Usage: [maketable thead="1" tfoot="0" delimiter="|" tclass="table-class" emptycell="&nbsp;"]
 *       cell1|cell2|cell3
 *       cell4| |cell6
 *       [/maketable]
 */
function generate_table ( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'tclass' => 'table-class',
		'delimiter' => '|',
		'thead' => 1,
		'tfoot' => 0,
		'emptycell' => '&nbsp;'
	), $atts ) );
	
	if ($content == null) {
		return;
	} else {
		
		$content = str_replace(array("\r\n", "\n\r", "\r"), "\n", $content);
		$content = str_replace(array("<br />", "<p>", ",</p>"), "", $content);
		$content = trim($content);
		$rows = explode("\n", $content);

		while (!empty($rows) and strlen(reset($rows)) === 0) {
			array_shift($rows);
		}
		while (!empty($rows) and strlen(end($rows)) === 0) {
			array_pop($rows);
		}
		
		$rowsNumber = count($rows);
		$colsNumber = 0;
		for ($i=0; $i<$rowsNumber; $i++) {
			$rows[$i] = explode($delimiter, $rows[$i]);
			($colsNumber < count($rows[$i])) ? $colsNumber = count($rows[$i]) : $colsNumber;
		}
//content output
		$out = '';
		$tableHead = '';
		if ($thead) {
			$tableHead = '<table class="'.$tclass.'">';
			$tableHead .= '<thead>';
			$tableHead .= '<tr>';
			for($j=0;$j<$colsNumber;$j++) {
				if(isset($rows[0][$j])) {
					$tableHead .= '<td>'.$rows[0][$j].'</td>';
				} else {
					$tableHead .= '<td>'.$emptycell.'</td>';
				}
            }
			$tableHead .= '</tr>';
			$tableHead .= '</thead>';
			array_shift($rows);
			$rowsNumber = count($rows);
		} else {
			$tableHead = '<table class="'.$tclass.'">';
		}
		$tableFoot = '';
		if ($tfoot) {
			$tableFoot .= '<tfoot>';
			$tableFoot .= '<tr>';
			$tfootPosition = $rowsNumber - 1;
			for($j=0;$j<$colsNumber;$j++) {
				if(isset($rows[$tfootPosition][$j])) {
					$tableFoot .= '<td>'.$rows[$tfootPosition][$j].'</td>';
				} else {
					$tableFoot .= '<td>'.$emptycell.'</td>';
				}
            }
			$tableFoot .= '</tr>';
			$tableFoot .= '</tfoot>';
			$tableFoot .= '</table>';
			array_pop($rows);
			$rowsNumber = count($rows);
		} else {
			$tableFoot = '</table>';
		}
		
		$tableBody = '';
		$tableBody .= '<tbody>';
		for($i=0;$i<$rowsNumber;$i++) {
			$tableBody .= '<tr>';
			for($j=0;$j<$colsNumber;$j++) {
				if(isset($rows[$i][$j])) {
					$tableBody .= '<td>'.$rows[$i][$j].'</td>';
				}
				else {
					$tableBody .= '<td>'.$emptycell.'</td>';
				}
			}
			$tableBody .= '</tr>';
		}
		$tableBody .= '</tbody>';
		
		$out .= $tableHead .$tableBody .$tableFoot;
		
	}
	return $out;
}

add_shortcode('maketable', 'generate_table');
?>