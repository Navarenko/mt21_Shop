<?php 
function getCurSale($groupid) {
	switch ($groupid) {
		case 3:
			$text_cur_special_prise = 5;
			break;
		case 4:
			$text_cur_special_prise = 10;
			break;
		case 5:
			$text_cur_special_prise = 15;
			break;
		case 6:
			$text_cur_special_prise = 20;
			break;
		case 7:
			$text_cur_special_prise = 25;
			break;
		case 8:
			$text_cur_special_prise = 30;
			break;
		case 9:
			$text_cur_special_prise = 21;
			break;
	}
	return $text_cur_special_prise;
}
?>