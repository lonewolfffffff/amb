<?php
	function is_selected($menu_processed,$menu_label) {
		if($menu_processed==$menu_label) {
			return 'active';
		}
		else {
			return '';
		}
	}
