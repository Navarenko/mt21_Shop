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
$push_text = urlencode("МедТорг 21 желает хорошего дня!"); // Текст пуша
/* Проверка дня отправки пуша (необязательные данные) */
$pending = false;
$date = "5";    // Дата месяца
$weekday = ""; // день недели от 1 (понедельник) до 7 (воскресенье)
$mounth = "12";  // Порядковый номер месяца
$year = "16";    // Порядковый номер года


$arrtokens = explode(",", $alltokens);
$countArrTokens = count($arrtokens);

if (checkPushDay($date, $weekday, $mounth, $year, $pending)) {
	/*header("Location: https://mt21.ru/shop/index.php?route=mshpo/ajax/push&ACTION=addPush&tokens=".$tokens."&push=".$push_text."&".$push_method."=".$push_pageId);
	exit;*/

	$push_data = http_build_query(
		array(
			'route' => 'mshpo/ajax/push',
			'ACTION' => 'addPush',
			'tokens' => $tokens,
			'push'   => $push_text,
			'$push_method' => $push_pageId
		)
	);

	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $push_data
		)
	);

	$context  = stream_context_create($opts);

	$result = file_get_contents('https://mt21.ru/shop/index.php', false, $context);

	echo $result;



/*

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
	curl_multi_close($mh);*/
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