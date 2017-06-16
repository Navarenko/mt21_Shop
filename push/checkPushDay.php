<?php 
function checkPushDay($date, $weekday, $mounth, $year, $pending) {
	if (!$pending)
		return true;
	if (!((!$date) || (($date == date("d")) || ($date == date("j")))))
		return false;
	if (!((!$weekday) || (($weekday == date("D")) || ($weekday == date("l")) || ($weekday == date("N")))))
		return false;
	if (!((!$mounth) || (($mounth == date("F")) || ($mounth == date("m")) || ($mounth == date("M")) || ($mounth == date("n")))))
		return false;
	if (!((!$year) || (($year == date("Y")) || ($year == date("y")))))
		return false;
	return true;
}
?>