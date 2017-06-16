<?php 

include 'push_data.php';

function checkPushDay($date, $weekday, $mounth, $year, $pending) {
	if (!$pending)
		echo "1 ";
	if (!((!$date) || (($date == date("d")) || ($date == date("j")))))
		echo "2 ";
	if (!((!$weekday) || (($weekday == date("D")) || ($weekday == date("l")) || ($weekday == date("N")))))
		echo "3 ";
	if (!((!$mounth) || (($mounth == date("F")) || ($mounth == date("m")) || ($mounth == date("M")) || ($mounth == date("n")))))
		echo "4 ";
	if (!((!$year) || (($year == date("Y")) || ($year == date("y")))))
		echo "5 ";
	echo "6 ";
	return true;
}

if (checkPushDay($date, $weekday, $mounth, $year, $pending)) {
	echo "Good with checkPushDay";
} else {
	echo 'Error with checkPushDay';
}

?>