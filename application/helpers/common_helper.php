<?php
	function is_selected($menu_processed,$menu_label) {
		if($menu_processed==$menu_label) {
			return 'active';
		}
		else {
			return '';
		}
	}
	
	function month_to_roman($number) {
		$roman = '';
		switch($number) {
			case 1:
				$roman = 'I';
				break;
			case 2:
				$roman = 'II';
				break;
			case 3:
				$roman = 'III';
				break;
			case 4:
				$roman = 'IV';
				break;
			case 5:
				$roman = 'V';
				break;
			case 6:
				$roman = 'VI';
				break;
			case 7:
				$roman = 'VII';
				break;
			case 8:
				$roman = 'VIII';
				break;
			case 9:
				$roman = 'IX';
				break;
			case 10:
				$roman = 'X';
				break;
			case 11:
				$roman = 'XI';
				break;
			case 12:
				$roman = 'XII';
				break;
		}
		return $roman;
	}
