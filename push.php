<?php 
define("LESHA", "APA91bH7SDsDjJyleWv6IH-ZVQyKXwGrWbY9rJXcbi0FOL22ZfaIPCj0ruBhVQJkWS7zLKxtYN7VLo8crwBwVmnIb-iFq9YamwWfN8oKoYQfo-lWuzJa2fs");
define("MARY", "APA91bFtjpAX5602W2h16j9fdRSDl8id21goFmgyf24SVnmmdmhCY-UsVlH4iAmH3kPojen1Vk1kndMdst2ULdG_iusKhW_5NZTHWd3hulXHFOtdTgnOzQQ");
define("IVAN", "APA91bEKNdRBLzFWMLrNK3z0AJaJ74qULd4P12hzY6Q6to6OQrNEDB8zWuITU0mC01o0H02u_sLBJkpq66qkGStZ84La_liUZCM6BtgsNueuhqC6H4cB81E");
define("IVAN2", "APA91bFZrN25zZAky2wHaZG02EBv3tKX7ve5XWj08KccKlHbVIften4KPtJwXGYgKIYvvUs8DO-1atAsUf_Ud8psS8WxgDRwkam4c004w_nEbX7POe_f94");
define("NIKITA", "62dd78d5 678b5b7c daa88d77 8457425e 670de85d 89ad9285 5b4920e5 e4aaf058");
define("NAMIR", "APA91bFYYiI2b4iV9axlCYNFY7fKGXt0fhw0DRLvFuaWggF8PiTYB1u4vMgqFKnAT2e5j0rxlmJ-9b6ZobiXMnCskoVvDxLNfasOs_34k8NRSUac_QYXzK8");

$tokens = NIKITA; /* получатели через запятую. Например $tokens = LESHA.','.MARY; */
$alltokens = NIKITA;
$push_method = "news"; //news или offers
$push_pageId = "17"; //id статьи или элемента каталога
$push_text = urlencode("5 декабря - начало контрнаступления советских войск под Москвой"); // Текст пуша
/* Проверка дня отправки пуша (необязательные данные) */
$pending = true;
$date = "5";    // Дата месяца
$weekday = ""; // день недели от 1 (понедельник) до 7 (воскресенье)
$mounth = "12";  // Порядковый номер месяца
$year = "16";    // Порядковый номер года


$arrtokens = explode(",", $alltokens);
$countArrTokens = count($arrtokens);

if (checkPushDay($date, $weekday, $mounth, $year, $pending)) {
	header("Location: https://mt21.ru/shop/index.php?route=mshpo/ajax/push&ACTION=addPush&tokens=".$tokens."&push=".$push_text."&".$push_method."=".$push_pageId);
	exit;

	$i = 0;
	$ch = array();
	$mh = curl_multi_init(); //создаем набор дескрипторов cURL
	while ($i < $countArrTokens) {
		$ch[$i] = curl_init(); // создаем ресурс cURL
		// устанавливаем URL и другие соответствующие опции
		curl_setopt($ch[$i], CURLOPT_URL, 'https://mt21.ru/shop/index.php?route=mshpo/ajax/push&ACTION=addPush&tokens='.$arrtokens[$i].'&push='.$push_text.'&'.$push_method.'='.$push_pageId);
		curl_setopt($ch[$i], CURLOPT_HEADER, 0);
		curl_multi_add_handle($mh,$ch[$i++]); //добавляем дескриптор
	}

	$active = null;
	//запускаем дескрипторы
	do {
		$mrc = curl_multi_exec($mh, $active);
	} while ($mrc == CURLM_CALL_MULTI_PERFORM);

	while ($active && $mrc == CURLM_OK) {
		if (curl_multi_select($mh) != -1) {
			do {
				$mrc = curl_multi_exec($mh, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}
	}

	$i = 0;
	while ($i < $countArrTokens) {
		//закрываем дескрипторы
		curl_multi_remove_handle($mh, $ch[$i++]);
	}
	curl_multi_close($mh);
	// создаем оба ресурса cURL
	/*$ch1 = curl_init();
	$ch2 = curl_init();*/

/*// устанавливаем URL и другие соответствующие опции
	curl_setopt($ch1, CURLOPT_URL, "https://mt21.ru/shop/index.php?route=mshpo/ajax/push&ACTION=addPush&tokens=APA91bH7SDsDjJyleWv6IH-ZVQyKXwGrWbY9rJXcbi0FOL22ZfaIPCj0ruBhVQJkWS7zLKxtYN7VLo8crwBwVmnIb-iFq9YamwWfN8oKoYQfo-lWuzJa2fs&push=%D0%94%D0%B5%D0%BD%D1%8C%20%D0%92%D0%B5%D0%BB%D0%B8%D0%BA%D0%BE%D0%B9%20%D0%9E%D0%BA%D1%82%D1%8F%D0%B1%D1%80%D1%8C%D1%81%D0%BA%D0%BE%D0%B9%20%D1%81%D0%BE%D1%86%D0%B8%D0%B0%D0%BB%D0%B8%D1%81%D1%82%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%BE%D0%B9%20%D1%80%D0%B5%D0%B2%D0%BE%D0%BB%D1%8E%D1%86%D0%B8%D0%B8&news=16");
	curl_setopt($ch1, CURLOPT_HEADER, 0);
	curl_setopt($ch2, CURLOPT_URL, "https://mt21.ru/shop/index.php?route=mshpo/ajax/push&ACTION=addPush&tokens=APA91bFtjpAX5602W2h16j9fdRSDl8id21goFmgyf24SVnmmdmhCY-UsVlH4iAmH3kPojen1Vk1kndMdst2ULdG_iusKhW_5NZTHWd3hulXHFOtdTgnOzQQ&push=%D0%94%D0%B5%D0%BD%D1%8C%20%D0%92%D0%B5%D0%BB%D0%B8%D0%BA%D0%BE%D0%B9%20%D0%9E%D0%BA%D1%82%D1%8F%D0%B1%D1%80%D1%8C%D1%81%D0%BA%D0%BE%D0%B9%20%D1%81%D0%BE%D1%86%D0%B8%D0%B0%D0%BB%D0%B8%D1%81%D1%82%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%BE%D0%B9%20%D1%80%D0%B5%D0%B2%D0%BE%D0%BB%D1%8E%D1%86%D0%B8%D0%B8&news=16");
	curl_setopt($ch2, CURLOPT_HEADER, 0);
*/
/*

//добавляем два дескриптора
	curl_multi_add_handle($mh,$ch1);
	curl_multi_add_handle($mh,$ch2);
*/
/*	$active = null;
//запускаем дескрипторы
	do {
		$mrc = curl_multi_exec($mh, $active);
	} while ($mrc == CURLM_CALL_MULTI_PERFORM);

	while ($active && $mrc == CURLM_OK) {
		if (curl_multi_select($mh) != -1) {
			do {
				$mrc = curl_multi_exec($mh, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}
	}
*/
} else {
	echo 'Error with checkPushDay';
}

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