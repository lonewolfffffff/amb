/* 
 * date and/or time functions
 */

function classify_time(hour_part) {
	var classify = 'morning';
	
	if((hour_part >= 6) && (hour_part < 12)) {
		classify = 'morning';
	}
	else {
		if((hour_part >= 12) && (hour_part < 18)) {
			classify = 'afternoon';
		}
		else {
			classify = 'night';
		}
	}
	
	return classify;
}